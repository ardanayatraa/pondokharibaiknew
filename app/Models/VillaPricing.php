<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillaPricing extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_villa_pricing';
        protected $table = 'tbl_villa_pricing';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'villa_id',
        'season_id',
        'sunday_pricing',
        'monday_pricing',
        'tuesday_pricing',
        'wednesday_pricing',
        'thursday_pricing',
        'friday_pricing',
        'saturday_pricing',
    ];

    public function villa()
    {
        return $this->belongsTo(Villa::class, 'villa_id');
    }

    public function season()
    {
        return $this->belongsTo(Season::class, 'season_id');
    }
}
