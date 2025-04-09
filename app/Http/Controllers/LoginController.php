<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function login_form()
    {
        return view('login_form');
    }

    public function login(Request $request)
    {
        $this->validate($request, $this->pattern, $this->messenger, $this->customName);

        // success
        $credentials = $request->only(['email', 'password']);
        $credentials['status'] = 1;

        if (!Auth::attempt($credentials)) {
            $request->session()->put('error', 'Sai thông tin đăng nhập');
            return redirect()->back();
        }

        return redirect()->route('categories.index');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login_form');
    }
}
