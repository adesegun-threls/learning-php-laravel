# 🏭 Factories & Seeding Guide

## Overview
This project includes comprehensive factories for generating test data for Events and Attendees.

## Quick Start

### Reset Database and Seed
```bash
php artisan migrate:fresh --seed
```

This creates:
- **11 Users** (1 test user + 10 regular users)
- **23 Events** (3 by test user, 15 future events, 5 past events)
- **82 Attendees** (1-5 random attendees per event)

### Test User Credentials
```
Email: test@example.com
Password: password
```

## Using Factories in Tinker

### Basic Usage
```bash
php artisan tinker
```

```php
// Create a single event
$event = Event::factory()->create();

// Create 5 events
Event::factory()->count(5)->create();

// Create event for specific user
$user = User::find(1);
Event::factory()->create(['user_id' => $user->id]);

// Create attendee
Attendee::factory()->create([
    'user_id' => 1,
    'event_id' => 1
]);
```

## Event Factory States

### Past Events
```php
// Create events that already happened
Event::factory()->past()->create();
Event::factory()->past()->count(3)->create();
```

### Today's Events
```php
// Create events happening today
Event::factory()->today()->create();
```

### Events Without End Time
```php
// Create events without end_time
Event::factory()->withoutEndTime()->create();
```

### Combining States
```php
// Past event without end time
Event::factory()->past()->withoutEndTime()->create();
```

## Advanced Factory Usage

### Create Event with Attendees
```php
// Create event with 5 attendees
$event = Event::factory()
    ->has(Attendee::factory()->count(5))
    ->create();

// Or using relationships
$event = Event::factory()->create();
$users = User::factory()->count(3)->create();

foreach ($users as $user) {
    Attendee::factory()->create([
        'user_id' => $user->id,
        'event_id' => $event->id,
    ]);
}
```

### Create User with Events
```php
// Create user with 3 events
$user = User::factory()
    ->has(Event::factory()->count(3))
    ->create();
```

### Create Multiple Events with Custom Data
```php
Event::factory()
    ->count(5)
    ->create([
        'user_id' => 1,
        'name' => 'Laravel Workshop Series'
    ]);
```

## Using in Tests

### Feature Test Example
```php
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_event()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/events', [
                'name' => 'Test Event',
                'start_time' => now()->addDays(1),
            ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('events', [
            'name' => 'Test Event',
            'user_id' => $user->id,
        ]);
    }

    public function test_user_can_attend_event()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->postJson("/api/events/{$event->id}/attendees");

        $response->assertStatus(201);
        $this->assertDatabaseHas('attendees', [
            'user_id' => $user->id,
            'event_id' => $event->id,
        ]);
    }
}
```

## Custom Seeder

Create a custom seeder for specific scenarios:

```bash
php artisan make:seeder EventSeeder
```

**database/seeders/EventSeeder.php:**
```php
<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $organizer = User::factory()->create([
            'name' => 'Event Organizer',
            'email' => 'organizer@example.com',
        ]);

        // Create tech conferences
        Event::factory()->count(5)->create([
            'user_id' => $organizer->id,
            'name' => fn() => fake()->randomElement([
                'Laravel Conference 2025',
                'PHP Summit',
                'DevOps Meetup',
                'Cloud Computing Workshop',
                'AI & ML Symposium'
            ]),
        ]);

        // Create past webinars
        Event::factory()->past()->count(10)->create([
            'user_id' => $organizer->id,
        ]);
    }
}
```

Run it:
```bash
php artisan db:seed --class=EventSeeder
```

## Factory Methods Reference

### EventFactory
```php
definition()          // Default event (future, random user)
past()               // Event in the past (1 day to 6 months ago)
today()              // Event happening today
withoutEndTime()     // Event without end_time
```

### AttendeeFactory
```php
definition()          // Default attendee (random user & event)
```

## Useful Commands

```bash
# Reset and seed
php artisan migrate:fresh --seed

# Seed without resetting
php artisan db:seed

# Seed specific seeder
php artisan db:seed --class=EventSeeder

# Open tinker REPL
php artisan tinker

# Check database state
php artisan tinker
>>> User::count()
>>> Event::count()
>>> Attendee::count()
```

## Tips

1. **Use factories in tests** - Always use `RefreshDatabase` trait
2. **Prevent duplicates** - Check before creating attendees
3. **Realistic data** - Factories use Faker for realistic names, dates, etc.
4. **State methods** - Use `past()`, `today()` for specific scenarios
5. **Relationships** - Factories automatically create related models

## Example: Full Event Creation Flow

```php
// In tinker or seeder
$organizer = User::factory()->create([
    'name' => 'John Organizer',
    'email' => 'john@example.com',
]);

$event = Event::factory()->create([
    'user_id' => $organizer->id,
    'name' => 'Laravel 12 Release Party',
    'description' => 'Celebrating Laravel 12 with the community!',
    'start_time' => now()->addWeeks(2),
    'end_time' => now()->addWeeks(2)->addHours(4),
]);

$attendees = User::factory()->count(10)->create();

foreach ($attendees as $attendee) {
    Attendee::factory()->create([
        'user_id' => $attendee->id,
        'event_id' => $event->id,
    ]);
}

echo "Event created with {$event->attendees->count()} attendees!";
```

---

**Your database is now ready with realistic test data!** 🎉
