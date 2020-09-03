<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});
Route::get('/welcome', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'auth'], function () {
        
        //dahsboard
        Route::get('/dashboard', 'Admin\DashboardController@index')->name('admin.dashboard.index');
    });
});