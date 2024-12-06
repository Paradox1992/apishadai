<?php

use App\Http\Controllers\API\Stock\StockController;
use Illuminate\Support\Facades\Route;

Route::prefix('stock')->group(function () {
    Route::get('/all', [StockController::class, 'index']);
    Route::get('/find/{id}', [StockController::class, 'show']);
    Route::post('/create', [StockController::class, 'store']);
    Route::put('/update/{id}', [StockController::class, 'update']);
    Route::delete('/delete/{id}', [StockController::class, 'destroy']);
});