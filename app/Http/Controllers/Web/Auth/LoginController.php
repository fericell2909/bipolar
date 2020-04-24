<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\SocialNetworkService;
use App\Instances\CartBipolar;
use App\Models\Cart;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm($loginRegister = 'login')
    {
        return view('web.auth.login-register', compact('loginRegister'));
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $sessionCartId = null;
        if (CartBipolar::getInstance()->count() > 0) {
            $sessionCartId = CartBipolar::getInstance()->id();
        }

        if ($this->attemptLogin($request)) {
            if (!is_null($sessionCartId)) {
                $this->convertOrDestroyCart($sessionCartId);
            }
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
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

        $sessionCartId = null;
        if (CartBipolar::getInstance()->count() > 0) {
            $sessionCartId = CartBipolar::getInstance()->id();
        }

        \Auth::loginUsingId($user->id);

        if (!is_null($sessionCartId)) {
            $this->convertOrDestroyCart($sessionCartId);
        }

        return response()->json([
            'success' => true,
            'message' => "Auth ok",
            'url'     => route('checkout'),
        ]);
    }

    private function convertOrDestroyCart($sessionCartId)
    {
        $userId = \Auth::id();
        $userCartExists = Cart::has('details')->whereUserId($userId)->exists();

        if ($userCartExists) {
            /** @var Cart $sessionCart */
           $sessionCart = Cart::findOrFail($sessionCartId);
           return $sessionCart->destroyCart();
        }

        $userCartId = $this->convertSessionCartToUserCart($sessionCartId);

        return $this->removeOtherCarts($userId, $userCartId);
    }

    private function convertSessionCartToUserCart($sessionCartId)
    {
        /** @var Cart $sessionCart */
        $sessionCart = Cart::findOrFail($sessionCartId);
        $sessionCart->user()->associate(\Auth::user());
        $sessionCart->session_id = null;
        $sessionCart->save();

        return $sessionCart->id;
    }

    private function removeOtherCarts($userId, $userCartId)
    {
        $carts = Cart::whereUserId($userId)->whereKeyNot($userCartId)->get();

        $carts->each(function ($cart) {
            /** @var Cart $cart */
            $cart->destroyCart();
        });
    }

    public function logout(Request $request)
    {
        CartBipolar::getInstance()->removeCoupon();

        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ? : redirect('/');
    }
}
