<?php

use App\Http\Controllers\API\LotesController;
use Illuminate\Support\Facades\Route;

Route::prefix('lotes')->group(function () {
    Route::get('/all', [LotesController::class, 'index']);
    Route::get('/find/{id}', [LotesController::class, 'show']);
    Route::post('/create', [LotesController::class, 'store']);
    Route::put('/update/{id}', [LotesController::class, 'update']);
    Route::delete('/delete/{id}', [LotesController::class, 'destroy']);
});
