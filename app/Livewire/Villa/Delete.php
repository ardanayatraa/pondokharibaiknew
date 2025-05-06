<?php

namespace App\Livewire\Villa;

use Livewire\Component;
use App\Models\Villa;

class Delete extends Component
{
    public $open = false;
    public $villaIdToDelete;

    protected $listeners = ['delete' => 'confirmDelete'];

    public function confirmDelete($id)
    {
        $this->villaIdToDelete = $id;
        $this->open = true;
    }

    public function deleteVilla()
    {
        $villa = Villa::find($this->villaIdToDelete);
        if ($villa) {
            $villa->delete();
            session()->flash('message', 'Villa berhasil dihapus.');
            $this->dispatch('refreshDatatable');
        }

        $this->reset(['open', 'villaIdToDelete']);
    }

    public function render()
    {
        return view('livewire.villa.delete');
    }
}
