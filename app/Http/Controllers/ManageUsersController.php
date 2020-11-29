<?php

namespace App\Http\Controllers;

use App\Models\ForceIncome;
use App\Models\Team;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;

class ManageUsersController extends Controller {

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
    public function index() {
        $can_add = true;
        $current_user = auth()->user();
        $isEnabled = $current_user->is_enabled;
        if ($isEnabled == 0) {
            session()->flash('message', 'You are banned by admin');
            return redirect('/logout');
        }

        $current_role = $current_user->rUserRole;
        
        if ($current_role->level == 0) {
            $roles = UserRole::where('level', 1)->get();

            $userList = [$current_user];
            foreach($roles as $role) {
                $users = $role->rUsers;
                
                foreach ($users as $user) {
                    array_push($userList, $user);
                }
            }

        } else if ($current_role->level == 1) {
            $roles = UserRole::where('level', 2)->get();
            
            $userList = [$current_user];
            foreach($roles as $role) {
                $users = $role->rUsers;
                
                foreach ($users as $user) {
                    array_push($userList, $user);
                }
            }

        } else {
            $userList = [$current_user];
            $can_add = false;
        }

        $users = [];
        foreach ($userList as $user) {
            $data = [];
            $data['id'] = $user->id;
            $data['user_id'] = $user->user_id;
            $data['password'] = $user->password;
            $data['level'] = $user->rUserRole->level;
            $data['team'] = $user->rUserRole->rTeam->name;
            $data['service_date'] = $user->service_date;
            $data['expire_date'] = $user->expire_date;
            $data['status'] = $user->status;
            $data['is_enabled'] = $user->is_enabled;

            array_push($users, $data);
        }

        return view('manageuser', array('users' => $users, 'can_add' => $can_add));
    }

    public function registerUser(Request $request) {
        $current_user = auth()->user();
        $isEnabled = $current_user->is_enabled;
        if ($isEnabled == 0) {
            session()->flash('message', 'You are banned by admin');
            return redirect('/logout');
        }

        $userId = $request->user_id;
        $password = $request->password;
        $team_name = $request->team_name;
        $servieDate = $request->service_date;
        $expireDate = $request->expire_date;

        $user = User::where('user_id', $userId)->first();
        $team = Team::where('name', $team_name)->first();

        if ($team != null) {
            return response()->json(['success'=>false, 'message'=>'그룹이 이미 존재합니다.']);
        }

        if ($user != null) {
            return response()->json(['success'=>false, 'message'=>'사용자아이디가 이미 존재합니다.']);
        }

        $role = new UserRole();
        $current_role = User::where('id', $current_user->id)->first()->rUserRole;

        if ($current_role->level == 0) {
            $role->level = 1;
            
            $team = new Team();
            $team->name = $team_name;
            $team->save();

            $role->team_id = $team->id;
        } else {
            $role->level = 2;
            $role->team_id = $current_role->team_id;
        }

        $role->save();

        $user = new User();
        $user->user_id = $userId;
        $user->password = bcrypt($password);
        $user->role_id = $role->id;
        $user->service_date = $servieDate;
        $user->expire_date = $expireDate;
        $user->save();

        return redirect('/manage/users');
    }

    public function updateUserStatus(Request $request) {
        $user = auth()->user();
        $isEnabled = $user->is_enabled;
        if ($isEnabled == 0) {
            session()->flash('message', 'You are banned by admin');
            return redirect('/logout');
        }

        $status = $request->status;
        $user_id = $request->user_id;
        $child = User::where('id', $user_id)->first();

        if ($child == null) {
            return response()->json(['success'=>false, 'message'=>'사용자가 존재하지 않습니다.']);
        }

        $child->is_enabled = ($status == "false") ? false : true;
        $child->save();

        $role = $child->rUserRole;
        if ($role->level == 1 && $status == "false") {
            $roles = $role->rTeam->rUserRoles;
            foreach ($roles as $i => $item) {
                if ($item->id != $role->id) {
                    $members = $item->rUsers;

                    foreach ($members as $j => $member) {
                        $member->is_enabled = false;
                        $member->save();
                    }
                }
            }
        }

        return response()->json(['success'=>true, 'message'=>'성과적으로 갱신되였습니다.']);
    }
}