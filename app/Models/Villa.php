<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Villa extends Model
{
    use HasFactory;

    protected $table = 'tbl_villa';
    protected $primaryKey = 'id_villa';
    protected $fillable = ['facility_id', 'villa_pricing_id', 'name', 'description', 'cek_ketersediaan_id'];

    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'villa_id');
    }

    public function fasilitas()
    {
        return $this->belongsTo(Facility::class, 'facility_id');
    }

    public function harga()
    {
        return $this->hasOne(VillaPricing::class, 'villa_pricing_id');
    }
}
