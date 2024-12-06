<?php

use App\Http\Controllers\API\ProductosController;
use Illuminate\Support\Facades\Route;

Route::prefix('productos')->group(function () {
    Route::get('/find/{id}', [ProductosController::class, 'show']);
    Route::get('/all', [ProductosController::class, 'index']);
    Route::post('/create', [ProductosController::class, 'store']);
    Route::put('/update/{id}', [ProductosController::class, 'update']);
    Route::delete('/delete/{id}', [ProductosController::class, 'destroy']);
});