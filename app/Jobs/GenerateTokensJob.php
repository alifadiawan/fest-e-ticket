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
        $batchId = Str::uuid();

        DB::transaction(function () use ($event, $batchId) {

            // token batch
            DB::insert(
                'INSERT INTO token_batches (id, event_id, count, created_at) VALUES (?, ?, ?, ?)',
                [$batchId, $event->id, $this->count, now()]
            );

            // check existing tokens for this event
            $existingTokens = DB::select(
                'SELECT token FROM tokens WHERE event_id = ?',
                [$event->id]
            );
            $existingSet = array_flip(array_column($existingTokens, 'token'));

            // Generate tokens
            $tokens = [];
            $tokensSet = [];
            $randomLen = $this->tokenLength;

            // Generate with small buffer for collision safety
            $targetCount = $this->count;
            $generateCount = (int) ceil($targetCount * 1.05); // 5% buffer

            while (count($tokens) < $targetCount) {
                $needed = $generateCount - count($tokens);

                for ($i = 0; $i < $needed; $i++) {
                    $token = strtoupper(Str::random($randomLen));

                    // O(1) uniqueness check
                    if (!isset($existingSet[$token]) && !isset($tokensSet[$token])) {
                        $tokens[] = $token;
                        $tokensSet[$token] = true;

                        if (count($tokens) >= $targetCount) {
                            break 2; // Exit both loops
                        }
                    }
                }

                // Safety check - should rarely hit this
                if ($needed > $targetCount * 5) {
                    throw new \RuntimeException(
                        "Token generation inefficient. Increase token length from {$this->tokenLength}"
                    );
                }
            }

            // Single-query batch insert - optimal for 200-8000 tokens
            $now = now();
            $values = [];
            $bindings = [];

            foreach ($tokens as $token) {
                $values[] = '(?, ?, ?, ?, ?, ?)';
                $bindings[] = Str::uuid();
                $bindings[] = $event->id;
                $bindings[] = $token;
                $bindings[] = $batchId;
                $bindings[] = 'unused';
                $bindings[] = $now;
            }

            $valuesStr = implode(', ', $values);

            // Execute single INSERT with all tokens
            DB::insert(
                "INSERT INTO tokens (id, event_id, token, batch_id, status, created_at) 
             VALUES {$valuesStr}",
                $bindings
            );
        });
    }

    private function generateToken(string $eventId, int $length): string
    {
        $prefix = strtoupper(substr($eventId, 0, 3));
        return $prefix . strtoupper(Str::random($length - strlen($prefix)));
    }
}
