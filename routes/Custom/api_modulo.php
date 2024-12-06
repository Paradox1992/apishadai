<?php

use App\Http\Controllers\API\ModulosController;
use Illuminate\Support\Facades\Route;

Route::prefix('modulo')->group(function () {
    Route::get('/all', [ModulosController::class, 'index']);
    Route::get('/find/{id}', [ModulosController::class, 'show']);
    Route::post('/create', [ModulosController::class, 'store']);
    Route::put('/update/{id}', [ModulosController::class, 'update']);
    Route::delete('/delete/{id}', [ModulosController::class, 'destroy']);
});