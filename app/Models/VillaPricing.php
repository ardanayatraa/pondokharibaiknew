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

    /**
     * Get price for specific day of week
     * 0 = Sunday, 1 = Monday, etc.
     */
    public function getPriceForDay($dayOfWeek)
    {
        $dayFields = [
            0 => 'sunday_pricing',
            1 => 'monday_pricing',
            2 => 'tuesday_pricing',
            3 => 'wednesday_pricing',
            4 => 'thursday_pricing',
            5 => 'friday_pricing',
            6 => 'saturday_pricing',
        ];

        return $this->{$dayFields[$dayOfWeek]} ?? 0;
    }

    /**
     * Get range date price from season
     */
    public function getRangeDatePriceAttribute()
    {
        return $this->season ? $this->season->range_date_price : null;
    }

    /**
     * Check if pricing is valid for specific date
     */
    public function isValidForDate($date)
    {
        $carbon = Carbon::parse($date);
        $dayOfWeek = $carbon->dayOfWeek;

        if (!$this->season) {
            return false;
        }

        // If season is repeat weekly, check if day is in allowed days
        if ($this->season->repeat_weekly) {
            return in_array($dayOfWeek, $this->season->days_of_week ?? []);
        }

        // If season uses date range, check if date is within range
        if ($this->season->range_date_price && is_array($this->season->range_date_price)) {
            foreach ($this->season->range_date_price as $range) {
                if (isset($range['start_date']) && isset($range['end_date'])) {
                    $startDate = Carbon::parse($range['start_date']);
                    $endDate = Carbon::parse($range['end_date']);

                    if ($carbon->between($startDate, $endDate)) {
                        return true;
                    }
                }
            }
            return false;
        }

        // Check traditional season date range
        if ($this->season->tgl_mulai_season && $this->season->tgl_akhir_season) {
            $startDate = Carbon::parse($this->season->tgl_mulai_season);
            $endDate = Carbon::parse($this->season->tgl_akhir_season);

            return $carbon->between($startDate, $endDate);
        }

        return false;
    }

    /**
     * Get effective price for a specific date
     */
    public function getEffectivePriceForDate($date)
    {
        if (!$this->isValidForDate($date)) {
            return null;
        }

        // Return day-specific price
        $carbon = Carbon::parse($date);
        $dayOfWeek = $carbon->dayOfWeek;

        return $this->getPriceForDay($dayOfWeek);
    }

    /**
     * Get day name in Indonesian
     */
    public function getDayName($dayOfWeek)
    {
        $dayNames = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu'
        ];

        return $dayNames[$dayOfWeek] ?? '';
    }

    /**
     * Get all day prices as array
     */
    public function getAllDayPrices()
    {
        return [
            'sunday' => $this->sunday_pricing,
            'monday' => $this->monday_pricing,
            'tuesday' => $this->tuesday_pricing,
            'wednesday' => $this->wednesday_pricing,
            'thursday' => $this->thursday_pricing,
            'friday' => $this->friday_pricing,
            'saturday' => $this->saturday_pricing,
        ];
    }

    /**
     * Check if any price is set
     */
    public function hasAnyPrice()
    {
        return $this->sunday_pricing || $this->monday_pricing || $this->tuesday_pricing ||
               $this->wednesday_pricing || $this->thursday_pricing || $this->friday_pricing ||
               $this->saturday_pricing;
    }
}
