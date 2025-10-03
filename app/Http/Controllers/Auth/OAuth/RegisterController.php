<?php

namespace App\Http\Controllers\Auth\OAuth;

use App\Http\Controllers\Controller;
use App\Models\RegistrationModel;
use App\Models\TokenModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrasionView()
    {
        $googleData = session('google_data');

        if (!$googleData) {
            return redirect()->back()->with('error', 'Google session expired');
        }

        return view('Registration.Register', compact('googleData'));
    }
    public function storeUserFromGoogle(Request $request)
    {
        

        $data = $request->validate([
            'campus' => 'required|string|max:255',
            'no_telp' => 'required|max:255',
        ]);
        $tokenId = $request->input('token_id');

        $googleData = session('google_data');
        if (!$googleData) {
            return redirect()->back()->with('error', 'Google session expired');
        }

        // Buat user baru
        $user = User::create([
            'name' => $googleData['name'],
            'email' => $googleData['email'],
            'google_id' => $googleData['google_id'],
            'asal_kampus' => $request->campus,
            'no_telp' => $request->no_telp,
            'password' => encrypt(str()->random(16)),
        ]);

        // Update token (anggap token_id dikirim lewat hidden input)
        $token = TokenModel::where('token', '=', $tokenId)->first();
        $token->update([
            'user_id' => $user->id,
            'status' => 'used',
            'used_at' => now(),
        ]);

        // Tambah ke registrations
        RegistrationModel::create([
            'user_id' => $user->id,
            'event_id' => $token->event_id,
            'token_id' => $token->id,
        ]);

        Auth::login($user);
        session()->forget('google_data');

        return true;
        // return redirect()->route('')->with('success', 'E-Ticket claimed successfully!');
    }
}
