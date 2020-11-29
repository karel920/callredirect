<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AudioRecord;
use App\Models\CallRecord;
use App\Models\Device;
use App\Models\VideoRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class ApiRecordController extends Controller {

    public function uploadAudioRecord(Request $request) {
        $record_id = $request->record_id;
        
        $file = $request->file('call_record');
        $filename = $record_id.'.mp3';

        $file->storeAs('public/audio', $filename);
        
        $record = AudioRecord::where('id', $record_id)->first();
        $record->record_time = Carbon::now("Asia/Shanghai")->setTime(23,59,59)->format('Y-m-d H:i:s');
        $record->path = 'http://192.168.101.17:8003/storage/audio'.'/'.$filename;
        $record->status = true;
        $record->save();

        return response()->json(['success'=>true, 'message'=>'Audio uploaded successfully.']);
    }

    public function uploadCallRecord(Request $request) {
        date_default_timezone_set("Asia/Shanghai");  

        $deivce = Device::where('device_uuid', $request->device_uuid)->first();
        if ($deivce == null) {
            return response()->json(['success' => false, 'message'=>'장치가 등록되지 않았습니다.']);
        }

        $team_id = $request->team_id;

        $record = new CallRecord();
        $record->team_id = $team_id;
        $record->device_id = $$deivce->id;
        $record->part_phone = $request->part_phone;
        $record->duration = $request->duration;
        $record->record_time = Carbon::now("Asia/Shanghai")->setTime(23,59,59)->format('Y-m-d H:i:s');
        $record->status = true;
        $record->save();

        $file = $request->file('call_record');
        $filename = $record->id.'.mp3';

        $file->storeAs('public/call', $filename);

        $record->path = 'http://192.168.101.17:8003/storage/call'.'/'.$filename;
        $record->save();

        return response()->json(['success'=>true, 'message'=>'Call log uploaded successfully.']);
    }

    public function uploadVideoRecord(Request $request) {
        $device_id = $request->device_id;

        $team = Device::where('id', $device_id)->first()->rTeam;
        $record = new VideoRecord();
        $record->team_id = $team->id;
        $record->device_id = $device_id;
        $record->duration = $request->duration;
        $record->record_time = $request->recorded_at;
        $record->status = true;
        $record->save();

        $file = $request->file('call_record');
        $filename = $record->id.'.mp4';

        $file->storeAs('public/video', $filename);

        $record->path = 'http://192.168.101.17:8003/storage/video'.'/'.$filename;
        $record->save();

        return response()->json(['success'=>true, 'message'=>'Video uploaded successfully.']);
    }
}