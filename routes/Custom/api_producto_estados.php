<?php

use App\Http\Controllers\API\Prod_EstadoController;
use Illuminate\Support\Facades\Route;

Route::prefix('producto_estados')->group(function () {
    Route::get('/find/{id}', [Prod_EstadoController::class, 'show']);
    Route::get('/all', [Prod_EstadoController::class, 'index']);
    Route::post('/create', [Prod_EstadoController::class, 'store']);
    Route::put('/update/{id}', [Prod_EstadoController::class, 'update']);
    Route::delete('/delete/{id}', [Prod_EstadoController::class, 'destroy']);
});