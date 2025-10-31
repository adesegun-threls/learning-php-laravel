# Copilot Instructions for Laravel Example App

## Project Overview

This is a **Laravel 12 API-first** learning project using **PHP 8.2+** with an event management domain. The application is a RESTful API where users create events and other users can attend them. **This is NOT a web application** - it returns JSON, not HTML views.

## Architecture & Domain Model

**Core Models** (`app/Models/`):

-   `User` - Laravel's built-in authentication user model
-   `Event` - Events created by users (has `user_id`, `name`, `description`, `start_time`, `end_time`)
-   `Attendee` - Junction table linking users to events they're attending (has `user_id`, `event_id`)

**Relationships**:

-   Events belong to a User (creator)
-   Attendees belong to both User and Event (many-to-many relationship)
-   Models use `foreignIdFor()` in migrations for type-safe foreign keys

**Key Pattern**: Models are minimal - Eloquent relationships should be defined in model classes (e.g., `Attendee::user()` exists, but `Event` and `User` need corresponding relationships added).

## Development Workflow

### Quick Start

Use the custom Composer scripts for streamlined development:

```bash
composer setup   # One-command setup: install deps, copy .env, generate key, migrate, build assets
composer dev     # Start ALL services concurrently: Laravel server + queue worker + Pail logs + Vite
composer test    # Clear config cache and run PHPUnit tests
```

### Individual Commands

-   `php artisan serve` - Laravel dev server (port 8000)
-   `npm run dev` - Vite dev server with hot module replacement
-   `php artisan migrate` - Run migrations
-   `php artisan tinker` - Interactive REPL for testing code

### Testing

-   Tests use **SQLite in-memory database** (see `phpunit.xml`)
-   Run with `php artisan test` or `./vendor/bin/phpunit`
-   Test files go in `tests/Feature/` (HTTP tests) or `tests/Unit/` (isolated logic)

## Project-Specific Conventions

### API-First Architecture

-   **All routes return JSON** - Use `routes/api.php` for endpoints (auto-prefixed with `/api`)
-   **Authentication**: Laravel Sanctum for API token-based auth (pending installation)
-   **Controllers**: Located in `app/Http/Controllers/Api/` namespace
-   **Testing**: Use `->postJson()`, `->getJson()` methods in feature tests
-   **No Blade views needed** for core functionality (API only)

### Controller Organization

Controllers use **namespace-based API versioning**: `app/Http/Controllers/Api/` for API controllers. Resource controllers (`EventController`, `AttendeeController`) are scaffolded with RESTful methods but not yet implemented.

**API Resource Controller Pattern:**

```php
index()    // GET    /api/events        - List all
store()    // POST   /api/events        - Create new
show($id)  // GET    /api/events/{id}   - Get one
update()   // PUT    /api/events/{id}   - Update
destroy()  // DELETE /api/events/{id}   - Delete
```

### Migration Patterns

-   Anonymous class syntax: `return new class extends Migration`
-   Use `foreignIdFor(ModelClass::class)` instead of manual foreign key definitions
-   Import model classes at top: `use App\Models\User;`
-   Timestamps enabled by default with `$table->timestamps()`

### Frontend Stack

-   **Tailwind CSS v4** with Vite plugin (`@tailwindcss/vite`)
-   Assets in `resources/css/app.css` and `resources/js/app.js`
-   Blade templates in `resources/views/` (currently just `welcome.blade.php`)
-   Vite config: `vite.config.js` with Laravel plugin and Tailwind integration

### Code Generation

When using `php artisan make:*` commands:

-   Controllers: Add to `app/Http/Controllers/Api/` for API routes
-   Models: Add relationships immediately (use `belongsTo`, `hasMany`, `belongsToMany`)
-   Migrations: Use `foreignIdFor()` and import model classes
-   Factories: Located in `database/factories/` (e.g., `UserFactory` exists)

## Critical Files

-   `composer.json` - Custom scripts (`setup`, `dev`, `test`) are defined here
-   `routes/api.php` - **Primary file** - All API endpoints go here
-   `routes/auth.php` - Authentication endpoints (register, login, logout)
-   `routes/web.php` - Minimal, can be used for health checks or API docs
-   `database/migrations/` - Schema definitions (Events and Attendees tables created Oct 31, 2025)
-   `API_GUIDE.md` - Comprehensive guide for API development patterns
-   `SETUP_TODO.md` - Pending setup tasks (Sanctum installation)

## What's Missing (Learning Project Status)

This is an **early-stage learning project**. When implementing features:

-   **Sanctum not installed yet** - Requires network connectivity (see SETUP_TODO.md)
-   Controllers are scaffolded but empty
-   Models lack complete relationship definitions
-   No validation rules defined
-   No request/resource classes for API responses
-   No API resource transformers

When adding features, follow Laravel conventions for resource APIs, request validation, and API resource transformers.
