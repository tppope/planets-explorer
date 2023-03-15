<?php

namespace App\Jobs;

use App\Synchronizer\Synchronizer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Synchronize implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly string $url)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(Synchronizer $synchronizer): void
    {
        $synchronizer->sync($this->url);
    }
}
