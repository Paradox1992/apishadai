<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CfgController;
use Illuminate\Support\Facades\Route;

//Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:api')->group(function () {
    Route::get('/config', [CfgController::class, 'getconfig']);
});