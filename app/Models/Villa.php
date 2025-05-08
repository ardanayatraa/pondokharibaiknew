<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Facility;
use App\Models\VillaPricing;
use App\Models\Reservasi;

class Villa extends Model
{
    use HasFactory;

    protected $table = 'tbl_villa';
    protected $primaryKey = 'id_villa';

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

    public function getFacilityNamesAttribute()
    {
        if (! is_array($this->facility_id)) return [];
        return Facility::whereIn('id_facility', $this->facility_id)
                       ->pluck('name_facility')
                       ->toArray();
    }

    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'villa_id');
    }

    public function harga()
    {
        return $this->belongsTo(VillaPricing::class, 'villa_pricing_id', 'id_villa_pricing');
    }

    public function pricings()
    {
        return $this->hasMany(VillaPricing::class, 'villa_id', 'id_villa');
    }

    public function cekKetersediaan()
    {
        return $this->hasMany(CekKetersediaan::class, 'villa_id', 'id_villa');
    }
}
