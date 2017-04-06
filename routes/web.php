<?php

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

Route::get('/bbb','BbbPlaybackController@index')->name("bbblist"); 
Route::get('/playback/{internalid}','BbbPlaybackController@playback');
Route::get('/video/{internal}', 'MediaFileController@file');
Route::get('/image/{internalid}/logo.png','MediaFileController@logo'); 
Route::get('/image/{internalid}/presentation/{imgid}/{filename}','MediaFileController@image'); 

Route::get('/home', function() {
   return redirect('/bbb');
});

Auth::routes();
