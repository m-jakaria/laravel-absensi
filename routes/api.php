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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/user','UserController@getUser');
Route::post('/user','UserController@createUser');
Route::put('/user/update/{id}','UserController@editUser');
Route::delete('/user/delete/{id}','UserController@deleteUser');

Route::get('/role','RoleController@getRole');
Route::post('/role','RoleController@createRole');
Route::delete('/role/{id}', 'RoleController@deleteRole');

Route::post('/login','LoginController@login');
Route::get('/login','LoginController@getUser');
