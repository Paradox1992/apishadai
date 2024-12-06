<?php

use App\Http\Controllers\API\ProveedoresController;
use Illuminate\Support\Facades\Route;

Route::prefix('proveedores')->group(function () {
    Route::get('/all', [ProveedoresController::class, 'index']);
    Route::post('/create', [ProveedoresController::class, 'store']);
    Route::get('/find/{id}', [ProveedoresController::class, 'show']);
    Route::put('/update/{id}', [ProveedoresController::class, 'update']);
    Route::delete('/delete/{id}', [ProveedoresController::class, 'destroy']);
});