<?php

namespace App\Services;

use App\Models\Activity;
use App\Repositories\Interfaces\ActivityRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ActivityService
{
    private const MAX_NESTING_LEVEL = 2;

    public function __construct(
        protected ActivityRepositoryInterface $activityRepository
    ){}

    public function createActivity(string $name, ?int $parentId): Activity
    {
        if ($parentId !== null) {
            $parent = $this->activityRepository->findById($parentId);

            if (!$parent) {
                throw new ModelNotFoundException("Parent activity with ID {$parentId} not found.");
            }

            $newLevel = $parent->level + 1;

            if ($newLevel > self::MAX_NESTING_LEVEL) {
                throw new \InvalidArgumentException("Activity nesting level cannot exceed 3 levels.");
            }
        } else {
            $newLevel = 0;
        }

        return $this->activityRepository->create([
            'name' => $name,
            'parent_id' => $parentId,
            'level' => $newLevel,
        ]);
    }
}
