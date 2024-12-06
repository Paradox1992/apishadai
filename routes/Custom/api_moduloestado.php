<?php

use App\Http\Controllers\API\ModuloEstadosController;
use Illuminate\Support\Facades\Route;

Route::prefix('moduloestado')->group(function () {
    Route::get('/all', [ModuloEstadosController::class, 'index']);
    Route::get('/find/{id}', [ModuloEstadosController::class, 'show']);
    Route::post('/create', [ModuloEstadosController::class, 'store']);
    Route::put('/update/{id}', [ModuloEstadosController::class, 'update']);
    Route::delete('/delete/{id}', [ModuloEstadosController::class, 'destroy']);
});