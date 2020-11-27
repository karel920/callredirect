<?php

namespace App\Http\Controllers;

use App\Models\AudioRecord;
use App\Models\RequestHistory;
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

        $team_id = 2;
        $role = $user->rUserRole;
        if ($role->level != 0) {
            $team_id = $role->team_id;
        }

        return $this->getCallHistories($team_id);
    }

    public function getCallHistories($team_id) {
        $cond = RequestHistory::where('team_id', $team_id)->orderBy('id');
        $requests = $cond->get();

        $requestList = [];
        foreach ($requests as $request) {
            $data = [];
            $data['id'] = $request->id;
            $data['phone'] = $request->rDevice->phone;
            $data['request_time'] = $request->created_at;
            $data['response_time'] = $request->response_time;
            
            array_push($requestList, $data);
        }

        return view('callhistory', array('requests' => $requestList));
    }

    public function saveReqeustHistory(Request $request) {
        $user_id = auth()->user()->id;
        $user = User::where('id', $user_id)->first();

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
}