<?php

namespace Database\Seeders;

use App\Models\Attendee;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user with specific credentials
        $testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create additional regular users
        $users = User::factory(10)->create();

        // Create events - some by test user, some by random users
        $testUserEvents = Event::factory(3)->create([
            'user_id' => $testUser->id,
        ]);

        $otherEvents = Event::factory(15)->create([
            'user_id' => fake()->randomElement($users)->id,
        ]);

        // Create some past events
        $pastEvents = Event::factory(5)->past()->create([
            'user_id' => fake()->randomElement($users)->id,
        ]);

        // Merge all events
        $allEvents = $testUserEvents->concat($otherEvents)->concat($pastEvents);

        // Create attendees - each event gets 1-5 random attendees
        foreach ($allEvents as $event) {
            $numberOfAttendees = fake()->numberBetween(1, 5);
            $randomUsers = $users->random(min($numberOfAttendees, $users->count()));

            foreach ($randomUsers as $user) {
                // Prevent duplicate attendees for the same event
                if (!Attendee::where('event_id', $event->id)
                    ->where('user_id', $user->id)
                    ->exists()) {
                    Attendee::factory()->create([
                        'user_id' => $user->id,
                        'event_id' => $event->id,
                    ]);
                }
            }
        }

        // Add test user as attendee to some events they didn't create
        $eventsToAttend = $otherEvents->random(min(3, $otherEvents->count()));
        foreach ($eventsToAttend as $event) {
            if (!Attendee::where('event_id', $event->id)
                ->where('user_id', $testUser->id)
                ->exists()) {
                Attendee::factory()->create([
                    'user_id' => $testUser->id,
                    'event_id' => $event->id,
                ]);
            }
        }

        // Seed Page Builder data
        $this->call([
            PageBuilderSeeder::class,
            TemplateSeeder::class,
        ]);

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info("📧 Test User: test@example.com | Password: password");
        $this->command->info("👥 Users: " . User::count());
        $this->command->info("📅 Events: " . Event::count());
        $this->command->info("🎟️  Attendees: " . Attendee::count());
    }
}
