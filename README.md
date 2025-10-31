# Laravel Event Management API

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

A **RESTful API** built with **Laravel 12**, **Sanctum authentication**, and **PHP 8.2+** for managing events and attendees. This is a learning project demonstrating API-first development with modern Laravel.

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
