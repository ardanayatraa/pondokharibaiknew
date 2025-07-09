<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Carbon\Carbon;

class RefundController extends Controller
{
    /**
     * Process refund for cancelled reservation - FIXED VERSION
     */
    public function processRefund(Request $request): JsonResponse
    {
        // Start database transaction to ensure data consistency
        DB::beginTransaction();

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
                DB::rollBack();
                return response()->json(['error' => 'Unauthorized access to reservation'], 403);
            }

            // Check if reservation can be cancelled
            if (!in_array($reservation->status, ['confirmed', 'rescheduled'])) {
                DB::rollBack();
                return response()->json(['error' => 'Reservation cannot be cancelled'], 400);
            }

            // Calculate H-7 eligibility based on check-in date
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

            // STEP 1: ALWAYS UPDATE RESERVATION STATUS FIRST (This ensures cancellation always succeeds)
            $reservation->update([
                'status' => 'cancelled',
                'cancelation_date' => now(),
                'cancelation_reason' => $validated['cancelation_reason'],
            ]);

            Log::info('Reservation cancelled successfully', [
                'reservation_id' => $reservation->id_reservation,
                'status' => 'cancelled',
                'reason' => $validated['cancelation_reason']
            ]);

            // STEP 2: Handle refund processing based on H-7 eligibility
            if (!$isH7Eligible) {
                // No refund case - create record for tracking
                $this->createPaymentRecord([
                    'guest_id' => $reservation->guest_id,
                    'reservation_id' => $reservation->id_reservation,
                    'order_id' => $this->generateOrderId($reservation->id_reservation, 'CANCEL'),
                    'amount' => 0,
                    'status' => 'no_refund',
                    'notifikasi' => "Pembatalan reservasi #{$reservation->id_reservation} - Tidak ada refund (kurang dari H-7) - Alasan: {$validated['cancelation_reason']} - Sisa hari: {$daysUntilCheckIn}"
                ]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => "Reservasi berhasil dibatalkan. Tidak ada refund karena pembatalan dilakukan kurang dari 7 hari sebelum check-in (sisa {$daysUntilCheckIn} hari).",
                    'refund_amount' => 0,
                    'cancelation_reason' => $validated['cancelation_reason'],
                    'refund_status' => 'no_refund',
                    'days_until_checkin' => $daysUntilCheckIn,
                    'h7_eligible' => false,
                    'refund_policy' => 'Refund 50% hanya berlaku jika pembatalan dilakukan minimal 7 hari sebelum check-in',
                    'cancellation_successful' => true
                ]);
            }

            // STEP 3: H-7 eligible - process refund
            if (!$latestPayment) {
                // No payment found but still H-7 eligible
                $this->createPaymentRecord([
                    'guest_id' => $reservation->guest_id,
                    'reservation_id' => $reservation->id_reservation,
                    'order_id' => $this->generateOrderId($reservation->id_reservation, 'CANCEL'),
                    'amount' => 0,
                    'status' => 'no_payment_found',
                    'notifikasi' => "Pembatalan reservasi #{$reservation->id_reservation} - H-7 eligible tapi tidak ada pembayaran ditemukan - Alasan: {$validated['cancelation_reason']}"
                ]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Reservasi berhasil dibatalkan. Tidak ada pembayaran yang ditemukan untuk direfund.',
                    'refund_amount' => 0,
                    'cancelation_reason' => $validated['cancelation_reason'],
                    'refund_status' => 'no_payment_found',
                    'days_until_checkin' => $daysUntilCheckIn,
                    'h7_eligible' => true,
                    'cancellation_successful' => true
                ]);
            }

            // Check if payment method supports automatic refund
            $isQrisPayment = $this->checkIfQrisPayment($latestPayment);

            if (!$isQrisPayment) {
                // Manual refund required for non-QRIS payments
                $this->createPaymentRecord([
                    'guest_id' => $reservation->guest_id,
                    'reservation_id' => $reservation->id_reservation,
                    'order_id' => $this->generateOrderId($reservation->id_reservation, 'REFUND'),
                    'amount' => $actualRefundAmount,
                    'status' => 'manual_refund_required',
                    'notifikasi' => "Refund 50% MANUAL untuk pembatalan reservasi #{$reservation->id_reservation} - Metode pembayaran tidak mendukung refund otomatis - Alasan: {$validated['cancelation_reason']}"
                ]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Reservasi berhasil dibatalkan. Refund 50% akan diproses manual oleh tim kami dalam 1x24 jam karena metode pembayaran tidak mendukung refund otomatis.',
                    'refund_amount' => $actualRefundAmount,
                    'cancelation_reason' => $validated['cancelation_reason'],
                    'refund_status' => 'manual_refund_required',
                    'days_until_checkin' => $daysUntilCheckIn,
                    'h7_eligible' => true,
                    'payment_method' => $validated['payment_method'],
                    'manual_process_required' => true,
                    'cancellation_successful' => true
                ]);
            }

            // STEP 4: Attempt automatic refund via Midtrans API
            $refundResult = $this->processMidtransRefund($latestPayment, $actualRefundAmount, $reservation->id_reservation);

            if ($refundResult['success']) {
                // Successful automatic refund
                $this->createPaymentRecord([
                    'guest_id' => $reservation->guest_id,
                    'reservation_id' => $reservation->id_reservation,
                    'order_id' => $refundResult['order_id'] ?? $this->generateOrderId($reservation->id_reservation, 'REFUND'),
                    'amount' => $actualRefundAmount,
                    'status' => 'refunded',
                    'snap_token' => $refundResult['refund_id'] ?? null,
                    'notifikasi' => "Refund 50% berhasil untuk pembatalan reservasi #{$reservation->id_reservation} - Alasan: {$validated['cancelation_reason']} - Refund ID: {$refundResult['refund_id']} - H-7 eligible"
                ]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Pembatalan berhasil diproses. Refund 50% akan diproses dalam 3-5 hari kerja.',
                    'refund_amount' => $actualRefundAmount,
                    'refund_id' => $refundResult['refund_id'] ?? null,
                    'cancelation_reason' => $validated['cancelation_reason'],
                    'refund_status' => 'refunded',
                    'days_until_checkin' => $daysUntilCheckIn,
                    'h7_eligible' => true,
                    'midtrans_response' => $refundResult['response'] ?? null,
                    'cancellation_successful' => true
                ]);
            } else {
                // Automatic refund failed - but cancellation still successful
                $this->createPaymentRecord([
                    'guest_id' => $reservation->guest_id,
                    'reservation_id' => $reservation->id_reservation,
                    'order_id' => $refundResult['order_id'] ?? $this->generateOrderId($reservation->id_reservation, 'REFUND'),
                    'amount' => $actualRefundAmount,
                    'status' => 'refund_failed_manual_required',
                    'notifikasi' => "Refund 50% GAGAL (akan diproses manual) untuk pembatalan reservasi #{$reservation->id_reservation} - Alasan: {$validated['cancelation_reason']} - Error: {$refundResult['message']} - H-7 eligible"
                ]);

                DB::commit();

                return response()->json([
                    'success' => true, // Still success because reservation is cancelled
                    'message' => 'Reservasi berhasil dibatalkan. Refund otomatis gagal, tim kami akan memproses refund manual dalam 1x24 jam.',
                    'refund_amount' => $actualRefundAmount,
                    'cancelation_reason' => $validated['cancelation_reason'],
                    'refund_status' => 'refund_failed_manual_required',
                    'days_until_checkin' => $daysUntilCheckIn,
                    'h7_eligible' => true,
                    'error_detail' => $refundResult['message'],
                    'manual_process_required' => true,
                    'cancellation_successful' => true
                ]);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Refund processing error: ' . $e->getMessage(), [
                'reservation_id' => $validated['reservation_id'] ?? null,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Terjadi kesalahan saat memproses pembatalan',
                'message' => $e->getMessage(),
                'cancellation_successful' => false
            ], 500);
        }
    }

    /**
     * Generate order ID for payment records
     */
    private function generateOrderId($reservationId, $type = 'ORDER'): string
    {
        return $type . '-' . $reservationId . '-' . time();
    }

    /**
     * Create payment record with consistent structure - FIXED VERSION
     */
    private function createPaymentRecord(array $data): void
    {
        try {
            Pembayaran::create([
                'guest_id' => $data['guest_id'],
                'reservation_id' => $data['reservation_id'],
                'order_id' => $data['order_id'] ?? $this->generateOrderId($data['reservation_id']),
                'amount' => $data['amount'],
                'payment_date' => now(),
                'snap_token' => $data['snap_token'] ?? null,
                'notifikasi' => $data['notifikasi'],
                'status' => $data['status'],
            ]);

            Log::info('Payment record created successfully', [
                'reservation_id' => $data['reservation_id'],
                'order_id' => $data['order_id'] ?? 'generated',
                'amount' => $data['amount'],
                'status' => $data['status']
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to create payment record: ' . $e->getMessage(), [
                'data' => $data,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
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

        // Default to true for testing - change to false for production
        return true;
    }

    /**
     * Process refund via Midtrans API using Guzzle - IMPROVED VERSION
     */
    private function processMidtransRefund($payment, $refundAmount, $reservationId): array
    {
        try {
            // Generate order_id from payment data
            $orderId = $this->getOrderIdFromPayment($payment);
            if (!$orderId) {
                return [
                    'success' => false,
                    'message' => 'Order ID tidak ditemukan',
                    'order_id' => null
                ];
            }

            // Validate refund amount
            if ($refundAmount <= 0) {
                return [
                    'success' => false,
                    'message' => 'Invalid refund amount: ' . $refundAmount,
                    'order_id' => $orderId
                ];
            }

            // Convert to integer (Midtrans expects integer in smallest currency unit)
            $refundAmountInt = (int) round($refundAmount);

            // Generate refund key
            $refundKey = 'refund-' . $reservationId . '-' . time();

            Log::info('Attempting Midtrans refund', [
                'order_id' => $orderId,
                'refund_key' => $refundKey,
                'original_amount' => $refundAmount,
                'refund_amount_int' => $refundAmountInt,
                'payment_id' => $payment->id ?? null
            ]);

            $client = new \GuzzleHttp\Client([
                'timeout' => 30,
                'connect_timeout' => 10
            ]);

            $response = $client->request('POST', 'https://api.sandbox.midtrans.com/v2/' . $orderId . '/refund', [
                'body' => json_encode([
                    'refund_key' => $refundKey,
                    'amount' => $refundAmountInt,
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

            // Check response for success/failure
            if (isset($responseBody['status_code'])) {
                $statusCode = $responseBody['status_code'];

                // Handle different Midtrans status codes
                if (in_array($statusCode, ['200', '201'])) {
                    return [
                        'success' => true,
                        'refund_id' => $refundKey,
                        'response' => $responseBody,
                        'message' => 'Refund processed successfully',
                        'order_id' => $orderId
                    ];
                } else {
                    // Handle specific error codes
                    $errorMessage = $responseBody['status_message'] ?? 'Unknown error';

                    if ($statusCode === '414') {
                        $errorMessage = 'Invalid refund amount - possibly exceeds original payment or payment not found';
                    } elseif ($statusCode === '404') {
                        $errorMessage = 'Transaction not found or not eligible for refund';
                    }

                    return [
                        'success' => false,
                        'message' => "Midtrans refund failed (Code: {$statusCode}): {$errorMessage}",
                        'order_id' => $orderId,
                        'midtrans_response' => $responseBody
                    ];
                }
            }

            // Fallback check based on HTTP status code
            if ($response->getStatusCode() === 200 || $response->getStatusCode() === 201) {
                return [
                    'success' => true,
                    'refund_id' => $refundKey,
                    'response' => $responseBody,
                    'message' => 'Refund processed successfully',
                    'order_id' => $orderId
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Midtrans refund failed with HTTP status: ' . $response->getStatusCode(),
                    'order_id' => $orderId
                ];
            }

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : 'No response body';
            $statusCode = $e->getResponse() ? $e->getResponse()->getStatusCode() : 'No status code';

            Log::error('Midtrans refund client error: ' . $e->getMessage(), [
                'response_body' => $responseBody,
                'status_code' => $statusCode,
                'order_id' => $orderId ?? 'unknown'
            ]);

            return [
                'success' => false,
                'message' => 'Midtrans API client error: ' . $e->getMessage(),
                'order_id' => $orderId ?? null
            ];
        } catch (\Exception $e) {
            Log::error('Midtrans refund error: ' . $e->getMessage(), [
                'order_id' => $orderId ?? 'unknown',
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Refund processing error: ' . $e->getMessage(),
                'order_id' => $orderId ?? null
            ];
        }
    }

    /**
     * Extract order_id from payment data - IMPROVED VERSION
     */
    private function getOrderIdFromPayment($payment): ?string
    {
        if (!$payment) {
            Log::warning('No payment provided to getOrderIdFromPayment');
            return null;
        }

        // Method 1: Check if order_id field exists and has value
        if (isset($payment->order_id) && !empty($payment->order_id)) {
            return $payment->order_id;
        }

        // Method 2: If you store order_id in snap_token field
        if ($payment->snap_token && str_contains($payment->snap_token, 'ORDER-')) {
            return $payment->snap_token;
        }

        // Method 3: If you store order_id in notifikasi field
        if ($payment->notifikasi) {
            // Try to extract order_id from notification
            if (preg_match('/ORDER-\d+/', $payment->notifikasi, $matches)) {
                return $matches[0];
            }
        }

        // Method 4: Generate order_id based on payment ID (fallback)
        $generatedOrderId = 'ORDER-' . ($payment->id ?? time());

        Log::warning('Order ID not found in payment data, using generated ID', [
            'payment_id' => $payment->id ?? null,
            'generated_order_id' => $generatedOrderId,
            'snap_token' => $payment->snap_token ?? null,
            'notifikasi' => $payment->notifikasi ?? null,
            'order_id_field' => $payment->order_id ?? null
        ]);

        return $generatedOrderId;
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

            // Check H-7 rule based on check-in date
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
                'can_refund_by_time' => $isH7Eligible,
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
