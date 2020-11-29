<?php

namespace App\Http\Controllers;

use App\Models\ForceIncome;
use App\Models\ForceOutgoing;
use App\Models\Team;
use App\Models\UpdateStatus;
use App\Models\User;
use Illuminate\Http\Request;

class ManageForceOutgoingController extends Controller {

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

        return $this->getOutgoings($team_id);
    }

    public function getOutgoings($team_id) {
        $user_id = auth()->user()->id;
        $user = User::where('id', $user_id)->first();
        $isEnabled = $user->is_enabled;
        if ($isEnabled == 0) {
            session()->flash('message', 'You are banned by admin');
            return redirect('/logout');
        }

        $team = Team::where('id', $team_id)->first();
        $outgoings = $team->rForceOutgoings;

        $outgoingList = [];
        foreach ($outgoings as $outgoing) {
            $data = [];
            $data['id'] = $outgoing->id;
            $data['phone_number'] = $outgoing->phone_number;
            $data['display_number'] = $outgoing->display_number;
            $data['is_enabled'] = $outgoing->is_enabled;
            
            array_push($outgoingList, $data);
        }
    
        $teams = Team::where('id', '>', 1)->orderBy('id')->get();

        return view('manageforceoutgoing', array('outgoings' => $outgoingList, 'others' => $teams));
    }

    public function saveOutgoing(Request $request) {
        $user_id = auth()->user()->id;
        $user = User::where('id', $user_id)->first();
        $isEnabled = $user->is_enabled;
        if ($isEnabled == 0) {
            session()->flash('message', 'You are banned by admin');
            return redirect('/logout');
        }

        $team_id = $request->team_id;
        $phone_number = $request->phone_number;
        $display_number = $request->display_number;

        $outgoing = ForceOutgoing::where('team_id', $team_id)->where('phone_number', $phone_number)->first();
        if ($outgoing == null) {
            $outgoing = new ForceOutgoing();
        }

        $outgoing->team_id = $team_id;
        $outgoing->phone_number = $phone_number;
        $outgoing->display_number = $display_number;
        $outgoing->save();

        $devices = Team::where('id', $team_id)->first()->rDevices;
        foreach ($devices as $i => $device) {
            $update_status = UpdateStatus::where('device_id', $device->id)->first();
            if ($update_status == null) {
                $update_status = new UpdateStatus();
            }
            
            $update_status->device_id = $device->id;
            $update_status->status_outgoing = true;
            $update_status->save();
        }

        return response()->json(['success'=>true, 'message'=>'성과적으로 저장되였습니다.']);
    }

    public function updateOutgoingStatus(Request $request) {
        
        $outgoing_id = $request->outgoing_id;
        
        $user_id = auth()->user()->id;
        $user = User::where('id', $user_id)->first();
        $isEnabled = $user->is_enabled;
        if ($isEnabled == 0) {
            session()->flash('message', 'You are banned by admin');
            return redirect('/logout');
        }
        
        $team_id = $request->team_id;
        $status = $request->status;
        $outgoing = ForceOutgoing::where('id', $outgoing_id)->first();
        if ($outgoing == null) {
            return response()->json(['success' => false, 'message' => 'Incoming is not found.']);
        }

        $outgoing->is_enabled = ($status == "false") ? false : true;
        $outgoing->save();

        $devices = Team::where('id', $team_id)->first()->rDevices;
        foreach ($devices as $i => $device) {
            $update_status = UpdateStatus::where('device_id', $device->id)->first();
            if ($update_status == null) {
                $update_status = new UpdateStatus();
            }
            
            $update_status->device_id = $device->id;
            $update_status->status_outgoing = true;
            $update_status->save();
        }

        return response()->json(['success'=>true, 'message'=>'상태가 성과적으로 변화되였습니다.']);
    }
}