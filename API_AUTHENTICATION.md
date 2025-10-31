# 🔐 API Authentication Guide

## Token-Based Authentication (Sanctum)

This API uses **stateless token-based authentication** (not sessions). This is proper REST architecture.

---

## Authentication Flow

### 1. Register New User

**Endpoint:** `POST /api/register`

**Request:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "device_name": "mobile" // optional
}
```

**Response (201):**
```json
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  },
  "token": "1|abc123def456..."
}
```

---

### 2. Login Existing User

**Endpoint:** `POST /api/login`

**Request:**
```json
{
  "email": "test@example.com",
  "password": "password",
  "device_name": "web" // optional
}
```

**Response (200):**
```json
{
  "user": {
    "id": 1,
    "name": "Test User",
    "email": "test@example.com"
  },
  "token": "2|xyz789abc123..."
}
```

---

### 3. Use Token for Authenticated Requests

Add the token to the `Authorization` header:

```bash
curl -X GET http://localhost:8000/api/events \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

**JavaScript Example:**
```javascript
fetch('http://localhost:8000/api/events', {
  headers: {
    'Authorization': `Bearer ${token}`,
    'Accept': 'application/json',
    'Content-Type': 'application/json'
  }
})
```

---

### 4. Logout (Revoke Token)

**Endpoint:** `POST /api/logout`

**Headers:**
```
Authorization: Bearer YOUR_TOKEN
```

**Response (200):**
```json
{
  "message": "Token revoked successfully"
}
```

> **Note:** This revokes only the current token. Client should delete the stored token.

---

### 5. Logout All Devices

**Endpoint:** `POST /api/logout-all`

**Headers:**
```
Authorization: Bearer YOUR_TOKEN
```

**Response (200):**
```json
{
  "message": "All tokens revoked successfully"
}
```

> **Note:** Revokes all tokens for the user (all devices).

---

## Key Differences from Session Auth

| Session-Based (Web)          | Token-Based (API)                    |
|------------------------------|--------------------------------------|
| Returns 204 (no content)     | Returns user + token                 |
| Uses cookies/sessions        | Uses Authorization header            |
| Stateful (server stores)     | Stateless (client stores token)      |
| CSRF protection required     | No CSRF needed                       |
| Logout destroys session      | Logout revokes token                 |
| Not suitable for mobile/SPA  | Perfect for mobile/SPA/microservices |

---

## Testing with cURL

### Register
```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

### Login
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password"
  }'
```

### Get Current User
```bash
TOKEN="your-token-here"
curl -X GET http://localhost:8000/api/user \
  -H "Authorization: Bearer $TOKEN" \
  -H "Accept: application/json"
```

### Create Event (Authenticated)
```bash
TOKEN="your-token-here"
curl -X POST http://localhost:8000/api/events \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "Laravel Conference 2025",
    "description": "Annual conference",
    "start_time": "2025-12-01 09:00:00",
    "end_time": "2025-12-01 17:00:00"
  }'
```

---

## Security Best Practices

1. **Store tokens securely**
   - Web: Use httpOnly cookies or sessionStorage (NOT localStorage for sensitive apps)
   - Mobile: Use secure storage (Keychain/Keystore)

2. **Token lifetime**
   - Tokens don't expire by default in Sanctum
   - Configure expiration in `config/sanctum.php` if needed

3. **HTTPS only**
   - Always use HTTPS in production
   - Tokens in plain HTTP can be intercepted

4. **Revoke compromised tokens**
   - Use `/api/logout-all` if account is compromised
   - Tokens are stored in `personal_access_tokens` table

---

## Swagger UI Testing

1. Open: http://localhost:8000/api/documentation
2. Register or login to get a token
3. Click **"Authorize"** button (top right)
4. Enter: `Bearer YOUR_TOKEN`
5. Test all endpoints with the "Try it out" button

---

## Common Issues

**401 Unauthenticated**
- Token is missing or invalid
- Token format must be: `Bearer TOKEN` (note the space)
- Check `Authorization` header is set

**422 Validation Error**
- Check request body matches required fields
- Password must meet minimum requirements
- Email must be unique for registration

**419 CSRF Token Mismatch**
- Should NOT happen with API routes
- Make sure you're using `/api/*` routes, not web routes
