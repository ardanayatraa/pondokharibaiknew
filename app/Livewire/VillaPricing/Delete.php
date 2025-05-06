<?php

namespace App\Livewire\VillaPricing;

use Livewire\Component;
use App\Models\VillaPricing;

class Delete extends Component
{
    public $open = false;
    public $id_villa_pricing;

    protected $listeners = ['delete' => 'confirmDelete'];

    public function confirmDelete($id)
    {
        $this->id_villa_pricing = $id;
        $this->open = true;
    }

    public function delete()
    {
        VillaPricing::findOrFail($this->id_villa_pricing)->delete();
        session()->flash('message', 'Data harga villa berhasil dihapus.');
        $this->dispatch('refreshDatatable');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.villa-pricing.delete');
    }
}
