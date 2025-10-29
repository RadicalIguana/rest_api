<?php

namespace App\Repositories\Interfaces;


use App\Models\Activity;
use Illuminate\Support\Collection;

interface OrganizationRepositoryInterface
{
    public function getByBuildingId(int $buildingId): Collection;
    public function getByActivityId(int $activityId): Collection;
    public function getWithinRadius(float $lat, float $lng, float $radius): Collection;
    public function getByActivityIds(array $activityIds): Collection;
    public function searchByName(string $name): Collection;
    public function findActivityWithChildrenRecursive(int $id): ?Activity;
}
