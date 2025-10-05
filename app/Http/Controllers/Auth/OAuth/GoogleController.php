<?php

namespace App\Http\Controllers\Auth\OAuth;

use App\Http\Controllers\Controller;
use App\Models\RegistrationModel;
use App\Models\TokenModel;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
            // Ambil token dari session
            $registrationToken = session('registration_token_custom');
            if (!$registrationToken) {
                return redirect()->back()->with('error', 'Token tidak ditemukan');
            }

            $googleUser = Socialite::driver('google')->user();

            // Cek apakah user sudah terdaftar
            $findUser = User::where('google_id', $googleUser->getId())->first();

            if ($findUser) {
                // Update token
                $token = TokenModel::where('token', $registrationToken)->firstOrFail();
                $token->update([
                    'user_id' => $findUser->id,
                    'status' => 'used',
                    'used_at' => now(),
                ]);

                // Buat registration
                RegistrationModel::create([
                    'user_id' => $findUser->id,
                    'event_id' => $token->event_id,
                    'token_id' => $token->id,
                ]);

                return redirect()->route('tokens.success')->with('success', 'Login berhasil');
            }

            // Store Google data di session untuk registrasi baru
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
            Log::error('Google callback error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat login dengan Google.');
        }
    }


}
