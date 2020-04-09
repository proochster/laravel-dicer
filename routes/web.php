<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/room/{room_hash}', 'RoomController@show');
Route::get('/room', function(){
    return redirect('/');
});
Route::post('/room', 'RoomController@store')->name('create-room');

// Route::get('/clear-cache', function() {
//     $clearcache = Artisan::call('cache:clear');
//     echo "Cache cleared. \r\n";
//     $setCache = Artisan::call('config:cache');
//     echo "Cache configured. \r\n";
// });