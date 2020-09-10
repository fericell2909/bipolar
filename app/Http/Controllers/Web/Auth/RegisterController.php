<?php

namespace App\Http\Controllers\Web\Auth;

use App\Instances\CartBipolar;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'birthday' => 'nullable|date_format:Y-m-d',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name'     => $data['name'],
            'lastname' => $data['lastname'] ?? null,
            'email'    => $data['email'],
            'birthday' => $data['birthday'] ?? null,
            'password' => Hash::make($data['password']),
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $cartBeforeRegister = null;
        if (CartBipolar::getInstance()->count() > 0) {
            $cartBeforeRegister = CartBipolar::getInstance()->last();
        }

        $this->guard()->login($user);

        if (!is_null($cartBeforeRegister)) {
            CartBipolar::getInstance()->convertToUser($cartBeforeRegister, $user);
        }

        if ($request->session()->has('url.intended')) {
            return redirect($request->session()->get('url.intended'));
        }

        return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }
}
