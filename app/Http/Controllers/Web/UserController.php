<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\UpdateProfile;
use App\Models\Buy;

class UserController extends Controller
{
    public function profile()
    {
        return view('web.auth.profile');
    }

    public function updateProfile(UpdateProfile $request)
    {
        $user = \Auth::user();
        $user->name = $request->input('name');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        if ($request->filled('birthday')) {
            $user->birthday_date = "{$request->input('birthday')} 00:00:00";
        }
        if ($request->filled('old_password')) {
            if (\Hash::check($request->input('old_password'), $user->password) === false) {

                $request->session()->flash('success', false);
                $request->session()->flash('message', 'La contraseña actual no coincide');

                return redirect()->back();
            } else {
                $user->password = bcrypt($request->input('new_password'));
            }
            
        }

        $user->save();

        $request->session()->flash('success', true);
        $request->session()->flash('message', 'Se actualizó el usuario con éxito');

        return redirect()->back();
    }

    public function myaccount()
    {
        $buys = Buy::whereUserId(\Auth::id())->with('details')->orderByDesc('id')->get();

        return view('web.auth.myaccount', compact('buys'));
    }
}
