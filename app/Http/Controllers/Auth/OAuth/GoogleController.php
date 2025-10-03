<?php

namespace App\Http\Controllers\Auth\OAuth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Throwable;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle(Request $request)
    {
        $token = $request->query('token');
        session(['registration_token_custom' => $token]);

       return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            // Get token from state parameter
            $registrationToken = session('registration_token_custom') ?? 'token not found';

            $googleUser = Socialite::driver('google')->user();

            if ($finduser = User::where('google_id', $googleUser->getId())->first()) {
                Auth::login($finduser);
                return redirect()->intended('home');
            }

            // Store Google data and token in session
            session([
                'google_data' => [
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'token' => $registrationToken,
                ],
            ]);

            return redirect()->route('google.register');

        } catch (\Throwable $e) {
            dd($e->getMessage(), $e->getTraceAsString());
        }
    }


}
