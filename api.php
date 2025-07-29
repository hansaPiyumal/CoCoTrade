<?php
// routes/api.php

use Illuminate\Http\Request;
use App\Http\Controllers\VehicleController;

Route::middleware('api')->group(function () {
    // Vehicle tracking endpoints
    Route::prefix('vehicles')->group(function () {
        Route::get('/', [VehicleController::class, 'getAllVehicles']);
        Route::get('/positions', [VehicleController::class, 'getAllVehiclePositions']);
        Route::get('/{vehicleId}/history', [VehicleController::class, 'getVehiclePositionHistory']);
        Route::post('/position', [VehicleController::class, 'updateVehiclePosition']);
    });
});