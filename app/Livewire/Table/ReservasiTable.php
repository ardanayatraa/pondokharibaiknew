<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Reservasi;
use Illuminate\Database\Eloquent\Builder;

class ReservasiTable extends DataTableComponent
{
    protected $model = Reservasi::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function builder() :Builder
    {
        return Reservasi::query()
            ->with(['guest', 'villa'])
            ->select('tbl_reservasi.*')
            ->orderBy('start_date', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id_reservation")
                ->sortable(),
            Column::make("Guest", "guest.full_name")
                ->sortable(),
            Column::make("Villa", "villa.name")
                ->sortable(),

            Column::make("Start", "start_date")
                ->sortable(),
            Column::make("End", "end_date")
                ->sortable(),
            Column::make("Status", "status")
                ->sortable(),
            Column::make("Total", "total_amount")
                ->sortable(),
                Column::make("Aksi")
                ->label(fn ($row) => view('components.link-action-view', [
                    'id' => $row->id_reservation,
                    'routeName' => 'reservasi'
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
