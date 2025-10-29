<?php

namespace App\Services;

use App\Repositories\Interfaces\BuildingRepositoryInterface;
use App\Repositories\Interfaces\OrganizationRepositoryInterface;
use Illuminate\Support\Collection;

class LocationService
{
    public function __construct(
        protected OrganizationRepositoryInterface $organizationRepository,
        protected BuildingRepositoryInterface $buildingRepository
    ) {}

    public function getOrganizationsWithinRadius(float $lat, float $lng, float $radius): Collection
    {
        return $this->organizationRepository->getWithinRadius($lat, $lng, $radius);
    }

    public function getBuildingsWithinRadius(float $lat, float $lng, float $radius): Collection
    {
        return $this->buildingRepository->getWithinRadius($lat, $lng, $radius);
    }

}
