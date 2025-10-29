<?php

use App\Http\Controllers\Api\V1\ActivityController;
use App\Http\Controllers\Api\V1\LocationController;
use App\Http\Controllers\Api\V1\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->middleware('check.api.key')
    ->group(function () {
        Route::prefix('organizations')->group(function () {
            Route::get('/search', [OrganizationController::class, 'searchByName']);
            Route::get('/{organization}', [OrganizationController::class, 'show']);
            Route::get('/building/{building}', [OrganizationController::class, 'getByBuildingId']);
            Route::get('/activity/{activity}', [OrganizationController::class, 'getByActivityId']);
            Route::get('/activity-tree/{activity}', [OrganizationController::class, 'getByActivityTree']);
        });

        Route::prefix('activities')->group(function () {
            Route::post('/', [ActivityController::class, 'store']);
        });

        Route::get('/locations/nearby', [LocationController::class, 'getNearby']);
    });
