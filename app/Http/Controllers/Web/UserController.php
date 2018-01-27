<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buy;

class UserController extends Controller
{
    public function profile()
    {
        return view('web.auth.profile');
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'name'                      => 'required|string|between:3,255',
            'lastname'                  => 'nullable|string|between:3,255',
            'email'                     => 'required|string|between:3,255',
            'birthday'                  => 'nullable|date_format:Y-m-d',
            // password validation
            'old_password'              => 'nullable|string',
            'new_password'              => 'required_with:old_password|confirmed',
            'new_password_confirmation' => 'required_with:old_password',
        ]);

        $user = \Auth::user();
        $user->name = $request->input('name');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        if ($request->has('birthday')) {
            $user->birthday_date = "{$request->input('birthday')} 00:00:00";
        }
        if ($request->has('old_password')) {
            if (\Hash::check($request->input('old_password'), $user->password) === false) {
                $request->session()->flash('success', false);
                $request->session()->flash('message', 'La contraseña actual no coincide');

                return redirect()->back();
            }
            $user->password = bcrypt($request->input('old_password'));
        }

        $user->save();

        $request->session()->flash('success', true);
        $request->session()->flash('message', 'Se actualizó el usuario con éxito');

        return redirect()->back();
    }

    public function myaccount()
    {
        $buys = Buy::whereUserId(\Auth::id())->orderByDesc('id')->get();

        return view('web.auth.myaccount', compact('buys'));
    }
}
