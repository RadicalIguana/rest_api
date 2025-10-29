<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\StoreActivityRequest;
use App\Http\Resources\ActivityResource;
use App\Services\ActivityService;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;


class ActivityController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected ActivityService $activityService
    ) {}

    #[OA\Post(
        path: '/api/v1/activities',
        summary: 'Создать новую деятельность',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    required: ['name'],
                    properties: [
                        new OA\Property(property: 'name', type: 'string', example: 'Молочная продукция'),
                        new OA\Property(property: 'parent_id', type: 'integer', example: 1, nullable: true),
                    ]
                )
            )
        ),
        tags: ['Activities'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Деятельность успешно создана',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'string', example: 'success'),
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/Activity'
                        ),
                    ]
                )
            ),
            new OA\Response(response: 400, description: 'Invalid input or nesting level exceeded'),
            new OA\Response(response: 404, description: 'Parent activity not found'),
        ]
    )]
    public function store(StoreActivityRequest $request): JsonResponse
    {
        try {
            $activity = $this->activityService->createActivity(
                $request->getName(),
                $request->getParentId()
            );
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse($e->getMessage(), 404);
        } catch (\InvalidArgumentException $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }

        return $this->successResponse(new ActivityResource($activity),  201);
    }
}
