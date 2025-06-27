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

            // Get the latest payment for this reservation
            $latestPayment = $reservation->pembayaran()
                ->where('status', 'paid')
                ->latest()
                ->first();

            if (!$latestPayment) {
                return response()->json(['error' => 'No payment found for this reservation'], 400);
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

            if ($refundResult['success']) {
                // Update reservation status and set cancellation date
                $reservation->update([
                    'status' => 'cancelled',
                    'cancelation_date' => now(),
                ]);

                // Create refund payment record
                Pembayaran::create([
                    'guest_id' => $reservation->guest_id,
                    'reservation_id' => $reservation->id_reservation,
                    'amount' => -$validated['refund_amount'], // Negative amount for refund
                    'payment_date' => now(),
                    'snap_token' => $refundResult['refund_id'] ?? null,
                    'notifikasi' => "Refund 50% untuk pembatalan reservasi #{$reservation->id_reservation} - Refund ID: {$refundResult['refund_id']}",
                    'status' => 'refunded',
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Refund berhasil diproses',
                    'refund_amount' => $validated['refund_amount'],
                    'refund_id' => $refundResult['refund_id'] ?? null,
                    'midtrans_response' => $refundResult['response'] ?? null,
                ]);
            } else {
                return response()->json([
                    'error' => 'Gagal memproses refund: ' . $refundResult['message']
                ], 500);
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
    private function processMidtransRefund($payment): array
    {
        try {
            // Generate order_id from payment data
         $pembayaran = Pembayaran::where('reservation_id', $payment->reservation_id)
                        ->where('status', 'paid')
                        ->latest()
                        ->first();

            $orderId = $pembayaran->order_id;

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
                'headers' => [
                    'accept' => 'application/json',
                    'authorization' => 'Basic ' . base64_encode(config('midtrans.server_key') . ':')
                ],
            ]);


            $responseBody = json_decode($response->getBody(), true);



            return [
                'success' => true,
                'refund_id' => $refundKey,
                'response' => $responseBody,
                'message' => 'Refund processed successfully'
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
        $orderId = 'ORDER-' . $payment->id . '-' . strtotime($payment->payment_date);

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
                ->latest()
                ->first();

            $isQrisPayment = $latestPayment ? $this->checkIfQrisPayment($latestPayment) : false;

            return response()->json([
                'total_paid' => $totalPaid,
                'refund_amount' => $refundAmount,
                'refund_percentage' => 50,
                'is_qris_payment' => $isQrisPayment,
                'can_refund' => $isQrisPayment && $totalPaid > 0,
                'payment_method' => $isQrisPayment ? 'QRIS' : 'Other',
                'order_id' => $latestPayment ? $this->getOrderIdFromPayment($latestPayment) : null
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

            $response = $client->request('POST', 'https://api.sandbox.midtrans.com/v2/' . $orderId . '/refund', [
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
