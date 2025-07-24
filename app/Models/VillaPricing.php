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

    /**
     * Struktur data range_date_price:
     * [
     *   {
     *     'start_date': 'Y-m-d',
     *     'end_date': 'Y-m-d',
     *     'dates': ['Y-m-d', 'Y-m-d', ...],
     *     'price': 100000,
     *     'description': 'Deskripsi harga'
     *   },
     *   ...
     * ]
     *
     * Struktur data special_price_range:
     * [
     *   {
     *     'start_date': 'Y-m-d',
     *     'end_date': 'Y-m-d',
     *     'dates': ['Y-m-d', 'Y-m-d', ...],
     *     'price': 100000,
     *     'description': 'Deskripsi harga'
     *   },
     *   ...
     * ]
     */

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
        if (!$this->special_price_range) {
            return false;
        }

        // Handle both single object and array of objects
        if (isset($this->special_price_range['dates'])) {
            // Single object format
            return in_array($date, $this->special_price_range['dates']);
        } else {
            // Array of objects format
            foreach ($this->special_price_range as $range) {
                if (isset($range['dates']) && in_array($date, $range['dates'])) {
                    return true;
                }
            }
            return false;
        }
    }

    /**
     * Check if date is in range date price
     *
     * @param string $date Format: Y-m-d
     * @return bool
     */
    public function isRangeDatePrice($date)
    {
        if (!$this->range_date_price) {
            return false;
        }

        // Handle both single object and array of objects
        if (isset($this->range_date_price['dates'])) {
            // Single object format
            return in_array($date, $this->range_date_price['dates']);
        } else {
            // Array of objects format
            foreach ($this->range_date_price as $range) {
                if (isset($range['dates']) && in_array($date, $range['dates'])) {
                    return true;
                }
            }
            return false;
        }
    }

    /**
     * Get all special dates (both special_price_range and range_date_price)
     *
     * @return array
     */
    public function getSpecialDates()
    {
        $specialDates = [];

        // Handle special_price_range
        if ($this->special_price_range) {
            if (isset($this->special_price_range['dates'])) {
                // Single object format
                foreach ($this->special_price_range['dates'] as $date) {
                    $specialDates[$date] = [
                        'type' => 'special_price_range',
                        'price' => $this->special_price_range['price'] ?? null,
                        'description' => $this->special_price_range['description'] ?? 'Special price'
                    ];
                }
            } else {
                // Array of objects format
                foreach ($this->special_price_range as $range) {
                    if (isset($range['dates'])) {
                        foreach ($range['dates'] as $date) {
                            $specialDates[$date] = [
                                'type' => 'special_price_range',
                                'price' => $range['price'] ?? null,
                                'description' => $range['description'] ?? 'Special price'
                            ];
                        }
                    }
                }
            }
        }

        // Handle range_date_price
        if ($this->range_date_price) {
            if (isset($this->range_date_price['dates'])) {
                // Single object format
                foreach ($this->range_date_price['dates'] as $date) {
                    $specialDates[$date] = [
                        'type' => 'range_date_price',
                        'price' => $this->range_date_price['price'] ?? null,
                        'description' => $this->range_date_price['description'] ?? 'Harga khusus'
                    ];
                }
            } else {
                // Array of objects format
                foreach ($this->range_date_price as $range) {
                    if (isset($range['dates'])) {
                        foreach ($range['dates'] as $date) {
                            $specialDates[$date] = [
                                'type' => 'range_date_price',
                                'price' => $range['price'] ?? null,
                                'description' => $range['description'] ?? 'Harga khusus'
                            ];
                        }
                    }
                }
            }
        }

        return $specialDates;
    }

    /**
     * Get special price range for a specific date
     *
     * @param string $date Format: Y-m-d
     * @return array|null
     */
    public function getSpecialPriceRangeForDate($date)
    {
        if (!$this->special_price_range) {
            return null;
        }

        // Handle both single object and array of objects
        if (isset($this->special_price_range['dates'])) {
            // Single object format
            if (in_array($date, $this->special_price_range['dates'])) {
                return $this->special_price_range;
            }
        } else {
            // Array of objects format
            foreach ($this->special_price_range as $range) {
                if (isset($range['dates']) && in_array($date, $range['dates'])) {
                    return $range;
                }
            }
        }

        return null;
    }

    /**
     * Get range date price for a specific date
     *
     * @param string $date Format: Y-m-d
     * @return array|null
     */
    public function getRangeDatePriceForDate($date)
    {
        if (!$this->range_date_price) {
            return null;
        }

        // Handle both single object and array of objects
        if (isset($this->range_date_price['dates'])) {
            // Single object format
            if (in_array($date, $this->range_date_price['dates'])) {
                return $this->range_date_price;
            }
        } else {
            // Array of objects format
            foreach ($this->range_date_price as $range) {
                if (isset($range['dates']) && in_array($date, $range['dates'])) {
                    return $range;
                }
            }
        }

        return null;
    }

    /**
     * Add a new range date price
     *
     * @param array $rangeDatePrice
     * @return $this
     */
    public function addRangeDatePrice(array $rangeDatePrice)
    {
        if (!isset($rangeDatePrice['start_date']) || !isset($rangeDatePrice['end_date']) || !isset($rangeDatePrice['price'])) {
            throw new \InvalidArgumentException('Range date price must have start_date, end_date, and price');
        }

        // Generate dates array if not provided
        if (!isset($rangeDatePrice['dates'])) {
            $startDate = \Carbon\Carbon::parse($rangeDatePrice['start_date']);
            $endDate = \Carbon\Carbon::parse($rangeDatePrice['end_date']);

            $dates = [];
            $currentDate = $startDate->copy();
            while ($currentDate->lte($endDate)) {
                $dates[] = $currentDate->format('Y-m-d');
                $currentDate->addDay();
            }

            $rangeDatePrice['dates'] = $dates;
        }

        // Convert to array of objects format if currently single object
        if ($this->range_date_price && isset($this->range_date_price['dates'])) {
            $this->range_date_price = [$this->range_date_price];
        }

        // Initialize if null
        if (!$this->range_date_price) {
            $this->range_date_price = [];
        }

        // Add new range
        $this->range_date_price[] = $rangeDatePrice;

        return $this;
    }

    /**
     * Add a new special price range
     *
     * @param array $specialPriceRange
     * @return $this
     */
    public function addSpecialPriceRange(array $specialPriceRange)
    {
        if (!isset($specialPriceRange['start_date']) || !isset($specialPriceRange['end_date']) || !isset($specialPriceRange['price'])) {
            throw new \InvalidArgumentException('Special price range must have start_date, end_date, and price');
        }

        // Generate dates array if not provided
        if (!isset($specialPriceRange['dates'])) {
            $startDate = \Carbon\Carbon::parse($specialPriceRange['start_date']);
            $endDate = \Carbon\Carbon::parse($specialPriceRange['end_date']);

            $dates = [];
            $currentDate = $startDate->copy();
            while ($currentDate->lte($endDate)) {
                $dates[] = $currentDate->format('Y-m-d');
                $currentDate->addDay();
            }

            $specialPriceRange['dates'] = $dates;
        }

        // Convert to array of objects format if currently single object
        if ($this->special_price_range && isset($this->special_price_range['dates'])) {
            $this->special_price_range = [$this->special_price_range];
        }

        // Initialize if null
        if (!$this->special_price_range) {
            $this->special_price_range = [];
        }

        // Add new range
        $this->special_price_range[] = $specialPriceRange;

        return $this;
    }

    /**
     * Get all range date prices
     *
     * @return array
     */
    public function getAllRangeDatePrices()
    {
        if (!$this->range_date_price) {
            return [];
        }

        // Handle both single object and array of objects
        if (isset($this->range_date_price['dates'])) {
            // Single object format
            return [$this->range_date_price];
        } else {
            // Array of objects format
            return $this->range_date_price;
        }
    }

    /**
     * Get all special price ranges
     *
     * @return array
     */
    public function getAllSpecialPriceRanges()
    {
        if (!$this->special_price_range) {
            return [];
        }

        // Handle both single object and array of objects
        if (isset($this->special_price_range['dates'])) {
            // Single object format
            return [$this->special_price_range];
        } else {
            // Array of objects format
            return $this->special_price_range;
        }
    }
}
