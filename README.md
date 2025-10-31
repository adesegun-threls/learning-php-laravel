# Laravel Event Management API

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

A **RESTful API** built with **Laravel 12**, **Sanctum authentication**, and **PHP 8.2+** for managing events and attendees.

## 🚀 Quick Start

```bash
# One-command setup
composer setup

# Start development server
composer dev

# Run tests
composer test
```

**Test User:** `test@example.com` / `password`

## 📋 API Endpoints

### Authentication (Public - No token required)
- `POST /api/register` - Register new user (returns token)
- `POST /api/login` - Login user (returns token)

### Authentication (Protected - Requires token)
- `POST /api/logout` - Revoke current token
- `POST /api/logout-all` - Revoke all tokens
- `GET /api/user` - Get current user

### Events (Protected)
- `GET /api/events` - List all
- `POST /api/events` - Create
- `GET /api/events/{id}` - Show one
- `PUT /api/events/{id}` - Update (creator only)
- `DELETE /api/events/{id}` - Delete (creator only)

### Attendees (Protected)
- `GET /api/events/{id}/attendees` - List
- `POST /api/events/{id}/attendees` - Register
- `DELETE /api/events/{id}/attendees/{id}` - Cancel

**📖 API Documentation:** http://localhost:8000/api/documentation (Swagger UI)

## 🧪 Quick Test

```bash
# Start server
composer dev

# Register (get token)
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'

# Login (get token)
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"email":"test@example.com","password":"password"}'

# Use token for authenticated requests
curl http://localhost:8000/api/events \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

## 📚 Documentation

**[→ API Authentication Guide](API_AUTHENTICATION.md)** - Token-based auth explained  
**[→ Complete Development Guide](DEVELOPMENT.md)** - Everything you need

Key topics:
- Token-based authentication (stateless)
- API testing examples
- Factories & seeding
- Swagger/OpenAPI docs
- Development tips

## 🛠️ Tech Stack

- Laravel 12 + PHP 8.2
- Laravel Sanctum (Token-based API auth)
- SQLite (tests use in-memory)
- Vite + Tailwind CSS
- Swagger/OpenAPI documentation

## 📦 What's Included

✅ Stateless token-based authentication (proper REST)  
✅ RESTful API with Sanctum tokens  
✅ Event and Attendee management  
✅ Interactive Swagger API documentation  
✅ Comprehensive test data (23 events, 82 attendees)  
✅ API factories for testing  
✅ Complete API documentation  
✅ Git-ready with proper commits

## 🎓 Learning Resources

- [Laravel Docs](https://laravel.com/docs/12.x)
- [Sanctum Docs](https://laravel.com/docs/12.x/sanctum)
- [Complete Development Guide](DEVELOPMENT.md)

## 📝 License

MIT

## 🚀 Features

- ✅ **RESTful API** - JSON responses, no HTML views
- ✅ **Token-based Authentication** - Laravel Sanctum
- ✅ **Event Management** - Create, read, update, delete events
- ✅ **Attendee Management** - Register for events, view attendees
- ✅ **Authorization** - Only event creators can modify their events
- ✅ **Validation** - Input validation on all endpoints
- ✅ **Relationships** - Eloquent ORM with proper model relationships

## 📋 API Endpoints

### Authentication
```
POST   /api/register          - Register new user
POST   /api/login             - Login and get token
POST   /api/logout            - Logout (revoke token)
GET    /api/user              - Get authenticated user
```

### Events (Protected)
```
GET    /api/events            - List all events
POST   /api/events            - Create event
GET    /api/events/{id}       - Show event
PUT    /api/events/{id}       - Update event (creator only)
DELETE /api/events/{id}       - Delete event (creator only)
```

### Attendees (Protected)
```
GET    /api/events/{id}/attendees       - List attendees
POST   /api/events/{id}/attendees       - Register for event
DELETE /api/events/{id}/attendees/{id}  - Cancel attendance
```

## 🏃 Quick Start

## 🏃 Quick Start

### One Command Setup
```bash
composer setup
```
This will:
- Install dependencies
- Copy `.env.example` to `.env`
- Generate application key
- Run migrations
- Build frontend assets

### Start Development Server
```bash
composer dev
```
This starts:
- Laravel server (http://localhost:8000)
- Queue worker
- Log viewer (Pail)
- Vite dev server

### Test the API
```bash
# Register a user
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{"name":"Test User","email":"test@example.com","password":"password","password_confirmation":"password"}'

# Use the token from response to access protected endpoints
curl http://localhost:8000/api/events \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

## 📚 Documentation

- **[TESTING_GUIDE.md](TESTING_GUIDE.md)** - Complete testing guide with cURL examples
- **[API_GUIDE.md](API_GUIDE.md)** - Detailed API architecture and patterns
- **[API_QUICKREF.md](API_QUICKREF.md)** - Quick reference for common operations
- **[SETUP_TODO.md](SETUP_TODO.md)** - Setup checklist and next steps

## 🛠️ Tech Stack

- **Laravel 12** - PHP framework
- **Laravel Sanctum** - API authentication
- **Laravel Breeze** - Authentication scaffolding
- **PHP 8.2+** - Modern PHP features
- **SQLite** - Database (tests use in-memory)
- **Vite** - Asset bundling

## 📦 Project Structure

```
app/
├── Http/Controllers/Api/
│   ├── EventController.php      # Event CRUD operations
│   └── AttendeeController.php   # Attendee management
├── Models/
│   ├── User.php                 # User model with API tokens
│   ├── Event.php                # Event model
│   └── Attendee.php             # Attendee model
routes/
├── api.php                      # API endpoints (protected by Sanctum)
└── auth.php                     # Authentication endpoints
database/
└── migrations/
    ├── create_events_table.php
    └── create_attendees_table.php
```

## 🧪 Testing

Run the test suite:
```bash
composer test
```

Run tests with coverage:
```bash
php artisan test --coverage
```

## 🎓 Learning Resources

- [Laravel Documentation](https://laravel.com/docs/12.x)
- [Laravel Sanctum](https://laravel.com/docs/12.x/sanctum)
- [RESTful API Design](https://restfulapi.net/)
- [API Testing Guide](TESTING_GUIDE.md) - Comprehensive examples

## 🤝 Contributing

This is a learning project. Feel free to fork and experiment!

## 📝 License

This Laravel application is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
