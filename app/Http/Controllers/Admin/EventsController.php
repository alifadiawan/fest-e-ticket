<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventModel;
use App\Models\TokenBatchModel;
use App\Models\TokenModel;
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
            'status' => EventModel::DRAFT,
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
        $RegisteredUsers = 10;
        $TokenClaimed = TokenModel::where('status', '=', 'used')->count();

        return view('Events.Show', compact('event', 'TokenHistory', 'RegisteredUsers', 'TokenClaimed', 'TotalToken'));
    }

    public function update()
    {
    }
    public function delete()
    {
    }
}
