<?php

namespace Database\Seeders;

use App\Models\Attendee;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // Create some additional users first
        $users = User::factory(5)->create();

        // Get all users including the admin
        $allUsers = User::all();

        // Create events with realistic data
        $events = [
            [
                'name' => 'Laravel Conference 2026',
                'description' => 'Join us for the biggest Laravel conference of the year! Learn about the latest features, best practices, and network with fellow developers.',
                'start_time' => now()->addDays(30),
                'end_time' => now()->addDays(30)->addHours(8),
            ],
            [
                'name' => 'PHP User Group Meetup',
                'description' => 'Monthly meetup for PHP enthusiasts. This month: Exploring Modern PHP Features.',
                'start_time' => now()->addDays(15),
                'end_time' => now()->addDays(15)->addHours(3),
            ],
            [
                'name' => 'Web Development Workshop',
                'description' => 'Hands-on workshop covering frontend and backend development with Laravel and Vue.js.',
                'start_time' => now()->addDays(7),
                'end_time' => now()->addDays(7)->addHours(6),
            ],
            [
                'name' => 'API Design Best Practices',
                'description' => 'Learn how to design scalable and maintainable RESTful APIs using Laravel.',
                'start_time' => now()->addDays(45),
                'end_time' => now()->addDays(45)->addHours(4),
            ],
            [
                'name' => 'Database Optimization Seminar',
                'description' => 'Deep dive into database performance tuning, query optimization, and indexing strategies.',
                'start_time' => now()->addDays(60),
                'end_time' => now()->addDays(60)->addHours(5),
            ],
            [
                'name' => 'Testing in Laravel Workshop',
                'description' => 'Master PHPUnit, Pest, and feature testing in Laravel applications.',
                'start_time' => now()->addDays(20),
                'end_time' => now()->addDays(20)->addHours(4),
            ],
            [
                'name' => 'Microservices Architecture Talk',
                'description' => 'Learn how to build and maintain microservices using Laravel and Docker.',
                'start_time' => now()->addDays(90),
                'end_time' => now()->addDays(90)->addHours(3),
            ],
            [
                'name' => 'Career Development for Developers',
                'description' => 'Tips and strategies for advancing your career in software development.',
                'start_time' => now()->addDays(10),
                'end_time' => now()->addDays(10)->addHours(2),
            ],
        ];

        foreach ($events as $eventData) {
            // Randomly assign event to a user
            $user = $allUsers->random();

            $event = Event::create([
                ...$eventData,
                'user_id' => $user->id,
            ]);

            // Add random attendees (2-4 attendees per event)
            $attendeeCount = rand(2, 4);
            $attendees = $allUsers->random($attendeeCount);

            foreach ($attendees as $attendee) {
                Attendee::create([
                    'event_id' => $event->id,
                    'user_id' => $attendee->id,
                ]);
            }
        }

        $this->command->info('Created ' . count($events) . ' events with attendees!');
    }
}
