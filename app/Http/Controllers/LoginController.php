<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    }

    public function logout() {}
}
