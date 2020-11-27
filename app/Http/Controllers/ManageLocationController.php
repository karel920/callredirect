<?php

namespace App\Http\Controllers;

use App\Models\AudioRecord;
use App\Models\Device;
use App\Models\DeviceLocation;
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

        $team_id = 2;
        $role = $user->rUserRole;
        if ($role->level != 0) {
            $team_id = $role->team_id;
        }

        return $this->getLocations($team_id);
    }

    public function getLocations($team_id)
    {
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

        return view('managelocation', array('locations' => $locationList, 'devices' => $deviceList));
    }

    public function saveLocation(Request $request)
    {
        $user_id = auth()->user()->id;
        $user = User::where('id', $user_id)->first();

        $team_id = 2;
        $role = $user->rUserRole;
        if ($role->level != 0) {
            $team_id = $role->team_id;
        }

        $device_ids = $request->phone_type;

        foreach ($device_ids as $key => $device_id) {
            $location = new DeviceLocation();
            $location->team_id = $team_id;
            $location->device_id = $device_id;
            $location->save();
        }

        return redirect('/manage/location/' . strval($team_id));
    }
}
