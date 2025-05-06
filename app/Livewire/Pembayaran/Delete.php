<?php

namespace App\Livewire\Pembayaran;

use Livewire\Component;
use App\Models\Pembayaran;

class Delete extends Component
{
    public $open = false;
    public $id_pembayaran;

    protected $listeners = ['delete' => 'confirmDelete'];

    public function confirmDelete($id)
    {
        $this->id_pembayaran = $id;
        $this->open = true;
    }

    public function delete()
    {
        Pembayaran::findOrFail($this->id_pembayaran)->delete();

        session()->flash('message', 'Pembayaran berhasil dihapus.');
        $this->dispatch('refreshDatatable');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.pembayaran.delete');
    }
}
