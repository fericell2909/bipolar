<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderByDesc('id')->paginate(20);

        return view('admin.users.list', compact('users'));
    }

    public function search(Request $request)
    {
        $this->validate($request, ['searchfield' => 'required']);

        $searchField = $request->input('searchfield');

        $users = User::where('name', 'LIKE', "%{$searchField}%")
            ->orWhere('name', 'LIKE', "%{$searchField}%")
            ->orWhere('email', 'LIKE', "%{$searchField}%")
            ->get();

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
            'name'              => 'required|max:255',
            'lastname'          => 'nullable|max:255',
            'email'             => 'email|max:255',
            'birthday'          => 'nullable|date_format:Y-m-d',
            'has_showroom_sale' => 'required|boolean',
        ]);

        $user->name = $request->input('name');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        if ($request->filled('birthday')) {
            $user->birthday_date = "{$request->input('birthday')} 00:00:00";
        }
        $user->has_showroom_sale = (bool)$request->input('has_showroom_sale');
        $user->save();

        flash()->success('Actualizado con éxito');

        return redirect()->back();
    }

    public function withCartFilled()
    {
        $users = User::has('carts')->with('carts.details.product')->latest()->get();

        return view('admin.users.with-carts', compact('users'));
    }

    public function download()
    {
        $users = User::orderByDesc('created_at')->get();

        \Excel::create('bipolar_usuarios', function ($excel) use ($users) {
            $excel->setTitle('Lista de usuarios de bipolar');
            $excel->sheet('Usuarios', function ($sheet) use ($users) {
                $sheet->setOrientation('landscape');
                $sheet->appendRow([
                    'Nombres',
                    'Correo',
                    'Cumpleaños',
                    'Activo',
                ]);

                foreach ($users as $user) {
                    $sheet->appendRow([
                        "{$user->name} {$user->lastname}",
                        $user->email,
                        $user->getBirthdayOrNull(),
                        $user->active ? 'Sí' : 'No',
                    ]);
                }
            });
        })
            ->download('xlsx');
    }
}
