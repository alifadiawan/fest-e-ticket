<?php

namespace App\Services;

use App\Models\EventModel;
use App\Models\TokenModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GenerateTokenService
{
    // core function
    function generateUniqueToken(string $eventSlug, int $length = 8): string
    {
        $prefix = strtoupper(substr($eventSlug, 0, 3)); // first 3 letters of slug
        do {
            $token = $prefix . strtoupper(Str::random($length - strlen($prefix))); // total length = $length
        } while (TokenModel::where('token', $token)->where('event_id', function ($query) use ($eventSlug) {
            $query->select('id')->from('events')->where('slug', $eventSlug);
        })->exists());

        return $token;
    }

    // large scale
    function generateTokensForEvent(string $eventSlug, int $count = 25000, int $tokenLength = 8)
    {
        $event = EventModel::where('slug', $eventSlug)->firstOrFail();
        $tokens = [];

        for ($i = 0; $i < $count; $i++) {
            $tokens[] = [
                'id' => Str::uuid(),
                'event_id' => $event->id,
                'token' => $this->generateUniqueToken($eventSlug, $tokenLength),
                'status' => 'unused',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Optional: insert every 1000 tokens to reduce memory usage
            if (count($tokens) >= 1000) {
                DB::table('tokens')->insert($tokens);
                $tokens = [];
            }
        }

        // Insert remaining tokens
        if (!empty($tokens)) {
            DB::table('tokens')->insert($tokens);
        }

        return $count . ' tokens generated for event: ' . $eventSlug;
    }
}
