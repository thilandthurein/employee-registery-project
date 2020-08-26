<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Department
Route::get('/departments','DepartmentController@index');
Route::post('/departments','DepartmentController@store');
Route::get('/departments/{id}','DepartmentController@detail');
Route::put('/departments/{id}','DepartmentController@update');
Route::delete('/departments/{id}','DepartmentController@delete');

//Position
Route::get('/positions','PositionController@index');
Route::post('/positions','PositionController@store');
Route::get('/positions/{id}','PositionController@detail');
Route::put('/positions/{id}','PositionController@update');
Route::delete('/positions/{id}','PositionController@delete');

//Employee
Route::apiResource('/employees','EmployeeController');
Route::delete('/employees/delete_at/{id}','EmployeeController@delete');

//Department has Position
Route::apiResource('/department_positions','Dep_has_positionController');