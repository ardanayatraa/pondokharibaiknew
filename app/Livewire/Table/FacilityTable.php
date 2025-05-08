<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Facility;

class FacilityTable extends DataTableComponent
{
    protected $model = Facility::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id facility", "id_facility")
                ->sortable(),
            Column::make("Name facility", "name_facility")
                ->sortable(),
            Column::make("Description", "description")
                ->sortable(),
            Column::make("Facility type", "facility_type")
                ->sortable(),
                Column::make("Aksi")
                ->label(fn ($row) => view('components.link-action', [
                    'id' => $row->id_facility,
                    'routeName' => 'facility'
                ]))
                ->html(),
        ];
    }
}
