<?php

namespace App\Swagger\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Organization',
    title: 'Organization',
    description: 'Сущность организации',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'ООО "Рога и Копыта"'),
        new OA\Property(
            property: 'building',
            ref: '#/components/schemas/Building'
        ),
        new OA\Property(
            property: 'phones',
            type: 'array',
            items: new OA\Items(type: 'string', example: '8-923-666-13-13')
        ),
        new OA\Property(
            property: 'activities',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/Activity')
        ),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time'),
    ]
)]
class OrganizationSchema {}
