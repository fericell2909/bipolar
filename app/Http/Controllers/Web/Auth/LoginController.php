<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\SocialNetworkService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function showLoginForm()
    {
        return view('web.auth.login');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Function for login through the Social Network
     *
     * @param Request $request
     * @param SocialNetworkService $socialNetworkService
     * @return \Illuminate\Http\JsonResponse
     */
    public function facebookAuth(Request $request, SocialNetworkService $socialNetworkService)
    {
        $user = $request->input('user');
        $image = $request->input('image');

        if (empty($user['email'])) {
            return response()->json([
                'success' => false,
                'message' => "Your facebook account doesn't have an email",
            ]);
        }

        $user = $socialNetworkService->getOrCreateFromFacebook($user, $image);

        if (empty($user)) {
            return response()->json([
                'success' => true,
                'message' => "There is no user",
            ]);
        }

        \Auth::loginUsingId($user->id);

        return response()->json([
            'success' => true,
            'message' => "Auth ok",
        ]);
    }
}