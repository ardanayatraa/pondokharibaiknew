<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Models\Facility;
use App\Models\Reservasi;
use App\Models\VillaPricing;
use App\Models\CekKetersediaan;

class Villa extends Model
{
    use HasFactory;

    protected $table = 'tbl_villa';
    protected $primaryKey = 'id_villa';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'facility_id',
        'name',
        'description',
        'picture',
        'capacity',
    ];

    protected $casts = [
        'facility_id' => 'array',
    ];

    // —— RELATIONS —— //

    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'villa_id');
    }

    public function pricings()
    {
        return $this->hasMany(VillaPricing::class, 'villa_id', 'id_villa');
    }

    public function cekKetersediaan()
    {
        return $this->hasMany(CekKetersediaan::class, 'villa_id', 'id_villa');
    }

    // —— UTILITY —— //

    public function getFacilityNamesAttribute(): array
    {
        if (! is_array($this->facility_id)) {
            return [];
        }

        return Facility::whereIn('id_facility', $this->facility_id)
                       ->pluck('name_facility')
                       ->toArray();
    }

    // —— PRICING LOGIC —— //

    /**
     * Cari VillaPricing yang berlaku pada $date:
     * - season.repeat_weekly = true & days_of_week berisi hari itu
     * - season.repeat_weekly = false & date di antara tgl_mulai & tgl_akhir
     * Pilih yang punya season.priority tertinggi.
     *
     * @param  string|\DateTime|null  $date
     * @return VillaPricing|null
     */
    public function currentPricing($date = null): ?VillaPricing
    {
        $dateObj      = $date ? Carbon::parse($date) : Carbon::today();
        $dateString   = $dateObj->toDateString();
        $weekdayIndex = $dateObj->dayOfWeek; // 0=Sunday…6=Saturday

        /** @var Collection<VillaPricing> $allPricings */
        $allPricings = $this->pricings()
                           ->with('season')
                           ->get();

        // Filter season yang match tanggal/hari
        $matched = $allPricings->filter(function(VillaPricing $p) use ($dateString, $weekdayIndex) {
            $s = $p->season;
            if (! $s) return false;

            if ($s->repeat_weekly) {
                return is_array($s->days_of_week)
                    && in_array($weekdayIndex, $s->days_of_week, true);
            }

            return $s->tgl_mulai_season->toDateString() <= $dateString
                && $s->tgl_akhir_season->toDateString() >= $dateString;
        });

        if ($matched->isNotEmpty()) {
            return $matched
                ->sortByDesc(fn($p) => $p->season->priority)
                ->first();
        }

        return null;
    }

    /**
     * Accessor agar bisa dipanggil $villa->current_pricing
     */
    public function getCurrentPricingAttribute(): ?VillaPricing
    {
        return $this->currentPricing();
    }

    /**
     * Ambil harga untuk $date (atau hari ini):
     * 1) dari season utama
     * 2) jika null, fallback ke season lain dengan harga tidak null, by priority
     *
     * @param  string|\DateTime|null  $date
     * @return int|null
     */
    public function priceForDate($date = null): ?int
    {
        $dateObj = $date ? Carbon::parse($date) : Carbon::today();
        $dayName = strtolower($dateObj->format('l')); // monday, tuesday, ...
        $column  = "{$dayName}_pricing";

        // 1) Coba dari season utama
        $primary = $this->currentPricing($dateObj);
        $price   = $primary->{$column} ?? null;
        if (! is_null($price)) {
            return $price;
        }

        // 2) Fallback: cari di semua pricing yang punya kolom hari itu tidak null
        $fallback = $this->pricings()
                         ->with('season')
                         ->get()
                         ->filter(fn($p) => ! is_null($p->{$column}))
                         ->sortByDesc(fn($p) => $p->season->priority)
                         ->first();

        return $fallback->{$column} ?? null;
    }

    /**
     * Accessor agar bisa dipanggil $villa->today_price
     */
    public function getTodayPriceAttribute(): ?int
    {
        return $this->priceForDate();
    }

    /**
     * Hitung harga per-hari untuk rentang [start, end) dan kembalikan array date=>rate.
     *
     * @param  string|\DateTime  $start
     * @param  string|\DateTime  $end
     * @return array  ['2025-05-10'=>20000, '2025-05-11'=>20000, …]
     */
    public function pricesForRange($start, $end): array
    {
        $from = Carbon::parse($start)->startOfDay();
        $to   = Carbon::parse($end)->startOfDay();

        $results = [];
        for ($dt = $from->copy(); $dt->lt($to); $dt->addDay()) {
            $dateKey = $dt->toDateString();
            $results[$dateKey] = $this->priceForDate($dt) ?? 0;
        }

        return $results;
    }

    /**
     * Accessor agar bisa dipanggil $villa->prices_for_range
     */
    public function getPricesForRangeAttribute(): array
    {
        // default contoh 7 hari dari hari ini
        return $this->pricesForRange(now(), now()->addDays(7));
    }
}
