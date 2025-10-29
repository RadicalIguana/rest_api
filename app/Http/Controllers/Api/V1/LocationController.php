<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\GetOrganizationsByLocationRequest;
use App\Http\Resources\BuildingResource;
use App\Http\Resources\OrganizationResource;
use App\Services\LocationService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class LocationController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected LocationService $locationService
    ) {}

    #[OA\Get(
        path: '/api/v1/locations/nearby',
        summary: 'Получить организации и здания в пределах заданного радиуса от точки',
        tags: ['Location'],
        parameters: [
            new OA\Parameter(
                name: 'lat',
                description: 'Широка центральной точки',
                in: 'query',
                required: true,
                schema: new OA\Schema(type: 'number', format: 'double')
            ),
            new OA\Parameter(
                name: 'lng',
                description: 'Долгота центральной точки',
                in: 'query',
                required: true,
                schema: new OA\Schema(type: 'number', format: 'double')
            ),
            new OA\Parameter(
                name: 'radius',
                description: 'Радиус в километрах',
                in: 'query',
                required: true,
                schema: new OA\Schema(type: 'number', format: 'double')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Список организаций и зданий в пределах радиуса',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(
                            property: 'data',
                            properties: [
                                new OA\Property(
                                    property: 'organizations',
                                    type: 'array',
                                    items: new OA\Items(ref: '#/components/schemas/Organization')
                                ),
                                new OA\Property(
                                    property: 'buildings',
                                    type: 'array',
                                    items: new OA\Items(ref: '#/components/schemas/Building')
                                ),
                            ]
                        ),
                    ]
                )
            ),
            new OA\Response(response: 400, description: 'Radius is required or invalid coordinates'),
        ]
    )]
    public function getNearby(GetOrganizationsByLocationRequest $request): JsonResponse
    {
        $lat = $request->getLat();
        $lng = $request->getLng();
        $radius = $request->getRadius();

        if ($radius === null) {
            return $this->errorResponse('Radius is required', 400);
        }

        $organizations = $this->locationService->getOrganizationsWithinRadius($lat, $lng, $radius);
        $buildings = $this->locationService->getBuildingsWithinRadius($lat, $lng, $radius);

        return $this->successResponse([
            'organizations' => OrganizationResource::collection($organizations),
            'buildings' => BuildingResource::collection($buildings),
        ]);
    }
}
