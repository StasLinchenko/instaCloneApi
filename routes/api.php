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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', 'AuthController@register')->name('register');

Route::middleware(['auth:api'])->group(function () {
    Route::resource('/posts', 'PostController');
    Route::post('/logout','AuthController@logout');
});


