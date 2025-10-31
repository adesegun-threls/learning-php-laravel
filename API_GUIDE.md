# Laravel API Development Guide

## 🏗️ API Architecture Overview

This project is an **API-first Laravel application** for event management. Here's how it works:

### **1. Authentication Flow (Sanctum)**

**What is Sanctum?**
- Laravel's official package for API authentication
- Issues API tokens to users after login
- Tokens are sent with each request in the `Authorization` header

**How it works:**
```
1. User registers → POST /register → Get token
2. User logs in → POST /login → Get token  
3. Use token → Authorization: Bearer {token}
4. Access protected endpoints
```

### **2. API Routes Structure**

**File: `routes/api.php`**
- All API routes automatically prefixed with `/api`
- Example: Route defined as `/events` becomes `/api/events`

**Protected Routes:**
```php
// Requires authentication
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Your event management endpoints will go here
    Route::apiResource('events', EventController::class);
    Route::apiResource('events.attendees', AttendeeController::class);
});
```

**Public Routes:**
```php
// No authentication needed
Route::post('/register', [RegisterController::class, 'store']);
Route::post('/login', [LoginController::class, 'store']);
```

### **3. Controllers for APIs**

**API Resource Controllers** have these methods:
- `index()` - GET /api/events (list all)
- `store()` - POST /api/events (create)
- `show($id)` - GET /api/events/{id} (get one)
- `update($id)` - PUT/PATCH /api/events/{id} (update)
- `destroy($id)` - DELETE /api/events/{id} (delete)

**Example API Controller:**
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
        // Return all events as JSON
        return Event::with('user')->get();
    }

    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after:start_time',
        ]);

        // Create event for authenticated user
        $event = $request->user()->events()->create($validated);

        // Return JSON response
        return response()->json($event, 201);
    }

    public function show(Event $event)
    {
        // Return single event with relationships
        return $event->load('user', 'attendees');
    }

    public function update(Request $request, Event $event)
    {
        // Authorize: only event creator can update
        $this->authorize('update', $event);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'sometimes|date',
            'end_time' => 'nullable|date|after:start_time',
        ]);

        $event->update($validated);

        return response()->json($event);
    }

    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);
        
        $event->delete();

        return response()->json(null, 204);
    }
}
```

### **4. API Response Format**

**Success Response:**
```json
{
    "id": 1,
    "name": "Laravel Meetup",
    "description": "Monthly Laravel developers meetup",
    "start_time": "2025-11-15 18:00:00",
    "end_time": "2025-11-15 21:00:00",
    "user_id": 1,
    "created_at": "2025-10-31T10:00:00.000000Z",
    "updated_at": "2025-10-31T10:00:00.000000Z"
}
```

**Error Response:**
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "name": ["The name field is required."],
        "start_time": ["The start time must be a valid date."]
    }
}
```

### **5. Model Relationships for API**

Add these to your models:

**Event.php:**
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = ['name', 'description', 'start_time', 'end_time'];

    // Event belongs to a creator (User)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Event has many attendees
    public function attendees(): HasMany
    {
        return $this->hasMany(Attendee::class);
    }
}
```

**User.php:**
```php
// Add these methods to User model

public function events(): HasMany
{
    return $this->hasMany(Event::class);
}

public function attendedEvents(): HasMany
{
    return $this->hasMany(Attendee::class);
}
```

### **6. Testing APIs**

**Using cURL:**
```bash
# Register
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{"name":"John Doe","email":"john@example.com","password":"password","password_confirmation":"password"}'

# Login (get token)
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"john@example.com","password":"password"}'

# Use token to access protected route
curl http://localhost:8000/api/user \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"

# Create event
curl -X POST http://localhost:8000/api/events \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{"name":"My Event","start_time":"2025-11-15 18:00:00"}'
```

**Using Postman or Insomnia:**
1. Create a POST request to `/api/login`
2. Get the token from response
3. Add header: `Authorization: Bearer {token}`
4. Make requests to protected endpoints

### **7. API Testing with PHPUnit**

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

    public function test_user_can_create_event()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/events', [
                'name' => 'Test Event',
                'start_time' => '2025-11-15 18:00:00',
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'name', 'start_time']);
    }

    public function test_guest_cannot_create_event()
    {
        $response = $this->postJson('/api/events', [
            'name' => 'Test Event',
            'start_time' => '2025-11-15 18:00:00',
        ]);

        $response->assertStatus(401); // Unauthorized
    }
}
```

## 📋 Next Steps (Once Network is Fixed)

1. **Install Sanctum:**
   ```bash
   composer require laravel/sanctum
   php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
   php artisan migrate
   ```

2. **Add relationships to models** (Event, User, Attendee)

3. **Implement API Resource Controllers**

4. **Add API routes in `routes/api.php`**

5. **Test with Postman or cURL**

## 🔑 Key Differences: Web vs API

| Aspect | Web App | API App |
|--------|---------|---------|
| **Returns** | HTML views | JSON data |
| **Auth** | Session cookies | API tokens (Sanctum) |
| **Routes** | `routes/web.php` | `routes/api.php` |
| **Validation** | Redirects with errors | JSON error responses |
| **Middleware** | `auth` | `auth:sanctum` |
| **URLs** | `/events` | `/api/events` |

## 🎯 Your Event Management API Endpoints

Once implemented, your API will have:

```
Authentication:
POST   /api/register
POST   /api/login
POST   /api/logout
GET    /api/user

Events:
GET    /api/events              (list all events)
POST   /api/events              (create event)
GET    /api/events/{id}         (show event)
PUT    /api/events/{id}         (update event)
DELETE /api/events/{id}         (delete event)

Attendees:
GET    /api/events/{id}/attendees       (list attendees)
POST   /api/events/{id}/attendees       (register attendance)
DELETE /api/events/{id}/attendees/{id}  (cancel attendance)
```

---

**Questions?** This guide covers the basics. As you implement, we'll dive deeper into each concept!
