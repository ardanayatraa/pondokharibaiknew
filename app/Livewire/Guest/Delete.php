<?php

namespace App\Livewire\Guest;

use Livewire\Component;
use App\Models\Guest;

class Delete extends Component
{
    public $open = false;
    public $id_guest;

    protected $listeners = ['delete' => 'confirmDelete'];

    public function confirmDelete($id)
    {
        $this->id_guest = $id;
        $this->open = true;
    }

    public function delete()
    {
        Guest::findOrFail($this->id_guest)->delete();
        session()->flash('message', 'Guest berhasil dihapus.');
        $this->dispatch('refreshDatatable');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.guest.delete');
    }
}
