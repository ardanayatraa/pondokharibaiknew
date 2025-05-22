<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Season extends Model
{
    use HasFactory;

    protected $table = 'tbl_season';
    protected $primaryKey = 'id_season';

    protected $fillable = [
        'nama_season',
        'tgl_mulai_season',
        'tgl_akhir_season',
        'repeat_weekly',
        'days_of_week',
        'priority',
    ];

    protected $casts = [
        'tgl_mulai_season' => 'date',
        'tgl_akhir_season' => 'date',
        'repeat_weekly'    => 'boolean',
        'days_of_week'     => 'array',
        'priority'         => 'integer',
    ];

    /**
     * Relasi ke tabel villa_pricing
     */
    public function villaPricing(): HasMany
    {
        return $this->hasMany(VillaPricing::class, 'season_id', 'id_season');
    }

    /**
     * Nama-nama hari jika weekly; '-' kalau bukan atau days_of_week kosong.
     */
    public function getDaysOfWeekLabelAttribute(): string
    {
        if (! $this->repeat_weekly || ! is_array($this->days_of_week)) {
            return '-';
        }

        $map = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
        ];

        return collect($this->days_of_week)
            ->filter(fn($d) => isset($map[$d]))
            ->map(fn($d) => $map[$d])
            ->join(', ');
    }

    /**
     * Label Periode:
     * - daftar hari jika weekly
     * - atau "dd-mm-yyyy s/d dd-mm-yyyy" jika rentang
     * - fallback '-' kalau data tanggal kosong
     */
    public function getPeriodeLabelAttribute(): string
    {
        if ($this->repeat_weekly) {
            return $this->days_of_week_label;
        }

        $start = optional($this->tgl_mulai_season)->format('d-m-Y');
        $end   = optional($this->tgl_akhir_season)->format('d-m-Y');

        if (! $start || ! $end) {
            return '-';
        }

        return "{$start} s/d {$end}";
    }
}
