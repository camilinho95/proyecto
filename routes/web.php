<?php

Auth::routes();

// Admin routes
Route::group(['middleware' => 'admin', 'namespace' => 'Admin'], function () {
    Route::resource('/usuarios', 'UserController');
    Route::get('restore/{id}', 'UserController@restore');
});

// // Verify Email reset route
// Route::get('password/email' , 'Auth\PasswordController@getEmail');

//All users Routes
Route::group(['middleware' => ['auth']], function () {
    Route::get('/perfil', 'PerfilController@index'); 
    Route::put('/perfil/{id}', 'PerfilController@update'); 
    Route::get('/', function () {return view('/perfil');});    
    Route::get('/home', function () {return view('/perfil'); });
    Route::get('/sig', function () {return view('/sig'); });

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
    Route::put('/solicitud/{id}', 'SolicitudController@resolverSolicitud'); 
    Route::get('solicitud/files/{id}', 'SolicitudController@getFiles');
    
    //Rutas para gestionar cartas catastrales
    Route::get('/cartas', 'CartasController@index'); 
    Route::post('/cartas', 'CartasController@store'); 
    Route::put('/carta/{id}', 'CartasController@update'); 
    Route::delete('/carta/{id}', 'CartasController@destroy'); 
    Route::get('carta/restore/{id}', 'CartasController@restore');
    Route::get('carta/download/{id}', 'CartasController@download');

});



