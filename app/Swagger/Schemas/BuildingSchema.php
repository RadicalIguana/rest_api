<?php

namespace App\Swagger\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Building',
    title: 'Building',
    description: 'Сущность здания',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'address', type: 'string', example: 'г. Москва, ул. Ленина 1, офис 3'),
        new OA\Property(property: 'latitude', type: 'number', format: 'double', example: 55.7558),
        new OA\Property(property: 'longitude', type: 'number', format: 'double', example: 37.6173),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time'),
    ]
)]
class BuildingSchema {}
