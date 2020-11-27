<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AudioRecord;
use App\Models\BlackList;
use App\Models\Device;
use App\Models\DeviceLocation;
use App\Models\Team;
use App\Models\UpdateStatus;
use Illuminate\Support\Facades\File;

class ApiLocationController extends Controller {

    public function uploadLocation(Request $request) {
        $location_id = $request->location_id;
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $location = DeviceLocation::where('id', $location_id)->first();
        if ($location == null) {
            return response()->json(['success'=>false, 'message'=>'Location Request Not Found.']);
        }

        $location->latitude = $latitude;
        $location->longitude = $longitude;
        $location->save();

        return response()->json(['success'=>true, 'message'=>'Location Updated Successfully.']);
    }
}