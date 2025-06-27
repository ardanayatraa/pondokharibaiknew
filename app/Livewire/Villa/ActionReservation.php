<?php

namespace App\Livewire\Villa;

use Livewire\Component;
use App\Models\Reservasi;
use App\Jobs\SendEmailStatus;
use Illuminate\Support\Facades\Log;

class ActionReservation extends Component
{
    public $showModal = false;
    public $reservationId;
    public $reservation;

    protected $listeners = [
        'openModal' => 'openModal',
    ];

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

    public function cancelReservation()
    {
        if (! $this->reservation || $this->reservation->status !== 'confirmed') {
            return;
        }

        $this->reservation->status = 'cancelled';
        $this->reservation->save();

        SendEmailStatus::dispatch($this->reservation, 'cancelled');
        $this->showModal = false;
    }

    public function rescheduleReservation()
    {
        if (! $this->reservation || $this->reservation->status !== 'confirmed') {
            return;
        }

        // Emit event to open reschedule modal instead of changing status
        $this->dispatch('openRescheduleModal', $this->reservationId);
        $this->showModal = false;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.villa.action-reservation');
    }
}
