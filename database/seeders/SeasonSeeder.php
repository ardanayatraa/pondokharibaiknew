<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Season;
use Carbon\Carbon;

class SeasonSeeder extends Seeder
{
    public function run()
    {
        Season::firstOrCreate(
            ['nama_season' => 'Normal'],           // kolom pencarian
            [
                'tgl_mulai_season' => Carbon::parse('0001-01-01'),  // sesuaikan nama kolom
                'tgl_akhir_season' => Carbon::parse('9999-12-31'),
            ]
        );
    }
}
