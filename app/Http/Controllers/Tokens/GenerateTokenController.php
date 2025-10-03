<?php

namespace App\Http\Controllers\Tokens;

use App\Http\Controllers\Controller;
use App\Jobs\GenerateTokensJob;
use App\Models\TokenBatchModel;
use Illuminate\Http\Request;

class GenerateTokenController extends Controller
{
    public function generateTokens(Request $request, $eventid)
    {
        // Ambil jumlah token dari input, default 25000 kalau kosong
        $count = $request->input('count', 1000);

        // Ambil panjang token dari input, default 8
        $length = $request->input('length', 8);

        // Dispatch job ke queue
        GenerateTokensJob::dispatch($eventid, $count, $length);

        return redirect()->back()->with('loading', 'Token generation started in background.');
    }
}
