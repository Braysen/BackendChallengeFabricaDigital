<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/* Modificado */
/*Route::apiResource("clientes", "ClientesController");*/
Route::group(['middleware' => ['cors']], function () {
    //Rutas a las que se permitirá acceso
    Route::apiResource("clientes", "ClientesController");
});

//Route::apiResource("clientes", "ClientesController");
