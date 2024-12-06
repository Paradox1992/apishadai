<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


// ========================= LOGIN =====================
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);
// =====================================================

Route::middleware('auth:api')->group(function () {
    // =================== TEST ============================
    require __DIR__ . '/Custom/api_alive.php';
    // =====================================================

    // =================== AUTH MODULO =====================
    require __DIR__ . '/Custom/api_auth.php';
    // =====================================================

    // =================== WORK SESSION =====================
    require __DIR__ . '/Custom/api_worksession.php';
    // =====================================================

});
