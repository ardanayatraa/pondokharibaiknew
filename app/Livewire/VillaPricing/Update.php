<?php

namespace App\Livewire\VillaPricing;

use Livewire\Component;
use App\Models\VillaPricing;

class Update extends Component
{
    public $open = false;
    public $id_villa_pricing;
    public $villa_id, $season_id;
    public $sunday_pricing, $monday_pricing, $tuesday_pricing, $wednesday_pricing, $thursday_pricing, $friday_pricing, $saturday_pricing;

    protected $listeners = ['edit' => 'loadData'];

    protected $rules = [
        'villa_id' => 'required|exists:tbl_villa,id_villa',
        'season_id' => 'required|exists:tbl_season,id_season',
        'sunday_pricing' => 'required|numeric',
        'monday_pricing' => 'required|numeric',
        'tuesday_pricing' => 'required|numeric',
        'wednesday_pricing' => 'required|numeric',
        'thursday_pricing' => 'required|numeric',
        'friday_pricing' => 'required|numeric',
        'saturday_pricing' => 'required|numeric',
    ];

    public function loadData($id)
    {
        $data = VillaPricing::findOrFail($id);
        $this->id_villa_pricing = $data->id_villa_pricing;
        $this->villa_id = $data->villa_id;
        $this->season_id = $data->season_id;
        $this->sunday_pricing = $data->sunday_pricing;
        $this->monday_pricing = $data->monday_pricing;
        $this->tuesday_pricing = $data->tuesday_pricing;
        $this->wednesday_pricing = $data->wednesday_pricing;
        $this->thursday_pricing = $data->thursday_pricing;
        $this->friday_pricing = $data->friday_pricing;
        $this->saturday_pricing = $data->saturday_pricing;
        $this->open = true;
    }

    public function update()
    {
        $this->validate();

        VillaPricing::where('id_villa_pricing', $this->id_villa_pricing)->update([
            'villa_id' => $this->villa_id,
            'season_id' => $this->season_id,
            'sunday_pricing' => $this->sunday_pricing,
            'monday_pricing' => $this->monday_pricing,
            'tuesday_pricing' => $this->tuesday_pricing,
            'wednesday_pricing' => $this->wednesday_pricing,
            'thursday_pricing' => $this->thursday_pricing,
            'friday_pricing' => $this->friday_pricing,
            'saturday_pricing' => $this->saturday_pricing,
        ]);

        session()->flash('message', 'Data harga villa berhasil diperbarui.');
        $this->dispatch('refreshDatatable');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.villa-pricing.update', [
            'villas' => \App\Models\Villa::all(),
            'seasons' => \App\Models\Season::all(),
        ]);
    }
}
