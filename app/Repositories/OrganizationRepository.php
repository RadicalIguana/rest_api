<?php

namespace App\Repositories;

use App\Models\Activity;
use App\Models\Organization;
use App\Repositories\Interfaces\OrganizationRepositoryInterface;
use Illuminate\Support\Collection;

class OrganizationRepository implements OrganizationRepositoryInterface
{
    public function findById(int $organizationId): Organization
    {
        return Organization::with(['building', 'phones', 'activities'])->find($organizationId);
    }

    public function getByBuildingId(int $buildingId): Collection
    {
        return Organization::where('building_id', $buildingId)
            ->with(['building', 'phones', 'activities'])
            ->get();
    }

    public function getByActivityId(int $activityId): Collection
    {
        return Organization::whereHas('activities', function ($query) use ($activityId) {
            $query->where('activity_id', $activityId);
        })
            ->with(['building', 'phones', 'activities'])
            ->get();
    }

    public function getWithinRadius(float $lat, float $lng, float $radius): Collection
    {
        $earthRadiusKm = 6371;

        return Organization::join('buildings', 'organizations.building_id', '=', 'buildings.id')
            ->select('organizations.*')
            ->whereRaw("
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
            ])
            ->with(['building', 'phones', 'activities'])
            ->get();
    }

    public function getByActivityIds(array $activityIds): Collection
    {
        return Organization::whereHas('activities', function ($query) use ($activityIds) {
            $query->whereIn('activity_id', $activityIds);
        })
            ->with(['building', 'phones', 'activities'])
            ->get();
    }

    public function searchByName(string $name): Collection
    {
        return Organization::where('name', 'like', "%{$name}%")
            ->with(['building', 'phones', 'activities'])
            ->get();
    }

    public function findActivityWithChildrenRecursive(int $id): ?Activity
    {
        return Activity::with('childrenRecursive')->find($id);
    }
}
