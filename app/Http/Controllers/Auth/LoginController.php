<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

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

        // Attempt Login
        if (Auth::attempt($data)) {
            $request->session()->regenerate();

            return redirect()->route('dashboard.overview');
        }

        return redirect()->back()->with('errors', 'Email / Password are wrong');
    }
}
