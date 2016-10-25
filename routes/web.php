<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::group(['prefix' => 'user', 'middleware' => 'auth'], function() {
    Route::resource('profile', 'User\UsersController', [
        'only' => ['index', 'update']
    ]);
});

Route::group(['prefix' => 'user'], function() {
    Route::resource('poll', 'User\PollController', [
        'only' => ['index', 'show']
    ]);
});

Route::get('/redirect/{provider}', 'SocialAuthController@redirectToProvider');
Route::get('/callback/{provider}', 'SocialAuthController@handleProviderCallback');

/*
 /--------------------------------------------------------------------
 / Route Admin
 /--------------------------------------------------------------------
 */
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {
    Route::resource('poll', 'PollController');
});

/*
 * Route check token of link
 */
Route::resource('link', 'LinkController', ['only' => [
    'store'
]]);
