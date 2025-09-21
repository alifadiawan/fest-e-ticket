<?php

namespace App\Jobs;

use App\Models\EventModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GenerateTokensJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $eventId;
    protected $count;
    protected $tokenLength;

    public function __construct($eventId, $count = 25000, $tokenLength = 8)
    {
        $this->eventId = $eventId;
        $this->count = $count;
        $this->tokenLength = $tokenLength;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $event = EventModel::findOrFail($this->eventId);
        $tokens = [];

        $batchId = Str::uuid(); // new batch UUID

        DB::table('token_batches')->insert([
            'id'        => $batchId,
            'event_id'  => $this->eventId,
            'count'     => $this->count,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        for ($i = 0; $i < $this->count; $i++) {
            $token = $this->generateUniqueToken($event->id, $this->tokenLength);

            $tokens[] = [
                'id'        => Str::uuid(),
                'event_id'  => $event->id,
                'token'     => $token,
                'batch_id'   => $batchId,
                'status'    => 'unused',
                'created_at' => now(),
            ];

            if (count($tokens) >= 1000) {
                DB::table('tokens')->insert($tokens);
                $tokens = [];
            }
        }

        if (!empty($tokens)) {
            DB::table('tokens')->insert($tokens);
        }
    }

    private function generateUniqueToken(string $eventId, int $length): string
    {
        $prefix = strtoupper(substr($eventId, 0, 3));

        do {
            $token = $prefix . strtoupper(Str::random($length - strlen($prefix)));
        } while (
            DB::table('tokens')->where('token', $token)->where('event_id', $eventId)->exists()
        );

        return $token;
    }
}
