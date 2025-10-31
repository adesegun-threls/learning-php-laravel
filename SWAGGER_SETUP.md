# 📝 L5-Swagger Implementation Guide

## Installation (Run when network is available)

```bash
composer require darkaonline/l5-swagger
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
```

## Configuration

After installation, the config file will be at `config/l5-swagger.php`.

### Key Settings to Update:

**config/l5-swagger.php:**
```php
'api' => [
    'title' => 'Event Management API',
],

'routes' => [
    'api' => 'api/documentation',  // Access at: /api/documentation
],

'paths' => [
    'annotations' => [
        base_path('app/Http/Controllers'),
        base_path('app/Models'),
    ],
],

'securityDefinitions' => [
    'sanctum' => [
        'type' => 'apiKey',
        'description' => 'Enter token in format: Bearer <token>',
        'name' => 'Authorization',
        'in' => 'header',
    ],
],
```

## Generate Documentation

```bash
# Generate OpenAPI documentation
php artisan l5-swagger:generate

# View at: http://localhost:8000/api/documentation
```

## Quick Test

Once installed:

1. Start server: `composer dev`
2. Visit: `http://localhost:8000/api/documentation`
3. Click "Authorize" button
4. Enter: `Bearer YOUR_TOKEN`
5. Test endpoints directly from UI!

---

**See the example annotations in your controllers for how to document endpoints.**
