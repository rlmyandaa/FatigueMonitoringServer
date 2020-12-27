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
Route::middleware('api')->get('/userdata/{id}', 'PersonController@api_data');
Route::middleware('api')->post('/alert/{device}/update', 'PersonController@api_alert');
Route::prefix('attendance')->middleware('api')->group(function () {
    Route::post('/new', 'AttendanceController@newAttendance');
    Route::post('/finish', 'AttendanceController@completeAttendance');
});

Route::prefix('report')->middleware('api')->group(function () {
    Route::get('/generate/{uid}', 'ReportController@generateReport')->name('api.report.generate');
    Route::post('/update', 'ReportController@update')->name('api.report.update');    
});

Route::prefix('rpc')->middleware('api')->group(function () {
    Route::post('/setactive', 'RpcController@setActive')->name('api.rpc.active');
    Route::post('/setInactive', 'RpcController@setInactive')->name('api.rpc.inactive');
});