<?php

namespace App\Livewire\Reservasi;

use App\Mail\MailToGuest;
use Livewire\Component;
use App\Models\CekKetersediaan;
use App\Models\Reservasi;
use App\Models\Pembayaran;
use App\Models\Season;
use App\Models\VillaPricing;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Midtrans\Config;
use Midtrans\Snap;
use Livewire\Attributes\On;

class ReservationStep extends Component
{
    public $step = 1;

    // STEP 1
    public $checkin_date;
    public $checkout_date;
    public $availableSlots = [];

    // STEP 2
    public $selectedSlot = [];

    // STEP 3
    public $guest_name;
    public $guest_email;

    // STEP 4
    public $payment_method;

    // STEP 5
    public $reservationId;
    public $paymentId;

    protected $listeners = [
        'midtransSuccess',
        'midtransPending',
        'midtransError',
    ];

    protected $rulesGuest = [
        'guest_name'  => 'required|string|max:255',
        'guest_email' => 'required|email|max:255',
    ];

    protected $rulesPayment = [
        'payment_method' => 'required',
    ];

    public function mount()
    {
        if (session('role') === 'guest' && Auth::guard('guest')->check()) {
            $g = Auth::guard('guest')->user();
            $this->guest_name  = $g->full_name;
            $this->guest_email = $g->email;
        }
    }

    public function searchAvailability()
    {
        $today = Carbon::today()->toDateString();

        $this->validate([
            'checkin_date'  => "required|date|after_or_equal:{$today}|before:checkout_date",
            'checkout_date' => "required|date|after:checkin_date",
        ]);

        $slots = CekKetersediaan::with('villa')
            ->whereDate('start_date', '<=', $this->checkin_date)
            ->whereDate('end_date',   '>=', $this->checkout_date)
            ->whereDoesntHave('reservasi')
            ->get();

        $this->availableSlots = $slots->map(fn($s) => [
            'cek_id'     => $s->id_cek_ketersediaan,
            'villa_id'   => $s->villa_id,
            'villa_name' => $s->villa->name,
            'slot_start' => $s->start_date->format('d/m/Y'),
            'slot_end'   => $s->end_date->format('d/m/Y'),
        ])->toArray();

        $this->step = 2;
    }

    public function selectSlot($cekId)
    {
        $found = collect($this->availableSlots)
                 ->first(fn($s) => $s['cek_id'] == $cekId);
        if (! $found) return;

        $this->selectedSlot = [
            'cek_id'       => $found['cek_id'],
            'villa_id'     => $found['villa_id'],
            'villa_name'   => $found['villa_name'],
            'booking_start'=> $this->checkin_date,
            'booking_end'  => $this->checkout_date,
            'display_start'=> Carbon::parse($this->checkin_date)->format('d/m/Y'),
            'display_end'  => Carbon::parse($this->checkout_date)->format('d/m/Y'),
        ];

        $this->step = 3;
    }

    public function submitGuestDetails()
    {
        $this->validate($this->rulesGuest);
        $this->step = 4;
    }

    public function submitPayment()
    {
        $this->validate($this->rulesPayment);

        // Hitung total berdasarkan harga per malam & season
        $start  = Carbon::parse($this->selectedSlot['booking_start']);
        $end    = Carbon::parse($this->selectedSlot['booking_end']);
        $nights = $start->diffInDays($end);

        $seasons   = Season::whereDate('tgl_mulai_season','<=',$this->selectedSlot['booking_end'])
                           ->whereDate('tgl_akhir_season','>=',$this->selectedSlot['booking_start'])
                           ->get();
        $seasonIds = $seasons->pluck('id_season')->all();

        $pricings = VillaPricing::where('villa_id',$this->selectedSlot['villa_id'])
                                 ->whereIn('season_id',$seasonIds)
                                 ->get()
                                 ->keyBy('season_id');

                                 $startDate = Carbon::parse($this->selectedSlot['booking_start']);
                                 $firstSeason = $seasons->first(fn($s) =>
                                     $startDate->toDateString() >= $s->tgl_mulai_season
                                  && $startDate->toDateString() <= $s->tgl_akhir_season
                                 );

                                 // 3. Ambil pricing yang cocok dengan season tersebut
                                 $firstPricing = $firstSeason
                                     ? $pricings->get($firstSeason->id_season)
                                     : null;

                                 $dayMap = [
                                    'sunday' => 'sunday_pricing',
                                    'monday' => 'monday_pricing',
                                    'tuesday' => 'tuesday_pricing',
                                    'wednesday' => 'wednesday_pricing',
                                    'thursday' => 'thursday_pricing',
                                    'friday' => 'friday_pricing',
                                    'saturday' => 'saturday_pricing',
                                ];


        $total = 0;
        for ($i = 0; $i < $nights; $i++) {
            $date   = $start->copy()->addDays($i);
            $season = $seasons->first(fn($s) =>
                $date->toDateString() >= $s->tgl_mulai_season
             && $date->toDateString() <= $s->tgl_akhir_season
            );
            if (! $season) continue;
            $pricing = $pricings->get($season->id_season);
            $dayKey  = strtolower($date->isoFormat('dddd'));
            $col     = $dayMap[$dayKey] ?? null;
            $price   = $pricing?->{$col} ?? 0;
            $total  += $price;
        }

        if ($total < 1) {
            $this->addError('payment_method','Total pembayaran minimal Rp 1');
            return;
        }

        $guestId = session('role') === 'guest' && Auth::guard('guest')->check()
                 ? Auth::guard('guest')->id()
                 : Auth::id();

        $res = Reservasi::create([
            'guest_id'            => $guestId,
            'villa_id'            => $this->selectedSlot['villa_id'],
            'cek_ketersediaan_id' => $this->selectedSlot['cek_id'],
            'start_date'          => $this->selectedSlot['booking_start'],
            'end_date'            => $this->selectedSlot['booking_end'],
            'status'              => 'pending',
            'total_amount'        => $total,
            'villa_pricing_id'    => $firstPricing?->id_villa_pricing,
        ]);

        $pay = Pembayaran::create([
            'guest_id'       => $guestId,
            'reservation_id' => $res->id_reservation,
            'amount'         => $total,
            'payment_date'   => now()->toDateString(),
            'snap_token'     => null,
            'notifikasi'     => null,
            'status'         => 'pending',
        ]);

        $this->reservationId = $res->id_reservation;
        $this->paymentId     = $pay->id_pembayaran;

        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');

        $params = [
            'transaction_details'=>[
             'order_id' => 'ORDER-'.$res->id_reservation.'-'.uniqid(),
                'gross_amount' => $total,
            ],
            'customer_details'=>[
                'first_name' => $this->guest_name,
                'email'      => $this->guest_email,
            ],
        ];


        $token = Snap::getSnapToken($params);
        $this->dispatch('midtrans-token',$token);
    }

    #[On('midtransSuccess')]
    public function midtransSuccess()
    {
        $result = data_get(request()->input('components.0.calls'), '1.params.1');

        $bayar=Pembayaran::find($this->paymentId);

          $bayar->update([
                'status'     => 'paid',
                'notifikasi' => json_encode($result['status_message']),
            ]);

        Reservasi::find($this->reservationId)
            ->update([
                'status' => 'confirmed',
            ]);
        $email=$bayar->guest->email;
        $name=$bayar->guest->full_name;

        Mail::to($email)->send(new MailToGuest($name));

        $this->step = 5;
    }

    #[On('midtransPending')]
    public function midtransPending()
    {
        $result = data_get(request()->input('components.0.calls'), '1.params.1');
        Pembayaran::find($this->paymentId)
            ->update([
                'status'     => 'pending',
                'notifikasi' => json_encode($result['status_message']),
            ]);

        $this->step = 5;
    }

    #[On('midtransError')]
    public function midtransError()
    {
        $result = data_get(request()->input('components.0.calls'), '1.params.1');
        Pembayaran::find($this->paymentId)
            ->update([
                'status'     => 'error',
                'notifikasi' => json_encode($result['status_message']),
            ]);

        $this->step = 5;
    }
    public function goToStep($n)
    {
        $this->step = $n;
    }

    public function render()
    {
        return view('livewire.reservasi.reservation-step');
    }
}
