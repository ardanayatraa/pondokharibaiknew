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

    /**
     * Get complete pricing information for a specific date
     */
    public function getPriceForDate($date)
    {
        $targetDate = Carbon::parse($date);
        $dayOfWeek = $targetDate->dayOfWeek;
        $dateString = $targetDate->format('Y-m-d');

        // Priority-based pricing system
        $priceData = $this->getSpecialPriceRangeForDate($dateString) ?:
                    $this->getRangeDatePriceForDate($dateString) ?:
                    $this->getGlobalSpecialPrice() ?:
                    $this->getDayOfWeekPrice($dayOfWeek);

        return $priceData;
    }

    /**
     * Get special price range for a specific date
     */
    public function getSpecialPriceRangeForDate($date)
    {
        if (!$this->special_price_range) {
            return null;
        }

        $ranges = $this->normalizeRangeArray($this->special_price_range);

        foreach ($ranges as $range) {
            if (isset($range['dates']) && in_array($date, $range['dates']) &&
                isset($range['price']) && $range['price'] > 0) {
                return [
                    'price' => $range['price'],
                    'source' => 'special_price_range',
                    'description' => $range['description'] ?? 'Special price untuk tanggal tertentu',
                    'range_info' => $range
                ];
            }
        }

        return null;
    }

    /**
     * Get range date price for a specific date
     */
    public function getRangeDatePriceForDate($date)
    {
        if (!$this->range_date_price) {
            return null;
        }

        $ranges = $this->normalizeRangeArray($this->range_date_price);

        foreach ($ranges as $range) {
            if (isset($range['dates']) && in_array($date, $range['dates']) &&
                isset($range['price']) && $range['price'] > 0) {
                return [
                    'price' => $range['price'],
                    'source' => 'range_date_price',
                    'description' => $range['description'] ?? 'Harga khusus untuk periode tertentu',
                    'range_info' => $range
                ];
            }
        }

        return null;
    }

    /**
     * Get global special price if active
     */
    public function getGlobalSpecialPrice()
    {
        if ($this->use_special_price && $this->special_price > 0) {
            return [
                'price' => $this->special_price,
                'source' => 'global_special_price',
                'description' => $this->special_price_description ?? 'Special price'
            ];
        }

        return null;
    }

    /**
     * Get day of week pricing
     */
    public function getDayOfWeekPrice($dayOfWeek)
    {
        $dayMapping = [
            0 => 'sunday_pricing',
            1 => 'monday_pricing',
            2 => 'tuesday_pricing',
            3 => 'wednesday_pricing',
            4 => 'thursday_pricing',
            5 => 'friday_pricing',
            6 => 'saturday_pricing'
        ];

        $pricingField = $dayMapping[$dayOfWeek] ?? null;

        if ($pricingField && $this->$pricingField > 0) {
            return [
                'price' => $this->$pricingField,
                'source' => 'day_of_week',
                'description' => 'Harga reguler'
            ];
        }

        return null;
    }

    /**
     * Check if date is in special price range
     */
    public function isSpecialPriceDate($date)
    {
        return $this->getSpecialPriceRangeForDate($date) !== null;
    }

    /**
     * Check if date is in range date price
     */
    public function isRangeDatePrice($date)
    {
        return $this->getRangeDatePriceForDate($date) !== null;
    }

    /**
     * Get all special dates with their pricing info
     */
    public function getSpecialDates()
    {
        $specialDates = [];

        // Add special price range dates
        if ($this->special_price_range) {
            $ranges = $this->normalizeRangeArray($this->special_price_range);
            foreach ($ranges as $range) {
                if (isset($range['dates'])) {
                    foreach ($range['dates'] as $date) {
                        $specialDates[$date] = [
                            'type' => 'special_price_range',
                            'price' => $range['price'] ?? null,
                            'description' => $range['description'] ?? 'Special price',
                            'range_info' => $range
                        ];
                    }
                }
            }
        }

        // Add range date price dates (lower priority, won't override special price range)
        if ($this->range_date_price) {
            $ranges = $this->normalizeRangeArray($this->range_date_price);
            foreach ($ranges as $range) {
                if (isset($range['dates'])) {
                    foreach ($range['dates'] as $date) {
                        if (!isset($specialDates[$date])) { // Only add if not already set by special price range
                            $specialDates[$date] = [
                                'type' => 'range_date_price',
                                'price' => $range['price'] ?? null,
                                'description' => $range['description'] ?? 'Harga khusus',
                                'range_info' => $range
                            ];
                        }
                    }
                }
            }
        }

        return $specialDates;
    }

    /**
     * Add a new range date price
     */
    public function addRangeDatePrice(array $rangeDatePrice)
    {
        $this->validateRangeData($rangeDatePrice);

        // Ensure dates array is generated
        if (!isset($rangeDatePrice['dates'])) {
            $rangeDatePrice['dates'] = $this->generateDatesArray(
                $rangeDatePrice['start_date'],
                $rangeDatePrice['end_date']
            );
        }

        // Convert existing data to array format
        $existingRanges = $this->getAllRangeDatePrices();
        $existingRanges[] = $rangeDatePrice;

        $this->range_date_price = count($existingRanges) === 1 ? $existingRanges[0] : $existingRanges;

        return $this;
    }

    /**
     * Add a new special price range
     */
    public function addSpecialPriceRange(array $specialPriceRange)
    {
        $this->validateRangeData($specialPriceRange);

        // Ensure dates array is generated
        if (!isset($specialPriceRange['dates'])) {
            $specialPriceRange['dates'] = $this->generateDatesArray(
                $specialPriceRange['start_date'],
                $specialPriceRange['end_date']
            );
        }

        // Convert existing data to array format
        $existingRanges = $this->getAllSpecialPriceRanges();
        $existingRanges[] = $specialPriceRange;

        $this->special_price_range = count($existingRanges) === 1 ? $existingRanges[0] : $existingRanges;

        return $this;
    }

    /**
     * Get all range date prices as array
     */
    public function getAllRangeDatePrices()
    {
        if (!$this->range_date_price) {
            return [];
        }

        return $this->normalizeRangeArray($this->range_date_price);
    }

    /**
     * Get all special price ranges as array
     */
    public function getAllSpecialPriceRanges()
    {
        if (!$this->special_price_range) {
            return [];
        }

        return $this->normalizeRangeArray($this->special_price_range);
    }

    /**
     * Remove a range date price by index
     */
    public function removeRangeDatePrice($index)
    {
        $ranges = $this->getAllRangeDatePrices();

        if (isset($ranges[$index])) {
            unset($ranges[$index]);
            $ranges = array_values($ranges); // Reindex array

            $this->range_date_price = empty($ranges) ? null :
                (count($ranges) === 1 ? $ranges[0] : $ranges);
        }

        return $this;
    }

    /**
     * Remove a special price range by index
     */
    public function removeSpecialPriceRange($index)
    {
        $ranges = $this->getAllSpecialPriceRanges();

        if (isset($ranges[$index])) {
            unset($ranges[$index]);
            $ranges = array_values($ranges); // Reindex array

            $this->special_price_range = empty($ranges) ? null :
                (count($ranges) === 1 ? $ranges[0] : $ranges);
        }

        return $this;
    }

    /**
     * Get pricing summary for a date range
     */
    public function getPricingSummaryForDateRange($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $summary = [
            'total_days' => 0,
            'available_days' => 0,
            'total_price' => 0,
            'pricing_breakdown' => [],
            'daily_prices' => []
        ];

        $currentDate = $start->copy();
        while ($currentDate->lte($end)) {
            $dateString = $currentDate->format('Y-m-d');
            $summary['total_days']++;

            $priceData = $this->getPriceForDate($dateString);

            if ($priceData && $priceData['price'] > 0) {
                $summary['available_days']++;
                $summary['total_price'] += $priceData['price'];

                // Count pricing sources
                $source = $priceData['source'];
                $summary['pricing_breakdown'][$source] = ($summary['pricing_breakdown'][$source] ?? 0) + 1;

                $summary['daily_prices'][] = [
                    'date' => $dateString,
                    'price' => $priceData['price'],
                    'source' => $source,
                    'description' => $priceData['description']
                ];
            } else {
                $summary['daily_prices'][] = [
                    'date' => $dateString,
                    'price' => null,
                    'available' => false,
                    'reason' => 'Tidak ada harga tersedia'
                ];
            }

            $currentDate->addDay();
        }

        return $summary;
    }

    /**
     * Check if pricing is available for a specific date
     */
    public function isAvailableForDate($date)
    {
        $priceData = $this->getPriceForDate($date);
        return $priceData && $priceData['price'] > 0;
    }

    /**
     * Get the lowest price in a date range
     */
    public function getLowestPriceInRange($startDate, $endDate)
    {
        $summary = $this->getPricingSummaryForDateRange($startDate, $endDate);
        $prices = array_filter(array_column($summary['daily_prices'], 'price'));

        return empty($prices) ? null : min($prices);
    }

    /**
     * Get the highest price in a date range
     */
    public function getHighestPriceInRange($startDate, $endDate)
    {
        $summary = $this->getPricingSummaryForDateRange($startDate, $endDate);
        $prices = array_filter(array_column($summary['daily_prices'], 'price'));

        return empty($prices) ? null : max($prices);
    }

    /**
     * Get average price in a date range
     */
    public function getAveragePriceInRange($startDate, $endDate)
    {
        $summary = $this->getPricingSummaryForDateRange($startDate, $endDate);
        $prices = array_filter(array_column($summary['daily_prices'], 'price'));

        return empty($prices) ? null : array_sum($prices) / count($prices);
    }

    // Private Helper Methods

    /**
     * Normalize range data to always be an array of ranges
     */
    private function normalizeRangeArray($data)
    {
        if (!$data) {
            return [];
        }

        // If it's a single range (has 'dates' key), wrap it in an array
        if (isset($data['dates'])) {
            return [$data];
        }

        // If it's already an array of ranges, return as is
        if (is_array($data) && !empty($data)) {
            return $data;
        }

        return [];
    }

    /**
     * Validate range data structure
     */
    private function validateRangeData(array $rangeData)
    {
        if (!isset($rangeData['start_date']) || !isset($rangeData['end_date']) || !isset($rangeData['price'])) {
            throw new \InvalidArgumentException(
                'Range data must have start_date, end_date, and price'
            );
        }

        if ($rangeData['price'] < 0) {
            throw new \InvalidArgumentException('Price cannot be negative');
        }

        $startDate = Carbon::parse($rangeData['start_date']);
        $endDate = Carbon::parse($rangeData['end_date']);

        if ($startDate->gt($endDate)) {
            throw new \InvalidArgumentException('Start date cannot be after end date');
        }
    }

    /**
     * Generate array of dates between start and end date
     */
    private function generateDatesArray($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $dates = [];

        $currentDate = $start->copy();
        while ($currentDate->lte($end)) {
            $dates[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }

        return $dates;
    }

    /**
     * Filter dates based on season configuration
     */
    private function filterDatesBySeason(array $dates, Season $season)
    {
        if (!$season->repeat_weekly) {
            // For date range seasons, filter dates within season range
            return array_filter($dates, function($date) use ($season) {
                $dateCarbon = Carbon::parse($date);
                return $dateCarbon->gte($season->tgl_mulai_season) &&
                       $dateCarbon->lte($season->tgl_akhir_season);
            });
        } else {
            // For weekly seasons, filter by days of week
            return array_filter($dates, function($date) use ($season) {
                $dayOfWeek = Carbon::parse($date)->dayOfWeek;
                return in_array($dayOfWeek, $season->days_of_week);
            });
        }
    }

    /**
     * Get formatted price display
     */
    public function getFormattedPrice($price)
    {
        return 'Rp ' . number_format($price, 0, ',', '.');
    }

    /**
     * Check if there are any conflicts between ranges
     */
    public function hasRangeConflicts()
    {
        $allDates = [];

        // Collect all dates from special price ranges
        foreach ($this->getAllSpecialPriceRanges() as $range) {
            if (isset($range['dates'])) {
                foreach ($range['dates'] as $date) {
                    if (isset($allDates[$date])) {
                        return true; // Conflict found
                    }
                    $allDates[$date] = 'special_price_range';
                }
            }
        }

        // Check range date prices for conflicts with special price ranges
        foreach ($this->getAllRangeDatePrices() as $range) {
            if (isset($range['dates'])) {
                foreach ($range['dates'] as $date) {
                    if (isset($allDates[$date]) && $allDates[$date] === 'special_price_range') {
                        // This is not a conflict since special price has higher priority
                        continue;
                    }
                    if (isset($allDates[$date])) {
                        return true; // Conflict found
                    }
                    $allDates[$date] = 'range_date_price';
                }
            }
        }

        return false;
    }

    /**
     * Get range conflicts details
     */
    public function getRangeConflicts()
    {
        $conflicts = [];
        $dateTracker = [];

        // Track special price ranges
        foreach ($this->getAllSpecialPriceRanges() as $index => $range) {
            if (isset($range['dates'])) {
                foreach ($range['dates'] as $date) {
                    if (isset($dateTracker[$date])) {
                        $conflicts[] = [
                            'date' => $date,
                            'ranges' => [$dateTracker[$date], ['type' => 'special_price_range', 'index' => $index]]
                        ];
                    } else {
                        $dateTracker[$date] = ['type' => 'special_price_range', 'index' => $index];
                    }
                }
            }
        }

        // Track range date prices
        foreach ($this->getAllRangeDatePrices() as $index => $range) {
            if (isset($range['dates'])) {
                foreach ($range['dates'] as $date) {
                    if (isset($dateTracker[$date])) {
                        $conflicts[] = [
                            'date' => $date,
                            'ranges' => [$dateTracker[$date], ['type' => 'range_date_price', 'index' => $index]]
                        ];
                    } else {
                        $dateTracker[$date] = ['type' => 'range_date_price', 'index' => $index];
                    }
                }
            }
        }

        return $conflicts;
    }
}
