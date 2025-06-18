<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Season;
use Carbon\Carbon;

class SeasonTable extends DataTableComponent
{
    protected $model = Season::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id_season")
                ->sortable(),
            Column::make("Nama", "nama_season")
                ->sortable(),
     Column::make("Tgl mulai", "tgl_mulai_season")
    ->sortable()
    ->format(fn($value) => Carbon::parse($value)->format('d-m-Y')),

        Column::make("Tgl akhir", "tgl_akhir_season")
    ->sortable()
    ->format(fn($value) => Carbon::parse($value)->format('d-m-Y')),
            Column::make("Repeat weekly", "repeat_weekly")
            ->format(function ($value) {
                return $value
                    ? '<span class="px-2 py-1 text-xs   rounded">Ya</span>'
                    : '<span class="px-2 py-1 text-xs text-red-500 rounded">Tidak</span>';
            })
            ->html() ,

            Column::make("Days of week", "days_of_week")
                ->format(function ($value) {
                    $days = [
                        0 => 'Minggu',
                        1 => 'Senin',
                        2 => 'Selasa',
                        3 => 'Rabu',
                        4 => 'Kamis',
                        5 => 'Jumat',
                        6 => 'Sabtu',
                    ];

                    $data = is_array($value) ? $value : json_decode($value, true);

                    if (!is_array($data)) return '-';

                    return collect($data)->map(fn($day) => $days[$day] ?? 'Unknown')->join(', ');
                })
            ,
          Column::make("Aksi")
                ->label(fn ($row) => view('components.link-action', [
                    'id' => $row->id_season,
                    'routeName' => 'season'
                ]))
                ->html(),
        ];
    }

        public function delete($id)
    {
        $this->dispatch('delete', $id);
    }

    public function edit($id)
    {
        $this->dispatch('edit', $id);
    }
}
