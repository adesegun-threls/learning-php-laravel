# API Project Setup - TODO

## ⚠️ Once Network is Back, Run These Commands:

### 1. Install Sanctum (API Authentication)
```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

### 2. Remove Breeze Blade Views (We Don't Need HTML)
```bash
rm -rf resources/views/auth
rm -rf resources/views/profile
rm -rf resources/views/dashboard.blade.php
rm -rf resources/views/layouts
```

### 3. Keep Only API Routes
The important files for API:
- ✅ `routes/api.php` - Your API endpoints
- ✅ `routes/auth.php` - Auth API endpoints (login, register)
- ❌ `routes/web.php` - Can keep for docs/health checks

## 📦 What You Already Have:

- ✅ Laravel 12 installed
- ✅ Event and Attendee models
- ✅ Database migrations
- ✅ API controllers scaffolded (EventController, AttendeeController)
- ✅ User model ready
- ⚠️ Sanctum - NEEDS INSTALLATION

## 🎯 What to Implement Next:

1. **Add Model Relationships** (see API_GUIDE.md)
2. **Implement Event API endpoints** in EventController
3. **Implement Attendee API endpoints** in AttendeeController  
4. **Test with Postman or cURL**

## 🧪 Quick Test After Setup:

```bash
# Start server
composer dev

# In another terminal, test:
curl http://localhost:8000/api/user
# Should return 401 Unauthorized (good - it's protected!)
```

Check API_GUIDE.md for detailed implementation examples!
