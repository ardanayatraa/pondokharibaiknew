<?php

namespace App\Livewire\Reservasi;

use Livewire\Component;
use App\Models\Reservasi;

class Update extends Component
{
    public $open = false;
    public $id_reservation;
    public $guest_id, $villa_id, $cek_ketersediaan_id, $villa_pricing_id;
    public $start_date, $end_date, $status, $total_amount;

    protected $listeners = ['edit' => 'loadData'];

    protected $rules = [
        'guest_id' => 'required|exists:tbl_guest,id_guest',
        'villa_id' => 'required|exists:tbl_villa,id_villa',
        'cek_ketersediaan_id' => 'nullable|exists:tbl_cek_ketersediaan,id_cek_ketersediaan',
        'villa_pricing_id' => 'required|exists:tbl_villa_pricing,id_villa_pricing',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'status' => 'required|string|max:100',
        'total_amount' => 'required|numeric|min:0',
    ];

    public function loadData($id)
    {
        $data = Reservasi::findOrFail($id);
        $this->id_reservation = $data->id_reservation;
        $this->guest_id = $data->guest_id;
        $this->villa_id = $data->villa_id;
        $this->cek_ketersediaan_id = $data->cek_ketersediaan_id;
        $this->villa_pricing_id = $data->villa_pricing_id;
        $this->start_date = $data->start_date;
        $this->end_date = $data->end_date;
        $this->status = $data->status;
        $this->total_amount = $data->total_amount;
        $this->open = true;
    }

    public function update()
    {
        $this->validate();

        Reservasi::where('id_reservation', $this->id_reservation)->update([
            'guest_id' => $this->guest_id,
            'villa_id' => $this->villa_id,
            'cek_ketersediaan_id' => $this->cek_ketersediaan_id,
            'villa_pricing_id' => $this->villa_pricing_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
            'total_amount' => $this->total_amount,
        ]);

        session()->flash('message', 'Reservasi berhasil diperbarui.');
        $this->dispatch('refreshDatatable');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.reservasi.update', [
            'guests' => \App\Models\Guest::all(),
            'villas' => \App\Models\Villa::all(),
            'ketersediaan' => \App\Models\CekKetersediaan::all(),
            'pricings' => \App\Models\VillaPricing::all(),
        ]);
    }
}
