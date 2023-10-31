<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::user()) {
            // if ($user->level = '1') {
            //     return redirect()->intended('orderan');
            // } elseif ($user->level == '2') {
            //     return redirect()->intended('owner');
            // }

            return redirect()->intended('home');
        }

        return view('pages.login');
    }

    public function proses(Request $request)
    {
        $request->validate(
            [
                'username' => 'required',
                'password' => 'required',
            ],
            [
                'username.required' => 'Username tidak boleh kosong',
                'password.required' => 'Password Tidak Boleh Kosong',
            ]
        );

        $kredensial = $request->only('username', 'password');
        if (Auth::attempt($kredensial)) {
            $request->session()->regenerate();
            $user = Auth::user();
            // if ($user->level = '1') {
            //     return redirect()->intended('orderan');
            // } elseif ($user->level == '2') {
            //     return redirect()->intended('owner');
            // }

            if ($user) {
                return redirect()->intended('home');
            }

            return redirect()->intended('/');
        }

        return back()->with(['msg' => 'Username atau password salah!'])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
