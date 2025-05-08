<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $normal = Season::where('nama_season','Normal')->first();
        Villa::all()->each(function($villa) use ($normal) {
            VillaPricing::firstOrCreate(
                [
                    'villa_id'   => $villa->id_villa,
                    'season_id'  => $normal->id_season,
                ],
                [
                    'sunday_pricing'    => 0,
                    'monday_pricing'    => 0,
                    'tuesday_pricing'   => 0,
                    'wednesday_pricing' => 0,
                    'thursday_pricing'  => 0,
                    'friday_pricing'    => 0,
                    'saturday_pricing'  => 0,
                ]
            );
        });
    }
}
