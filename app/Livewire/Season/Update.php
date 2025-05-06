<?php

namespace App\Livewire\Season;

use Livewire\Component;
use App\Models\Season;

class Update extends Component
{
    public $open = false;
    public $id_season, $nama_season, $tgl_mulai_season, $tgl_akhir_season;

    protected $listeners = ['edit' => 'loadData'];

    protected $rules = [
        'nama_season' => 'required|string|max:255',
        'tgl_mulai_season' => 'required|date',
        'tgl_akhir_season' => 'required|date|after_or_equal:tgl_mulai_season',
    ];

    public function loadData($id)
    {
        $season = Season::findOrFail($id);
        $this->id_season = $season->id_season;
        $this->nama_season = $season->nama_season;
        $this->tgl_mulai_season = $season->tgl_mulai_season;
        $this->tgl_akhir_season = $season->tgl_akhir_season;
        $this->open = true;
    }

    public function update()
    {
        $this->validate();

        Season::where('id_season', $this->id_season)->update([
            'nama_season' => $this->nama_season,
            'tgl_mulai_season' => $this->tgl_mulai_season,
            'tgl_akhir_season' => $this->tgl_akhir_season,
        ]);

        session()->flash('message', 'Season berhasil diperbarui.');
        $this->reset();
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.season.update');
    }
}
