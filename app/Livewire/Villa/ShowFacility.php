<?php

namespace App\Livewire\Villa;

use Livewire\Component;
use App\Models\Villa;
use App\Models\Facility;

class ShowFacility extends Component
{
    public $open = false;
    public $selectedFacilityNames = [];
    public $facilityDetails = [];

    protected $listeners = ['showFacilityModal' => 'loadFacility'];

    public function loadFacility($id)
    {
        $villa = Villa::find($id);

        if (!$villa || !is_array($villa->facility_id)) {
            $this->selectedFacilityNames = [];
            $this->facilityDetails = [];
            $this->open = true;
            return;
        }

        // Get full facility details
        $facilities = Facility::whereIn('id_facility', $villa->facility_id)->get();

        $this->selectedFacilityNames = $villa->facility_names ?? [];
        $this->facilityDetails = $facilities->map(function($facility) {
            return [
                'id' => $facility->id_facility,
                'name' => $facility->name_facility,
                'type' => $facility->facility_type,
                'description' => $facility->description,
                'icon' => $facility->icon
            ];
        })->toArray();

        $this->open = true;
    }

    // Removed getFacilityIcon method as we now use icons from the database

    public function render()
    {
        return view('livewire.villa.show-facility');
    }
}
