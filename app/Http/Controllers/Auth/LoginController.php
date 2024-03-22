<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');

    }

    public function authenticate(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember_me = ($request->has('remember_token')) ? true : false;

        if (Auth::attempt($credentials, $remember_me)) {
            return redirect()->route('admin.dashboard')->with('message', 'You are successfully logged in!');
        }
        else{
            return redirect()->route('/')->with(['Input' => $request->only('email','password'), 'error' => 'Your Email id and Password do not match our records!']);
        }

    }

    public function logout() {
        Session::flush();
        Auth::logout();
        return redirect()->route('/')->with('message', 'You are logout Successfully.');
    }
}
