<?php

namespace App\Livewire\Reservasi;

use Livewire\Component;
use App\Models\Reservasi;

class Delete extends Component
{
    public $open = false;
    public $id_reservation;

    protected $listeners = ['delete' => 'confirmDelete'];

    public function confirmDelete($id)
    {
        $this->id_reservation = $id;
        $this->open = true;
    }

    public function delete()
    {
        Reservasi::findOrFail($this->id_reservation)->delete();

        session()->flash('message', 'Reservasi berhasil dihapus.');
        $this->dispatch('refreshDatatable');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.reservasi.delete');
    }
}
