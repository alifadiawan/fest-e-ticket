<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventModel;
use App\Models\RegistrationModel;
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
            ->where('events.status', '!=', 'deleted')
            ->leftJoin('tokens', 'tokens.event_id', '=', 'events.id')
            ->groupBy('events.id')
            ->take(5)
            ->get();

        $totalEvent = EventModel::count();
        $totalTokens = TokenModel::where('status', '=', 'used')->count();
        $totalUsers = User::count();

        return view('Dashboard.Overview', compact('events', 'totalEvent', 'totalTokens', 'totalUsers'));
    }

    public function analytics()
    {
        $topEvents = EventModel::select('events.id', 'events.name', 'events.status')
            ->withCount('registrations')
            ->where('status', '!=', 'deleted')
            ->orderByDesc('registrations_count')
            ->limit(5)
            ->get();

        $tokenUseByEvent = EventModel::select('events.name')
            ->join('tokens', 'tokens.event_id', '=', 'events.id')
            ->selectRaw('COUNT(tokens.id) as total_tokens, SUM(CASE WHEN tokens.status = "used" THEN 1 ELSE 0 END) as used_tokens')
            ->groupBy('events.id', 'events.name')
            ->orderByDesc('used_tokens')
            ->get();

        $uniqueUsers = RegistrationModel::distinct('user_id')->count('user_id');

        $totalTokens = TokenModel::count();
        $usedTokens = TokenModel::where('status', 'used')->count();
        $tokenUsageRate = $totalTokens > 0 ? round(($usedTokens / $totalTokens) * 100, 2) : 0;

        return view('Dashboard.Analytics', compact([
            'topEvents',
            'tokenUsageRate',
            'tokenUseByEvent',
            'uniqueUsers',
            'usedTokens',
            'totalTokens'
        ]));
    }

}
