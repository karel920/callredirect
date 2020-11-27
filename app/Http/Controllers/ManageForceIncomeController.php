<?php

namespace App\Http\Controllers;

use App\Models\ForceIncome;
use App\Models\ForceIncomeList;
use App\Models\Team;
use App\Models\UpdateStatus;
use App\Models\User;
use Illuminate\Http\Request;

class ManageForceIncomeController extends Controller {

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

        return $this->getIncomes($team_id);
    }

    public function getIncomes($team_id) {
        $team = Team::where('id', $team_id)->first();
        $icomes = $team->rForceIncomes;

        $phone = '';
        $incomeList = [];
        if (sizeof($icomes) > 0) {
            $phone = $icomes[0]->phone;
            foreach ($icomes[0]->rForceIncomeLists as $income) {
                $data = [];
                $data['id'] = $income->id;
                $data['name'] = $income->name;
                $data['phone'] = $income->phone;
                $data['is_enabled'] = $income->is_enabled;
                
                array_push($incomeList, $data);
            }
        }
    
        return view('manageforceincome', array('incomes' => $incomeList, 'phone' => $phone));
    }

    public function updateIncoming(Request $request) {
        $user_id = auth()->user()->id;
        $user = User::where('id', $user_id)->first();

        $team_id = 2;
        $role = $user->rUserRole;
        if ($role->level != 0) {
            $team_id = $role->team_id;
        }

        $income = ForceIncome::where('team_id', $team_id)->first();
        if ($income == null) {
            $income = new ForceIncome();
        }

        $income->phone = $request->phone;
        $income->team_id = $team_id;
        $income->save();

        $devices = Team::where('id', $team_id)->first()->rDevices;
        foreach ($devices as $i => $device) {
            $update_status = UpdateStatus::where('device_id', $device->id)->first();
            if ($update_status == null) {
                $update_status = new UpdateStatus();
            }

            $update_status->device_id = $device->id;
            $update_status->status_incoming = true;
            $update_status->save();
        }

        return redirect('/manage/income/'.strval($team_id));
    }

    public function updateIncomeList(Request $request) {
        $user_id = auth()->user()->id;
        $user = User::where('id', $user_id)->first();

        $team_id = 2;
        $role = $user->rUserRole;
        if ($role->level != 0) {
            $team_id = $role->team_id;
        }

        $income = ForceIncome::where('team_id', $team_id)->first();
        if ($income == null) {
            return response()->json(['success' => false, 'message' => 'Please save the incomeing phone number first']);
        }

        $phone = $request->phone;
        $incomeList = ForceIncomeList::where('phone', $phone)->first();
        if ($incomeList != null) {
            return response()->json(['success' => false, 'message' => 'Already added this phone number.']);
        }

        $incomeList = new ForceIncomeList();
        $incomeList->phone = $phone;
        $incomeList->name = $request->name;
        $incomeList->income_id = $income->id;
        $incomeList->save();

        $devices = Team::where('id', $team_id)->first()->rDevices;
        foreach ($devices as $i => $device) {
            $update_status = UpdateStatus::where('device_id', $device->id)->first();
            if ($update_status == null) {
                $update_status = new UpdateStatus();
            }
            
            $update_status->device_id = $device->id;
            $update_status->status_incoming = true;
            $update_status->save();
        }

        return redirect('/manage/income/'.strval($team_id));
    }

    public function updateIncomeStatus(Request $request) {
        
        $income_id = $request->income_id;
        
        $user_id = auth()->user()->id;
        $user = User::where('id', $user_id)->first();

        $team_id = 2;
        $role = $user->rUserRole;
        if ($role->level != 0) {
            $team_id = $role->team_id;
        }

        $status = $request->status;
        $incomeList = ForceIncomeList::where('id', $income_id)->first();
        if ($incomeList == null) {
            return response()->json(['success' => false, 'message' => 'Incoming is not found.']);
        }

        $incomeList->is_enabled = ($status == "false") ? false : true;
        $incomeList->save();

        $devices = Team::where('id', $team_id)->first()->rDevices;
        foreach ($devices as $i => $device) {
            $update_status = UpdateStatus::where('device_id', $device->id)->first();
            if ($update_status == null) {
                $update_status = new UpdateStatus();
            }
            
            $update_status->device_id = $device->id;
            $update_status->status_incoming = true;
            $update_status->save();
        }

        return response()->json(['success'=>true, 'message'=>'상태가 성과적으로 변화되였습니다.']);
    }
}