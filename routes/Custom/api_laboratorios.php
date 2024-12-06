<?php

use App\Http\Controllers\API\LaboratoriosController;
use Illuminate\Support\Facades\Route;

Route::prefix('laboratorios')->group(function () {
    Route::get('/find/{id}', [LaboratoriosController::class, 'show']);
    Route::get('/all', [LaboratoriosController::class, 'index']);
    Route::post('/create', [LaboratoriosController::class, 'store']);
    Route::put('laboratorios/update/{id}', [LaboratoriosController::class, 'update']);
    Route::delete('/delete/{id}', [LaboratoriosController::class, 'destroy']);
});