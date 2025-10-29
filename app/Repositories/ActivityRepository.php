<?php

namespace App\Repositories;

use App\Models\Activity;
use App\Repositories\Interfaces\ActivityRepositoryInterface;

class ActivityRepository implements ActivityRepositoryInterface
{
    public function findById(int $id): ?Activity
    {
        return Activity::find($id);
    }

    public function create(array $data): Activity
    {
        return Activity::create($data);
    }
}
