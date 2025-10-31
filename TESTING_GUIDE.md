# 🧪 Testing Your Event Management API

## Setup

1. **Start the server:**
   ```bash
   composer dev
   # or just: php artisan serve
   ```

2. **Use any of these tools:**
   - **cURL** (command line)
   - **Postman** (GUI)
   - **Insomnia** (GUI)
   - **HTTPie** (command line, user-friendly)

## 📝 API Endpoints

### Base URL
```
http://localhost:8000/api
```

---

## 1️⃣ Authentication Flow

### Register a User
```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password",
    "password_confirmation": "password"
  }'
```

**Response:**
```json
{
  "token": "1|abcdef123456...",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  }
}
```

### Login
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password"
  }'
```

**Response:**
```json
{
  "token": "2|xyz789...",
  "user": { ... }
}
```

### ⚠️ Save Your Token!
Copy the token from the response and use it in all subsequent requests.

---

## 2️⃣ Event Management

### Get All Events
```bash
curl http://localhost:8000/api/events \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### Create an Event
```bash
curl -X POST http://localhost:8000/api/events \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Laravel Meetup",
    "description": "Monthly Laravel developers meetup",
    "start_time": "2025-11-15 18:00:00",
    "end_time": "2025-11-15 21:00:00"
  }'
```

**Response (201 Created):**
```json
{
  "id": 1,
  "name": "Laravel Meetup",
  "description": "Monthly Laravel developers meetup",
  "start_time": "2025-11-15T18:00:00.000000Z",
  "end_time": "2025-11-15T21:00:00.000000Z",
  "user_id": 1,
  "created_at": "2025-10-31T14:30:00.000000Z",
  "updated_at": "2025-10-31T14:30:00.000000Z",
  "user": {
    "id": 1,
    "name": "John Doe"
  }
}
```

### Get Single Event
```bash
curl http://localhost:8000/api/events/1 \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### Update an Event (only creator can update)
```bash
curl -X PUT http://localhost:8000/api/events/1 \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Laravel Meetup - Updated",
    "description": "New description"
  }'
```

### Delete an Event (only creator can delete)
```bash
curl -X DELETE http://localhost:8000/api/events/1 \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Response:** 204 No Content

---

## 3️⃣ Attendee Management

### Get Attendees for an Event
```bash
curl http://localhost:8000/api/events/1/attendees \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Response:**
```json
[
  {
    "id": 1,
    "user_id": 2,
    "event_id": 1,
    "created_at": "2025-10-31T14:35:00.000000Z",
    "user": {
      "id": 2,
      "name": "Jane Smith",
      "email": "jane@example.com"
    }
  }
]
```

### Register for an Event
```bash
curl -X POST http://localhost:8000/api/events/1/attendees \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json"
```

**Response (201 Created):**
```json
{
  "id": 1,
  "user_id": 2,
  "event_id": 1,
  "created_at": "2025-10-31T14:35:00.000000Z",
  "user": {
    "id": 2,
    "name": "Jane Smith",
    "email": "jane@example.com"
  }
}
```

### Cancel Attendance
```bash
curl -X DELETE http://localhost:8000/api/events/1/attendees/1 \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Response:** 204 No Content

---

## 🎯 Complete Testing Workflow

### Step 1: Register Two Users
```bash
# User 1 (Event Creator)
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{"name":"Alice","email":"alice@example.com","password":"password","password_confirmation":"password"}'

# User 2 (Attendee)
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{"name":"Bob","email":"bob@example.com","password":"password","password_confirmation":"password"}'
```

### Step 2: User 1 Creates Event
```bash
# Save Alice's token as TOKEN1
curl -X POST http://localhost:8000/api/events \
  -H "Authorization: Bearer TOKEN1" \
  -H "Content-Type: application/json" \
  -d '{"name":"PHP Conference","start_time":"2025-12-01 09:00:00"}'
```

### Step 3: User 2 Registers for Event
```bash
# Save Bob's token as TOKEN2
curl -X POST http://localhost:8000/api/events/1/attendees \
  -H "Authorization: Bearer TOKEN2" \
  -H "Content-Type: application/json"
```

### Step 4: Check Attendees
```bash
curl http://localhost:8000/api/events/1/attendees \
  -H "Authorization: Bearer TOKEN1"
```

---

## ❌ Error Responses

### 401 Unauthorized (No token)
```json
{
  "message": "Unauthenticated."
}
```

### 403 Forbidden (Not authorized)
```json
{
  "message": "You are not authorized to update this event."
}
```

### 422 Validation Error
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "name": ["The name field is required."],
    "start_time": ["The start time must be a date after now."]
  }
}
```

### 404 Not Found
```json
{
  "message": "No query results for model [App\\Models\\Event] 999"
}
```

---

## 🔧 Tips for Testing

### Using Environment Variables (bash/zsh)
```bash
# Save your token
export TOKEN="1|abcdef123456..."

# Use in requests
curl http://localhost:8000/api/events \
  -H "Authorization: Bearer $TOKEN"
```

### Using HTTPie (more readable)
```bash
# Install: brew install httpie

# Register
http POST :8000/api/register name="John Doe" email="john@example.com" password="password" password_confirmation="password"

# With token
http :8000/api/events Authorization:"Bearer TOKEN"

# Create event
http POST :8000/api/events Authorization:"Bearer TOKEN" name="Meetup" start_time="2025-11-15 18:00:00"
```

### Testing with Postman
1. Import collection or create requests manually
2. Set `Authorization` header: `Bearer YOUR_TOKEN`
3. Use environment variables for token storage
4. Create a collection for all endpoints

---

## 🧪 PHPUnit Tests

Run the test suite:
```bash
composer test
# or
php artisan test
```

See `tests/Feature/` for authentication tests that come with Breeze.

---

**Next:** Check out `API_GUIDE.md` for implementation details!
