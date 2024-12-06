<?php

use Illuminate\Support\Facades\Route;

Route::prefix('test')->group(function () {
    Route::get('/alive', [App\Http\Controllers\AliveController::class, 'test']);
});
