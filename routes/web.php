<?php

Route::get('/', function () {
    return view('welcome');
});

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
});

Route::get('/sig', 'SigController@index'); 


Route::get('/home', 'HomeController@index')->name('home');


