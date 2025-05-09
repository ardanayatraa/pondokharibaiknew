<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Villa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
     /**
     * List semua villa dengan filter opsional
     */
    public function index(Request $request)
    {
        $villa = Villa::all();

        return view('landing-page',compact('villa'));
    }

    /**
     * Kembalikan array rentang tanggal yang sudah dipesan
     * untuk villa dengan ID $villa.
     *
     * Response JSON:
     * [
     *   { "from": "2025-05-01", "to": "2025-05-05" },
     *   { "from": "2025-05-10", "to": "2025-05-12" },
     *   …
     * ]
     */
    public function reservedDates($villa): JsonResponse
    {
        $ranges = Reservasi::query()
            ->where('villa_id', $villa)
            // ->where('status', 'confirmed') // jika perlu filter status
            ->get(['start_date','end_date'])
            ->map(fn($r) => [
                'from' => $r->start_date,
                'to'   => $r->end_date,
            ])
            ->toArray();

        return response()->json($ranges);
    }


    public function villabyId($id){
        $villa = Villa::findOrFail($id);

        return response()->json([
            'id'          => $villa->id_villa,
            'name'        => $villa->name,
            'price'       => $villa->today_price,
            'image'       => $villa->image_url,
            'capacity'    => $villa->capacity,
            'beds'        => $villa->beds,
            'tag'         => $villa->tag,
            'description' => $villa->description,
        ]);
    }

}
