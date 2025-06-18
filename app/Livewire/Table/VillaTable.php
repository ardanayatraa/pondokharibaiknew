<?php

namespace App\Livewire\Table;

use App\Models\Villa;
use App\Models\VillaPricing;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class VillaTable extends DataTableComponent
{
    protected $model = Villa::class;

    public $showFacilityModal = false;
    public $selectedFacilityNames = [];

    public function configure(): void
    {
        $this->setPrimaryKey('id_villa');
        $this->setTableAttributes([
        'default' => false,
        'class'   => 'min-w-full table-fixed', // ⭐️ 这里加上 table-fixed
    ]);
    }

    public function builder(): Builder
    {
        return Villa::query(); // penting: load relasi 'harga'
    }

    public function showFacility($id)
    {
        $this->dispatch('showFacilityModal', $id);
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id_villa")->sortable(),
            Column::make('Picture', 'picture')
                ->format(fn($value) => view('components.image-thumbnail', [
                    'src' => $value
                        ? asset('storage/' . $value)
                        : null
                ]))
                ->html(),

            Column::make("Nama", "name")->sortable(),
Column::make("Description", "description")
    ->sortable()
    ->format(fn($value) => '
        <div
            class="truncate"
            style="max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"
            title="'.e($value).'"
        >'
            .e($value).
        '</div>
    ')
    ->html(),
            Column::make("Fasilitas", "facility_id")
                ->label(function ($row) {
                    return '<button wire:click="showFacility(' . $row->id_villa . ')" class="text-blue-600 underline text-sm hover:text-blue-800">Lihat Fasilitas</button>';
                })
                ->html(),

                Column::make("Harga (" . ucfirst(now()->locale('id')->isoFormat('dddd')) . ")", "villa_pricing_id")
                ->label(function ($row) {
                    $day = strtolower(now()->locale('id')->isoFormat('dddd'));
                    $map = [
                        'minggu' => 'sunday_pricing',
                        'senin' => 'monday_pricing',
                        'selasa' => 'tuesday_pricing',
                        'rabu' => 'wednesday_pricing',
                        'kamis' => 'thursday_pricing',
                        'jumat' => 'friday_pricing',
                        'sabtu' => 'saturday_pricing',
                    ];
                    $column = $map[$day] ?? 'sunday_pricing';

                    $pricing = \App\Models\VillaPricing::where('villa_id', $row->id_villa)->first();

                    return $pricing && $pricing->$column !== null
                        ? 'Rp ' . number_format($pricing->$column, 0, ',', '.')
                        : '<span class="text-gray-400">Belum diatur</span>';
                })
                ->html(),




                Column::make("Aksi")
                ->label(fn ($row) => view('components.link-action', [
                    'id' => $row->id_villa,
                    'routeName' => 'villa'
                ]))
                ->html(),
        ];
    }


}
