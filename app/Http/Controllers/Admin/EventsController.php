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
            'location' => 'nullable',
            'custom_ticket_pict' => 'nullable',
            'status' => 'nullable',
        ]);

        if ($request->hasFile('custom_ticket_pict')) {
            $path = $request->file('custom_ticket_pict')->store('tickets', 'public');
            $data['custom_ticket_pict'] = $path;
        }

        $event = EventModel::create($data);

        return redirect()->route('events.index')->with('success', 'Event Created Successfully');
    }
    public function show(Request $request, $id)
    {
        $event = EventModel::find($id);
        $TokenHistory = TokenBatchModel::where('event_id', '=', $id)->latest()->get();

        // stats
        $TotalToken = TokenModel::where('event_id', '=', $id)->count();
        $RegisteredUsersCount = RegistrationModel::where('event_id', '=', $id)->count();
        $TokenClaimed = TokenModel::where('status', '=', 'used')
            ->where('event_id', '=', $id)->count();

        // search
        $search = $request->input('search');

        $RegisteredUsers = RegistrationModel::where('event_id', $id)
            ->with('user:id,name,email')
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(20)
            ->appends(['search' => $search]);

        return view('Events.Show', compact('event', 'TokenHistory', 'RegisteredUsersCount', 'TokenClaimed', 'TotalToken', 'RegisteredUsers', 'search'));
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
            'location' => 'nullable',
            'custom_ticket_pict' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'nullable|string',
        ]);

        // Handle file upload & Hapus file lama kalau ada
        if ($request->hasFile('custom_ticket_pict')) {
            if ($event->custom_ticket_pict && \Storage::disk('public')->exists($event->custom_ticket_pict)) {
                \Storage::disk('public')->delete($event->custom_ticket_pict);
            }

            $path = $request->file('custom_ticket_pict')->store('tickets', 'public');
            $data['custom_ticket_pict'] = $path;
        }

        $event->update($data);

        return redirect()->route('events.index')->with('success', 'Event Updated Successfully');
    }

    public function delete()
    {
    }
}
