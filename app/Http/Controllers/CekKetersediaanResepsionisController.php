<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Villa;

class CekKetersediaanResepsionisController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->input('start', now()->toDateString());
        $end = $request->input('end', now()->addDay()->toDateString());

        $villas = Villa::with('reservasi')->get()->map(function($villa) use ($start, $end) {
            $reservasiBentrok = $villa->reservasi
                ->where('status', 'confirmed')
                ->filter(function($r) use ($start, $end) {
                    // Overlap: (start < r.end_date) && (end > r.start_date)
                    return $start < $r->end_date && $end > $r->start_date;
                });

            return [
                'villa' => $villa,
                'tersedia' => $reservasiBentrok->isEmpty(),
                'reservasi_bentrok' => $reservasiBentrok,
            ];
        });

        return view('resepsionis.cek-ketersediaan', compact('villas', 'start', 'end'));
    }
} 