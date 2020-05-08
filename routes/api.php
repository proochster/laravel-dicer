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

Route::get('/rooms', 'RoomController@index');
Route::post('/user', 'UserController@store');

Route::get('/room/{room_hash}/messages', 'MessageController@show');
Route::post('/messages', 'MessageController@store');

Route::get('/room/{room_hash}/links', 'LinkController@show');
Route::post('/links', 'LinkController@store');
Route::delete('/room/{room_hash}/link/{id}', 'LinkController@destroy');

Route::get('/room/{room_hash}/videos', 'VideoController@show');
Route::post('/videos', 'VideoController@store');
Route::delete('/room/{room_hash}/video/{id}', 'VideoController@destroy');
Route::post('/room/{room_hash}/play/{vUrl}', 'VideoController@play');
// Route::post('/room/{room_hash}/pause/{vUrl}', 'VideoController@pause');
