<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TokenModel;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function show($tokenID, $batch_id)
    {
        $tokendetail = TokenModel::with(['event', 'user'])
            ->where('batch_id', '=', $batch_id)
            ->paginate(20);


        return view('Tokens.Show', compact('tokendetail'));
    }
}
