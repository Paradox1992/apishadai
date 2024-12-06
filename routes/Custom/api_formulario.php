<?php

use App\Http\Controllers\API\Accesos\FormulariosController;
use Illuminate\Support\Facades\Route;

Route::prefix('formulario')->group(function () {
    Route::get('/all', [FormulariosController::class, 'index']);
    Route::get('/find/{id}', [FormulariosController::class, 'show']);
    Route::post('/create', [FormulariosController::class, 'store']);
    Route::put('/update/{id}', [FormulariosController::class, 'update']);
    Route::delete('/delete/{id}', [FormulariosController::class, 'destroy']);
    Route::get('/bymodule/{id}', [FormulariosController::class, 'filterbyModule']);
});