<?php
// database/seeders/VillaSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Villa;

class VillaSeeder extends Seeder
{
    public function run()
    {
        $rooms = [
            [
                'name'        => 'Family Bungallo',
                'description' => 'This air-conditioned family room has a desk, a terrace, garden views and a private bathroom. The unit has 2 beds.',
                'capacity'    => 4,
                'picture'     => 'https://via.placeholder.com/800x600?text=Family+Bungallo',
                'facility_id' => [],
            ],
            [
                'name'        => 'Family Room with Garden View',
                'description' => 'The spacious family room features air conditioning, a dining area, a terrace with garden views as well as a private bathroom boasting a bath. The unit has 2 beds.',
                'capacity'    => 4,
                'picture'     => 'https://via.placeholder.com/800x600?text=Family+Garden+View',
                'facility_id' => [],
            ],
            [
                'name'        => 'Twins Room with Garden View',
                'description' => 'This air-conditioned twin/double room has a desk, a terrace, garden views and a private bathroom. The unit has 2 beds.',
                'capacity'    => 2,
                'picture'     => 'https://via.placeholder.com/800x600?text=Twins+Garden+View',
                'facility_id' => [],
            ],
        ];

        foreach ($rooms as $data) {
            Villa::firstOrCreate(
                ['name' => $data['name']],
                $data
            );
        }
    }
}
