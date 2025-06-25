<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomAuthController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->away('http://-foodpanda-app.test:83/public/sso-login?email=' . $request->email);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->away('http://-foodpanda-app.test:83/public/sso-logout');
    }

    public function ssoLogin(Request $request)
    {
        if (auth()->check()) {
            return redirect()->away('http://-foodpanda-app.test:83/public/sso-login');
        } else {
            return redirect(route('login'));
        }
    }

    public function ssoLogout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->away('http://-foodpanda-app.test:83/public/sso-logout');
    }
}
