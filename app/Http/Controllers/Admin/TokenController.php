<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventModel;
use App\Models\TokenModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function show($tokenID, $batch_id)
    {
        $tokendetail = TokenModel::with(['event', 'user:id,name'])
            ->where('batch_id', '=', $batch_id)
            ->paginate(20);

        return view('Tokens.Show', compact('tokendetail'));
    }

    public function download($event_id, $batch_id)
    {
        $event = EventModel::findOrFail($event_id);

        // Get all tokens for this batch
        $tokens = TokenModel::where('event_id', $event_id)
            ->where('batch_id', $batch_id)
            ->get();

        // Generate PDF
        $pdf = Pdf::loadView('TokensPageA3', [
            'event' => $event,
            'tokens' => $tokens,
            'custom_image' => $event->{'custom-ticket-pict'}
        ])->setPaper('a3', 'potrait'); // A3 size, landscape

        // File name
        $fileName = $event->slug . "-batch-{$batch_id}.pdf";

        return $pdf->download($fileName);
    }
}
