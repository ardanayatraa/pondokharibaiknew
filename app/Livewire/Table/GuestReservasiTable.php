<?php

namespace App\Livewire\Table;

use App\Jobs\SendEmailStatus;
use App\Models\Reservasi;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class GuestReservasiTable extends DataTableComponent
{
    protected $model = Reservasi::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id_reservation');
    }

    public function columns(): array
    {
        return [


            Column::make("Id Reservation", "id_reservation")
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

            Column::make("Start Date", "start_date")
                ->sortable(),

            Column::make("End Date", "end_date")
                ->sortable(),

            Column::make("Total Amount", "total_amount")
                ->sortable(),
        ];
    }

    public function openModal($idReservation)
    {

    $this->dispatch('openModal', $idReservation);
    }
}
