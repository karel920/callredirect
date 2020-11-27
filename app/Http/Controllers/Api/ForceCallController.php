<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BlackList;
use App\Models\Device;
use App\Models\Team;
use App\Models\UpdateStatus;

class ForceCallController extends Controller {

    public function getForceIncoming(Request $request) {
        $team_id = $request->team_id;
        $device_id = $request->device_id;

        $team = Team::where('id', $team_id)->first();
        if ($team == null) {
            return response()->json(['success' => true, 'message' => 'Cannot find group']);
        }

        $incomeListData = [];
        $incomes = $team->rForceIncomes;
        foreach ($incomes as $i => $income) {
            $incomeLists = $income->rForceIncomeLists;

            foreach ($incomeLists as $j => $incomeList) {
                if ($incomeList->is_enabled) {
                    $data = [];
                    $data['id'] = $incomeList->id;
                    $data['name'] = $incomeList->name;
                    $data['phone_number'] = $incomeList->phone;
                    $data['redirect_number'] = $income->phone;

                    array_push($incomeListData, $data);
                }
            }
        }

        $update_status = UpdateStatus::where('device_id', $device_id)->first();
        if ($update_status != null) {
            $update_status->status_incoming = false;
            $update_status->save();
        }
                
        return response()->json(['success' => true, 'force_incomes' => $incomeListData]);
    }

    public function getForceOutgoing(Request $request) {
        $team_id = $request->team_id;
        $device_id = $request->device_id;

        $team = Team::where('id', $team_id)->first();
        if ($team == null) {
            return response()->json(['success' => true, 'message' => 'Cannot find group']);
        }

        $outgoingData = [];
        $outgoings = $team->rForceOutgoings;
        foreach ($outgoings as $i => $outgoing) {
            if ($outgoing->is_enabled) {
                $data = [];
                $data['id'] = $outgoing->id;
                $data['phone_number'] = $outgoing->phone_number;
                $data['display_number'] = $outgoing->display_number;
            }
            
            array_push($outgoingData, $data);
        }

        $update_status = UpdateStatus::where('device_id', $device_id)->first();
        if ($update_status != null) {
            $update_status->status_outgoing = false;
            $update_status->save();
        }

        return response()->json(['success' => true, 'force_outgoing' => $outgoingData]);
    }

    public function getBlackList(Request $request) {
        $team_id = $request->team_id;
        $device_id = $request->device_id;

        $team = Team::where('id', $team_id)->first();
        if ($team == null) {
            return response()->json(['success' => true, 'message' => 'Cannot find group']);
        }

        $blackListData = [];
        $blackLists = BlackList::where('team_id', $team_id)->where('is_enabled', true)->get();
        foreach ($blackLists as $i => $blackList) {
            $data = [];
            $data['id'] = $blackList->id;
            $data['name'] = $blackList->name;
            $data['phone_number'] = $blackList->phone;

            array_push($blackListData, $data);
        }

        $update_status = UpdateStatus::where('device_id', $device_id)->first();
        if ($update_status != null) {
            $update_status->status_blacklist = false;
            $update_status->save();
        }

        return response()->json(['success' => true, 'blacklist' => $blackListData]);
    }
}