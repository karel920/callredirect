<?php

namespace App\Http\Controllers;

use App\Models\AudioRecord;
use App\Models\CallRecord;
use App\Models\RequestHistory;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class CallHistoryController extends Controller {

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
        $isEnabled = $user->is_enabled;
        if ($isEnabled == 0) {
            session()->flash('message', 'You are banned by admin');
            return redirect('/logout');
        }

        $team_id = 2;
        $role = $user->rUserRole;

        // If User is not admin
        if ($role->level != 0) {
            $team_id =  $role->team_id;

        // If User is admin
        } else {
            $team = Team::where('id', '>', 1)->orderBy('id')->first();
            $team_id = $team->id;
        }

        return $this->getCallHistories($team_id);
    }

    public function getCallHistories($team_id) {
        $user_id = auth()->user()->id;
        $user = User::where('id', $user_id)->first();
        $isEnabled = $user->is_enabled;
        if ($isEnabled == 0) {
            session()->flash('message', 'You are banned by admin');
            return redirect('/logout');
        }
        
        $user_id = auth()->user()->id;
        $user = User::where('id', $user_id)->first();
        $isEnabled = $user->is_enabled;
        if ($isEnabled == 0) {
            session()->flash('message', 'You are banned by admin');
            return redirect('/logout');
        }

        $cond = CallRecord::where('team_id', $team_id)->orderBy('id');
        $records = $cond->get();

        $recordList = [];
        foreach ($records as $record) {
            $data = [];
            $data['id'] = $record->id;
            $data['phone'] = $record->rDevice->phone;
            $data['direction'] = $record->direction;
            $data['part_phone'] = $record->part_phone;
            $data['record_time'] = $record->record_time;
            $data['duration'] = $record->rDevice->phone;
            $data['path'] = $record->path;
            $data['request_time'] = $record->duration;
            
            array_push($recordList, $data);
        }

        $teams = Team::where('id', '>', 1)->orderBy('id')->get();

        return view('callhistory', array('records' => $recordList, 'others' => $teams));
    }

    public function saveReqeustHistory(Request $request) {
        $user_id = auth()->user()->id;
        $user = User::where('id', $user_id)->first();
        $isEnabled = $user->is_enabled;
        if ($isEnabled == 0) {
            session()->flash('message', 'You are banned by admin');
            return redirect('/logout');
        }

        $team_id = 2;
        $role = $user->rUserRole;
        if ($role->level != 0) {
            $team_id = $role->team_id;
        }

        $device_id = $request->device_id;

        $audio = new AudioRecord();
        $audio->team_id = $team_id;
        $audio->device_id = $device_id;
        $audio->save();
        
        return redirect('/manage/record/'.strval($team_id));
    }

    public function deleteRecord(Request $request) {
        
        $user_id = auth()->user()->id;
        $user = User::where('id', $user_id)->first();
        $isEnabled = $user->is_enabled;
        if ($isEnabled == 0) {
            session()->flash('message', 'You are banned by admin');
            return redirect('/logout');
        }
        
        $record_id = $request->record_id;
        $record = CallRecord::where('id', $record_id)->first();
        if ($record == null) {
            return response()->json(['success' => false, 'message' => 'Incoming is not found.']);
        }

        $record->delete();

        return response()->json(['success'=>true, 'message'=>'상태가 성과적으로 변화되였습니다.']);
    }
}