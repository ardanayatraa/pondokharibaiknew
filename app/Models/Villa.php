<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
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
    protected $keyType = 'int'; // ubah jika PK-mu non-int

    protected $fillable = [
        'facility_id',
        'name',
        'description',
        'picture',
        'capacity',    // biarkan typo ini sesuai kolom DB-mu
    ];

    protected $casts = [
        'facility_id' => 'array',
    ];

    // —— RELATIONS —— //

    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'villa_id');
    }

    /**
     * Semua VillaPricing milik villa ini
     */
    public function pricings()
    {
        return $this->hasMany(VillaPricing::class, 'villa_id', 'id_villa');
    }

    /**
     * Relasi one-to-many ke tabel cek_ketersediaan
     */
    public function cekKetersediaan()
    {
        return $this->hasMany(CekKetersediaan::class, 'villa_id', 'id_villa');
    }

    /**
     * Untuk menampilkan daftar nama fasilitas
     */
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
     * Cari VillaPricing yang berlaku pada $date (default: hari ini).
     * – Pertama: cari pricing di season di mana $date di antara tgl_mulai_season & tgl_akhir_season
     * – Jika tidak ada, fallback ke season dengan nama 'Normal'
     *
     * @param  string|\DateTime|null  $date
     * @return VillaPricing|null
     */
    public function currentPricing($date = null): ?VillaPricing
    {
        $date = $date
            ? Carbon::parse($date)->toDateString()
            : Carbon::today()->toDateString();

        // 1) Pricing dalam rentang season
        $pricing = $this->pricings()
            ->whereHas('season', fn($q) => $q
                ->where('tgl_mulai_season', '<=', $date)
                ->where('tgl_akhir_season', '>=', $date)
            )
            ->first();

        if ($pricing) {
            return $pricing;
        }

        // 2) Fallback ke season 'Normal'
        return $this->pricings()
            ->whereHas('season', fn($q) => $q->where('nama_season', 'Normal'))
            ->first();
    }

    /**
     * Accessor agar bisa dipanggil $villa->current_pricing
     */
    public function getCurrentPricingAttribute(): ?VillaPricing
    {
        return $this->currentPricing();
    }

    /**
     * Ambil harga sesuai hari pada $date (default: hari ini).
     *
     * @param  string|\DateTime|null  $date
     * @return int|null
     */
    public function priceForDate($date = null): ?int
    {
        $pricing = $this->currentPricing($date);
        if (! $pricing) {
            return null;
        }

        $dayName = strtolower(Carbon::parse($date ?: Carbon::today())->format('l'));
        $column  = "{$dayName}_pricing";

        return $pricing->{$column};
    }

    /**
     * Accessor agar bisa dipanggil $villa->today_price
     */
    public function getTodayPriceAttribute(): ?int
    {
        return $this->priceForDate();
    }
}
