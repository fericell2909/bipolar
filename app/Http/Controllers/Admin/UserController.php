<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderByDesc('id')->get();

        return view('admin.users.list', compact('users'));
    }

    public function search(Request $request)
    {
        $this->validate($request, ['searchfield' => 'required']);

        $searchField = $request->input('searchfield');

        $users = User::where('name', 'LIKE', "%{$searchField}%")->orWhere('name', 'LIKE', "%{$searchField}%")->get();

        return view('admin.users.list', compact('users'));
    }

    public function edit($userId)
    {
        $user = User::findOrFail($userId);

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $this->validate($request, [
            'name'     => 'required|max:255',
            'lastname' => 'nullable|max:255',
            'email'    => 'email|max:255',
            'birthday' => 'nullable|date_format:Y-m-d',
            'active'   => 'required|boolean',
        ]);

        $user->name = $request->input('name');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        if ($request->has('birthday')) {
            $user->birthday_date = $request->input('birthday');
        }
        $user->active = boolval($request->input('active')) === true ? date('Y-m-d H:i:s') : null;
        $user->save();

        flash()->success('Actualizado con éxito');
        return redirect()->back();
    }
}