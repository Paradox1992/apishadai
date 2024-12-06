<?php

use App\Http\Controllers\API\user\Rolcontroller;
use Illuminate\Support\Facades\Route;

Route::prefix('userrol')->group(function () {
    Route::get('/all', [Rolcontroller::class, 'index']);
    Route::get('/find/{id}', [Rolcontroller::class, 'show']);
    Route::post('/create', [Rolcontroller::class, 'store']);
    Route::put('/update/{id}', [Rolcontroller::class, 'update']);
    Route::delete('/delete/{id}', [Rolcontroller::class, 'destroy']);
});