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

    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return Pembayaran::query()
            ->with(['guest'])
            ->select('tbl_pembayaran.*')
            ->orderBy('payment_date', 'desc')
            ->orderBy('created_at', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id_pembayaran")
                ->sortable(),
            Column::make("Guest", "guest.full_name")
                ->sortable(),
            Column::make("Reservation", "reservation_id")
                ->sortable(),
            Column::make("Amount", "amount")
                ->sortable(),
            Column::make("Payment date", "payment_date")
                ->sortable(),


            Column::make("Status", "status")
                ->sortable(),
                Column::make("Aksi")
                ->label(fn ($row) => view('components.link-action-view', [
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
