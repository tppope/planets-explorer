<?php

namespace App\Console\Commands;

use App\Jobs\Synchronize;
use App\Synchronizer\Synchronizer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class SyncPlanets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:planets {url} {--Q|queue}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync the list of all known planets and their residents from given url';

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
        } else {
            $this->queueSync($url);
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
        for ($page = 1; $page < $pageCount; $page++) {
            $synchronizer->sync("$url/?page=$page");
            $progressBar->advance();
        }

        $progressBar->finish();
    }

    private function queueSync(string $url): void
    {
        $batch = Bus::batch([])->dispatch();

        $page = 1;
        $pageUrl = "$url/?page=$page";
        while (!Http::get($pageUrl)->notFound()) {
            $batch->add(new Synchronize($pageUrl));
            $pageUrl = "$url/?page=" . ++$page;
        }

        $progressBar = $this->output->createProgressBar(100);

        $progressBar->start();
        while ($batch->progress() < 100) {
            $progressBar->setProgress($batch->progress());
            $batch = $batch->fresh();
            sleep(1);
        }

        $progressBar->setProgress($batch->progress());

        $progressBar->finish();

    }
}
