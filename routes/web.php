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

Route::get('/', 'AppController@home');
Auth::routes();
Route::resource('video', 'VideoController');
Route::get('my-videos', 'UserController@my_videos')->name('user.videos');
Route::get('subscriptions', 'UserController@subscribed_videos')->name('user.subscribed.videos');

Route::post('subscribe', 'SubscriptionController@subscribe')->name('video.subscribe');
Route::get('payment/callback', 'SubscriptionController@callback');

