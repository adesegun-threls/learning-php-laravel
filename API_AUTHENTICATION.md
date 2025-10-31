# 🔐 API Authentication Guide

## JWT Token-Based Authentication (Laravel Passport)

This API uses **JWT (JSON Web Token) authentication** via Laravel Passport. This provides true stateless, industry-standard OAuth2 authentication.

### What is JWT?

JWT tokens are self-contained, encoded strings with three parts:
- **Header**: Algorithm and token type
- **Payload**: Claims (user ID, expiration, etc.)
- **Signature**: Cryptographic signature for verification

**Example JWT:**
```
eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIwMTlhM2I...
```

**Key Benefits:**
- ✅ **Stateless** - No database lookup needed
- ✅ **Self-contained** - Includes user info in payload
- ✅ **Industry standard** - OAuth2 compliance
- ✅ **Expires automatically** - Built-in expiration
- ✅ **Can be decoded** - Read claims without server

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
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIwMTlhM..."
}
```

> **Note:** This is a real JWT token! It starts with `eyJ...` and contains encoded JSON.

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
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIwMTlhM..."
}
```

> **JWT Decoded Payload:**
> ```json
> {
>   "sub": "1",           // User ID
>   "aud": "...",         // Client ID
>   "iat": 1761933168,    // Issued at
>   "exp": 1793469168,    // Expires (1 year by default)
>   "scopes": []
> }
> ```

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

## Key Differences from Sanctum

| Sanctum (Database Tokens)   | Passport (JWT)                       |
|------------------------------|--------------------------------------|
| Token: `1\|abc123...`        | Token: `eyJ0eXAiOiJKV1Qi...`         |
| Stored in database           | Self-contained (no storage)          |
| Requires database lookup     | Stateless (no DB query)              |
| Manual expiration            | Auto-expires (configurable)          |
| Simple personal tokens       | Full OAuth2 server                   |
| Good for SPAs with cookies   | Perfect for mobile/API-first         |

---

## JWT Token Lifetime

- **Default:** 1 year (31,536,000 seconds)
- **Configure in:** `config/passport.php`
- **Refresh tokens:** Available for long-lived sessions

```php
// config/passport.php
'personal_access_client' => [
    'secret' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET'),
],

// Token expiration
'tokens_expire_in' => 365, // days
```

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

1. **Store JWT tokens securely**
   - Web: Use httpOnly cookies or sessionStorage
   - Mobile: Use secure storage (Keychain/Keystore)
   - NEVER store in localStorage for sensitive apps

2. **Token expiration**
   - Tokens expire automatically (default: 1 year)
   - Configure in `config/passport.php`
   - Use refresh tokens for long sessions

3. **HTTPS only in production**
   - Always use HTTPS
   - JWT tokens can be decoded by anyone (base64)
   - Signature prevents tampering, not reading

4. **Revoke compromised tokens**
   - Use `/api/logout-all` if account is compromised
   - Tokens stored in `oauth_access_tokens` table
   - Can manually revoke via database

5. **Validate on every request**
   - Passport validates signature automatically
   - Checks expiration on each request
   - Invalid tokens rejected immediately

---

## JWT Structure

A JWT token has 3 parts separated by dots:

```
header.payload.signature
```

**Example:**
```
eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9     ← Header (algorithm)
.
eyJhdWQiOiIwMTlhM2I1Yi0wMDM4...           ← Payload (claims)
.
v5CCBp9S2gg_YCfLxCveJVWS5fr0...           ← Signature (RSA-256)
```

You can decode the payload at [jwt.io](https://jwt.io) to see claims (but never trust unverified tokens!).

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
