<?php

Auth::routes();

// Admin routes
Route::group(['middleware' => 'admin', 'namespace' => 'Admin'], function () {
    Route::resource('/usuarios', 'UserController');
    Route::get('restore/{id}', 'UserController@restore');
});

//All users Routes
Route::group(['middleware' => ['auth']], function () {
    Route::get('/perfil', 'PerfilController@index'); 
    Route::put('/perfil/{id}', 'PerfilController@update'); 
    Route::get('/', function () {return view('/perfil');});    
    Route::get('/home', function () {return view('/perfil'); });
});

//Ventanilla Routes
Route::group(['middleware' => 'ventanilla'], function () {
        
    //Rutas para solicitar cartas catastrales
    Route::get('/solicitud', 'SolicitudController@index'); 
    Route::post('/solicitud', 'SolicitudController@store'); 
});

//Cartografía Routes
Route::group(['middleware' => 'cartografia'], function () {
  
    //Rutas para gestionar solicitudes de cartas
    Route::get('/solicitudes', 'SolicitudController@solicitudes');
    Route::post('/solicitud/{id}', 'SolicitudController@resolverSolicitud'); 
    
    //Rutas para gestionar cartas catastrales
    Route::get('/cartas', 'CartasController@index'); 
    Route::post('/cartas', 'CartasController@store'); 
    Route::put('/cartas/{id}', 'CartasController@update'); 
    Route::delete('/cartas/{id}', 'CartasController@destroy'); 
});



