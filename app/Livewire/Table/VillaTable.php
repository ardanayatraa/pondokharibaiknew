<?php

namespace App\Livewire\Table;

use App\Models\Villa;
use App\Models\VillaPricing;
use Illuminate\Database\Eloquent\Builder;
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
    }

    public function builder(): Builder
    {
        return Villa::with('harga'); // penting: load relasi 'harga'
    }

    public function showFacility($id)
    {
        $this->dispatch('showFacilityModal', $id);
    }

    public function columns(): array
    {
        return [
            Column::make("ID Villa", "id_villa")->sortable(),
            Column::make("Nama", "name")->sortable(),
            Column::make("Deskripsi", "description")->sortable(),
            Column::make("Ketersediaan", "cek_ketersediaan_id")
            ->label(function ($row) {


                $data = \App\Models\CekKetersediaan::where('villa_id',$row->id_villa)->first();
                return $data
                    ? now()->parse($data->start_date)->translatedFormat('d M Y') . ' - ' . now()->parse($data->end_date)->translatedFormat('d M Y')
                    : '<span class="text-gray-400">Tidak tersedia</span>';
            })
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
                ->label(fn ($row) => view('components.link-action', ['id' => $row->id_villa]))
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
