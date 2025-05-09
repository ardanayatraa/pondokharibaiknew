<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Villa;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Guest;
use App\Models\VillaPricing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
            ->where('status', 'confirmed')
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


    /**
     * Calculate total price between start & end (exclusive end).
     * Example: /villa/1/calculate?start=2025-05-10&end=2025-05-15
     */
    public function calculate(Request $request, $id): JsonResponse
    {
        $villa = Villa::findOrFail($id);

        $start = Carbon::parse($request->query('start'));
        $end   = Carbon::parse($request->query('end'));

        if ($end->lte($start)) {
            return response()->json(['total' => 0]);
        }

        $total = 0;
        for ($date = $start->copy(); $date->lt($end); $date->addDay()) {
            // TODO: jika ada seasonal pricing, ambil di sini.
            // Misal: $rate = $villa->rateForDate($date);
            $rate = $villa->today_price;
            $total += $rate;
        }

        return response()->json(['total' => $total]);
    }

    public function guestInfo($id)
{
    // pastikan yang sedang login sama dengan $id
    if (Auth::id() != $id) {
        return response()->json(['message'=>'Unauthorized'], 403);
    }

    $guest = Guest::findOrFail($id);
    return response()->json([
        'id'           => $guest->id_guest,
        'full_name'    => $guest->full_name,
        'email'        => $guest->email,
        'address'        => $guest->address,
        'phone_number' => $guest->phone_number,

    ]);
}


public function paymentToken(Request $request): JsonResponse
{

    $payload = $request->validate([
      'villa_id'     => 'required|exists:tbl_villa,id_villa',
      'check_in'     => 'required|date',
      'check_out'    => 'required|date|after:check_in',
      'total_amount' => 'required|numeric',
      'guest_name'   => 'required|string',
      'guest_email'  => 'required|email',
      'guest_phone'  => 'required|string',
    ]);

    \Midtrans\Config::$serverKey    = config('midtrans.server_key');
    \Midtrans\Config::$isProduction = config('midtrans.is_production');
    \Midtrans\Config::$isSanitized  = config('midtrans.is_sanitized');
    \Midtrans\Config::$is3ds        = config('midtrans.is_3ds');

    $transaction = [
      'transaction_details' => [
        'order_id'     => 'ORDER‑'.time(),
        'gross_amount' => $payload['total_amount'],
      ],
      'customer_details' => [
        'first_name' => $payload['guest_name'],
        'email'      => $payload['guest_email'],
        'phone'      => $payload['guest_phone'],
      ],
    ];

    $snapToken = \Midtrans\Snap::getSnapToken($transaction);

    return response()->json(['snap_token'=>$snapToken]);
}



public function storeReservation(Request $request)
{
    // ✅ 1. Cek token dari header
    $token = $request->header('X-API-TOKEN');
    $expectedToken = config('services.reservation_api.token');


    if ($token !== $expectedToken) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // ✅ 2. Validasi input
    $validated = $request->validate([
        'villa_id' => 'required|integer',
        'start_date' => 'required|date',
        'end_date' => 'required|date',
        'total_amount' => 'required|numeric',
        'guest_id' => 'required|integer',
        'snap_token' => 'nullable|string',     // untuk pembayaran
        'notifikasi' => 'nullable|string',     // jika kamu ingin kirim info notifikasi
    ]);


    $start = Carbon::parse($validated['start_date']);

// Cari season yang aktif untuk tanggal start_date
$villaPricing = VillaPricing::where('villa_id', $validated['villa_id'])
    ->whereHas('season', function ($query) use ($start) {
        $query->whereDate('tgl_mulai_season', '<=', $start)
              ->whereDate('tgl_akhir_season', '>=', $start);
    })
    ->first();

    // ✅ 3. Simpan data reservasi
    $reservasi = Reservasi::create([
        'villa_id' => $validated['villa_id'],
        'start_date' => $validated['start_date'],
        'end_date' => $validated['end_date'],
        'total_amount' => $validated['total_amount'],
        'guest_id' => $validated['guest_id'],
       'villa_pricing_id' => $villaPricing?->id_villa_pricing ?? null,
        'status' => 'confirmed', // default status setelah booking & sebelum konfirmasi
    ]);

    // ✅ 4. Simpan data pembayaran
    $pembayaran = \App\Models\Pembayaran::create([
        'guest_id' => $validated['guest_id'],
        'reservation_id' => $reservasi->id_reservation,
        'amount' => $validated['total_amount'],
        'payment_date' => now(),
        'snap_token' => $validated['snap_token']??0,
        'notifikasi' => "Pesanan telah berhasil dibuat #".$reservasi->id_reservation,
        'status' => 'paid', // default status sebelum konfirmasi
    ]);

    // ✅ 5. Return respons sukses
    return response()->json([
        'message' => 'Reservasi & pembayaran berhasil disimpan',
        'data' => [
            'reservasi' => $reservasi,
            'pembayaran' => $pembayaran,
        ],
    ]);
}


}
