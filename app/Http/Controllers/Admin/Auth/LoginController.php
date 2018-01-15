<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function redirectTo()
    {
        return route('admin.dashboard');
    }

    public function guard()
    {
        return \Auth::guard('admin');
    }

    public function showLoginForm()
    {
        return view('admin.login');
    }
}