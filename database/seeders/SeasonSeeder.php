<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Season;

class SeasonSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Season mingguan
            ['nama_season' => 'Weekend',       'repeat_weekly' => true,  'days_of_week' => [0,6], 'priority' => 0],
            ['nama_season' => 'Weekday',       'repeat_weekly' => true,  'days_of_week' => [1,2,3,4,5], 'priority' => 0],
            // Season tahunan berdasarkan tanggal
            ['nama_season' => 'Low Season',    'repeat_weekly' => false, 'tgl_mulai_season' => '2025-09-01','tgl_akhir_season'=>'2025-11-30','priority'=>1],
            ['nama_season' => 'Peak Season',   'repeat_weekly' => false, 'tgl_mulai_season' => '2025-04-10','tgl_akhir_season'=>'2025-04-20','priority'=>5], // contoh Idul Fitri
            ['nama_season' => 'High Season',   'repeat_weekly' => false, 'tgl_mulai_season' => '2025-12-20','tgl_akhir_season'=>'2026-01-05','priority'=>4], // libur sekolah
            ['nama_season' => 'Normal Season', 'repeat_weekly' => false, 'tgl_mulai_season' => '2025-01-01','tgl_akhir_season'=>'2025-12-31','priority'=>0],
        ];

        foreach ($data as $row) {
            Season::updateOrCreate(
                ['nama_season' => $row['nama_season']],
                $row
            );
        }
    }
}
