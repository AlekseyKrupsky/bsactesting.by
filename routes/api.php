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
Route::prefix(env('URL_PREFIX') ? env('URL_PREFIX') : '')->group(function () {
    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/user/search', 'Admin\UserController@search');
    Route::post('/user/reset', 'Admin\UserController@updatePassword');
    Route::post('/user/delete', 'Admin\UserController@deleteUser');
    Route::delete('/user/delete/{user}', 'Admin\UserController@deletePermanentUser');
    Route::post('/user/restore', 'Admin\UserController@restoreUser');
});
