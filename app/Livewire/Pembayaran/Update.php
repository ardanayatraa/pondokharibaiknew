<?php

namespace App\Livewire\Pembayaran;

use Livewire\Component;
use App\Models\Pembayaran;

class Update extends Component
{
    public $open = false;
    public $id_pembayaran;
    public $guest_id, $reservation_id, $amount, $payment_date, $snap_token, $notifikasi, $status;

    protected $listeners = ['edit' => 'loadData'];

    protected $rules = [
        'guest_id' => 'required|exists:tbl_guest,id_guest',
        'reservation_id' => 'required|exists:tbl_reservasi,id_reservation',
        'amount' => 'required|numeric|min:0',
        'payment_date' => 'required|date',
        'snap_token' => 'nullable|string',
        'notifikasi' => 'nullable|string',
        'status' => 'required|string',
    ];

    public function loadData($id)
    {
        $data = Pembayaran::findOrFail($id);
        $this->id_pembayaran = $data->id_pembayaran;
        $this->guest_id = $data->guest_id;
        $this->reservation_id = $data->reservation_id;
        $this->amount = $data->amount;
        $this->payment_date = $data->payment_date;
        $this->snap_token = $data->snap_token;
        $this->notifikasi = $data->notifikasi;
        $this->status = $data->status;
        $this->open = true;
    }

    public function update()
    {
        $this->validate();

        Pembayaran::where('id_pembayaran', $this->id_pembayaran)->update([
            'guest_id' => $this->guest_id,
            'reservation_id' => $this->reservation_id,
            'amount' => $this->amount,
            'payment_date' => $this->payment_date,
            'snap_token' => $this->snap_token,
            'notifikasi' => $this->notifikasi,
            'status' => $this->status,
        ]);

        session()->flash('message', 'Pembayaran berhasil diperbarui.');
        $this->dispatch('refreshDatatable');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.pembayaran.update', [
            'guests' => \App\Models\Guest::all(),
            'reservasis' => \App\Models\Reservasi::all(),
        ]);
    }
}
