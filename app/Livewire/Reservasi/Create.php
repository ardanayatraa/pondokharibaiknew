<?php

namespace App\Livewire\Reservasi;

use Livewire\Component;
use App\Models\Reservasi;

class Create extends Component
{
    public $open = false;
    public $guest_id, $villa_id, $cek_ketersediaan_id, $villa_pricing_id;
    public $start_date, $end_date, $status, $total_amount;

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

    public function store()
    {
        $this->validate();

        Reservasi::create([
            'guest_id' => $this->guest_id,
            'villa_id' => $this->villa_id,
            'cek_ketersediaan_id' => $this->cek_ketersediaan_id,
            'villa_pricing_id' => $this->villa_pricing_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
            'total_amount' => $this->total_amount,
        ]);

        session()->flash('message', 'Reservasi berhasil ditambahkan.');
        $this->reset();
        $this->dispatch('refreshDatatable');
        $this->open = false;
    }

    public function render()
    {
        return view('livewire.reservasi.create', [
            'guests' => \App\Models\Guest::all(),
            'villas' => \App\Models\Villa::all(),
            'ketersediaan' => \App\Models\CekKetersediaan::all(),
            'pricings' => \App\Models\VillaPricing::all(),
        ]);
    }
}
