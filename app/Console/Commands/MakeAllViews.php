<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeAllViews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:all-view';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate all CRUD view stubs for resources';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $fs = new Filesystem;

        $resources = [
            'admin', 'facility', 'guest', 'owner',
            'pembayaran', 'report', 'reservasi',
            'season', 'villa', 'villa-pricing',
        ];

        $views = ['index', 'create', 'show', 'edit'];

        foreach ($resources as $dir) {
            $path = resource_path("views/{$dir}");
            if (! $fs->exists($path)) {
                $fs->makeDirectory($path, 0755, true);
                $this->info("Directory created: {$path}");
            }
            foreach ($views as $view) {
                $file = "{$path}/{$view}.blade.php";
                if (! $fs->exists($file)) {
                    $fs->put($file, "@{{-- View: {$dir}.{$view} --}}\n");
                    $this->info("Created view: {$dir}/{$view}.blade.php");
                } else {
                    $this->warn("Skipped, exists: {$dir}/{$view}.blade.php");
                }
            }
        }

        $this->info('All CRUD views have been generated.');
        return 0;
    }
}
