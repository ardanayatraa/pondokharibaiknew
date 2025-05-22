<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Villa;
use App\Models\VillaPricing;
use App\Models\Season;

class VillaPricingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Ambil semua season (Weekly maupun yang berdasar tanggal)
        $seasons = Season::all();

        // Default harga tiap hari (bisa disesuaikan per season bila perlu)
        $defaultRates = [
            'sunday_pricing'    => 100_000,
            'monday_pricing'    => 100_000,
            'tuesday_pricing'   => 100_000,
            'wednesday_pricing' => 100_000,
            'thursday_pricing'  => 100_000,
            'friday_pricing'    => 100_000,
            'saturday_pricing'  => 100_000,
        ];

        Villa::all()->each(function ($villa) use ($seasons, $defaultRates) {
            foreach ($seasons as $season) {
                VillaPricing::firstOrCreate(
                    [
                        'villa_id'   => $villa->id_villa,
                        'season_id'  => $season->id_season,
                    ],
                    $defaultRates
                );
            }
        });
    }
}
