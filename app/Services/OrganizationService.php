<?php

namespace App\Services;

use App\Models\Activity;
use App\Repositories\Interfaces\OrganizationRepositoryInterface;
use Illuminate\Support\Collection;

class OrganizationService
{
    public function __construct(
        protected OrganizationRepositoryInterface $organizationRepository
    ) {}
    public function getOrganizationsByBuildingId(int $buildingId): Collection
    {
        return $this->organizationRepository->getByBuildingId($buildingId);
    }

    public function getOrganizationsByActivityId(int $activityId): Collection
    {
        return $this->organizationRepository->getByActivityId($activityId);
    }

    public function getOrganizationsByActivityTree(int $activityId): Collection
    {
        $activity = $this->organizationRepository->findActivityWithChildrenRecursive($activityId);

        if (!$activity) {
            return collect();
        }

        $activityIds = $this->getAllActivityIdsRecursive($activity);

        return $this->organizationRepository->getByActivityIds($activityIds);
    }

    public function getAllActivityIdsRecursive(Activity $activity): array
    {
        $ids = [$activity->id];

        foreach ($activity->children as $child) {
            $ids = array_merge($ids, $this->getAllActivityIdsRecursive($child));
        }

        return $ids;
    }

    public function searchOrganizationsByName(string $name): Collection
    {
        return $this->organizationRepository->searchByName($name);
    }
}
