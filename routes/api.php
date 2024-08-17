<?php

use App\Http\Controllers\API\Accesos\FormularioestadoController;
use App\Http\Controllers\API\Accesos\FormulariosController;
use App\Http\Controllers\API\Accesos\ModulosController;
use App\Http\Controllers\API\Accesos\ModulosEstadoController;
use App\Http\Controllers\API\Accesos\PermisosController;
use App\Http\Controllers\API\Stock\StockController;
use App\Http\Controllers\API\user\Rolcontroller;
use App\Http\Controllers\API\user\UserStatusController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\WorkSessionController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {

    /*
|--------------------------------------------------------------------------
| auth Module
|--------------------------------------------------------------------------
|
*/
    Route::post('auth/logout', [AuthController::class, 'logout']);
    /*
|--------------------------------------------------------------------------
| user Module
|--------------------------------------------------------------------------
|
*/
    Route::apiResource('user/usr_resource', UserController::class);
    Route::apiResource('user/status', UserStatusController::class);
    Route::apiResource('user/rol', Rolcontroller::class);
    /*
|--------------------------------------------------------------------------
| Modulo Formulario
|--------------------------------------------------------------------------
|
*/
    Route::apiResource('formulario/frm_resource', FormulariosController::class);
    Route::get('formulario/bymodule/{id}', [FormulariosController::class, 'filterbyModule']);
    Route::apiResource('formulario/estado', FormularioestadoController::class);
    /*
|--------------------------------------------------------------------------
| Modulo Modulo
|--------------------------------------------------------------------------
|
*/
    Route::apiResource('modulo/mdl_resource', ModulosController::class);
    Route::apiResource('modulo/estado', ModulosEstadoController::class);
    /*
|--------------------------------------------------------------------------
| Modulo Permisos
|--------------------------------------------------------------------------
|
*/
    Route::apiResource('permisos/prms_resource', PermisosController::class);
    Route::get('permisos/byuser/{id}', [PermisosController::class, 'search']);

    /*
|--------------------------------------------------------------------------
| Modulo Stock
|--------------------------------------------------------------------------
|
*/
    Route::apiResource('stock/stk_resource', StockController::class);

    /*
|--------------------------------------------------------------------------
| Work Session Module
|--------------------------------------------------------------------------
|
*/
    Route::apiResource('workSession/ws_resource', WorkSessionController::class);
    Route::post('workSession/work', [WorkSessionController::class, 'StartEnd']);
    Route::post('workSession/lunch', [WorkSessionController::class, 'lunchStartEnd']);
    Route::get('workSession/workSessionByDate/', [WorkSessionController::class, 'getWorkSessionsByDate']);
});
