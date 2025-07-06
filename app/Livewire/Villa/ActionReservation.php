<?php

namespace App\Livewire\Villa;

use Livewire\Component;
use App\Models\Reservasi;
use App\Models\Pembayaran;
use App\Jobs\SendEmailStatus;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ActionReservation extends Component
{
    public $showModal = false;
    public $showCancelModal = false;
    public $reservationId;
    public $reservation;
    public $refundInfo = null;
    public $isProcessing = false;
    public $debugPaymentInfo = null;
    public $cancelationReason = '';
    public $canReschedule = false; // New property for H-7 validation
    public $rescheduleMessage = ''; // Message about reschedule eligibility

    protected $listeners = [
        'openModal' => 'openModal',
    ];

    public function mount()
    {
        $this->refundInfo = null;
        $this->cancelationReason = '';
        $this->canReschedule = false;
        $this->rescheduleMessage = '';
    }

    public function openModal($idReservation)
    {
        $this->reservationId = $idReservation;
        $this->loadReservation();
        $this->checkRescheduleEligibility();
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

    /**
     * Check if reschedule is allowed based on H-7 rule
     */
    protected function checkRescheduleEligibility()
    {
        if (!$this->reservation) {
            $this->canReschedule = false;
            $this->rescheduleMessage = 'Reservasi tidak ditemukan';
            return;
        }

        // Only allow reschedule for confirmed or rescheduled reservations
        if (!in_array($this->reservation->status, ['confirmed', 'rescheduled'])) {
            $this->canReschedule = false;
            $this->rescheduleMessage = 'Reschedule tidak tersedia untuk status reservasi ini';
            return;
        }

        $today = Carbon::today();
        $checkInDate = Carbon::parse($this->reservation->start_date)->startOfDay();

        // Calculate difference in days
        $daysUntilCheckIn = $today->diffInDays($checkInDate, false);

        // Allow reschedule if check-in is at least 7 days away
        $this->canReschedule = $daysUntilCheckIn >= 7;

        if ($this->canReschedule) {
            $this->rescheduleMessage = "Reschedule diizinkan ({$daysUntilCheckIn} hari sebelum check-in)";
        } else {
            if ($daysUntilCheckIn < 0) {
                $this->rescheduleMessage = "Check-in sudah berlalu, reschedule tidak dapat dilakukan";
            } else {
                $this->rescheduleMessage = "Reschedule hanya dapat dilakukan minimal 7 hari sebelum check-in (sisa {$daysUntilCheckIn} hari)";
            }
        }
    }

    public function openCancelModal()
    {
        if (!$this->reservation) return;

        // Load refund information
        $this->loadRefundInfo();
        $this->cancelationReason = '';
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

            // Debug payment info
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
            $errorMessage = 'Pembatalan tidak dapat diproses';

            if (!$this->refundInfo['can_refund_by_time']) {
                $errorMessage = 'Refund hanya dapat dilakukan dalam 7 hari setelah pembayaran';
            } elseif (!$this->refundInfo['is_qris_payment']) {
                $errorMessage = 'Refund hanya tersedia untuk pembayaran menggunakan QRIS';
            }

            $this->dispatch('show-alert', [
                'type' => 'error',
                'message' => $errorMessage
            ]);
            return;
        }

        // Validate cancellation reason
        if (empty(trim($this->cancelationReason))) {
            $this->dispatch('show-alert', [
                'type' => 'error',
                'message' => 'Alasan pembatalan harus diisi'
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
                'payment_method' => $this->refundInfo['payment_method'],
                'cancelation_reason' => $this->cancelationReason,
            ]);

            $response = $refundController->processRefund($request);
            $responseData = json_decode($response->getContent(), true);

            if (isset($responseData['success']) && $responseData['success']) {
                // Send email notification for successful refund
                SendEmailStatus::dispatch($this->reservation, 'cancelled');

                $this->dispatch('show-alert', [
                    'type' => 'success',
                    'message' => 'Pembatalan berhasil diproses. Refund 50% akan diproses dalam 3-5 hari kerja.'
                ]);
            } elseif (isset($responseData['manual_process_required']) && $responseData['manual_process_required']) {
                // Send email notification for failed refund (manual process required)
                SendEmailStatus::dispatch($this->reservation, 'cancelled');

                $this->dispatch('show-alert', [
                    'type' => 'warning',
                    'message' => 'Reservasi dibatalkan. Refund otomatis gagal, tim kami akan memproses refund manual dalam 1x24 jam.'
                ]);
            } else {
                $errorMessage = $responseData['error'] ?? 'Gagal memproses refund';
                $this->dispatch('show-alert', [
                    'type' => 'error',
                    'message' => $errorMessage
                ]);
                return;
            }

            $this->showCancelModal = false;
            $this->showModal = false;
            $this->cancelationReason = '';

            // Refresh component
            $this->dispatch('reservation-cancelled');

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
        // Check H-7 eligibility before allowing reschedule
        if (!$this->canReschedule) {
            $this->dispatch('show-alert', [
                'type' => 'error',
                'message' => $this->rescheduleMessage
            ]);
            return;
        }

        if (!$this->reservation || !in_array($this->reservation->status, ['confirmed', 'rescheduled'])) {
            $this->dispatch('show-alert', [
                'type' => 'error',
                'message' => 'Reschedule tidak tersedia untuk reservasi ini'
            ]);
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
        $this->cancelationReason = '';
        $this->canReschedule = false;
        $this->rescheduleMessage = '';
    }

    public function closeCancelModal()
    {
        $this->showCancelModal = false;
        $this->refundInfo = null;
        $this->isProcessing = false;
        $this->cancelationReason = '';
    }

    public function render()
    {
        return view('livewire.villa.action-reservation');
    }
}
