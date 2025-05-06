<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Guest;

class GuestTable extends DataTableComponent
{
    protected $model = Guest::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id guest", "id_guest")
                ->sortable(),
            Column::make("Username", "username")
                ->sortable(),

            Column::make("Email", "email")
                ->sortable(),
            Column::make("Full name", "full_name")
                ->sortable(),
            Column::make("Address", "address")
                ->sortable(),
            Column::make("Phone number", "phone_number")
                ->sortable(),
            Column::make("Id card number", "id_card_number")
                ->sortable(),
            Column::make("Passport number", "passport_number")
                ->sortable(),
            Column::make("Birthdate", "birthdate")
                ->sortable(),
            Column::make("Gender", "gender")
                ->sortable(),
                Column::make("Aksi")
                ->label(fn ($row) => view('components.link-action', ['id' => $row->id_guest]))
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
