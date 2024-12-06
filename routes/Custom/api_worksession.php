<?php

use App\Http\Controllers\API\WorkSessionController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/workSession')->group(function () {
    Route::get('/find/{id}', [WorkSessionController::class, 'show']);
    Route::post('/work', [WorkSessionController::class, 'StartEnd']);
    Route::post('/lunch', [WorkSessionController::class, 'lunchStartEnd']);
    Route::get('/workSessionByDate', [WorkSessionController::class, 'getWorkSessionsByDate']);
});