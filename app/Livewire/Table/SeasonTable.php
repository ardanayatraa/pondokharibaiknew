<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Season;

class SeasonTable extends DataTableComponent
{
    protected $model = Season::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id season", "id_season")
                ->sortable(),
            Column::make("Nama season", "nama_season")
                ->sortable(),
            Column::make("Tgl mulai season", "tgl_mulai_season")
                ->sortable(),
            Column::make("Tgl akhir season", "tgl_akhir_season")
                ->sortable(),
                Column::make("Aksi")
                ->label(fn ($row) => view('components.link-action', ['id' => $row->id_season]))
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
