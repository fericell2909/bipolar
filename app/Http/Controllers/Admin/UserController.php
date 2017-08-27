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
}