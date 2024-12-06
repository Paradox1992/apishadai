<?php

use Illuminate\Support\Facades\Route;

Route::prefix('distribucion')->group(function () {
    Route::get('/all', 'App\Http\Controllers\API\DistribucionController@index');
    Route::get('/find/{id}', 'App\Http\Controllers\API\DistribucionController@show');
    Route::post('/create', 'App\Http\Controllers\API\DistribucionController@store');
    Route::put('/update/{id}', 'App\Http\Controllers\API\DistribucionController@update');
    Route::delete('/delete/{id}', 'App\Http\Controllers\API\DistribucionController@destroy');
    Route::get('/findbyLote/{lote}', 'App\Http\Controllers\API\DistribucionController@findbyLote');
    Route::get('/findbyProveedor/{proveedor}', 'App\Http\Controllers\API\DistribucionController@findbyProveedor');
});