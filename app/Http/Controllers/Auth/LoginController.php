<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function show_login_form()
    {
        return view('login');
    }
    
    public function process_login(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('user_id', 'password');

        $user = User::where('user_id', $request->user_id)->first();

        if (Auth::attempt($credentials)) {
            return redirect()->route('manage_device');
        } else {
            session()->flash('message', 'Invalid credentials');
            return redirect()->back();
        }
    }

    public function show_signup_form()
    {
        return view('manageuser');
    }

    public function process_signup(Request $request)
    {   
        $request->validate([
            'user_id' => 'required',
            'password' => 'required'
        ]);
 
        $user = User::create([
            'user_id' => strtolower($request->input('user_id')),
            'password' => bcrypt($request->input('password')),
        ]);

        session()->flash('message', 'Your account is created');
       
        return redirect()->route('login');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
