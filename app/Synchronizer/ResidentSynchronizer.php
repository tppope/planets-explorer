<?php

namespace App\Synchronizer;

class ResidentSynchronizer implements Synchronizer
{

    public function sync($url): void
    {
        dd($url);
    }
}
