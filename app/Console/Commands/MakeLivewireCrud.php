<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeLivewireCrud extends Command
{
    protected $signature = 'make:livewire-crud {--all} {name?}';
    protected $description = 'Buat 3 komponen Livewire: Add, Update, dan Delete';

    protected $models = [
        'Admin',
        'KepalaSekolah',
        'Kelas',
        'AkunSiswa',
        'Guru',
        'Penilaian',
        'NilaiSiswa',
        'Notifikasi',
    ];

    public function handle()
    {
        if ($this->option('all')) {
            foreach ($this->models as $model) {
                $this->generateComponents($model);
            }
            $this->info('🔥 Semua komponen Livewire CRUD berhasil dibuat!');
        } elseif ($this->argument('name')) {
            $this->generateComponents($this->argument('name'));
            $this->info('✅ Komponen Livewire CRUD berhasil dibuat!');
        } else {
            $this->error('⚠️  Masukkan nama model atau gunakan opsi --all');
        }
    }

    protected function generateComponents($name)
    {
        $nameStudly = Str::studly($name);
        $components = ['Add', 'Update', 'Delete'];

        foreach ($components as $component) {
            $componentName = "{$nameStudly}.{$component}";
            $this->call('make:livewire', ['name' => $componentName]);
        }
    }
}
