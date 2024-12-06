<?php

use App\Http\Controllers\API\Prod_UnidadesController;
use Illuminate\Support\Facades\Route;

Route::prefix('producto_unidades')->group(function () {
    Route::get('/find/{id}', [Prod_UnidadesController::class, 'show']);
    Route::get('/all', [Prod_UnidadesController::class, 'index']);
    Route::post('/create', [Prod_UnidadesController::class, 'store']);
    Route::put('/update/{id}', [Prod_UnidadesController::class, 'update']);
    Route::delete('/delete/{id}', [Prod_UnidadesController::class, 'destroy']);
});