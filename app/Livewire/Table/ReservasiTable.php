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
        $columns = [
            Column::make("Id", "id_reservation")->sortable(),
            Column::make("Guest", "guest.full_name")->sortable(),
            Column::make("Villa", "villa.name")->sortable(),
            Column::make("Start", "start_date")->sortable(),
            Column::make("End", "end_date")->sortable(),
            Column::make("Status", "status")->sortable(),
            Column::make("Total", "total_amount")->sortable(),
            Column::make("Status Check-in", "status_check_in")
                ->label(fn($row) => view('components.badge-status-checkin', ['status' => $row->status_check_in]))
                ->sortable(),
        ];

        // Tambahkan kolom aksi check-in/out hanya jika ada reservasi yang belum checked_out
        if (\App\Models\Reservasi::where('status_check_in', '!=', 'checked_out')->exists()) {
            $columns[] = Column::make("Aksi Check-in/Out")
                ->label(fn($row) => $row->status_check_in !== 'checked_out' ? view('components.action-checkin', ['row' => $row]) : null)
                ->html();
        }

        $columns[] = Column::make("Aksi")
            ->label(fn ($row) => view('components.link-action-view', [
                'id' => $row->id_reservation,
                'routeName' => 'reservasi'
            ]))
            ->html();

        return $columns;
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
