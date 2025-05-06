<?php

namespace App\Livewire\Villa;

use Livewire\Component;
use App\Models\Villa;

class ShowFacility extends Component
{
    public $open = false;
    public $selectedFacilityNames = [];

    protected $listeners = ['showFacilityModal' => 'loadFacility'];

    public function loadFacility($id)
    {
        $villa = Villa::find($id);
        $this->selectedFacilityNames = $villa->facility_names ?? [];
        $this->open = true;
    }

    public function render()
    {
        return view('livewire.villa.show-facility');
    }
}
