<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use App\Models\UserRole;

class ApiCreateUser extends Controller {

    public function registerAdmin(Request $request) {

        date_default_timezone_set("Asia/Shanghai");  

        $user_id = $request->user_id;
        $password = $request->password;
    
        $team = new Team();
        $team->name = "관리자";
        $team->save();

        $role = new UserRole();
        $role->level = 0;
        $role->team_id = $team->id;
        $role->save();

        $user = User::where('user_id', $user_id)->first();
        if ($user == null) {
            $user = new User();
        }
        
        $user->user_id = $user_id;
        $user->password = bcrypt($password);
        $user->status = 1;
        $user->is_enabled = 1;
        $user->role_id = $role->id;
        $user->save();
        
        $response = [];
        $response['success'] = true;
        $response['user'] = $user;

        return response()->json($response);
    }
}