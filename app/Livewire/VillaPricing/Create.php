<?php

namespace App\Livewire\VillaPricing;

use Livewire\Component;
use App\Models\VillaPricing;
use App\Models\Villa;
use App\Models\Season;

class Create extends Component
{
    public $open = false;
    public $villa_id, $season_id;
    public $sunday_pricing, $monday_pricing, $tuesday_pricing, $wednesday_pricing, $thursday_pricing, $friday_pricing, $saturday_pricing;

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

    public function updatedVillaId()
    {
        $this->clearValidation();
    }

    public function updatedSeasonId()
    {
        $this->clearValidation();
    }

    public function store()
    {
        $this->validate();

        // Cari data berdasarkan villa_id + season_id
        $existing = VillaPricing::where('villa_id', $this->villa_id)
            ->where('season_id', $this->season_id)
            ->first();

        if ($existing) {
            // Update jika sudah ada
            $existing->update([
                'sunday_pricing' => $this->sunday_pricing,
                'monday_pricing' => $this->monday_pricing,
                'tuesday_pricing' => $this->tuesday_pricing,
                'wednesday_pricing' => $this->wednesday_pricing,
                'thursday_pricing' => $this->thursday_pricing,
                'friday_pricing' => $this->friday_pricing,
                'saturday_pricing' => $this->saturday_pricing,
            ]);

            session()->flash('message', 'Harga villa berhasil diperbarui.');
        } else {
            // Buat baru jika belum ada
            VillaPricing::create([
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

            session()->flash('message', 'Harga villa berhasil ditambahkan.');
        }

        $this->reset();
        $this->dispatch('refreshDatatable');
        $this->open = false;
    }


    public function render()
    {
        return view('livewire.villa-pricing.create', [
            'villas' => Villa::all(),
            'seasons' => Season::all(),
        ]);
    }
}
