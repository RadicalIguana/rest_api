<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface BuildingRepositoryInterface
{
    public function getWithinRadius(float $lat, float $lng, float $radius): Collection;
}
