<?php

namespace App\Livewire\Season;

use Livewire\Component;
use App\Models\Season;

class Create extends Component
{
    public $open = false;
    public $nama_season, $tgl_mulai_season, $tgl_akhir_season;

    protected $rules = [
        'nama_season' => 'required|string|max:255',
        'tgl_mulai_season' => 'required|date',
        'tgl_akhir_season' => 'required|date|after_or_equal:tgl_mulai_season',
    ];

    public function store()
    {
        $this->validate();

        Season::create([
            'nama_season' => $this->nama_season,
            'tgl_mulai_season' => $this->tgl_mulai_season,
            'tgl_akhir_season' => $this->tgl_akhir_season,
        ]);

        session()->flash('message', 'Season berhasil ditambahkan.');
        $this->reset();
        $this->dispatch('refreshDatatable');
        $this->open = false;
    }

    public function render()
    {
        return view('livewire.season.create');
    }
}
