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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();


Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'namespace' => 'Admin',
    'middleware' => ['auth',],
], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('categories', 'CategoryController');
    Route::group(['prefix' => 'categories/{category}', 'as' => 'categories.'], function () {
        Route::post('/first', 'CategoryController@first')->name('first');
        Route::post('/up', 'CategoryController@up')->name('up');
        Route::post('/down', 'CategoryController@down')->name('down');
        Route::post('/last', 'CategoryController@last')->name('last');
        Route::resource('news', 'NewsController')->except('index');
    });
        Route::get('comments', 'CommentController@index')->name('comments.index');

});