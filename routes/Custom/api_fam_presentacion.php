<?php

use App\Http\Controllers\API\Fam_PresentacionController;
use Illuminate\Support\Facades\Route;

Route::prefix('fam_presentacion')->group(function () {
    Route::get('/find/{id}', [Fam_PresentacionController::class, 'show']);
    Route::get('/all', [Fam_PresentacionController::class, 'index']);
    Route::post('/create', [Fam_PresentacionController::class, 'store']);
    Route::put('/update/{id}', [Fam_PresentacionController::class, 'update']);
    Route::delete('/delete/{id}', [Fam_PresentacionController::class, 'destroy']);
});