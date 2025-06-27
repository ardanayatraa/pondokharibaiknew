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
           $reservation = Reservasi::where('guest_id', $user->id_guest)
                        ->orderBy('created_at', 'desc')
                        ->get();

        }

        return view('landing-page', compact('villa', 'user', 'reservation'));
    }

    /**
     * Kembalikan array rentang tanggal yang sudah dipesan
     * untuk villa dengan ID $villa.
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

    /**
     * Get reservation details for reschedule
     */
    public function getReservationForReschedule($id): JsonResponse
    {
        try {
            $reservation = Reservasi::with(['villa', 'guest'])->findOrFail($id);

            // Check if user owns this reservation
            if (Auth::guard('guest')->check() && Auth::guard('guest')->id() !== $reservation->guest_id) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            // Hitung total pembayaran untuk reservasi ini saja
            $totalPaid = Pembayaran::where('reservation_id', $reservation->id_reservation)
                                  ->where('status', 'paid')
                                  ->sum('amount');

            return response()->json([
                'id' => $reservation->id_reservation,
                'villa_id' => $reservation->villa_id,
                'villa_name' => $reservation->villa->name,
                'original_start_date' => $reservation->start_date,
                'original_end_date' => $reservation->end_date,
                'original_total' => $reservation->total_amount,
                'paid_amount' => $totalPaid,
                'guest' => [
                    'id' => $reservation->guest->id_guest,
                    'name' => $reservation->guest->full_name,
                    'full_name' => $reservation->guest->full_name,
                    'email' => $reservation->guest->email,
                    'phone' => $reservation->guest->phone_number,
                    'phone_number' => $reservation->guest->phone_number,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Get reschedule data error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to load reservation data',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calculate reschedule payment difference
     */
    public function calculateReschedule(Request $request, $reservationId): JsonResponse
    {
        $request->validate([
            'new_start_date' => 'required|date',
            'new_end_date' => 'required|date|after:new_start_date',
        ]);

        $reservation = Reservasi::with(['villa'])->findOrFail($reservationId);

        // Check authorization
        if (Auth::guard('guest')->id() !== $reservation->guest_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $villa = $reservation->villa;
        $start = Carbon::parse($request->new_start_date)->startOfDay();
        $end = Carbon::parse($request->new_end_date)->startOfDay();
        $nights = $start->diffInDays($end);

        // Calculate new total
        $newTotal = 0;
        for ($i = 0; $i < $nights; $i++) {
            $day = $start->copy()->addDays($i);
            $rate = $villa->priceForDate($day) ?? 0;
            $newTotal += $rate;
        }

        // Hitung total yang sudah dibayar untuk reservasi ini saja
        $paidAmount = Pembayaran::where('reservation_id', $reservation->id_reservation)
                                ->where('status', 'paid')
                                ->sum('amount');

        // Calculate payment needed
        $paymentNeeded = max(0, $newTotal - $paidAmount);

        return response()->json([
            'original_total' => $reservation->total_amount,
            'new_total' => $newTotal,
            'paid_amount' => $paidAmount,
            'payment_needed' => $paymentNeeded,
            'nights' => $nights,
            'is_additional_payment' => $paymentNeeded > 0
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
          'reservation_id' => 'nullable|integer', // For reschedule
        ]);

        \Midtrans\Config::$serverKey    = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized  = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds        = config('midtrans.is_3ds');

        // Fix: Check if reservation_id exists before using it
        $orderPrefix = isset($payload['reservation_id']) && $payload['reservation_id'] ? 'RESCHEDULE' : 'ORDER';
        $orderId = $orderPrefix . '-' . time();
        session(['midtrans_order_id' => $orderId]);
        $transaction = [
          'transaction_details' => [
            'order_id'     => $orderId,
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
        $token = $request->header('X-API-TOKEN');
        $expectedToken = config('services.reservation_api.token');

        if ($token !== $expectedToken) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'villa_id'     => 'required|integer',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date',
            'total_amount' => 'required|numeric',
            'guest_id'     => 'required|integer',
            'snap_token'   => 'nullable|string',
            'notifikasi'   => 'nullable|string',
        ]);

        $start = Carbon::parse($validated['start_date']);
        $villaPricing = VillaPricing::where('villa_id', $validated['villa_id'])
            ->whereHas('season', function ($q) use ($start) {
                $q->whereDate('tgl_mulai_season', '<=', $start)
                  ->whereDate('tgl_akhir_season', '>=', $start);
            })
            ->first();

        $reservasi = Reservasi::create([
            'villa_id'         => $validated['villa_id'],
            'start_date'       => $validated['start_date'],
            'end_date'         => $validated['end_date'],
            'total_amount'     => $validated['total_amount'],
            'guest_id'         => $validated['guest_id'],
            'villa_pricing_id' => $villaPricing?->id_villa_pricing,
            'status'           => 'confirmed',
        ]);

        $pembayaran = Pembayaran::create([
            'guest_id'       => $validated['guest_id'],
            'reservation_id' => $reservasi->id_reservation,
            'amount'         => $validated['total_amount'],
            'payment_date'   => now(),
            'snap_token'     => $validated['snap_token'] ?? null,
            'notifikasi'     => $validated['notifikasi'] ?? "Pesanan #{$reservasi->id_reservation} berhasil dibuat",
            'status'         => 'paid',
            'order_id'       => session('midtrans_order_id'),
        ]);

        Mail::to($reservasi->guest->email)->queue(new ReservationCompleted($reservasi, $pembayaran));

        return response()->json([
            'message'   => 'Reservasi, pembayaran, & email invoice berhasil diproses',
            'data'      => [
                'reservasi'  => $reservasi,
                'pembayaran' => $pembayaran,
            ],
        ]);
    }

    /**
     * Process reschedule reservation
     */
    public function processReschedule(Request $request)
    {
        // Remove API token requirement for web requests
        // if (!Auth::guard('guest')->check()) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }

        try {
            $validated = $request->validate([
                'reservation_id' => 'required|integer',
                'new_start_date' => 'required|date',
                'new_end_date' => 'required|date',
                'new_total_amount' => 'required|numeric',
                'payment_amount' => 'required|numeric',
                'snap_token' => 'nullable|string',
            ]);

            $reservation = Reservasi::findOrFail($validated['reservation_id']);

            // Check if user owns this reservation
            if (Auth::guard('guest')->check() && Auth::guard('guest')->id() !== $reservation->guest_id) {
                return response()->json(['error' => 'Unauthorized access to reservation'], 403);
            }

            // Update reservation with new dates and amount
            $reservation->update([
                'start_date' => $validated['new_start_date'],
                'end_date' => $validated['new_end_date'],
                'total_amount' => $validated['new_total_amount'],
                'status' => 'reschedule' // Change status to indicate it was rescheduled
            ]);

            // Create additional payment record if needed
            if ($validated['payment_amount'] > 0) {
                Pembayaran::create([
                    'guest_id' => $reservation->guest_id,
                    'reservation_id' => $reservation->id_reservation,
                    'amount' => $validated['payment_amount'],
                    'payment_date' => now(),
                    'snap_token' => $validated['snap_token'] ?? null,
                    'notifikasi' => "Pembayaran tambahan reschedule #{$reservation->id_reservation}",
                    'status' => 'paid',
                ]);
            }

            // Send email notification
            $latestPayment = Pembayaran::where('reservation_id', $reservation->id_reservation)
                                      ->latest()
                                      ->first();

            if ($latestPayment) {
                Mail::to($reservation->guest->email)->queue(new ReservationCompleted($reservation, $latestPayment));
            }

            return response()->json([
                'message' => 'Reschedule berhasil diproses',
                'data' => $reservation->load(['guest', 'villa'])
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'details' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Reschedule error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to process reschedule',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
