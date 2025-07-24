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
        'special_price_range', // New field untuk special price dengan range tanggal tertentu
    ];

    protected $casts = [
        'range_date_price' => 'array',
        'special_price_range' => 'array', // New cast untuk special price range
        'use_special_price' => 'boolean',
    ];

    public function villa()
    {
        return $this->belongsTo(Villa::class, 'villa_id', 'id_villa');
    }

    public function season()
    {
        return $this->belongsTo(Season::class, 'season_id', 'id_season');
    }

    /**
     * Get price for a specific date
     *
     * @param string $date Format: Y-m-d
     * @return array|null
     */
    public function getPriceForDate($date)
    {
        $targetDate = \Carbon\Carbon::parse($date);
        $dayOfWeek = $targetDate->dayOfWeek;
        $dateString = $targetDate->format('Y-m-d');

        // Priority pricing:
        // 1. Special Price Range
        // 2. Range Date Price
        // 3. Global Special Price
        // 4. Day of week pricing

        // 1. Check Special Price Range
        if ($this->special_price_range &&
            isset($this->special_price_range['dates']) &&
            in_array($dateString, $this->special_price_range['dates']) &&
            isset($this->special_price_range['price']) &&
            $this->special_price_range['price'] > 0) {

            return [
                'price' => $this->special_price_range['price'],
                'source' => 'special_price_range',
                'description' => $this->special_price_range['description'] ?? 'Special price untuk tanggal tertentu'
            ];
        }

        // 2. Check Range Date Price
        if ($this->range_date_price &&
            isset($this->range_date_price['dates']) &&
            in_array($dateString, $this->range_date_price['dates']) &&
            isset($this->range_date_price['price']) &&
            $this->range_date_price['price'] > 0) {

            return [
                'price' => $this->range_date_price['price'],
                'source' => 'range_date_price',
                'description' => $this->range_date_price['description'] ?? 'Harga khusus untuk periode tertentu'
            ];
        }

        // 3. Check Global Special Price
        if ($this->use_special_price && $this->special_price > 0) {
            return [
                'price' => $this->special_price,
                'source' => 'global_special_price',
                'description' => $this->special_price_description ?? 'Special price'
            ];
        }

        // 4. Day of week pricing
        $dayMapping = [
            0 => 'sunday_pricing',
            1 => 'monday_pricing',
            2 => 'tuesday_pricing',
            3 => 'wednesday_pricing',
            4 => 'thursday_pricing',
            5 => 'friday_pricing',
            6 => 'saturday_pricing'
        ];

        $pricingField = $dayMapping[$dayOfWeek];
        $price = $this->$pricingField;

        if ($price > 0) {
            return [
                'price' => $price,
                'source' => 'day_of_week',
                'description' => 'Harga reguler'
            ];
        }

        return null;
    }

    /**
     * Check if date is in special price range
     *
     * @param string $date Format: Y-m-d
     * @return bool
     */
    public function isSpecialPriceDate($date)
    {
        if (!$this->special_price_range || !isset($this->special_price_range['dates'])) {
            return false;
        }

        return in_array($date, $this->special_price_range['dates']);
    }

    /**
     * Check if date is in range date price
     *
     * @param string $date Format: Y-m-d
     * @return bool
     */
    public function isRangeDatePrice($date)
    {
        if (!$this->range_date_price || !isset($this->range_date_price['dates'])) {
            return false;
        }

        return in_array($date, $this->range_date_price['dates']);
    }

    /**
     * Get all special dates (both special_price_range and range_date_price)
     *
     * @return array
     */
    public function getSpecialDates()
    {
        $specialDates = [];

        if ($this->special_price_range && isset($this->special_price_range['dates'])) {
            foreach ($this->special_price_range['dates'] as $date) {
                $specialDates[$date] = [
                    'type' => 'special_price_range',
                    'price' => $this->special_price_range['price'] ?? null,
                    'description' => $this->special_price_range['description'] ?? 'Special price'
                ];
            }
        }

        if ($this->range_date_price && isset($this->range_date_price['dates'])) {
            foreach ($this->range_date_price['dates'] as $date) {
                $specialDates[$date] = [
                    'type' => 'range_date_price',
                    'price' => $this->range_date_price['price'] ?? null,
                    'description' => $this->range_date_price['description'] ?? 'Harga khusus'
                ];
            }
        }

        return $specialDates;
    }
}
