<?php

namespace App\Livewire\Table;

use App\Jobs\SendEmailStatus;
use App\Models\Reservasi;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class GuestReservasiTable extends DataTableComponent
{
    protected $model = Reservasi::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id_reservation');
    }

    /**
     * Override builder() agar selalu mengurutkan dari yang terbaru berdasarkan created_at.
     */
    public function builder(): Builder
    {
        return Reservasi::query()
            ->with(['guest', 'villa'])
            ->orderBy('tbl_reservasi.created_at', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id_reservation")
                ->sortable()
                ->format(function($value, $row, Column $column) {
                    return view('components.action-reservation', [
                        'text'       => "#{$value}",
                        'clickEvent' => 'openModal',
                        'param'      => $value,
                    ])->render();
                })
                ->html(),

            Column::make("Status", "status")
                ->sortable(),

            Column::make("Guest", "guest.full_name")
                ->sortable(),

            Column::make("Villa", "villa.name")
                ->sortable(),

            Column::make("Start", "start_date")
                ->sortable(),

            Column::make("End", "end_date")
                ->sortable(),

            Column::make("Total", "total_amount")
                ->sortable(),
        ];
    }

    public function openModal($idReservation)
    {
        $this->dispatch('openModal', $idReservation);
    }
}
