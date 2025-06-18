<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\VillaPricing;

class VillaPricingTable extends DataTableComponent
{
    protected $model = VillaPricing::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id_villa_pricing")
                ->sortable(),
            Column::make("Villa", "villa.name")
                ->sortable(),
            Column::make("Season", "season.nama_season")
                ->sortable(),
            Column::make("Sunday", "sunday_pricing")
                ->sortable(),
            Column::make("Monday", "monday_pricing")
                ->sortable(),
            Column::make("Tuesday", "tuesday_pricing")
                ->sortable(),
            Column::make("Wednesday", "wednesday_pricing")
                ->sortable(),
            Column::make("Thursday", "thursday_pricing")
                ->sortable(),
            Column::make("Friday", "friday_pricing")
                ->sortable(),
            Column::make("Saturday", "saturday_pricing")
                ->sortable(),

                Column::make("Aksi")
                ->label(fn ($row) => view('components.link-action', [
                    'id' => $row->id_villa_pricing,
                    'routeName' => 'harga-villa'
                ])->render()) // ← render() mengubah view jadi string
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
