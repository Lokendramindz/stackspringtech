<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function form() { return Auth::check() ? redirect()->route('admin') : view('admin.login'); }

    public function login(Request $r)
    {
        $c = $r->validate(['email' => 'required|email', 'password' => 'required']);
        if (Auth::attempt($c, $r->boolean('remember'))) {
            $r->session()->regenerate();
            return redirect()->intended(route('admin'));
        }
        return back()->withErrors(['email' => 'Invalid credentials.'])->onlyInput('email');
    }

    public function logout(Request $r)
    {
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();
        return redirect()->route('home');
    }
}
