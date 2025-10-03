<?php

namespace App\Http\Controllers\Tokens;

use App\Http\Controllers\Controller;
use App\Models\TokenModel;
use Illuminate\Http\Request;

class ClaimTokenController extends Controller
{
    public function view(Request $request, $token)
    {
        // cek apakah token sudah digunakan
        $usedToken = TokenModel::where('token', '=', $token)
            ->where('status', '=', 'used')
            ->first();

        if ($usedToken) {
            return view('Registration.Index', [
                'token' => $token,
                'error' => 'Token Sudah Pernah Digunakan'
            ]);
        }

        session(['registration_token_custom' => $token]);
        return view('Registration.Index', compact('token'));
    }
}
