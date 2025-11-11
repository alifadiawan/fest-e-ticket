<?php

namespace App\Http\Controllers;

use App\Models\CertificateModel;
use App\Models\EventModel;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    public function create()
    {
        $event = DB::table('events')
            ->select('id', 'name')
            ->get();

        return view('Certificate.Create', compact('event'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'event_id' => 'required|exists:events,id',
            'certificate_name' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:jpeg,jpg,png|max:5000',
        ]);

        $id = Str::uuid()->toString();

        $path = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('certificates', 'public');
        }

        $certificate = CertificateModel::create([
            'id' => $id,
            'event_id' => $request->event_id,
            'certificate_name' => $request->certificate_name,
            'path' => $path,
            'storage_disk' => 'public',
        ]);

        return redirect()->route('events.show', $request->event_id)->with('success', 'certificate added !');
    }

    public function update()
    {
    }
    public function delete($event_id, $certificate_id)
    {
        $certificate = CertificateModel::where('id', '=',$certificate_id)
            ->where('event_id', $event_id)
            ->firstOrFail();

        if ($certificate->path && Storage::disk($certificate->storage_disk)->exists($certificate->path)) {
            Storage::disk($certificate->storage_disk)->delete($certificate->path);
        }

        $certificate->delete();

        return redirect()
            ->route('events.show', $event_id)
            ->with('success', 'Certificate deleted successfully!');
    }
    
    public function generate()
    {
    }
}
