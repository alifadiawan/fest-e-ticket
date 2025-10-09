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
            $registrationToken = session('registration_token_custom');
            if (!$registrationToken) {
                return back()->with('error', 'Token tidak ditemukan');
            }

            // Use stateless() for lighter auth (no session sync)
            $googleUser = Socialite::driver('google')->stateless()->user();

            $findUser = User::where('google_id', '=', $googleUser->getId())->first();
            $token = TokenModel::where('token', '=', $registrationToken)->first();

            if (!$token) {
                return back()->with('error', 'Token tidak valid.');
            }

            // ===============================
            // User Sudah ada
            // ===============================
            if ($findUser) {
                $alreadyRegistered = RegistrationModel::where('user_id', '=', $findUser->id)
                    ->where('event_id', '=', $token->event_id)
                    ->exists();

                if ($alreadyRegistered) {
                    return redirect()
                        ->route('tokens.redeem', $registrationToken)
                        ->with('error', 'You have already registered for this event.')
                        ->withInput();
                }

                if ($token->status !== 'used') {
                    $token->update([
                        'user_id' => $findUser->id,
                        'status' => 'used',
                        'used_at' => now(),
                    ]);
                }

                RegistrationModel::create([
                    'user_id' => $findUser->id,
                    'event_id' => $token->event_id,
                    'token_id' => $token->id,
                ]);

                return redirect()
                    ->route('tokens.success')
                    ->with('success', 'Login berhasil');
            }

            // ===============================
            // User Baru
            // ===============================
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
            Log::error('Google callback error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'registration_token' => $request->session()->get('registration_token_custom'),
            ]);

            return back()->with('error', 'Terjadi kesalahan saat login dengan Google.');
        }
    }



}
