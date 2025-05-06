<?php

namespace App\Livewire\Pembayaran;

use Livewire\Component;
use App\Models\Pembayaran;

class Create extends Component
{
    public $open = false;
    public $guest_id, $reservation_id, $amount, $payment_date, $snap_token, $notifikasi, $status;

    protected $rules = [
        'guest_id' => 'required|exists:tbl_guest,id_guest',
        'reservation_id' => 'required|exists:tbl_reservasi,id_reservation',
        'amount' => 'required|numeric|min:0',
        'payment_date' => 'required|date',
        'snap_token' => 'nullable|string',
        'notifikasi' => 'nullable|string',
        'status' => 'required|string',
    ];

    public function store()
    {
        $this->validate();

        Pembayaran::create([
            'guest_id' => $this->guest_id,
            'reservation_id' => $this->reservation_id,
            'amount' => $this->amount,
            'payment_date' => $this->payment_date,
            'snap_token' => $this->snap_token,
            'notifikasi' => $this->notifikasi,
            'status' => $this->status,
        ]);

        session()->flash('message', 'Pembayaran berhasil ditambahkan.');
        $this->reset();
        $this->dispatch('refreshDatatable');
        $this->open = false;
    }

    public function render()
    {
        return view('livewire.pembayaran.create', [
            'guests' => \App\Models\Guest::all(),
            'reservasis' => \App\Models\Reservasi::all(),
        ]);
    }
}
