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

        // dahsboard
        Route::get('/dashboard', 'Admin\DashboardController@index')->name('admin.dashboard.index');

        // permission
        Route::resource('/permission', 'Admin\PermissionController', ['except' => ['show', 'create', 'edit', 'update', 'delete'], 'as' => 'admin']);

        // role
        Route::resource('/role', 'Admin\RoleController', ['except' => ['show'], 'as' => 'admin']);

        // user
        Route::resource('/user', 'Admin\UserController', ['except' => ['show'], 'as' => 'admin']);

        // tag
        Route::resource('/tag', 'Admin\TagController', ['except' => ['show'], 'as' => 'admin']);

        // category
        Route::resource('/category', 'Admin\CategoryController', ['except' => ['show'], 'as' => 'admin']);

        // post
        Route::resource('/post', 'Admin\PostController', ['except' => ['show'], 'as' => 'admin']);

        // event
        Route::resource('/event', 'Admin\EventController', ['except' => ['show'], 'as' => 'admin']);

        // photo
        Route::resource('/photo', 'Admin\PhotoController', ['except' => ['create','show','update', 'edit'], 'as' => 'admin']);
    });
});