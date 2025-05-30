<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillaPricing extends Model
{
    use HasFactory;

    protected $table = 'tbl_villa_pricing';
    protected $primaryKey = 'id_villa_pricing';
    protected $fillable = [
        'villa_id', 'season_id', 'sunday_pricing', 'monday_pricing',
        'tuesday_pricing', 'wednesday_pricing', 'thursday_pricing',
        'friday_pricing', 'saturday_pricing'
    ];

    public function villa()
    {
        return $this->hasOne(Villa::class, 'id_villa', 'villa_id');
    }


    public function season()
    {
        return $this->belongsTo(Season::class, 'season_id');
    }
}
