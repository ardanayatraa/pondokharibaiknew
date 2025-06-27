<?php

namespace App\Livewire\Villa;

use Livewire\Component;
use App\Models\Reservasi;
use App\Models\Pembayaran;
use App\Jobs\SendEmailStatus;
use Illuminate\Support\Facades\Log;

class ActionReservation extends Component
{
    public $showModal = false;
    public $showCancelModal = false;
    public $reservationId;
    public $reservation;
    public $refundInfo = null;
    public $isProcessing = false;
    public $debugPaymentInfo = null; // For debugging

    protected $listeners = [
        'openModal' => 'openModal',
    ];

    public function mount()
    {
        $this->refundInfo = null;
    }

    public function openModal($idReservation)
    {
        $this->reservationId = $idReservation;
        $this->loadReservation();
        $this->showModal = true;
    }

    protected function loadReservation()
    {
        $this->reservation = Reservasi::with(['guest', 'villa', 'pembayaran'])
            ->find($this->reservationId);
        if (! $this->reservation) {
            $this->showModal = false;
        }
    }

    public function openCancelModal()
    {
        if (!$this->reservation) return;

        // Load refund information
        $this->loadRefundInfo();
        $this->showCancelModal = true;
    }

    private function loadRefundInfo()
    {
        try {
            // Call RefundController to get refund info
            $refundController = new \App\Http\Controllers\RefundController();
            $response = $refundController->getRefundInfo($this->reservation->id_reservation);

            $responseData = json_decode($response->getContent(), true);

            if (isset($responseData['error'])) {
                Log::error('Load refund info error: ' . $responseData['error']);
                $this->refundInfo = null;
                return;
            }

            $this->refundInfo = $responseData;

            // Debug payment info masih tetap ada
            $latestPayment = $this->reservation->pembayaran()
                ->where('status', 'paid')
                ->latest()
                ->first();

            $this->debugPaymentInfo = $latestPayment ? [
                'id' => $latestPayment->id,
                'snap_token' => $latestPayment->snap_token,
                'notifikasi' => $latestPayment->notifikasi,
                'payment_date' => $latestPayment->payment_date,
                'amount' => $latestPayment->amount,
            ] : null;

        } catch (\Exception $e) {
            Log::error('Load refund info error: ' . $e->getMessage());
            $this->refundInfo = null;
        }
    }

    public function processCancellation()
    {
        if ($this->isProcessing) return;

        if (!$this->reservation || !$this->refundInfo) {
            $this->dispatch('show-alert', [
                'type' => 'error',
                'message' => 'Tidak dapat memproses pembatalan'
            ]);
            return;
        }

        if (!$this->refundInfo['can_refund']) {
            $this->dispatch('show-alert', [
                'type' => 'error',
                'message' => 'Refund hanya tersedia untuk pembayaran menggunakan QRIS'
            ]);
            return;
        }

        $this->isProcessing = true;

        try {
            // Call RefundController to process refund
            $refundController = new \App\Http\Controllers\RefundController();

            $request = new \Illuminate\Http\Request([
                'reservation_id' => $this->reservation->id_reservation,
                'refund_amount' => $this->refundInfo['refund_amount'],
                'payment_method' => $this->refundInfo['payment_method']
            ]);

            $response = $refundController->processRefund($request);
            $responseData = json_decode($response->getContent(), true);

            if (isset($responseData['success']) && $responseData['success']) {
                // Send email notification
                SendEmailStatus::dispatch($this->reservation, 'cancelled');

                $this->dispatch('show-alert', [
                    'type' => 'success',
                    'message' => 'Pembatalan berhasil diproses. Refund 50% akan diproses dalam 3-5 hari kerja.'
                ]);

                $this->showCancelModal = false;
                $this->showModal = false;

                // Refresh component
                $this->dispatch('reservation-cancelled');
            } else {
                $errorMessage = $responseData['error'] ?? 'Gagal memproses refund';
                $this->dispatch('show-alert', [
                    'type' => 'error',
                    'message' => $errorMessage
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Process cancellation error: ' . $e->getMessage());
            $this->dispatch('show-alert', [
                'type' => 'error',
                'message' => 'Terjadi kesalahan saat memproses pembatalan: ' . $e->getMessage()
            ]);
        } finally {
            $this->isProcessing = false;
        }
    }

    public function cancelReservation()
    {
        $this->openCancelModal();
    }

    public function rescheduleReservation()
    {
        if (! $this->reservation || !in_array($this->reservation->status, ['confirmed', 'rescheduled'])) {
            return;
        }

        $this->dispatch('openRescheduleModal', $this->reservationId);
        $this->showModal = false;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->showCancelModal = false;
        $this->refundInfo = null;
        $this->isProcessing = false;
        $this->debugPaymentInfo = null;
    }

    public function closeCancelModal()
    {
        $this->showCancelModal = false;
        $this->refundInfo = null;
        $this->isProcessing = false;
    }

    public function render()
    {
        return view('livewire.villa.action-reservation');
    }
}
