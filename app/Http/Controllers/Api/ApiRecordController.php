<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AudioRecord;
use App\Models\BlackList;
use App\Models\Device;
use App\Models\Team;
use App\Models\UpdateStatus;
use App\Models\VideoRecord;
use Illuminate\Support\Facades\File;

class ApiRecordController extends Controller {

    public function uploadAudioRecord(Request $request) {
        $record_id = $request->record_id;
        
        $file = $request->file('call_record');
        $filename = $record_id.'.mp3';

        $tempLocation = storage_path().'/'.'app/public/temp'.'/'.$filename;
        $file->storeAs('public/temp', $filename);
        $realLocation = resource_path().'/audio'.'/'.strval($filename);
        
        if (File::exists($realLocation)) {
            File::delete($realLocation);
        }
        
        File::move($tempLocation, $realLocation);
        File::delete($tempLocation);

        $record = AudioRecord::where('id', $record_id)->first();
        $record->record_time = $request->recorded_at;
        $record->path = $realLocation;
        $record->status = true;
        $record->save();

        return response()->json(['success'=>true, 'message'=>'Audion uploaded successfully.']);
    }

    public function uploadCallRecord(Request $request) {
        $device_id = $request->device_id;

        $team = Device::where('id', $device_id)->first()->rTeam;
        $record = new AudioRecord();
        $record->team_id = $team->id;
        $record->device_id = $device_id;
        $record->duration = $request->duration;
        $record->record_time = $request->recorded_at;
        $record->status = true;
        $record->save();



        $file = $request->file('call_record');
        $filename = $record->id.'.mp3';

        $tempLocation = storage_path().'/'.'app/public/temp'.'/'.$filename;
        $file->storeAs('public/temp', $filename);
        $realLocation = resource_path().'/audio'.'/'.strval($filename);
        
        if (File::exists($realLocation)) {
            File::delete($realLocation);
        }
        
        File::move($tempLocation, $realLocation);
        File::delete($tempLocation);

        $record->path = $realLocation;
        $record->save();

        return response()->json(['success'=>true, 'message'=>'Audion uploaded successfully.']);
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

        $tempLocation = storage_path().'/'.'app/public/temp'.'/'.$filename;
        $file->storeAs('public/temp', $filename);
        $realLocation = resource_path().'/video'.'/'.strval($filename);
        
        if (File::exists($realLocation)) {
            File::delete($realLocation);
        }
        
        File::move($tempLocation, $realLocation);
        File::delete($tempLocation);

        $record->path = $realLocation;
        $record->save();

        return response()->json(['success'=>true, 'message'=>'Audion uploaded successfully.']);
    }
}