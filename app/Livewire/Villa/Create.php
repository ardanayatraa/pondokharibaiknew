<?php

namespace App\Livewire\Villa;

use Livewire\Component;
use App\Models\Facility;
use App\Models\Villa;
use App\Models\VillaPricing;
use App\Models\CekKetersediaan;

class Create extends Component
{
    public $open = false;
    public $facility_id = [];
    public $villa_pricing_id, $name, $description, $cek_ketersediaan_id;

    protected $rules = [
        'facility_id' => 'required|array|min:1',
        'facility_id.*' => 'exists:tbl_facility,id_facility',
        'villa_pricing_id' => 'required|exists:tbl_villa_pricing,id_villa_pricing',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'cek_ketersediaan_id' => 'nullable|exists:tbl_cek_ketersediaan,id_cek_ketersediaan',
    ];

    public function store()
    {
        $this->validate();

        Villa::create([
            'facility_id' => $this->facility_id,
            'villa_pricing_id' => $this->villa_pricing_id,
            'name' => $this->name,
            'description' => $this->description,
            'cek_ketersediaan_id' => $this->cek_ketersediaan_id,
        ]);

        session()->flash('message', 'Villa berhasil ditambahkan.');

        $this->resetExcept('open');
        $this->dispatch('refreshDatatable');
        $this->open = false;
    }

    public function render()
    {
        return view('livewire.villa.create', [
            'facilities' => Facility::all(),
            'pricings' => VillaPricing::all(),
            'ketersediaanList' => CekKetersediaan::all(),
        ]);
    }
}
