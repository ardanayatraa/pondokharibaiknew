<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Reservasi;

class ReservasiTable extends DataTableComponent
{
    protected $model = Reservasi::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id reservation", "id_reservation")
                ->sortable(),
            Column::make("Guest id", "guest_id")
                ->sortable(),
            Column::make("Villa id", "villa_id")
                ->sortable(),
            Column::make("Cek ketersediaan id", "cek_ketersediaan_id")
                ->sortable(),
            Column::make("Villa pricing id", "villa_pricing_id")
                ->sortable(),
            Column::make("Start date", "start_date")
                ->sortable(),
            Column::make("End date", "end_date")
                ->sortable(),
            Column::make("Status", "status")
                ->sortable(),
            Column::make("Total amount", "total_amount")
                ->sortable(),
                Column::make("Aksi")
                ->label(fn ($row) => view('components.link-action', ['id' => $row->id_reservation]))
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
