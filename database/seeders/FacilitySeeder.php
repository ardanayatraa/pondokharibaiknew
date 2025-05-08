<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facility;

class FacilitySeeder extends Seeder
{
    public function run()
    {
        $facilities = [
            // === AMENITIES (gratis / termasuk) ===
            ['name'=>'Tisu toilet',    'desc'=>'',                    'type'=>'amenities'],
            ['name'=>'Handuk',         'desc'=>'',                    'type'=>'amenities'],
            ['name'=>'Bidet',          'desc'=>'',                    'type'=>'amenities'],
            ['name'=>'Bathtub atau shower','desc'=>'',               'type'=>'amenities'],
            ['name'=>'Kamar mandi pribadi','desc'=>'',               'type'=>'amenities'],
            ['name'=>'Toilet',         'desc'=>'',                    'type'=>'amenities'],
            ['name'=>'Bathtub',        'desc'=>'',                    'type'=>'amenities'],
            ['name'=>'Shower',         'desc'=>'',                    'type'=>'amenities'],
            ['name'=>'Seprai',         'desc'=>'',                    'type'=>'amenities'],
            ['name'=>'Pemandangan taman','desc'=>'',                  'type'=>'amenities'],
            ['name'=>'Pemandangan',    'desc'=>'',                    'type'=>'amenities'],
            ['name'=>'Perabotan luar ruangan','desc'=>'',            'type'=>'amenities'],
            ['name'=>'Patio',          'desc'=>'',                    'type'=>'amenities'],
            ['name'=>'Balkon',         'desc'=>'',                    'type'=>'amenities'],
            ['name'=>'Teras',          'desc'=>'',                    'type'=>'amenities'],
            ['name'=>'Taman',          'desc'=>'',                    'type'=>'amenities'],
            ['name'=>'Ketel listrik',  'desc'=>'',                    'type'=>'amenities'],
            ['name'=>'Rak pengering baju','desc'=>'',                 'type'=>'amenities'],
            ['name'=>'Papan Jemur Baju','desc'=>'',                   'type'=>'amenities'],
            ['name'=>'Meja kerja',     'desc'=>'',                    'type'=>'amenities'],
            ['name'=>'TV layar datar', 'desc'=>'',                    'type'=>'amenities'],
            ['name'=>'Restoran',       'desc'=>'',                    'type'=>'amenities'],
            ['name'=>'Wi-Fi tersedia di seluruh hotel dan tidak dikenai biaya','desc'=>'','type'=>'amenities'],
            ['name'=>'Parkir pribadi gratis tersedia di lokasi properti (reservasi tidak diperlukan)','desc'=>'','type'=>'amenities'],
            ['name'=>'Invoice disediakan','desc'=>'',                  'type'=>'amenities'],
            ['name'=>'Check-in/out pribadi','desc'=>'',               'type'=>'amenities'],
            ['name'=>'Penitipan bagasi','desc'=>'',                   'type'=>'amenities'],
            ['name'=>'Layanan kebersihan harian','desc'=>'',          'type'=>'amenities'],
            ['name'=>'Fasilitas rapat/perjamuan','desc'=>'',          'type'=>'amenities'],
            ['name'=>'Pemadam api',    'desc'=>'',                    'type'=>'amenities'],
            ['name'=>'CCTV di luar akomodasi','desc'=>'',            'type'=>'amenities'],
            ['name'=>'CCTV di tempat umum','desc'=>'',               'type'=>'amenities'],
            ['name'=>'Akses kunci',    'desc'=>'',                    'type'=>'amenities'],
            ['name'=>'AC',             'desc'=>'',                    'type'=>'amenities'],
            ['name'=>'Bebas rokok di semua ruangan','desc'=>'',      'type'=>'amenities'],
            ['name'=>'Makan siang kemasan','desc'=>'',               'type'=>'amenities'],
            ['name'=>'Kamar bebas rokok','desc'=>'',                 'type'=>'amenities'],
            ['name'=>'Layanan kamar','desc'=>'',                     'type'=>'amenities'],
            ['name'=>'Buka sepanjang tahun','desc'=>'Gratis',         'type'=>'amenities'],
            ['name'=>'Untuk semua usia','desc'=>'',                  'type'=>'amenities'],
            ['name'=>'Kolam renang dengan pemandangan','desc'=>'',    'type'=>'amenities'],
            ['name'=>'Handuk kolam renang/pantai','desc'=>'',        'type'=>'amenities'],
            ['name'=>'Kursi berjemur','desc'=>'',                    'type'=>'amenities'],
            ['name'=>'Spa & pusat kesehatan','desc'=>'',             'type'=>'amenities'],
            ['name'=>'Bahasa Inggris','desc'=>'',                    'type'=>'amenities'],
            ['name'=>'Bahasa Indonesia','desc'=>'',                  'type'=>'amenities'],

            // === NON_AMENITIES (biaya tambahan) ===
            ['name'=>'Tur jalan kaki',           'desc'=>'Biaya tambahan', 'type'=>'non_amenities'],
            ['name'=>'Jasa penyetrikaan',        'desc'=>'Biaya tambahan', 'type'=>'non_amenities'],
            ['name'=>'Laundry',                  'desc'=>'Biaya tambahan', 'type'=>'non_amenities'],
            ['name'=>'Layanan antar-jemput',     'desc'=>'Biaya tambahan', 'type'=>'non_amenities'],
            ['name'=>'Antar-jemput bandara',     'desc'=>'Biaya tambahan', 'type'=>'non_amenities'],
            ['name'=>'Kamar keluarga',           'desc'=>'Biaya tambahan', 'type'=>'non_amenities'],
        ];

        foreach ($facilities as $f) {
            Facility::updateOrCreate(
                ['name_facility' => $f['name']],
                [
                    'description'   => $f['desc'],
                    'facility_type' => $f['type'],
                ]
            );
        }
    }
}
