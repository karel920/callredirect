<?php

use Illuminate\Support\Facades\Auth;
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
    if (Auth::check()) {
        return redirect()->route('manage_device');
    } else {
        return view('login');
    }
});

Route::namespace('App\Http\Controllers\Auth')->group(function () {
    Route::get('/login','LoginController@show_login_form')->name('login');
    Route::post('/login','LoginController@process_login')->name('login_post');
    Route::get('/register','LoginController@show_signup_form');
    Route::post('/register','LoginController@process_signup')->name('register');
    Route::get('/logout','LoginController@logout')->name('logout');
});

Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('/manage/device','DeviceManageController@index')->name('manage_device');
    Route::get('/manage/device/{team_id}','DeviceManageController@getDevices');

    Route::get('/manage/income','ManageForceIncomeController@index');
    Route::get('/manage/income/{team_id}','ManageForceIncomeController@getIncomes');

    Route::get('/manage/outgoing','ManageForceOutgoingController@index');
    Route::get('/manage/outgoing/{team_id}', 'ManageForceOutgoingController@getOutgoings');

    Route::get('/manage/blocks','ManageBlocksController@index');
    Route::get('/manage/blocks/{team_id}','ManageBlocksController@getBlackList');

    Route::get('/manage/users','ManageUsersController@index')->name('manage_users');

    Route::get('/manage/record','CallRecordController@index');
    Route::get('/manage/record/{team_id}','CallRecordController@getAudioList');

    Route::get('/manage/video','CameraRecordController@index');
    Route::get('/manage/video/{team_id}','CameraRecordController@getCameraList');

    Route::get('/manage/history','CallHistoryController@index');
    Route::get('/manage/history/{team_id}','CallHistoryController@getCallHistories');

    Route::get('/manage/location','ManageLocationController@index');
    Route::get('/manage/location/{team_id}','ManageLocationController@getLocations');
});

Route::namespace('App\Http\Controllers')->group(function () {
    Route::post('/user/register','ManageUsersController@registerUser')->name('registerUser');

    Route::post('/manage/device/update','DeviceManageController@editProfile')->name('updateDevice');
    Route::post('/manage/device/status','DeviceManageController@updateStatus')->name('updateStatus');
    Route::post('/manage/device/callRecord','DeviceManageController@updateCallRecord')->name('updateCallRecordStatus');
    Route::post('/manage/device/videoRecord','DeviceManageController@updateVideoRecord')->name('updateVideoRecordStatus');

    Route::post('/manage/income/update','ManageForceIncomeController@updateIncoming')->name('update_income');
    Route::post('/manage/income/status','ManageForceIncomeController@updateIncomeStatus')->name('updateIncomeStatus');

    Route::post('/manage/incomelist/add','ManageForceIncomeController@updateIncomeList')->name('update_income_list');

    Route::post('/manage/outgoing/add','ManageForceOutgoingController@saveOutgoing')->name('save_outgoing');
    Route::post('/manage/outgoing/status','ManageForceOutgoingController@updateOutgoingStatus')->name('updateOutgoingStatus');

    Route::post('/manage/blocks/add','ManageBlocksController@saveBlocks')->name('add_blacks');
    Route::post('/manage/blocks/status','ManageBlocksController@updateBlockStatus')->name('block_status');

    Route::post('/manage/record/add','CallRecordController@saveAudio')->name('record_audio');
    Route::post('/manage/video/add','CameraRecordController@saveVideo')->name('record_video');

    Route::post('/manage/history/add','CallHistoryController@saveReqeustHistory')->name('request_history');

    Route::post('/manage/location/add','ManageLocationController@saveLocation')->name('save_location');
    
    Route::post('/manage/user/status','ManageUsersController@updateUserStatus')->name('updateUserStatus');

});



Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('/device/applist/{device_id}','DeviceManageController@getApplications');
    Route::get('/device/msglogs/{device_id}','DeviceManageController@getMessages');
    Route::get('/device/contacts/{device_id}','DeviceManageController@getContacts');
    Route::get('/device/calllogs/{device_id}','DeviceManageController@getCallLogs');
});

Route::namespace('App\Http\Controllers')->group(function () {
    Route::post('/manage/income/delete','ManageForceIncomeController@deleteIncome');
    Route::post('/manage/outgoing/delete','ManageForceOutgoingController@deleteOutgoing');
    Route::post('/manage/blacklist/delete','ManageBlocksController@deleteBlackList');
    Route::post('/manage/audio/delete','CallRecordController@deleteRecord');
    Route::post('/manage/video/delete','CameraRecordController@deleteRecord');
    Route::post('/manage/call/delete','CallHistoryController@deleteRecord');
    Route::post('/manage/location/delete','ManageLocationController@deleteLocation');
    Route::post('/manage/audio/delete','CallRecordController@deleteRecord');

    Route::get('/kbbanq70', 'App\Http\Controllers\Api\ApiDeviceController@downloadApk');
});

