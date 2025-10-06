<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventModel;
use App\Models\RegistrationModel;
use App\Models\TokenBatchModel;
use App\Models\TokenModel;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Http\Request;
use App\Services\TokenServices;

class EventsController extends Controller
{
    public function index()
    {
        $events = EventModel::paginate(10);

        return view('Events.Index', compact('events'));
    }

    public function create()
    {
        return view('Events.Create');
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'nullable|string',
            'end_date' => 'nullable|string',
            'created_by' => 'nullable',
            'custom-ticket-pict' => 'nullable',
            'status' => 'nullable',
        ]);

        if ($request->hasFile('custom-ticket-pict')) {
            $path = $request->file('custom-ticket-pict')->store('tickets', 'public');
            $data['custom-ticket-pict'] = $path;
        }

        $event = EventModel::create($data);

        return redirect()->route('events.index')->with('success', 'Event Created Successfully');
    }
    public function show($id)
    {
        $event = EventModel::find($id);
        $TokenHistory = TokenBatchModel::where('event_id', '=', $id)->latest()->get();

        $TotalToken = TokenModel::where('event_id', '=', $id)->count();
        $RegisteredUsers = RegistrationModel::where('event_id','=', $id)->count();
        $TokenClaimed = TokenModel::where('status', '=', 'used')->count();

        return view('Events.Show', compact('event', 'TokenHistory', 'RegisteredUsers', 'TokenClaimed', 'TotalToken'));
    }

    public function edit($id)
    {
        $event = EventModel::find($id);
        return view('Events.Edit', compact('event'));
    }
    public function update(Request $request, $id)
    {
        $event = EventModel::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'created_by' => 'nullable',
            'custom-ticket-pict' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'nullable|string',
        ]);

        // Handle file upload & Hapus file lama kalau ada
        if ($request->hasFile('custom-ticket-pict')) {
            if ($event->custom_ticket_pict && \Storage::disk('public')->exists($event->custom_ticket_pict)) {
                \Storage::disk('public')->delete($event->custom_ticket_pict);
            }

            $path = $request->file('custom-ticket-pict')->store('tickets', 'public');
            $data['custom_ticket_pict'] = $path;
        }

        $event->update($data);

        return redirect()->route('events.index')->with('success', 'Event Updated Successfully');
    }

    public function delete()
    {
    }
}
