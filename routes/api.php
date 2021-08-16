<?php

use App\Http\Controllers\API\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\API\AuthController;

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

Route::post('/register', 'AuthController@register')->name('register');

Route::middleware(['auth:api'])->group(function () {
    Route::post('/logout','AuthController@logout');
    Route::resource('/posts', 'PostController');
    //comment controllers
    Route::post('/posts/{post}/comment','CommentController@store');
    Route::delete('/comment/{comment}','CommentController@delete');
    Route::put('comment/{comment}','CommentController@update');
    //profile controllers
    Route::get('/profile/{user}','ProfileController@index');
    Route::put('/profile/{user}', 'ProfileController@update');
});


