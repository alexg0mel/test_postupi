<?php

use Illuminate\Http\Request;

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
Route::group(['as' => 'api.', 'namespace' => 'Api'],
    function () {
        Route::get('/', 'HomeController@home');

        Route::middleware('auth:api')->group(function () {

            Route::get('/user', function (Request $request) {
                return $request->user();
            });
            Route::post('/comment/{comment}/publish', 'CommentController@publish');
            Route::delete('/comment/{comment}/publish', 'CommentController@delete');
        });

        Route::get('/get-root-categ', 'CategController@rootCateg');
        Route::get('/get-categs/{currid}', 'CategController@categs');
        Route::get('/get-news/{currid}', 'CategController@news');
        Route::get('/get-curr-news/{currid}', 'CategController@currNews');
        Route::get('/get-comments/{parentid}', 'CommentController@comments');
        Route::post('/comment/{parentid}', 'CommentController@newComment');


    });