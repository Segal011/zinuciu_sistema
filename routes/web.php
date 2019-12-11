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
    return view('home');
});


Auth::routes();

Route::get('/', 'ChatController@index')->name('home');

Route::get('/history', 'HistoryController@index')->name('history');
Route::get('/words', 'WordController@index')->name('words');

Route::get('/block/{id}', 'WordController@block');

Route::post('/chats/store', 'ChatController@store');
Route::post('/chats/sent', 'ChatController@storeMessage')->name('chats.sent');;

Route::post('/words', 'WordController@store')->name('words.store');;

Route::resources([
    'messages' => 'MessageController',
    'chats' => 'ChatController'
]);