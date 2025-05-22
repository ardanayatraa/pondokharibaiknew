<?php

namespace App\Services;

use App\Models\Season;
use App\Models\VillaPricing;
use Carbon\Carbon;

class SeasonService
{
    /**
     * Cari Season yang berlaku untuk tanggal tertentu.
     *
     * @param  Carbon  $date
     * @return Season|null
     */
    public static function getApplicableSeason(Carbon $date)
    {
        // 1. Cek season rentang tanggal, urut by priority desc
        $season = Season::where('repeat_weekly', false)
            ->whereDate('tgl_mulai_season', '<=', $date)
            ->whereDate('tgl_akhir_season', '>=', $date)
            ->orderByDesc('priority')
            ->first();

        if ($season) {
            return $season;
        }

        // 2. Fallback: season mingguan (Weekday/Weekend)
        return Season::where('repeat_weekly', true)
            ->whereJsonContains('days_of_week', $date->dayOfWeek)
            ->first();
    }

    /**
     * Ambil harga villa untuk tanggal tertentu.
     *
     * @param  int     $villaId
     * @param  Carbon  $date
     * @return float|null
     */
    public static function getPriceForDate(int $villaId, Carbon $date): ?float
    {
        $season = self::getApplicableSeason($date);
        if (! $season) {
            return null;
        }

        $pricing = VillaPricing::where('villa_id', $villaId)
            ->where('season_id', $season->id_season)
            ->first();

        if (! $pricing) {
            return null;
        }

        $fieldMap = [
            0 => 'sunday_pricing',
            1 => 'monday_pricing',
            2 => 'tuesday_pricing',
            3 => 'wednesday_pricing',
            4 => 'thursday_pricing',
            5 => 'friday_pricing',
            6 => 'saturday_pricing',
        ];

        return $pricing->{$fieldMap[$date->dayOfWeek]};
    }
}
