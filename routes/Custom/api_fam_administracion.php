<?php

use App\Http\Controllers\API\Fam_AdministracionController;
use Illuminate\Support\Facades\Route;

Route::prefix('fam_administracion')->group(function () {
    Route::get('/find/{id}', [Fam_AdministracionController::class, 'show']);
    Route::get('/all', [Fam_AdministracionController::class, 'index']);
    Route::post('/create', [Fam_AdministracionController::class, 'store']);
    Route::put('/update/{id}', [Fam_AdministracionController::class, 'update']);
    Route::delete('/delete/{id}', [Fam_AdministracionController::class, 'destroy']);
});