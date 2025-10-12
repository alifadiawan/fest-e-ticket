<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventModel;
use App\Models\TokenModel;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function overview()
    {
        $events = EventModel::select('events.*')
            ->selectRaw('COUNT(tokens.id) as total_tokens')
            ->selectRaw('SUM(CASE WHEN tokens.status = "used" THEN 1 ELSE 0 END) as claimed_tokens')
            ->leftJoin('tokens', 'tokens.event_id', '=', 'events.id')
            ->groupBy('events.id')
            ->take(5)
            ->get();

        $totalEvent = EventModel::count();
        $totalTokens = TokenModel::where('status', '=', 'used')->count();
        $totalUsers = User::count();

        return view('Dashboard.Overview', compact('events', 'totalEvent', 'totalTokens', 'totalUsers'));
    }

    public function analytics(){
        return view('Dashboard.Overview');
    }

}
