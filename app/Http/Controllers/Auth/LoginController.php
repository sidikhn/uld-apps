<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // file blade login kamu
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'ends_with:@mail.ugm.ac.id'],
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            // langsung redirect ke halaman utama/dashboard tanpa cek role
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Login gagal, periksa email dan password.',
        ]);
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
