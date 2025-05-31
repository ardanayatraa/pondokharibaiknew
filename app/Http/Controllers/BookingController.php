<?php

namespace App\Http\Controllers;

use App\Mail\ReservationCompleted;
use App\Models\Reservasi;
use App\Models\Villa;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Guest;
use App\Models\Pembayaran;
use App\Models\VillaPricing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
     /**
     * List semua villa dengan filter opsional
     */
    public function index(Request $request)
    {
        $villa = Villa::all();
        $user = null;
        $reservation = null;

        if (Auth::guard('guest')->check()) {
            $user = Auth::guard('guest')->user();
            $reservation = Reservasi::where('guest_id', $user->id_guest)->get();
        }

        return view('landing-page', compact('villa', 'user', 'reservation'));
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
            'picture'     => asset('storage/' . $villa->picture),
            'capacity'    => $villa->capacity,

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
        $request->validate([
            'start' => 'required|date',
            'end'   => 'required|date|after:start',
        ]);

        $villa = Villa::findOrFail($id);

        $start = Carbon::parse($request->query('start'))->startOfDay();
        $end   = Carbon::parse($request->query('end'))->startOfDay();

        // hitung jumlah malam (tiap malam dari start sampai sebelum end)
        $nights = $start->diffInDays($end);

        $total = 0;
        for ($i = 0; $i < $nights; $i++) {
            $day = $start->copy()->addDays($i);
            $rate = $villa->priceForDate($day) ?? 0;
            $total += $rate;
        }

        return response()->json(['total' => $total]);
    }


public function guestInfo($id)
{
    // pastikan yang sedang login sama dengan $id
    if (Auth::id() != $id) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    $guest = Guest::findOrFail($id);

    return response()->json([
        'id'               => $guest->id_guest,
        'username'         => $guest->username,
        'full_name'        => $guest->full_name,
        'email'            => $guest->email,
        'address'          => $guest->address,
        'phone_number'     => $guest->phone_number,
        'id_card_number'   => $guest->id_card_number,
        'passport_number'  => $guest->passport_number,
        'birthdate'        => $guest->birthdate,
        'gender'           => $guest->gender,
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
        'villa_id'     => 'required|integer',
        'start_date'   => 'required|date',
        'end_date'     => 'required|date',
        'total_amount' => 'required|numeric',
        'guest_id'     => 'required|integer',
        'snap_token'   => 'nullable|string',
        'notifikasi'   => 'nullable|string',
    ]);

    // hitung untuk pricing
    $start = Carbon::parse($validated['start_date']);
    $villaPricing = VillaPricing::where('villa_id', $validated['villa_id'])
        ->whereHas('season', function ($q) use ($start) {
            $q->whereDate('tgl_mulai_season', '<=', $start)
              ->whereDate('tgl_akhir_season', '>=', $start);
        })
        ->first();

    // ✅ 3. Simpan data reservasi
    $reservasi = Reservasi::create([
        'villa_id'         => $validated['villa_id'],
        'start_date'       => $validated['start_date'],
        'end_date'         => $validated['end_date'],
        'total_amount'     => $validated['total_amount'],
        'guest_id'         => $validated['guest_id'],
        'villa_pricing_id' => $villaPricing?->id_villa_pricing,
        'status'           => 'confirmed',
    ]);

    // ✅ 4. Simpan data pembayaran
    $pembayaran = Pembayaran::create([
        'guest_id'       => $validated['guest_id'],
        'reservation_id' => $reservasi->id_reservation,
        'amount'         => $validated['total_amount'],
        'payment_date'   => now(),
        'snap_token'     => $validated['snap_token'] ?? null,
        'notifikasi'     => $validated['notifikasi'] ?? "Pesanan #{$reservasi->id_reservation} berhasil dibuat",
        'status'         => 'paid',
    ]);

    // ✅ 5. Kirim email dengan invoice
    Mail::to($reservasi->guest->email)->queue(new ReservationCompleted($reservasi, $pembayaran));



    // ✅ 6. Return respons sukses
    return response()->json([
        'message'   => 'Reservasi, pembayaran, & email invoice berhasil diproses',
        'data'      => [
            'reservasi'  => $reservasi,
            'pembayaran' => $pembayaran,
        ],
    ]);
}


}
