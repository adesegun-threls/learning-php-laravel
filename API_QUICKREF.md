# Laravel API Quick Reference 🚀

## ⚡ Common Commands

```bash
# Development
composer dev                    # Start all services (server, queue, logs, vite)
php artisan serve              # Just the server
php artisan tinker             # Interactive console

# Database
php artisan migrate            # Run migrations
php artisan migrate:fresh      # Drop all tables and re-run
php artisan db:seed            # Seed database

# Code Generation
php artisan make:controller Api/EventController --api    # API controller
php artisan make:model Event -mf                         # Model + migration + factory
php artisan make:request StoreEventRequest               # Form request validator
php artisan make:resource EventResource                  # API resource transformer

# Testing
composer test                  # Run tests
php artisan test --filter EventApiTest    # Run specific test
```

## 🔑 Authentication Flow

### 1. Register User
```bash
POST /api/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password",
    "password_confirmation": "password"
}

Response: { "token": "1|abc123...", "user": {...} }
```

### 2. Login
```bash
POST /api/login
Content-Type: application/json

{
    "email": "john@example.com",
    "password": "password"
}

Response: { "token": "2|xyz789...", "user": {...} }
```

### 3. Use Token
```bash
GET /api/events
Authorization: Bearer 2|xyz789...

Response: [ {...events...} ]
```

## 📋 RESTful API Patterns

### Standard Routes
```
GET    /api/events           → index()   - List all
POST   /api/events           → store()   - Create new
GET    /api/events/{id}      → show()    - Show one
PUT    /api/events/{id}      → update()  - Update
DELETE /api/events/{id}      → destroy() - Delete
```

### Nested Resources
```
GET    /api/events/{event}/attendees
POST   /api/events/{event}/attendees
DELETE /api/events/{event}/attendees/{attendee}
```

## 🎯 Controller Template

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
        return Event::with('user')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date',
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
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
        ]);

        $event->update($validated);
        
        return response()->json($event);
    }

    public function destroy(Event $event)
    {
        $event->delete();
        
        return response()->json(null, 204);
    }
}
```

## 🧪 Testing Template

```php
<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_list_events()
    {
        $user = User::factory()->create();
        Event::factory()->count(3)->create();

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/events');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_user_can_create_event()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/events', [
                'name' => 'Laravel Meetup',
                'start_time' => now()->addDays(7),
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'name', 'start_time']);

        $this->assertDatabaseHas('events', [
            'name' => 'Laravel Meetup',
            'user_id' => $user->id,
        ]);
    }
}
```

## 🔒 Middleware

```php
// In routes/api.php

// Public routes
Route::post('/register', [RegisterController::class, 'store']);
Route::post('/login', [LoginController::class, 'store']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn(Request $request) => $request->user());
    Route::apiResource('events', EventController::class);
    Route::apiResource('events.attendees', AttendeeController::class);
});
```

## 📊 Response Helpers

```php
// Success with data
return response()->json($data, 200);

// Created
return response()->json($data, 201);

// No content
return response()->json(null, 204);

// Validation error (automatic)
$request->validate([...]); // Returns 422 on failure

// Custom error
return response()->json([
    'message' => 'Not found',
], 404);

// With pagination
return Event::paginate(15);
```

## 🔍 Query Helpers

```php
// Eager loading (avoid N+1)
Event::with('user', 'attendees')->get();

// Filtering
Event::where('start_time', '>', now())->get();

// Pagination
Event::paginate(15);

// Search
Event::where('name', 'like', "%{$search}%")->get();

// Sorting
Event::orderBy('start_time', 'desc')->get();
```

## 📝 Validation Rules

```php
'name' => 'required|string|max:255',
'email' => 'required|email|unique:users',
'password' => 'required|min:8|confirmed',
'start_time' => 'required|date|after:now',
'end_time' => 'nullable|date|after:start_time',
'status' => 'in:active,cancelled,completed',
'user_id' => 'exists:users,id',
```

## 🎨 API Resources (Transform Data)

```php
// app/Http/Resources/EventResource.php
<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'start_time' => $this->start_time,
            'creator' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'attendees_count' => $this->attendees->count(),
        ];
    }
}

// Usage in controller
return EventResource::collection(Event::all());
return new EventResource($event);
```

## 🚨 Common HTTP Status Codes

- `200` - OK (successful GET, PUT, PATCH)
- `201` - Created (successful POST)
- `204` - No Content (successful DELETE)
- `400` - Bad Request
- `401` - Unauthorized (not authenticated)
- `403` - Forbidden (authenticated but no permission)
- `404` - Not Found
- `422` - Unprocessable Entity (validation failed)
- `500` - Internal Server Error

---

**See API_GUIDE.md for detailed explanations!**
