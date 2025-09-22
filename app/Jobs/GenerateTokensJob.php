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
            // Buat record batch
            DB::table('token_batches')->insert([
                'id'        => $batchId,
                'event_id'  => $event->id,
                'count'     => $this->count,
                'created_at' => now(),
            ]);

            // Generate token unik di memory
            $tokens = collect();
            $prefix = strtoupper(substr($event->id, 0, 3));

            while ($tokens->count() < $this->count) {
                $needed = $this->count - $tokens->count();

                $newTokens = collect(range(1, $needed))->map(
                    fn() =>
                    $prefix . strtoupper(Str::random($this->tokenLength - strlen($prefix)))
                );

                $tokens = $tokens->merge($newTokens)->unique();
            }

            // Potong sesuai jumlah pasti
            $tokens = $tokens->take($this->count);

            // Batch insert
            foreach ($tokens->chunk(5000) as $chunk) {
                $rows = $chunk->map(fn($token) => [
                    'id'         => Str::uuid(),
                    'event_id'   => $event->id,
                    'token'      => $token,
                    'batch_id'   => $batchId,
                    'status'     => 'unused',
                    'created_at' => now(),
                ])->toArray();

                DB::table('tokens')->insert($rows);
            }
        });
    }

    private function generateToken(string $eventId, int $length): string
    {
        $prefix = strtoupper(substr($eventId, 0, 3));
        return $prefix . strtoupper(Str::random($length - strlen($prefix)));
    }
}
