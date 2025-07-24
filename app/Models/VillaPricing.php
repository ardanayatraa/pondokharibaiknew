<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    protected $casts = [
        'range_date_price' => 'array',
        'use_special_price' => 'boolean',
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
