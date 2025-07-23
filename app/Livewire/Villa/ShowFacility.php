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
                'icon' => $this->getFacilityIcon($facility->name_facility)
            ];
        })->toArray();

        $this->open = true;
    }

    /**
     * Get appropriate icon for facility based on name
     */
    public function getFacilityIcon($facilityName)
    {
        $name = strtolower($facilityName);

        // Map common facility names to Font Awesome icons
        $iconMap = [
            // Bedroom/Living
            'bedroom' => 'fa-bed',
            'bed' => 'fa-bed',
            'king bed' => 'fa-bed',
            'queen bed' => 'fa-bed',
            'living room' => 'fa-couch',
            'sofa' => 'fa-couch',

            // Kitchen
            'kitchen' => 'fa-kitchen-set',
            'refrigerator' => 'fa-refrigerator',
            'fridge' => 'fa-refrigerator',
            'microwave' => 'fa-microwave',
            'stove' => 'fa-fire',
            'oven' => 'fa-oven',
            'dishwasher' => 'fa-sink',
            'coffee' => 'fa-mug-hot',
            'coffee maker' => 'fa-mug-hot',

            // Bathroom
            'bathroom' => 'fa-bath',
            'shower' => 'fa-shower',
            'bathtub' => 'fa-bath',
            'toilet' => 'fa-toilet',

            // Entertainment
            'tv' => 'fa-tv',
            'television' => 'fa-tv',
            'wifi' => 'fa-wifi',
            'internet' => 'fa-wifi',
            'game' => 'fa-gamepad',

            // Outdoor
            'pool' => 'fa-swimming-pool',
            'swimming pool' => 'fa-swimming-pool',
            'garden' => 'fa-leaf',
            'balcony' => 'fa-door-open',
            'terrace' => 'fa-mountain',
            'bbq' => 'fa-fire',
            'grill' => 'fa-fire',

            // Services
            'parking' => 'fa-car',
            'breakfast' => 'fa-utensils',
            'restaurant' => 'fa-utensils',
            'laundry' => 'fa-washing-machine',
            'cleaning' => 'fa-broom',
            'housekeeping' => 'fa-broom',

            // Amenities
            'air conditioning' => 'fa-snowflake',
            'ac' => 'fa-snowflake',
            'heating' => 'fa-temperature-high',
            'elevator' => 'fa-elevator',
            'security' => 'fa-shield-alt',

            // Accessibility
            'wheelchair' => 'fa-wheelchair',
            'accessible' => 'fa-wheelchair',

            // Default
            'default' => 'fa-check-circle'
        ];

        // Check if facility name contains any of the keywords
        foreach ($iconMap as $keyword => $icon) {
            if (str_contains($name, $keyword)) {
                return $icon;
            }
        }

        // Return default icon if no match found
        return 'fa-check-circle';
    }

    public function render()
    {
        return view('livewire.villa.show-facility');
    }
}
