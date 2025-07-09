<?php

namespace App\Jobs;

use App\Models\Reservasi;
use App\Models\Pembayaran;
use App\Http\Controllers\RefundController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessRefundInBackground implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $reservationId;
    protected $refundAmount;
    protected $cancelationReason;

    /**
     * Create a new job instance.
     */
    public function __construct($reservationId, $refundAmount, $cancelationReason)
    {
        $this->reservationId = $reservationId;
        $this->refundAmount = $refundAmount;
        $this->cancelationReason = $cancelationReason;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $reservation = Reservasi::with(['guest', 'villa', 'pembayaran'])->find($this->reservationId);

            if (!$reservation) {
                Log::error('Background refund: Reservation not found', ['reservation_id' => $this->reservationId]);
                return;
            }

            // Get latest payment
            $latestPayment = $reservation->pembayaran()
                ->where('status', 'paid')
                ->latest('payment_date')
                ->first();

            if (!$latestPayment) {
                Log::error('Background refund: No payment found', ['reservation_id' => $this->reservationId]);
                return;
            }

            // Create RefundController instance
            $refundController = new RefundController();

            // Use reflection to access private method
            $reflection = new \ReflectionClass($refundController);
            $processMidtransRefund = $reflection->getMethod('processMidtransRefund');
            $processMidtransRefund->setAccessible(true);

            // Attempt refund
            $refundResult = $processMidtransRefund->invoke($refundController, $latestPayment, $this->refundAmount);

            // Update payment record based on result
            if ($refundResult['success']) {
                // Update existing manual refund record to successful
                Pembayaran::where('reservation_id', $this->reservationId)
                    ->where('status', 'manual_refund_required')
                    ->update([
                        'status' => 'refunded',
                        'snap_token' => $refundResult['refund_id'] ?? null,
                        'notifikasi' => "Refund 50% berhasil (background process) untuk pembatalan reservasi #{$reservation->id_reservation} - Alasan: {$this->cancelationReason} - Refund ID: {$refundResult['refund_id']}"
                    ]);

                Log::info('Background refund successful', [
                    'reservation_id' => $this->reservationId,
                    'refund_id' => $refundResult['refund_id'] ?? null
                ]);
            } else {
                // Update to failed status
                Pembayaran::where('reservation_id', $this->reservationId)
                    ->where('status', 'manual_refund_required')
                    ->update([
                        'status' => 'refund_failed_manual_required',
                        'notifikasi' => "Refund 50% GAGAL (background process) untuk pembatalan reservasi #{$reservation->id_reservation} - Alasan: {$this->cancelationReason} - Error: {$refundResult['message']}"
                    ]);

                Log::error('Background refund failed', [
                    'reservation_id' => $this->reservationId,
                    'error' => $refundResult['message']
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Background refund job error: ' . $e->getMessage(), [
                'reservation_id' => $this->reservationId,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
