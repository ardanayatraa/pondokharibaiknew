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

            // Check 7-day rule - calculate from latest payment date
            $latestPayment = $reservation->pembayaran()
                ->where('status', 'paid')
                ->latest('payment_date')
                ->first();

            if (!$latestPayment) {
                return response()->json(['error' => 'No payment found for this reservation'], 400);
            }

            $paymentDate = Carbon::parse($latestPayment->payment_date);
            $daysSincePayment = $paymentDate->diffInDays(Carbon::now());

            if ($daysSincePayment > 7) {
                return response()->json([
                    'error' => 'Refund hanya dapat dilakukan dalam 7 hari setelah pembayaran',
                    'payment_date' => $paymentDate->format('d M Y H:i'),
                    'days_since_payment' => $daysSincePayment
                ], 400);
            }

            // Check if payment method is QRIS
            $isQrisPayment = $this->checkIfQrisPayment($latestPayment);

            if (!$isQrisPayment) {
                return response()->json([
                    'error' => 'Refund hanya tersedia untuk pembayaran menggunakan QRIS',
                    'payment_method' => $validated['payment_method']
                ], 400);
            }

            // Process refund via Midtrans API
            $refundResult = $this->processMidtransRefund($latestPayment, $validated['refund_amount']);

            // Update reservation status and set cancellation date regardless of refund result
            $reservation->update([
                'status' => 'cancelled',
                'cancelation_date' => now(),
                'cancelation_reason' => $validated['cancelation_reason'],
            ]);

            if ($refundResult['success']) {
                // Create successful refund payment record
                Pembayaran::create([
                    'guest_id' => $reservation->guest_id,
                    'reservation_id' => $reservation->id_reservation,
                    'amount' => -$validated['refund_amount'], // Negative amount for refund
                    'payment_date' => now(),
                    'snap_token' => $refundResult['refund_id'] ?? null,
                    'notifikasi' => "Refund 50% berhasil untuk pembatalan reservasi #{$reservation->id_reservation} - Alasan: {$validated['cancelation_reason']} - Refund ID: {$refundResult['refund_id']}",
                    'status' => 'refunded',
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Refund berhasil diproses',
                    'refund_amount' => $validated['refund_amount'],
                    'refund_id' => $refundResult['refund_id'] ?? null,
                    'cancelation_reason' => $validated['cancelation_reason'],
                    'refund_status' => 'success',
                    'midtrans_response' => $refundResult['response'] ?? null,
                ]);
            } else {
                // Create failed refund payment record
                Pembayaran::create([
                    'guest_id' => $reservation->guest_id,
                    'reservation_id' => $reservation->id_reservation,
                    'amount' => -$validated['refund_amount'], // Negative amount for refund
                    'payment_date' => now(),
                    'snap_token' => null,
                    'notifikasi' => "Refund 50% GAGAL untuk pembatalan reservasi #{$reservation->id_reservation} - Alasan: {$validated['cancelation_reason']} - Error: {$refundResult['message']}",
                    'status' => 'refund_failed',
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Reservasi dibatalkan, namun refund otomatis gagal. Tim kami akan memproses refund manual.',
                    'refund_amount' => $validated['refund_amount'],
                    'cancelation_reason' => $validated['cancelation_reason'],
                    'refund_status' => 'failed',
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

        // Default to true for testing - you can change this
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
                    'reason' => 'Customer cancellation - 50% refund policy'
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
     * Get refund information for a reservation
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

            // Calculate 50% refund
            $refundAmount = $totalPaid * 0.5;

            // Get payment method info
            $latestPayment = $reservation->pembayaran()
                ->where('status', 'paid')
                ->latest('payment_date')
                ->first();

            $isQrisPayment = $latestPayment ? $this->checkIfQrisPayment($latestPayment) : false;

            // Check 7-day rule
            $canRefundByTime = true;
            $daysSincePayment = 0;
            $paymentDate = null;

            if ($latestPayment) {
                $paymentDate = Carbon::parse($latestPayment->payment_date);
                $daysSincePayment = $paymentDate->diffInDays(Carbon::now());
                $canRefundByTime = $daysSincePayment <= 7;
            }

            $canRefund = $isQrisPayment && $totalPaid > 0 && $canRefundByTime;

            return response()->json([
                'total_paid' => $totalPaid,
                'refund_amount' => $refundAmount,
                'refund_percentage' => 50,
                'is_qris_payment' => $isQrisPayment,
                'can_refund' => $canRefund,
                'can_refund_by_time' => $canRefundByTime,
                'days_since_payment' => $daysSincePayment,
                'payment_date' => $paymentDate ? $paymentDate->format('d M Y H:i') : null,
                'payment_method' => $isQrisPayment ? 'QRIS' : 'Other',
                'order_id' => $latestPayment ? $this->getOrderIdFromPayment($latestPayment) : null,
                'refund_deadline' => $paymentDate ? $paymentDate->addDays(7)->format('d M Y H:i') : null
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
