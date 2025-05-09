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
            Column::make("Id villa pricing", "id_villa_pricing")
                ->sortable(),
            Column::make("Villa id", "villa_id")
                ->sortable(),
            Column::make("Season id", "season_id")
                ->sortable(),
            Column::make("Sunday pricing", "sunday_pricing")
                ->sortable(),
            Column::make("Monday pricing", "monday_pricing")
                ->sortable(),
            Column::make("Tuesday pricing", "tuesday_pricing")
                ->sortable(),
            Column::make("Wednesday pricing", "wednesday_pricing")
                ->sortable(),
            Column::make("Thursday pricing", "thursday_pricing")
                ->sortable(),
            Column::make("Friday pricing", "friday_pricing")
                ->sortable(),
            Column::make("Saturday pricing", "saturday_pricing")
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
