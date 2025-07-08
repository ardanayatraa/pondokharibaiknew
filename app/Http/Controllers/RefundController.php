<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Carbon\Carbon;

class RefundController extends Controller
{
    /**
     * Process refund for cancelled reservation
     */
    public function processRefund(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'reservation_id' => 'required|integer',
                'refund_amount' => 'required|numeric|min:0',
                'payment_method' => 'required|string',
                'cancelation_reason' => 'required|string|max:500',
            ]);

            $reservation = Reservasi::with(['guest', 'villa', 'pembayaran'])->findOrFail($validated['reservation_id']);

            // Check if user owns this reservation
            if (Auth::guard('guest')->check() && Auth::guard('guest')->id() !== $reservation->guest_id) {
                return response()->json(['error' => 'Unauthorized access to reservation'], 403);
            }

            // Check if reservation can be cancelled
            if (!in_array($reservation->status, ['confirmed', 'rescheduled'])) {
                return response()->json(['error' => 'Reservation cannot be cancelled'], 400);
            }

            // NEW: Check H-7 rule based on check-in date (not payment date)
            $checkInDate = Carbon::parse($reservation->start_date)->startOfDay();
            $today = Carbon::today();
            $daysUntilCheckIn = $today->diffInDays($checkInDate, false);

            Log::info('Cancellation H-7 check', [
                'reservation_id' => $reservation->id_reservation,
                'check_in_date' => $checkInDate->format('Y-m-d'),
                'today' => $today->format('Y-m-d'),
                'days_until_checkin' => $daysUntilCheckIn,
                'is_h7_eligible' => $daysUntilCheckIn >= 7
            ]);

            // Determine refund eligibility based on H-7 rule
            $isH7Eligible = $daysUntilCheckIn >= 7;
            $actualRefundAmount = $isH7Eligible ? $validated['refund_amount'] : 0;

            // Get latest payment for processing
            $latestPayment = $reservation->pembayaran()
                ->where('status', 'paid')
                ->latest('payment_date')
                ->first();

            if (!$latestPayment) {
                return response()->json(['error' => 'No payment found for this reservation'], 400);
            }

            // Update reservation status first
            $reservation->update([
                'status' => 'cancelled',
                'cancelation_date' => now(),
                'cancelation_reason' => $validated['cancelation_reason'],
            ]);

            // If not H-7 eligible, no refund processing
            if (!$isH7Eligible) {
                // Create no-refund payment record
                Pembayaran::create([
                    'guest_id' => $reservation->guest_id,
                    'reservation_id' => $reservation->id_reservation,
                    'amount' => 0, // No refund amount
                    'payment_date' => now(),
                    'snap_token' => null,
                    'notifikasi' => "Pembatalan reservasi #{$reservation->id_reservation} - Tidak ada refund (kurang dari H-7) - Alasan: {$validated['cancelation_reason']} - Sisa hari: {$daysUntilCheckIn}",
                    'status' => 'no_refund',
                ]);

                return response()->json([
                    'success' => true,
                    'message' => "Reservasi berhasil dibatalkan. Tidak ada refund karena pembatalan dilakukan kurang dari 7 hari sebelum check-in (sisa {$daysUntilCheckIn} hari).",
                    'refund_amount' => 0,
                    'cancelation_reason' => $validated['cancelation_reason'],
                    'refund_status' => 'no_refund',
                    'days_until_checkin' => $daysUntilCheckIn,
                    'h7_eligible' => false,
                    'refund_policy' => 'Refund 50% hanya berlaku jika pembatalan dilakukan minimal 7 hari sebelum check-in'
                ]);
            }

            // H-7 eligible - proceed with refund processing
            // Check if payment method supports refund (QRIS check)
            $isQrisPayment = $this->checkIfQrisPayment($latestPayment);

            if (!$isQrisPayment) {
                // Create manual refund record for non-QRIS payments
                Pembayaran::create([
                    'guest_id' => $reservation->guest_id,
                    'reservation_id' => $reservation->id_reservation,
                    'amount' => -$actualRefundAmount,
                    'payment_date' => now(),
                    'snap_token' => null,
                    'notifikasi' => "Refund 50% MANUAL untuk pembatalan reservasi #{$reservation->id_reservation} - Metode pembayaran tidak mendukung refund otomatis - Alasan: {$validated['cancelation_reason']}",
                    'status' => 'notrefuned',
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Reservasi dibatalkan. Refund 50% akan diproses manual oleh tim kami dalam 1x24 jam karena metode pembayaran tidak mendukung refund otomatis.',
                    'refund_amount' => $actualRefundAmount,
                    'cancelation_reason' => $validated['cancelation_reason'],
                    'refund_status' => 'notrefuned',
                    'days_until_checkin' => $daysUntilCheckIn,
                    'h7_eligible' => true,
                    'payment_method' => $validated['payment_method']
                ]);
            }

            // Process automatic refund via Midtrans API for QRIS payments
            $refundResult = $this->processMidtransRefund($latestPayment, $actualRefundAmount);

            if ($refundResult['success']) {
                // Create successful refund payment record
                Pembayaran::create([
                    'guest_id' => $reservation->guest_id,
                    'reservation_id' => $reservation->id_reservation,
                    'amount' => -$actualRefundAmount, // Negative amount for refund
                    'payment_date' => now(),
                    'snap_token' => $refundResult['refund_id'] ?? null,
                    'notifikasi' => "Refund 50% berhasil untuk pembatalan reservasi #{$reservation->id_reservation} - Alasan: {$validated['cancelation_reason']} - Refund ID: {$refundResult['refund_id']} - H-7 eligible",
                    'status' => 'refunded',
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Pembatalan berhasil diproses. Refund 50% akan diproses dalam 3-5 hari kerja.',
                    'refund_amount' => $actualRefundAmount,
                    'refund_id' => $refundResult['refund_id'] ?? null,
                    'cancelation_reason' => $validated['cancelation_reason'],
                    'refund_status' => 'success',
                    'days_until_checkin' => $daysUntilCheckIn,
                    'h7_eligible' => true,
                    'midtrans_response' => $refundResult['response'] ?? null,
                ]);
            } else {
                // Create failed refund payment record
                Pembayaran::create([
                    'guest_id' => $reservation->guest_id,
                    'reservation_id' => $reservation->id_reservation,
                    'amount' => -$actualRefundAmount, // Negative amount for refund
                    'payment_date' => now(),
                    'snap_token' => null,
                    'notifikasi' => "Refund 50% GAGAL untuk pembatalan reservasi #{$reservation->id_reservation} - Alasan: {$validated['cancelation_reason']} - Error: {$refundResult['message']} - H-7 eligible",
                    'status' => 'refund_failed',
                ]);

                return response()->json([
                    'success' => true, // Still success because reservation is cancelled
                    'message' => 'Reservasi dibatalkan. Refund otomatis gagal, tim kami akan memproses refund manual dalam 1x24 jam.',
                    'refund_amount' => $actualRefundAmount,
                    'cancelation_reason' => $validated['cancelation_reason'],
                    'refund_status' => 'failed',
                    'days_until_checkin' => $daysUntilCheckIn,
                    'h7_eligible' => true,
                    'error_detail' => $refundResult['message'],
                    'manual_process_required' => true
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Refund processing error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Terjadi kesalahan saat memproses refund',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if payment was made using QRIS
     */
    private function checkIfQrisPayment($payment): bool
    {
        if (!$payment) return false;

        $notification = strtolower($payment->notifikasi ?? '');
        $snapToken = strtolower($payment->snap_token ?? '');

        // QRIS keywords
        $qrisKeywords = [
            'qris', 'qr code', 'qr_code', 'qrcode',
            'gopay', 'go-pay', 'gojek',
            'dana', 'shopeepay', 'shopee pay', 'shopee-pay',
            'ovo', 'linkaja', 'link aja',
            'jenius', 'scan'
        ];

        foreach ($qrisKeywords as $keyword) {
            if (str_contains($notification, $keyword) || str_contains($snapToken, $keyword)) {
                return true;
            }
        }

        // Default to true for testing - you can change this to false for production
        return true;
    }

    /**
     * Process refund via Midtrans API using Guzzle
     */
    private function processMidtransRefund($payment, $refundAmount): array
    {
        try {
            // Generate order_id from payment data
            $orderId = $this->getOrderIdFromPayment($payment);
            if (!$orderId) {
                return [
                    'success' => false,
                    'message' => 'Order ID tidak ditemukan'
                ];
            }

            // Generate refund key
            $refundKey = 'refund-' . $payment->id . '-' . time();

            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', 'https://api.sandbox.midtrans.com/v2/' . $orderId . '/refund', [
                'body' => json_encode([
                    'refund_key' => $refundKey,
                    'amount' => (int) $refundAmount,
                    'reason' => 'Customer cancellation - 50% refund policy (H-7 eligible)'
                ]),
                'headers' => [
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                    'authorization' => 'Basic ' . base64_encode(config('midtrans.server_key') . ':')
                ],
            ]);

            $responseBody = json_decode($response->getBody(), true);

            Log::info('Midtrans refund response', [
                'order_id' => $orderId,
                'refund_key' => $refundKey,
                'response' => $responseBody,
                'status_code' => $response->getStatusCode()
            ]);

            // Check if refund was successful based on response
            if ($response->getStatusCode() === 200 || $response->getStatusCode() === 201) {
                return [
                    'success' => true,
                    'refund_id' => $refundKey,
                    'response' => $responseBody,
                    'message' => 'Refund processed successfully'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Midtrans refund failed with status: ' . $response->getStatusCode()
                ];
            }

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : 'No response body';
            Log::error('Midtrans refund client error: ' . $e->getMessage(), [
                'response_body' => $responseBody,
                'status_code' => $e->getResponse() ? $e->getResponse()->getStatusCode() : 'No status code'
            ]);

            return [
                'success' => false,
                'message' => 'Midtrans API error: ' . $e->getMessage()
            ];
        } catch (\Exception $e) {
            Log::error('Midtrans refund error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Extract order_id from payment data
     */
    private function getOrderIdFromPayment($payment): ?string
    {
        // Method 1: If you store order_id in snap_token field
        if ($payment->snap_token && str_contains($payment->snap_token, 'ORDER-')) {
            return $payment->snap_token;
        }

        // Method 2: If you store order_id in notifikasi field
        if ($payment->notifikasi) {
            // Try to extract order_id from notification
            if (preg_match('/ORDER-\d+/', $payment->notifikasi, $matches)) {
                return $matches[0];
            }
        }

        // Method 3: Generate order_id based on your pattern
        // Adjust this based on how you generate order_id in your payment process
        $orderId = $payment->order_id;

        Log::warning('Order ID not found in payment data, using generated ID', [
            'payment_id' => $payment->id,
            'generated_order_id' => $orderId,
            'snap_token' => $payment->snap_token,
            'notifikasi' => $payment->notifikasi
        ]);

        return $orderId;
    }

    /**
     * Get refund information for a reservation - UPDATED with H-7 check-in rule
     */
    public function getRefundInfo($reservationId): JsonResponse
    {
        try {
            $reservation = Reservasi::with(['pembayaran'])->findOrFail($reservationId);

            // Check authorization
            if (Auth::guard('guest')->check() && Auth::guard('guest')->id() !== $reservation->guest_id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            // Calculate total paid amount for this reservation
            $totalPaid = $reservation->pembayaran()
                ->where('status', 'paid')
                ->sum('amount');

            // NEW: Check H-7 rule based on check-in date
            $checkInDate = Carbon::parse($reservation->start_date)->startOfDay();
            $today = Carbon::today();
            $daysUntilCheckIn = $today->diffInDays($checkInDate, false);

            // H-7 eligibility based on check-in date
            $isH7Eligible = $daysUntilCheckIn >= 7;

            // Calculate refund amount based on H-7 eligibility
            $refundAmount = $isH7Eligible ? ($totalPaid * 0.5) : 0;
            $refundPercentage = $isH7Eligible ? 50 : 0;

            // Get payment method info
            $latestPayment = $reservation->pembayaran()
                ->where('status', 'paid')
                ->latest('payment_date')
                ->first();

            $isQrisPayment = $latestPayment ? $this->checkIfQrisPayment($latestPayment) : false;

            // For H-7 eligible cancellations, check if automatic refund is possible
            $canAutoRefund = $isH7Eligible && $isQrisPayment && $totalPaid > 0;

            // Overall refund capability
            $canRefund = $isH7Eligible && $totalPaid > 0;

            return response()->json([
                'total_paid' => $totalPaid,
                'refund_amount' => $refundAmount,
                'refund_percentage' => $refundPercentage,
                'is_qris_payment' => $isQrisPayment,
                'can_refund' => $canRefund,
                'can_auto_refund' => $canAutoRefund,
                'is_h7_eligible' => $isH7Eligible,
                'days_until_checkin' => $daysUntilCheckIn,
                'check_in_date' => $checkInDate->format('d M Y'),
                'payment_method' => $isQrisPayment ? 'QRIS' : 'Other',
                'order_id' => $latestPayment ? $this->getOrderIdFromPayment($latestPayment) : null,
                'refund_policy' => $isH7Eligible
                    ? 'Refund 50% tersedia (pembatalan H-7 atau lebih)'
                    : 'Tidak ada refund (pembatalan kurang dari H-7)',
                'h7_deadline' => $checkInDate->subDays(7)->format('d M Y'),

                // Legacy fields for backward compatibility
                'can_refund_by_time' => $isH7Eligible, // Changed from payment-based to check-in based
                'payment_date' => $latestPayment ? Carbon::parse($latestPayment->payment_date)->format('d M Y H:i') : null,
                'refund_deadline' => $checkInDate->subDays(7)->format('d M Y') . ' (H-7 sebelum check-in)'
            ]);

        } catch (\Exception $e) {
            Log::error('Get refund info error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to get refund information',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check refund status from Midtrans
     */
    public function checkRefundStatus($orderId): JsonResponse
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', 'https://api.sandbox.midtrans.com/v2/' . $orderId . '/status', [
                'headers' => [
                    'accept' => 'application/json',
                    'authorization' => 'Basic ' . base64_encode(config('midtrans.server_key') . ':')
                ],
            ]);

            $responseBody = json_decode($response->getBody(), true);

            return response()->json([
                'success' => true,
                'data' => $responseBody
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to check refund status: ' . $e->getMessage()
            ], 400);
        }
    }
}
