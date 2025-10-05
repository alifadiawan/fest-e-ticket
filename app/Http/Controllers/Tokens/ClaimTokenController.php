<?php

namespace App\Http\Controllers\Tokens;

use App\Http\Controllers\Controller;
use App\Models\TokenModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClaimTokenController extends Controller
{
    public function view(Request $request, $token)
    {
        // Ambil token & cek status 'used'
        $usertoken = TokenModel::where('token', '=',$token)->first();

        if (!$usertoken) {
            return view('Registration.Index', [
                'token' => $token,
                'error' => 'Token tidak ditemukan'
            ]);
        }

        if ($usertoken->status === 'used') {
            return view('Registration.Index', [
                'token' => $token,
                'error' => 'Token Sudah Pernah Digunakan'
            ]);
        }

        // Cek apakah H+10 dari start_date sudah lewat
        $now = Carbon::now();
        $startDatePlus10 = Carbon::parse($usertoken->start_date)->addDays(10);
        $endDatePlus10 = Carbon::parse($usertoken->end_date)->addDays(10);

        if ($now->greaterThan($startDatePlus10) || $now->greaterThan($endDatePlus10)) {
            return view('Registration.Index', [
                'token' => $token,
                'status' => 'passed'
            ]);
        }

        // Simpan token ke session
        session(['registration_token_custom' => $token]);

        return view('Registration.Index', compact('token'));
    }
}
