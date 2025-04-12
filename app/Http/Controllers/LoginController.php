<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{

    protected $pattern = [
        'email' => 'required',
        'password' => 'required'
    ];

    protected $messenger = [
        'required' => ':attribute is requried'
    ];

    protected $customName = [
        'email' => 'Email',
        'password' => 'Password'
    ];

    public function loginForm()
    {
        return view('loginForm');
    }

    public function login(Request $request)
    {
        $this->validate($request, $this->pattern, $this->messenger, $this->customName);

        // success
        $credentials = $request->only(['email', 'password']);
        $remember_me = $request->has('remember_me') ? true : false;

        if (!Auth::attempt($credentials, $remember_me)) {
            $request->session()->put('error', 'Account is invalid');
            return redirect()->back();
        }

        $user = Auth::user();
        if ($user->status != 1) {
            $request->session()->put('error', 'Account is blocked');
            return redirect()->back();
        }

        $this->changeExpireCookieRemember();

        return redirect()->route('categories.index');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login_form');
    }

    protected function changeExpireCookieRemember()
    {
        $rememberTokenExpireMinutes = 1440;
        $rememberTokenName          = Auth::getRecallerName();
        $rememberCookie             = Auth::getCookieJar()->queued($rememberTokenName);
        if ($rememberCookie) {
            $cookieValue = $rememberCookie->getValue();
            \Cookie::queue($rememberTokenName, $cookieValue, $rememberTokenExpireMinutes);
        }
    }
}
