<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// post
Route::get('/post', 'Api\PostController@index');
Route::put('/post/{id?}', 'Api\PostController@show');
Route::get('/homepage/post', 'Api\PostController@PostHomePage');

// event
Route::get('/event', 'Api\EventController@index');
Route::put('/event/{id?}', 'Api\EventController@show');
Route::get('/homepage/event', 'Api\EventController@EventHomePage');