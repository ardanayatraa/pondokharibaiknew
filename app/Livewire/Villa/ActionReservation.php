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
    public $canReschedule = false;
    public $rescheduleMessage = '';

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
                'refund_amount' => $this->refundInfo['refund_amount'] ?? 0,
                'payment_method' => $this->refundInfo['payment_method'] ?? 'Other',
                'cancelation_reason' => $this->cancelationReason,
            ]);

            $response = $refundController->processRefund($request);
            $responseData = json_decode($response->getContent(), true);

            // IMPROVED: Always check if cancellation was successful first
            if (isset($responseData['cancellation_successful']) && $responseData['cancellation_successful']) {
                // Send email notification for successful cancellation
                try {
                    SendEmailStatus::dispatch($this->reservation, 'cancelled');
                } catch (\Exception $e) {
                    Log::warning('Failed to send cancellation email: ' . $e->getMessage());
                }

                // Determine message and alert type based on refund status
                $message = $this->getCancellationMessage($responseData);
                $alertType = $this->getCancellationAlertType($responseData);

                $this->dispatch('show-alert', [
                    'type' => $alertType,
                    'message' => $message
                ]);

                // Close modals and reset form
                $this->showCancelModal = false;
                $this->showModal = false;
                $this->cancelationReason = '';

                // Refresh component
                $this->dispatch('reservation-cancelled');

            } else {
                // Cancellation failed
                $errorMessage = $responseData['error'] ?? $responseData['message'] ?? 'Gagal memproses pembatalan';
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

    /**
     * Get appropriate cancellation message based on response data
     */
    private function getCancellationMessage(array $responseData): string
    {
        $refundStatus = $responseData['refund_status'] ?? '';
        $isH7Eligible = $responseData['h7_eligible'] ?? false;
        $daysUntilCheckIn = $responseData['days_until_checkin'] ?? 0;

        switch ($refundStatus) {
            case 'no_refund':
                return "Reservasi berhasil dibatalkan. Tidak ada refund karena pembatalan dilakukan kurang dari 7 hari sebelum check-in (sisa {$daysUntilCheckIn} hari).";

            case 'refunded':
                return 'Pembatalan berhasil diproses. Refund 50% akan diproses dalam 3-5 hari kerja.';

            case 'manual_refund_required':
                return 'Reservasi berhasil dibatalkan. Refund 50% akan diproses manual oleh tim kami dalam 1x24 jam karena metode pembayaran tidak mendukung refund otomatis.';

            case 'refund_failed_manual_required':
                return 'Reservasi berhasil dibatalkan. Refund otomatis gagal, tim kami akan memproses refund manual dalam 1x24 jam.';

            case 'no_payment_found':
                return 'Reservasi berhasil dibatalkan. Tidak ada pembayaran yang ditemukan untuk direfund.';

            default:
                if ($isH7Eligible) {
                    return 'Reservasi berhasil dibatalkan. Refund 50% akan diproses sesuai kebijakan.';
                } else {
                    return "Reservasi berhasil dibatalkan. Tidak ada refund karena pembatalan dilakukan kurang dari H-7 (sisa {$daysUntilCheckIn} hari).";
                }
        }
    }

    /**
     * Get appropriate alert type based on response data
     */
    private function getCancellationAlertType(array $responseData): string
    {
        $refundStatus = $responseData['refund_status'] ?? '';
        $manualProcessRequired = $responseData['manual_process_required'] ?? false;

        if (in_array($refundStatus, ['refunded'])) {
            return 'success';
        } elseif (in_array($refundStatus, ['manual_refund_required', 'refund_failed_manual_required']) || $manualProcessRequired) {
            return 'warning';
        } else {
            return 'success'; // Cancellation successful regardless of refund status
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
