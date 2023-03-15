<?php

namespace App\Console\Commands;

use App\Synchronizer\Synchronizer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($this->arguments(), ['url' => 'url']);

        if ($validator->fails()) {
            $this->error($validator->errors()->first());
            return;
        }

        $url = $this->argument('url');

        if (!$this->option('queue')) {
            $this->sync($url);
            return;
        }



    }

    private function sync(string $url): void
    {
        $pageCount = 1;
        while (!Http::get("$url/?page=$pageCount")->notFound()) {
            $pageCount++;
        }

        $synchronizer = resolve(Synchronizer::class);

        $progressBar = $this->output->createProgressBar($pageCount - 1);

        $progressBar->start();
        for ($i = 1; $i < $pageCount; $i++) {
            $synchronizer->sync($url);
            $progressBar->advance();
        }

        $progressBar->finish();
    }


}
