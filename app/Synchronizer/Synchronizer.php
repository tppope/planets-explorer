<?php

namespace App\Synchronizer;

interface Synchronizer
{
    public function sync($url): void;

}
