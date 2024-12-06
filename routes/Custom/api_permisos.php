<?php

use App\Http\Controllers\API\Accesos\PermisosController;
use Illuminate\Support\Facades\Route;

Route::prefix('permisos')->group(function () {
    Route::get('/all', [PermisosController::class, 'index']);
    Route::get('/create', [PermisosController::class, 'store']);
    Route::put('/update/{id}', [PermisosController::class, 'update']);
    Route::delete('/delete/{id}', [PermisosController::class, 'destroy']);
    Route::get('/byuser/{id}', [PermisosController::class, 'search']);
});