<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Pembayaran;

class PembayaranTable extends DataTableComponent
{
    protected $model = Pembayaran::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id pembayaran", "id_pembayaran")
                ->sortable(),
            Column::make("Guest id", "guest_id")
                ->sortable(),
            Column::make("Reservation id", "reservation_id")
                ->sortable(),
            Column::make("Amount", "amount")
                ->sortable(),
            Column::make("Payment date", "payment_date")
                ->sortable(),

            Column::make("Notifikasi", "notifikasi")
                ->sortable(),
            Column::make("Status", "status")
                ->sortable(),
                Column::make("Aksi")
                ->label(fn ($row) => view('components.link-action', [
                    'id' => $row->id_pembayaran,
                    'routeName' => 'pembayaran'
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
