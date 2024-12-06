<?php

use App\Http\Controllers\API\Prod_CategoriasController;
use Illuminate\Support\Facades\Route;

Route::prefix('producto_categorias')->group(function () {
    Route::get('/find/{id}', [Prod_CategoriasController::class, 'show']);
    Route::get('/all', [Prod_CategoriasController::class, 'index']);
    Route::post('/create', [Prod_CategoriasController::class, 'store']);
    Route::put('/update/{id}', [Prod_CategoriasController::class, 'update']);
    Route::delete('/delete/{id}', [Prod_CategoriasController::class, 'destroy']);
});