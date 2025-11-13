<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function view()
    {
        return view('Auth.Login');
    }

    public function authenticate(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        // limit 5 request per 1 menit
        $throttleKey = Str::lower($request->input('email')) . '|' . $request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            return back()->withErrors([
                'email' => 'Too many login attempts. Please try again later.'
            ]);
        }

        // Attempt Login
        if (Auth::attempt($data)) {
            $request->session()->regenerate();

            return redirect()->route('dashboard.overview');
        }

        return redirect()->back()->with('errors', 'Email / Password are wrong');
    }
}
