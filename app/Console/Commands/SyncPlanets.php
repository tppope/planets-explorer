<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncPlanets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:planets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync the list of all known planets and their residents from https://swapi.py4e.com/';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        //
    }
}
