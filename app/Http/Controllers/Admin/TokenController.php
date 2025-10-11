<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventModel;
use App\Models\TokenModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function show(Request $request, $tokenID, $batch_id)
    {
        $search = $request->input('search');

        $tokendetail = TokenModel::with(['event', 'user:id,name,email'])
            ->where('batch_id', $batch_id)
            ->when($search, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('token', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(20)
            ->appends(['search' => $search]);


        return view('Tokens.Show', compact('tokendetail', 'search'));
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
            'custom_image' => $event->{'custom_ticket_pict'}
        ])->setPaper('a3', 'potrait'); // A3 size, landscape

        // File name
        $fileName = $event->slug . "-batch-{$batch_id}.pdf";

        return $pdf->download($fileName);
    }
}
