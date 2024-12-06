<?php

use App\Http\Controllers\API\Accesos\FormularioestadoController;
use Illuminate\Support\Facades\Route;

Route::prefix('formularioestado')->group(function () {
    Route::get('/all', [FormularioestadoController::class, 'index']);
    Route::get('/find/{id}', [FormularioestadoController::class, 'show']);
    Route::post('/create', [FormularioestadoController::class, 'store']);
    Route::put('/update/{id}', [FormularioestadoController::class, 'update']);
    Route::delete('/delete/{id}', [FormularioestadoController::class, 'destroy']);
});