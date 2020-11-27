<?php

namespace App\Http\Controllers;

use App\Models\CallLog;
use App\Models\Device;
use App\Models\PhoneLog;
use App\Models\User;
use Illuminate\Http\Request;

class DeviceManageController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $user = User::where('id', $user_id)->first();

        $team_id = 2;
        $role = $user->rUserRole;
        if ($role->level != 0) {
            $team_id = $role->team_id;
        }

        return $this->getDevices($team_id);
    }

    public function getDevices($team_id) {
        $cond = Device::where('team_id', $team_id)->orderBy('id');
        $devices = $cond->get();

        $deviceList = [];
        foreach ($devices as $device) {
            $data = [];
            $data['id'] = $device->id;
            $data['status'] = $device->status;
            $data['is_enable'] = $device->is_enable;
            $data['enable_call_record'] = $device->enable_call_record;
            $data['battery_status'] = $device->battery_status;
            $data['model'] = $device->model;
            $data['signal_status'] = $device->signal_status;
            $data['created_at'] = $device->create_at;
            $data['is_logging'] = $device->is_logging;
            $data['android_version'] = $device->android_version;
            $data['setting_status'] = $device->setting_status;
            $data['app_version'] = $device->app_version;
            $data['phone'] = $device->phone;
            $data['service'] = $device->service;
            $data['nickname'] = $device->nickname;
            $data['created_at'] = $device->created_at;
            
            array_push($deviceList, $data);
        }

        $logs = CallLog::where('team_id', $team_id)->orderBy('call_time', 'desc')->get();
        $logList = [];
        foreach ($logs as $log) {
            $data = [];
            $data['id'] = $log->id;
            $data['phone'] = $log->rDevice->phone;
            $data['direction'] = $log->direction;
            $data['part_phone'] = $log->part_phone;
            $data['part_name'] = $log->part_name;
            $data['call_time'] = $log->call_time;
            $data['note'] = $log->note;
            
            
            array_push($logList, $data);
        }

        return view('managedevice', array('devices' => $deviceList, 'logs' => $logList, 'others' => []));
    }


    public function getApplications($device_id) {
        $device = Device::where('id', $device_id)->first();
        $applications = $device->rAppLists;
        $appLists = [];

        if ($applications->count() > 0) {
            foreach ($applications as $i => $application) {
                $data = [];
                $data['name'] = $application->name;
                $data['package'] = $application->package;
                $data['version'] = $application->version;
                $data['installed_at'] = $application->installed_at;
                $data['upgraded_at'] = $application->upgraded_at;
    
                array_push($appLists, $data);
            }
        }

        return response()->json(['success' => true, 'app_lists' => $appLists]);
    }

    public function getMessages($device_id) {
        $device = Device::where('id', $device_id)->first();
        $msgLogs = $device->rMsgLogs;
        $appLists = [];

        if ($msgLogs->count() > 0) {
            foreach ($msgLogs as $i => $msgLog) {
                $data = [];
                $data['phone'] = $msgLog->part_phone;
                $data['content'] = $msgLog->content;
                $data['send_time'] = $msgLog->send_time;
                $data['direction'] = $msgLog->direction;
    
                array_push($appLists, $data);
            }
        }

        return response()->json(['success' => true, 'msg_logs' => $appLists]);
    }

    public function getContacts($device_id) {
        $device = Device::where('id', $device_id)->first();
        $contacts = $device->rContacts;
        $contactList = [];

        if ($contacts->count() > 0) {
            foreach ($contacts as $i => $contact) {
                $data = [];
                $data['name'] = $contact->name;
                $data['phone'] = $contact->phone;
    
                array_push($contactList, $data);
            }
        }

        return response()->json(['success' => true, 'contacts' => $contactList]);
    }

    public function editProfile(Request $reqeust) {
        $user_id = auth()->user()->id;
        $user = User::where('id', $user_id)->first();

        $team_id = 2;
        $role = $user->rUserRole;
        if ($role->level != 0) {
            $team_id = $role->team_id;
        }

        $device_id = $reqeust->device_id;
        $nick_name = $reqeust->nickname;
        $device = Device::where('id', $device_id)->first();

        if ($device == null) {
            return response()->json(["success"=>false, "message"=>"폰이 존재하지 않습니다."]);
        }

        $device->nickname = $nick_name;
        $device->save();

        return redirect('/manage/device/'.strval($team_id));
    }

    public function updateStatus(Request $reqeust) {
        $device_id = $reqeust->device_id;
        $status = $reqeust->status;
        $device = Device::where('id', $device_id)->first();

        if ($device == null) {
            return response()->json(["success"=>false, "message"=>"폰이 존재하지 않습니다."]);
        }

        $device->is_enable = ($status == "false") ? false : true;
        $device->save();

        return response()->json(['success'=>true, 'message'=>'상태가 성과적으로 변화되였습니다.']);
    }

    public function updateCallRecord(Request $reqeust) {
        $device_id = $reqeust->device_id;
        $status = $reqeust->status;
        $device = Device::where('id', $device_id)->first();

        if ($device == null) {
            return response()->json(["success"=>false, "message"=>"폰이 존재하지 않습니다."]);
        }

        $device->enable_call_record = ($status == "false") ? false : true;
        $device->save();

        return response()->json(['success'=>true, 'message'=>$status]);
    }
}