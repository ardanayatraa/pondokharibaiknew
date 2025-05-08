<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Admin;

class AdminTable extends DataTableComponent
{
    protected $model = Admin::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id admin", "id_admin")
                ->sortable(),
            Column::make("Username", "username")
                ->sortable(),
            Column::make("Password", "password")
                ->sortable(),
            Column::make("Email", "email")
                ->sortable(),
                Column::make("Aksi")
                ->label(fn ($row) => view('components.link-action', [
                    'id' => $row->id_admin,
                    'routeName' => 'admin'
                ]))
                ->html(),
        ];
    }
}
