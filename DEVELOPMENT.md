# 📚 Laravel Event Management API - Development Guide

Complete guide for developing with this Laravel 12 API project.

## Table of Contents
- [Quick Start](#quick-start)
- [API Testing](#api-testing)
- [Factories & Seeding](#factories--seeding)
- [Route Configuration](#route-configuration)
- [Common Commands](#common-commands)
- [Development Tips](#development-tips)

---

## Quick Start

### Setup
```bash
composer setup   # Install deps, copy .env, generate key, migrate, build assets
composer dev     # Start all services (server + queue + logs + vite)
composer test    # Run PHPUnit tests
```

### Test Credentials
```
Email: test@example.com
Password: password
```

### Database Seeding
```bash
php artisan migrate:fresh --seed
```
Creates: 11 users, 23 events, 82 attendees

---

## API Testing

### Authentication Flow

#### 1. Register
```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{"name":"John Doe","email":"john@example.com","password":"password","password_confirmation":"password"}'
```

#### 2. Login (Get Token)
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"password"}'
```

**Save the token from response!**

#### 3. Use Token
```bash
# Get authenticated user
curl http://localhost:8000/api/user \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### Event Endpoints

```bash
# List all events
curl http://localhost:8000/api/events \
  -H "Authorization: Bearer YOUR_TOKEN"

# Create event
curl -X POST http://localhost:8000/api/events \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"name":"Laravel Meetup","start_time":"2025-11-15 18:00:00","end_time":"2025-11-15 21:00:00"}'

# Get single event
curl http://localhost:8000/api/events/1 \
  -H "Authorization: Bearer YOUR_TOKEN"

# Update event (creator only)
curl -X PUT http://localhost:8000/api/events/1 \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"name":"Updated Event Name"}'

# Delete event (creator only)
curl -X DELETE http://localhost:8000/api/events/1 \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### Attendee Endpoints

```bash
# List attendees for event
curl http://localhost:8000/api/events/1/attendees \
  -H "Authorization: Bearer YOUR_TOKEN"

# Register for event
curl -X POST http://localhost:8000/api/events/1/attendees \
  -H "Authorization: Bearer YOUR_TOKEN"

# Cancel attendance
curl -X DELETE http://localhost:8000/api/events/1/attendees/1 \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### HTTP Status Codes
- `200` - OK (successful GET, PUT)
- `201` - Created (successful POST)
- `204` - No Content (successful DELETE)
- `401` - Unauthorized (not authenticated)
- `403` - Forbidden (not authorized)
- `404` - Not Found
- `422` - Validation Error

---

## Factories & Seeding

### Using Factories in Tinker
```bash
php artisan tinker
```

```php
// Create events
Event::factory()->create();
Event::factory()->count(5)->create();
Event::factory()->past()->create();
Event::factory()->today()->create();
Event::factory()->withoutEndTime()->create();

// Create event with attendees
$event = Event::factory()->create();
Attendee::factory()->count(5)->create(['event_id' => $event->id]);

// Create for specific user
Event::factory()->create(['user_id' => 1]);
```

### Factory States

**EventFactory:**
- `past()` - Events from 1 day to 6 months ago
- `today()` - Events happening today
- `withoutEndTime()` - Events without end_time

### Custom Seeding
```php
// In DatabaseSeeder or custom seeder
$organizer = User::factory()->create(['name' => 'Organizer']);
$event = Event::factory()->create(['user_id' => $organizer->id]);
$attendees = User::factory()->count(10)->create();

foreach ($attendees as $user) {
    Attendee::factory()->create([
        'user_id' => $user->id,
        'event_id' => $event->id,
    ]);
}
```

### Using in Tests
```php
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
    }
}
```

---

## Route Configuration

### Modern Laravel 11+ (No RouteServiceProvider)

Routes are configured in `bootstrap/app.php`:

```php
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',     // Auto-prefixed with /api
        apiPrefix: 'api/v1',                    // Optional: change prefix
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);
    })
```

### Custom Rate Limiting
```php
->withRouting(
    web: __DIR__.'/../routes/web.php',
    api: __DIR__.'/../routes/api.php',
    then: function () {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
)
```

### Additional Route Files
```php
->withRouting(
    web: __DIR__.'/../routes/web.php',
    api: __DIR__.'/../routes/api.php',
    then: function () {
        Route::middleware('api')
            ->prefix('v2')
            ->group(base_path('routes/api-v2.php'));
    }
)
```

### Migration from Laravel 10
| Laravel 10 | Laravel 11+ |
|------------|-------------|
| `RouteServiceProvider::boot()` | `bootstrap/app.php` `withRouting()` |
| `RouteServiceProvider::HOME` | `AppServiceProvider::HOME` |
| `configureRateLimiting()` | `withRouting(then: ...)` |

---

## Common Commands

### Development
```bash
composer dev              # Start all services
php artisan serve         # Just Laravel server
php artisan tinker        # Interactive REPL
```

### Database
```bash
php artisan migrate              # Run migrations
php artisan migrate:fresh        # Drop all tables and re-run
php artisan migrate:fresh --seed # Reset and seed
php artisan db:seed              # Run seeders only
```

### Code Generation
```bash
php artisan make:controller Api/EventController --api
php artisan make:model Event -mf          # Model + migration + factory
php artisan make:request StoreEventRequest
php artisan make:resource EventResource
php artisan make:test EventApiTest
php artisan make:seeder EventSeeder
```

### Routes & Debugging
```bash
php artisan route:list            # List all routes
php artisan route:list --path=api # Only API routes
php artisan cache:clear           # Clear cache
php artisan config:clear          # Clear config cache
```

### Testing
```bash
composer test                     # Run all tests
php artisan test                  # Run tests (same as above)
php artisan test --filter EventTest  # Run specific test
```

---

## Development Tips

### API Controller Pattern
```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return Event::with('user:id,name')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date|after:now',
        ]);

        $event = $request->user()->events()->create($validated);
        
        return response()->json($event, 201);
    }

    public function show(Event $event)
    {
        return $event->load('user', 'attendees');
    }

    public function update(Request $request, Event $event)
    {
        if ($event->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $event->update($request->validated());
        return response()->json($event);
    }

    public function destroy(Request $request, Event $event)
    {
        if ($event->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $event->delete();
        return response()->json(null, 204);
    }
}
```

### Validation Rules Reference
```php
'name' => 'required|string|max:255',
'email' => 'required|email|unique:users',
'password' => 'required|min:8|confirmed',
'start_time' => 'required|date|after:now',
'end_time' => 'nullable|date|after:start_time',
'status' => 'in:active,cancelled,completed',
'user_id' => 'exists:users,id',
```

### Query Optimization
```php
// Eager loading (avoid N+1)
Event::with('user', 'attendees')->get();

// Pagination
Event::paginate(15);

// Filtering
Event::where('start_time', '>', now())->get();

// Sorting
Event::orderBy('start_time', 'desc')->get();
```

### API Response Helpers
```php
// Success
return response()->json($data, 200);

// Created
return response()->json($data, 201);

// No content
return response()->json(null, 204);

// Error
return response()->json(['message' => 'Error'], 422);

// With pagination
return Event::paginate(15); // Auto-formats JSON
```

### Environment Variables
```bash
# Save token for easy testing
export TOKEN="1|your-token-here"

# Use in curl
curl http://localhost:8000/api/events \
  -H "Authorization: Bearer $TOKEN"
```

### Using HTTPie (Better than cURL)
```bash
# Install: brew install httpie

# Register
http POST :8000/api/register name="John" email="john@example.com" password="password" password_confirmation="password"

# With token
http :8000/api/events Authorization:"Bearer $TOKEN"
```

---

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   │       ├── EventController.php
│   │       └── AttendeeController.php
│   └── Middleware/
├── Models/
│   ├── User.php
│   ├── Event.php
│   └── Attendee.php
bootstrap/
├── app.php              # Route & middleware config (replaces RouteServiceProvider)
config/
database/
├── factories/
│   ├── UserFactory.php
│   ├── EventFactory.php
│   └── AttendeeFactory.php
├── migrations/
│   ├── create_users_table.php
│   ├── create_events_table.php
│   └── create_attendees_table.php
└── seeders/
    └── DatabaseSeeder.php
routes/
├── api.php              # API endpoints (prefixed with /api)
└── auth.php             # Authentication endpoints
tests/
├── Feature/
│   └── Auth/            # Auth tests from Breeze
└── Unit/
```

---

## Troubleshooting

### Common Issues

**401 Unauthorized**
- Missing or invalid token
- Token expired (Sanctum tokens don't expire by default)
- Wrong Authorization header format

**422 Validation Error**
- Check validation rules in controller
- Ensure all required fields are provided
- Check date formats (Y-m-d H:i:s)

**403 Forbidden**
- User doesn't own the resource
- Check authorization logic in controller

**Network/DNS Issues**
- Check internet connection
- Try: `ping repo.packagist.org`
- Use `composer install --no-scripts` if needed

---

## Additional Resources

- [Laravel 12 Documentation](https://laravel.com/docs/12.x)
- [Laravel Sanctum](https://laravel.com/docs/12.x/sanctum)
- [RESTful API Design](https://restfulapi.net/)
- [Postman](https://www.postman.com/) - API testing GUI
- [Insomnia](https://insomnia.rest/) - API testing GUI

---

**Happy Coding! 🚀**
