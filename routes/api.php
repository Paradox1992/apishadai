<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


// ========================= LOGIN =====================
Route::post('auth/login', [AuthController::class, 'login']);
// =====================================================


Route::middleware('auth:api')->group(function () {
    // =================== TEST ============================
    require __DIR__ . '/Custom/api_alive.php';
    // =====================================================

    // =================== AUTH MODULO =====================
    require __DIR__ . '/Custom/api_auth.php';
    // =====================================================

});
