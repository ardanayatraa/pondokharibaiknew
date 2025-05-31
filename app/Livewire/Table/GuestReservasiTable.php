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
                ->sortable(),

            Column::make("Status")
                ->format(function($value, $row, Column $column) {
                    return view('components.status-dropdown', [
                        'reservasi' => $row,
                    ]);
                }),

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

    /**
     * Method ini dipanggil lewat wire:change di dropdown untuk update status.
     * Hanya mengizinkan perubahan jika old status benar-benar 'confirmed'.
     */
    public function updateStatus($idReservation, $newStatus)
    {
        $reservasi = Reservasi::find($idReservation);
        if (! $reservasi) {
            return;
        }

        $oldStatus = $reservasi->status;
        $allowedStatuses = ['cancelled', 'reschedule'];

        // Jika old status bukan 'confirmed', batalkan perubahan:
        if ($oldStatus !== 'confirmed') {
            return;
        }

        // Pastikan newStatus termasuk yang diizinkan
        if (! in_array($newStatus, $allowedStatuses)) {
            return;
        }

        // Simpan status baru
        $reservasi->status = $newStatus;
        $reservasi->save();

        // Karena oldStatus pasti 'confirmed' di sini,
        // kita dispatch job untuk email jika newStatus == cancelled atau reschedule
        SendEmailStatus::dispatch($reservasi, $newStatus);
    }
}
