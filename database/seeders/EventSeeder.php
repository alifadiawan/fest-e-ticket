<?php

namespace Database\Seeders;

use App\Jobs\GenerateTokensJob;
use App\Models\EventModel;
use App\Models\RegistrationModel;
use App\Models\TokenBatchModel;
use App\Models\TokenModel;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $cities = ['Jakarta', 'Bandung', 'Semarang', 'Yogyakarta', 'Surabaya'];

        foreach ($cities as $city) {
            // --- Create event ---
            $event = EventModel::create([
                'id' => Str::uuid(),
                'name' => "Futurepreneursummit {$city} 2025",
                'location' => $city,
                'slug' => Str::slug("futurepreneursummit-{$city}-2025"),
                'start_date' => Carbon::parse("2025-07-01")->addDays(rand(0, 30)),
                'end_date' => Carbon::parse("2025-07-02")->addDays(rand(0, 30)),
                'status' => 'published',
                'description' => $faker->paragraph(),
            ]);

            // --- Create several batches ---
            $numBatches = rand(2, 4);

            for ($b = 0; $b < $numBatches; $b++) {
                $count = rand(200, 4000);

                $batch = TokenBatchModel::create([
                    'id' => Str::uuid(),
                    'event_id' => $event->id,
                    'count' => $count,
                ]);

                // 🔹 Generate tokens asynchronously (via job)
                dispatch(new GenerateTokensJob($event->id, $count, 8));

                $this->command->info("🚀 [{$event->name}] Batch {$b} queued to generate {$count} tokens...");

                // 🔹 Wait until tokens are generated before random registration
                // (if you're using sync queue, they'll be generated instantly)
                if (config('queue.default') === 'sync') {
                    $this->registerRandomParticipants($event, $batch, $count, $faker);
                }
            }

            $this->command->info("✅ Event {$event->name} seeded successfully with {$numBatches} batches!");
        }

        $this->command->info('🎉 All events seeded. Tokens generation queued.');
    }

    /**
     * Register 5–15% of tokens as random participants.
     */
    private function registerRandomParticipants($event, $batch, $count, $faker)
    {
        $usedTokens = TokenModel::where('batch_id', $batch->id)
            ->inRandomOrder()
            ->take(intval($count * rand(5, 15) / 100))
            ->get();

        foreach ($usedTokens as $token) {
            $user = User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'password' => bcrypt('password'),
            ]);

            $token->update([
                'status' => 'used',
                'user_id' => $user->id,
                'used_at' => now(),
            ]);

            RegistrationModel::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'token_id' => $token->id,
                'ticket_path' => "tickets/{$event->slug}/" . Str::random(10) . ".pdf",
                'certificate_path' => null,
            ]);
        }

        $this->command->info("👥 Registered random participants for batch {$batch->id} ({$event->name})");
    }
}
