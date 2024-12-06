<?php

use App\Http\Controllers\API\FamiliaController;
use Illuminate\Support\Facades\Route;

Route::prefix('familia')->group(function () {
    Route::get('/all', [FamiliaController::class, 'index']);
    Route::post('/create', [FamiliaController::class, 'store']);
    Route::get('/find/{id}', [FamiliaController::class, 'show']);
    Route::put('/update/{id}', [FamiliaController::class, 'update']);
    Route::delete('/delete/{id}', [FamiliaController::class, 'destroy']);
});