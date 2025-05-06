<?php

namespace App\Livewire\Season;

use Livewire\Component;
use App\Models\Season;

class Delete extends Component
{
    public $open = false;
    public $id_season;

    protected $listeners = ['delete' => 'confirmDelete'];

    public function confirmDelete($id)
    {
        $this->id_season = $id;
        $this->open = true;
    }

    public function delete()
    {
        Season::findOrFail($this->id_season)->delete();
        session()->flash('message', 'Season berhasil dihapus.');
        $this->dispatch('refreshDatatable');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.season.delete');
    }
}
