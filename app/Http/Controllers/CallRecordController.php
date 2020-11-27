<?php

namespace App\Http\Controllers;

use App\Models\AudioRecord;
use App\Models\BlackList;
use App\Models\Block;
use App\Models\CallLog;
use App\Models\Device;
use App\Models\ForceIncome;
use App\Models\User;
use Illuminate\Http\Request;

class CallRecordController extends Controller
{

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

        return $this->getAudioList($team_id);
    }

    public function getAudioList($team_id)
    {
        $cond = AudioRecord::where('team_id', $team_id)->orderBy('id');
        $records = $cond->get();

        $recordList = [];
        foreach ($records as $record) {
            $data = [];
            $data['id'] = $record->id;
            $data['duration'] = $record->duration;
            $data['record_time'] = $record->record_time;
            $data['phone'] = $record->rDevice->phone;
            $data['path'] = $record->path;

            array_push($recordList, $data);
        }

        $devices = Device::where('team_id', $team_id)->where('is_enable', 1)->get();
        $deviceList = [];
        foreach ($devices as $device) {
            $data = [];
            $data['id'] = $device->id;
            $data['nickname'] = $device->nickname;
            $data['phone'] = $device->phone;

            array_push($deviceList, $data);
        }

        return view('callrecord', array('records' => $recordList, 'devices' => $deviceList));
    }

    public function saveAudio(Request $request)
    {
        $user_id = auth()->user()->id;
        $user = User::where('id', $user_id)->first();

        $team_id = 2;
        $role = $user->rUserRole;
        if ($role->level != 0) {
            $team_id = $role->team_id;
        }

        $device_ids = $request->phone_type;
        $duration = $request->duration;

        foreach ($device_ids as $key => $device_id) {
            $audio = new AudioRecord();
            $audio->team_id = $team_id;
            $audio->device_id = $device_id;
            $audio->duration = $duration;
            $audio->save();
        }

        return redirect('/manage/record/' . strval($team_id));
    }
}
