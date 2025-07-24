<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class VillaPricing extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_villa_pricing';
    protected $table = 'tbl_villa_pricing';
    public $incrementing = true;
    protected $keyType = 'int';

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
        'special_price',
        'use_special_price',
        'special_price_description',
        'range_date_price',
        'special_price_range',
    ];

    protected $casts = [
        'range_date_price' => 'array',
        'special_price_range' => 'array',
        'use_special_price' => 'boolean',
    ];

    // Relationships
    public function villa()
    {
        return $this->belongsTo(Villa::class, 'villa_id', 'id_villa');
    }

    public function season()
    {
        return $this->belongsTo(Season::class, 'season_id', 'id_season');
    }
}
