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


//Agrupamos las rutas de nuestra api para que puedan ser consumidas de forma privada
//Route::group(['middleware' => 'auth:api, cors'], function(){ ['cors', 'auth:api']
Route::group(['middleware' => ['cors','auth:api']], function(){
    /*Route::get('users/', 'UserController@index');*/
    Route::patch('users/{id}','UserController@updateProfile')->name('user.updateProfile');
    Route::delete('users/{id}','UserController@destroyAccount')->name('user.destroyAccount');
    Route::post('logout/', 'UserController@logout');
});

//Route::get('users/', 'UserController@index');
/*
Route::group(['middleware' => 'cors'], function(){
    Route::post('crearcuenta','UserController@store');
    Route::post('login','UserController@login');
    Route::get('users/', 'UserController@index');
});*/

//Route::post('crearcuenta','UserController@store');
//Agrupamos las rutas de nuestra api para que puedan ser consumidas de forma publica

Route::group(['middleware' => 'cors'], function(){
    //Route::get('users/', 'UserController@index');
    Route::post('crearcuenta','UserController@store');
    /*Route::get('clientes/', 'ClientesController@index');*/
    /*Route::post('users/', 'UserController@store');*/
    /*
    Route::delete('users/{id}','UserController@destroy')->name('user.destroy');*/
});