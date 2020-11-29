<?php

namespace App\Http\Controllers;

use App\Models\AudioRecord;
use App\Models\Device;
use App\Models\DeviceLocation;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Location;

class ManageLocationController extends Controller
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

        return $this->getLocations($team_id);
    }

    public function getLocations($team_id)
    {
        $user_id = auth()->user()->id;
        $user = User::where('id', $user_id)->first();
        $isEnabled = $user->is_enabled;
        if ($isEnabled == 0) {
            session()->flash('message', 'You are banned by admin');
            return redirect('/logout');
        }

        $cond = DeviceLocation::where('team_id', $team_id)->whereNotNull('latitude')->orderBy('created_at', 'desc');
        $locations = $cond->get();

        $locationList = [];
        foreach ($locations as $location) {
            $data = [];
            $data['id'] = $location->id;
            $data['team_id'] = $location->team_id;
            $data['device_id'] = $location->device_id;
            $data['phone'] = $location->rDevice->phone;
            $data['latitude'] = $location->latitude;
            $data['longitude'] = $location->longitude;
            $data['created_at'] = $location->created_at;
            $data['updated_at'] = $location->updated_at;

            array_push($locationList, $data);
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

        $teams = Team::where('id', '>', 1)->orderBy('id')->get();

        return view('managelocation', array('locations' => $locationList, 'devices' => $deviceList, 'others' => $teams));
    }

    public function saveLocation(Request $request)
    {
        $user_id = auth()->user()->id;
        $user = User::where('id', $user_id)->first();
        $isEnabled = $user->is_enabled;
        if ($isEnabled == 0) {
            session()->flash('message', 'You are banned by admin');
            return redirect('/logout');
        }
        
        $team_id = $request->team_id;
        $device_ids = $request->phone_type;

        foreach ($device_ids as $key => $device_id) {
            $location = new DeviceLocation();
            $location->team_id = $team_id;
            $location->device_id = $device_id;
            $location->save();
        }

        return response()->json(["success"=>true, 'message'=>'성과적으로 저장되였습니다.']);
    }

    public function deleteLocation(Request $request) {
        
        $user_id = auth()->user()->id;
        $user = User::where('id', $user_id)->first();
        $isEnabled = $user->is_enabled;
        if ($isEnabled == 0) {
            session()->flash('message', 'You are banned by admin');
            return redirect('/logout');
        }
        
        $location_id = $request->location_id;
        $location = DeviceLocation::where('id', $location_id)->first();
        if ($location == null) {
            return response()->json(['success' => false, 'message' => 'Incoming is not found.']);
        }

        $location->delete();

        return response()->json(['success'=>true, 'message'=>'상태가 성과적으로 변화되였습니다.']);
    }
}
