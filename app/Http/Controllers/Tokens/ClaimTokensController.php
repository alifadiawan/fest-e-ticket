<?php

namespace App\Http\Controllers\Tokens;

use App\Http\Controllers\Controller;
use App\Models\EventModel;
use App\Models\TokenModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ClaimTokensController extends Controller
{
    // public function submitClaim(Request $req)
    // {
    //     $event = EventModel::where('slug', $req->event)->firstOrFail();
    //     $code = strtoupper($req->code);

    //     return DB::transaction(function () use ($event, $code, $req) {
    //         $token = TokenModel::where('event_id', $event->id)
    //             ->where('code', $code)
    //             ->lockForUpdate()
    //             ->first();

    //         if (!$token || $token->status !== 'unused') {
    //             throw ValidationException::withMessages(['code' => 'Token invalid or already used.']);
    //         }

    //         $token->status = 'used';
    //         $token->used_at = now();
    //         $token->save();

    //         $registration = Registration::create([
    //             'event_id' => $event->id,
    //             'token_id' => $token->id,
    //             'data' => $req->except(['_token', 'code']),
    //         ]);

    //         // generate e-ticket (sync or queued)
    //         dispatch(new GenerateETicketJob($registration));

    //         return response()->json(['ok' => true, 'registration_id' => $registration->id]);
    //     });
    // }
}
