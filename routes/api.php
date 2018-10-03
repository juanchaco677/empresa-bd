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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/usuario/sesion', 'UsuarioEController@sesion');
Route::post('/usuario/crear', 'UsuarioEController@store');
Route::get('/usuario', function (Request $request) {
    return ["nombre"=>"camilo"];
});

Route::post('usuario/storeAndroidVisitante', 'UsuarioEController@storeAndroidVisitante');
Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('usuario/getUsuario', 'UsuarioEController@getUsuario');
    Route::post('usuario/storeJX', 'UsuarioEController@storeJX');
    Route::post('usuario/storeAndroid', 'UsuarioEController@storeAndroid');
    Route::post('usuario/storeAndroidEvento', 'UsuarioEController@storeAndroidEvento');
    Route::post('usuario/storePublicacion', 'PublicacionController@storePublicacion');
    Route::post('usuario/storeEvento', 'EventoController@storeEvento');
    Route::get('usuario/masivo', 'UsuarioEController@listaMasivo');
    Route::post('usuario/updateJX', 'UsuarioEController@updateJX');
    Route::get('usuario/getReferidos', 'UsuarioEController@getReferidos');
    Route::get('usuario/getEventos', 'EventoController@getEventos');
    Route::post('usuario/deleteEvento', 'EventoController@deleteEvento');
    Route::get('usuario/getPublicaciones', 'PublicacionController@getPublicaciones');
    Route::post('usuario/updateAndroid', 'UsuarioEController@updateAndroid');
    Route::post('usuario/storeDeleteImagen', 'ImagenController@storeDeleteImagen');    
    Route::get('usuario/getImagenesFoto', 'ImagenController@getImagenesFoto'); 
    Route::get('usuario/getUsuarioSms', 'UsuarioEController@getUsuarioSms'); 
    Route::post('usuario/envioSms', 'UsuarioEController@envioSms'); 
});
