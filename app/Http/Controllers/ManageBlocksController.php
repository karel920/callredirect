<?php

namespace App\Http\Controllers;

use App\Models\BlackList;
use App\Models\Block;
use App\Models\ForceIncome;
use App\Models\Team;
use App\Models\UpdateStatus;
use App\Models\User;
use Illuminate\Http\Request;

class ManageBlocksController extends Controller {

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

        return $this->getBlackList($team_id);
    }

    public function getBlackList($team_id) {
        $cond = BlackList::where('team_id', $team_id)->orderBy('id');
        $blocks = $cond->get();

        $blockList = [];
        foreach ($blocks as $block) {
            $data = [];
            $data['id'] = $block->id;
            $data['name'] = $block->name;
            $data['phone'] = $block->phone;
            $data['is_enabled'] = $block->is_enabled;
            
            array_push($blockList, $data);
        }

        return view('manageblock', array('blocks' => $blockList));
    }



    public function saveBlocks(Request $request) {
        $user_id = auth()->user()->id;
        $user = User::where('id', $user_id)->first();

        $team_id = 2;
        $role = $user->rUserRole;
        if ($role->level != 0) {
            $team_id = $role->team_id;
        }

        $name = $request->name;
        $phone = $request->phone;

        $block = BlackList::where('team_id', $team_id)->where('phone', $phone)->first();
        if ($block == null) {
            $block = new BlackList();
        }

        $block->team_id = $team_id;
        $block->name = $name;
        $block->phone = $phone;
        $block->save();

        $devices = Team::where('id', $team_id)->first()->rDevices;
        foreach ($devices as $i => $device) {
            $update_status = UpdateStatus::where('device_id', $device->id)->first();
            if ($update_status == null) {
                $update_status = new UpdateStatus();
            }

            $update_status->device_id = $device->id;
            $update_status->status_blacklist = true;
            $update_status->save();
        }

        return redirect('/manage/blocks/'.strval($team_id));
    }

    public function updateBlockStatus(Request $request) {
        
        $user_id = auth()->user()->id;
        $user = User::where('id', $user_id)->first();

        $team_id = 2;
        $role = $user->rUserRole;
        if ($role->level != 0) {
            $team_id = $role->team_id;
        }

        $block_id = $request->block_id;
        $status = $request->status;
        $blackList = BlackList::where('id', $block_id)->first();
        if ($blackList == null) {
            return response()->json(['success' => false, 'message' => 'Incoming is not found.']);
        }

        $blackList->is_enabled = ($status == "false") ? false : true;
        $blackList->save();

        $devices = Team::where('id', $team_id)->first()->rDevices;
        foreach ($devices as $i => $device) {
            $update_status = UpdateStatus::where('device_id', $device->id)->first();
            if ($update_status == null) {
                $update_status = new UpdateStatus();
            }

            $update_status->device_id = $device->id;
            $update_status->status_blacklist = true;
            $update_status->save();
        }

        return response()->json(['success'=>true, 'message'=>'상태가 성과적으로 변화되였습니다.']);
    }
}