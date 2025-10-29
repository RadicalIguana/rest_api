<?php

namespace App\Repositories\Interfaces;

use App\Models\Activity;

interface ActivityRepositoryInterface
{
    public function findById(int $id): ?Activity;
    public function create(array $data): Activity;
}
