<?php

namespace App\Livewire\Villa;

use Livewire\Component;
use App\Models\Facility;
use App\Models\Villa;
use App\Models\VillaPricing;
use App\Models\CekKetersediaan;

class Update extends Component
{
    public $open = false;

    public $villa_id;
    public $facility_id = [];
    public $villa_pricing_id, $name, $description, $cek_ketersediaan_id;

    protected $listeners = ['edit' => 'loadData'];

    protected $rules = [
        'facility_id' => 'required|array|min:1',
        'facility_id.*' => 'exists:tbl_facility,id_facility',
        'villa_pricing_id' => 'required|exists:tbl_villa_pricing,id_villa_pricing',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'cek_ketersediaan_id' => 'nullable|exists:tbl_cek_ketersediaan,id_cek_ketersediaan',
    ];

    public function loadData($id)
    {
        $villa = Villa::findOrFail($id);
        $this->villa_id = $villa->id_villa;
        // Fix: casting facility_id JSON array to array of strings for checkbox binding
        $this->facility_id = collect($villa->facility_id)->map(fn($id) => (string) $id)->toArray();
        $this->villa_pricing_id = $villa->villa_pricing_id;
        $this->name = $villa->name;
        $this->description = $villa->description;
        $this->cek_ketersediaan_id = $villa->cek_ketersediaan_id;

        $this->open = true;
    }

    public function update()
    {
        $this->validate();

        Villa::where('id_villa', $this->villa_id)->update([
            'facility_id' => $this->facility_id,
            'villa_pricing_id' => $this->villa_pricing_id,
            'name' => $this->name,
            'description' => $this->description,
            'cek_ketersediaan_id' => $this->cek_ketersediaan_id,
        ]);

        session()->flash('message', 'Data villa berhasil diperbarui.');
        $this->dispatch('refreshDatatable');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.villa.update', [
            'facilities' => Facility::all(),
            'pricings' => VillaPricing::all(),
            'ketersediaanList' => CekKetersediaan::all(),
        ]);
    }
}
