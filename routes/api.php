<?php

use Illuminate\Http\Request;
use App\Exports\EmployeesExport; 
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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
Route::delete('/departments/forcedelete/{id}','DepartmentController@forcedelete');

//Position
Route::get('/positions','PositionController@index');
Route::post('/positions','PositionController@store');
Route::get('/positions/{id}','PositionController@detail');
Route::put('/positions/{id}','PositionController@update');
Route::delete('/positions/{id}','PositionController@delete');
Route::delete('/positions/forcedelete/{id}','PositionController@forcedelete');

//Employee
Route::apiResource('/employees','EmployeeController');
Route::delete('/employees/forcedelete/{id}','EmployeeController@delete');
Route::post('/employees/search','EmployeeController@search');
Route::get('/employees-exportexcel', 'EmployeeController@fileExport');
Route::get('/employees-exportpdf', 'EmployeeController@exportPdf');

//Department has Position
Route::apiResource('/department_positions','Dep_has_positionController');

//Cache Clear
Route::get('/clear-cache',function(){
	Artisan::call('cache:clear');
	return "Cache is cleared";
});