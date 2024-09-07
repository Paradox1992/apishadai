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

//--------------------------Login------------------------------------------------
Route::post('auth/login', [AuthController::class, 'login']);



Route::middleware('auth:api')->group(function () {

    //--------------------------Auth Module------------------------------------------------
    Route::post('auth/logout', [AuthController::class, 'logout']);

    //----------------------------User Module----------------------------------------------
    Route::get('user/all', [UserController::class, 'index']);
    Route::get('user/find/{id}', [UserController::class, 'show']);
    Route::post('user/create', [UserController::class, 'store']);
    Route::put('user/update/{id}', [UserController::class, 'update']);
    Route::delete('user/delete/{id}', [UserController::class, 'delete']);

    //--------------------------UserStatus Module------------------------------------------------
    Route::get('userstatus/all', [UserStatusController::class, 'index']);
    Route::get('userstatus/find/{id}', [UserStatusController::class, 'show']);
    Route::post('userstatus/create', [UserStatusController::class, 'store']);
    Route::put('userstatus/update/{id}', [UserStatusController::class, 'update']);
    Route::delete('userstatus/delete/{id}', [UserStatusController::class, 'destroy']);

    //--------------------------User Rol Modulo------------------------------------------------
    // all methods for user rol
    Route::get('userrol/all', [Rolcontroller::class, 'index']);
    Route::get('userrol/find/{id}', [Rolcontroller::class, 'show']);
    Route::post('userrol/create', [Rolcontroller::class, 'store']);
    Route::put('userrol/update/{id}', [Rolcontroller::class, 'update']);
    Route::delete('userrol/delete/{id}', [Rolcontroller::class, 'destroy']);

    //-------------------------- Formulario Modulo------------------------------------------------
    Route::get('formulario/all', [FormulariosController::class, 'index']);
    Route::get('formulario/find/{id}', [FormulariosController::class, 'show']);
    Route::post('formulario/create', [FormulariosController::class, 'store']);
    Route::put('formulario/update/{id}', [FormulariosController::class, 'update']);
    Route::delete('formulario/delete/{id}', [FormulariosController::class, 'destroy']);

    Route::get('formulario/bymodule/{id}', [FormulariosController::class, 'filterbyModule']);

    //--------------------------FormularioEstados Modulo------------------------------------------
    Route::get('formularioestado/all', [FormularioestadoController::class, 'index']);
    Route::get('formularioestado/find/{id}', [FormularioestadoController::class, 'show']);
    Route::post('formularioestado/create', [FormularioestadoController::class, 'store']);
    Route::put('formularioestado/update/{id}', [FormularioestadoController::class, 'update']);
    Route::delete('formularioestado/delete/{id}', [FormularioestadoController::class, 'destroy']);

    //--------------------------Modulos  Modulo------------------------------------------
    Route::get('modulo/all', [ModulosController::class, 'index']);
    Route::get('modulo/find/{id}', [ModulosController::class, 'show']);
    Route::post('modulo/create', [ModulosController::class, 'store']);
    Route::put('modulo/update/{id}', [ModulosController::class, 'update']);
    Route::delete('modulo/delete/{id}', [ModulosController::class, 'destroy']);

    //--------------------------ModulosEstado  Modulo------------------------------------------
    Route::get('moduloestado/all', [ModulosEstadoController::class, 'index']);
    Route::get('moduloestado/find/{id}', [ModulosEstadoController::class, 'show']);
    Route::post('moduloestado/create', [ModulosEstadoController::class, 'store']);
    Route::put('moduloestado/update/{id}', [ModulosEstadoController::class, 'update']);
    Route::delete('moduloestado/delete/{id}', [ModulosEstadoController::class, 'destroy']);

    //--------------------------Permisos  Modulo----------------------------------------------
    Route::get('permisos/all', [PermisosController::class, 'index']);
    Route::get('permisos/find/{id}', [PermisosController::class, 'show']);
    Route::post('permisos/create', [PermisosController::class, 'store']);
    Route::put('permisos/update/{id}', [PermisosController::class, 'update']);
    Route::delete('permisos/delete/{id}', [PermisosController::class, 'destroy']);
    Route::get('permisos/byuser/{id}', [PermisosController::class, 'search']);

    //--------------------------Stocks  Modulo------------------------------------------
    Route::get('stock/all', [StockController::class, 'index']);
    Route::get('stock/find/{id}', [StockController::class, 'show']);
    Route::post('stock/create', [StockController::class, 'store']);
    Route::put('stock/update/{id}', [StockController::class, 'update']);
    Route::delete('stock/delete/{id}', [StockController::class, 'destroy']);

    //--------------------------WorkSession  Modulo------------------------------------------
    Route::get('workSession/find/{id}', [WorkSessionController::class, 'show']);
    Route::post('workSession/work', [WorkSessionController::class, 'StartEnd']);
    Route::post('workSession/lunch', [WorkSessionController::class, 'lunchStartEnd']);
    Route::get('workSession/workSessionByDate', [WorkSessionController::class, 'getWorkSessionsByDate']);
});