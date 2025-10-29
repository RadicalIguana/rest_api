<?php

namespace App\Repositories;

use App\Models\Building;
use App\Repositories\Interfaces\BuildingRepositoryInterface;
use Illuminate\Support\Collection;

class BuildingRepository implements BuildingRepositoryInterface
{

    public function getWithinRadius(float $lat, float $lng, float $radius): Collection
    {
        $earthRadiusKm = 6371;

        return Building::whereRaw("
        ? * acos(
            cos(radians(?)) *
            cos(radians(`buildings`.`latitude`)) *
            cos(radians(`buildings`.`longitude`) - radians(?)) +
            sin(radians(?)) *
            sin(radians(`buildings`.`latitude`))
        ) <= ?
    ", [
            $earthRadiusKm,
            $lat,
            $lng,
            $lat,
            $radius,
        ])->get();
    }
}
