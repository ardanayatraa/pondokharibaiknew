<?php

namespace App\Livewire\Reservasi;

use Livewire\Component;
use App\Models\CekKetersediaan;
use Carbon\Carbon;

class SearchVilla extends Component
{
    public $checkin_date;
    public $checkout_date;
    public $availableSlots = [];
    public $checked        = false;

    public function cekKetersediaan()
    {
        $this->checked = true;
        $this->loadAvailableSlots();
    }

    protected function loadAvailableSlots()
    {
        $this->availableSlots = [];

        if (! $this->checkin_date || ! $this->checkout_date) {
            return;
        }

        // parse date‐only
        $start = Carbon::createFromFormat('Y-m-d', $this->checkin_date)->toDateString();
        $end   = Carbon::createFromFormat('Y-m-d', $this->checkout_date)->toDateString();

        // ambil semua CekKetersediaan yang overlap
        $slots = CekKetersediaan::with('villa')
            ->whereDate('start_date', '<=', $end)
            ->whereDate('end_date',   '>=', $start)
            ->get();

        // map ke array
        $this->availableSlots = $slots->map(function($c) {
            return [
                'cek_id'        => $c->id_cek_ketersediaan,
                'villa_id'      => $c->villa_id,
                'villa_name'    => $c->villa->name,
                'start_date'    => $c->start_date->format('d/m/Y'),
                'end_date'      => $c->end_date->format('d/m/Y'),
                // untuk link query
                'start_raw'     => $c->start_date->toDateString(),
                'end_raw'       => $c->end_date->toDateString(),
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.reservasi.search-villa');
    }
}
