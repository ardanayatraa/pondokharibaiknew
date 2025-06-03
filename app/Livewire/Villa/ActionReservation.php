<?php

namespace App\Livewire\Villa;

use Livewire\Component;
use App\Models\Reservasi;
use App\Jobs\SendEmailStatus;
use Illuminate\Support\Facades\Log;

class ActionReservation extends Component
{
    // Properti untuk kontrol modal dan data reservasi
    public $showModal = false;
    public $reservationId;
    public $reservation; // Akan berisi instance Reservasi lengkap dengan relasi

    protected $listeners = [
        // Event trigger dari komponen lain, misal GuestReservasiTable
        'openModal' => 'openModal',
    ];

    /**
     * Method ini dipanggil saat event `openModal` di‐emit,
     * misalnya: Livewire.emit('openModal', 123)
     */
    public function openModal($idReservation)
    {
        $this->reservationId = $idReservation;
        $this->loadReservation();
        $this->showModal = true;
    }

    /**
     * Load data Reservasi berdasarkan ID (beserta relasi guest & villa).
     */
    protected function loadReservation()
    {
        $this->reservation = Reservasi::with(['guest', 'villa'])
            ->find($this->reservationId);
        if (! $this->reservation) {
            // Jika data tidak ditemukan, tutup modal dan log error
            $this->showModal = false;
        }
    }

    /**
     * Batalkan reservasi (status → 'cancelled') jika status sebelumnya 'confirmed'.
     */
    public function cancelReservation()
    {
        if (! $this->reservation || $this->reservation->status !== 'confirmed') {
            return;
        }

        $this->reservation->status = 'cancelled';
        $this->reservation->save();

        // Dispatch job kirim email
        SendEmailStatus::dispatch($this->reservation, 'cancelled');

        // Tutup modal
        $this->showModal = false;
    }

    /**
     * Tandai reservasi sebagai 'reschedule' jika sebelumnya 'confirmed'.
     */
    public function rescheduleReservation()
    {
        if (! $this->reservation || $this->reservation->status !== 'confirmed') {
            return;
        }

        $this->reservation->status = 'reschedule';
        $this->reservation->save();

        // Dispatch job kirim email
        SendEmailStatus::dispatch($this->reservation, 'reschedule');

        // Emit event agar komponen lain bisa refresh
        $this->emit('reservationStatusUpdated');

        // Tutup modal
        $this->showModal = false;
    }

    /**
     * Tutup modal tanpa mengubah apa‐apa.
     */
    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.villa.action-reservation');
    }
}
