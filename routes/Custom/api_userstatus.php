<?php

use App\Http\Controllers\API\UserStatusController;
use Illuminate\Support\Facades\Route;

Route::prefix('userstatus')->group(function () {
    Route::get('/all', [UserStatusController::class, 'index']);
    Route::get('/find/{id}', [UserStatusController::class, 'show']);
    Route::post('/create', [UserStatusController::class, 'store']);
    Route::put('/update/{id}', [UserStatusController::class, 'update']);
    Route::delete('/delete/{id}', [UserStatusController::class, 'destroy']);
});