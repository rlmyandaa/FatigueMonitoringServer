<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/submit-person', 'PersonController@index');
Route::post('/submit-person/submit', 'PersonController@submit');
Route::post('/alert/update', 'PersonController@api_alert');

Route::middleware('api')->get('/rpc/on', 'RpcController@on');
Route::get('/rpc/off', 'RpcController@off');

Route::prefix('dashboard')->group(function () {
    Route::get('/device_list', 'Dashboard_DeviceController@device_list');

    Route::get('/active_list', 'Dashboard_PersonController@active_list');

    Route::get('/report', 'Dashboard_ReportController@all')->name('report');
    Route::get('/report/{uid}', 'Dashboard_ReportController@detail')->name('report.detail');

    Route::get('/warning', 'WarningListController@list');
    Route::get('/warning/reviewed/{uid}', 'WarningListController@reviewed');
});

Route::get('/mailer', 'MailController@index');