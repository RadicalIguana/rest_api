<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\SearchOrganizationsByNameRequest;
use App\Http\Resources\OrganizationResource;
use App\Models\Activity;
use App\Models\Building;
use App\Models\Organization;
use App\Services\OrganizationService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class OrganizationController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected OrganizationService $organizationService
    ) {}

    #[OA\Get(
        path: '/api/v1/organizations/{id}',
        summary: 'Получить организацию по ID',
        tags: ['Organizations'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID организации',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Организация успешно получена',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/Organization'
                        ),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Organization not found'),
        ]
    )]
    public function show(Organization $organization): JsonResponse
    {
        return $this->successResponse(new OrganizationResource($organization));
    }

    #[OA\Get(
        path: '/api/v1/organizations/building/{id}/',
        summary: 'Получить организации по ID здания',
        tags: ['Organizations'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID здания',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Список организаций в здании',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/Organization')
                        ),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Building not found'),
        ]
    )]
    public function getByBuildingId(Building $building): JsonResponse
    {
        $data = $this->organizationService->getOrganizationsByBuildingId($building->id);

        return $this->successResponse(OrganizationResource::collection($data));
    }

    #[OA\Get(
        path: '/api/v1/organizations/activity/{id}',
        summary: 'Получить организации по ID вида деятельности',
        tags: ['Organizations'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID деятельности',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Список организаций с указанным видом деятельности',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/Organization')
                        ),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Activity not found'),
        ]
    )]
    public function getByActivityId(Activity $activity): JsonResponse
    {
        $data = $this->organizationService->getOrganizationsByActivityId($activity->id);

        return $this->successResponse(OrganizationResource::collection($data));
    }

    #[OA\Get(
        path: '/api/v1/organizations/activity-tree/{id}',
        description: 'Получить организации по ID вида деятельности и его подкатегориям',
        summary: 'Находит организации, связанные с указанным видом деятельности и всеми его вложенными подкатегориями',
        tags: ['Organizations'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID вида деятельности',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Список организаций, связанных с видом деятельности и его подкатегориями',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/Organization')
                        ),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Activity not found'),
        ]
    )]
    public function getByActivityTree(Activity $activity): JsonResponse
    {
        $data = $this->organizationService->getOrganizationsByActivityTree($activity->id);

        return $this->successResponse(OrganizationResource::collection($data));
    }

    #[OA\Get(
        path: '/api/v1/organizations/search',
        summary: 'Поиск организаций по названию',
        tags: ['Organizations'],
        parameters: [
            new OA\Parameter(
                name: 'name',
                description: 'Название для поиска',
                in: 'query',
                required: true,
                schema: new OA\Schema(type: 'string')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Список организаций, соответствующих поисковому запросу',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/Organization')
                        ),
                    ]
                )
            ),
            new OA\Response(response: 400, description: 'Name parameter is required'),
        ]
    )]
    public function searchByName(SearchOrganizationsByNameRequest $request): JsonResponse
    {
        $name = $request->getName();
        $data = $this->organizationService->searchOrganizationsByName($name);

        return $this->successResponse(OrganizationResource::collection($data));
    }
}
