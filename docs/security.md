# Security

- Laravel owns routing, database access, session handling, CSRF-capable stateful requests, hashing, validation, and scheduler integration.
- Passwords use Laravel's hashed cast / Hash facade.
- Authentication is username/password only; email verification, OTP, and social login are intentionally absent.
- Sanctum supports first-party SPA session authentication without exposing raw long-lived custom tokens.
- File uploads must use Laravel validation for MIME type, size, and authorization before enabling public attachment uploads.
- Use HTTPS in production and set correct `SESSION_DOMAIN`, `SANCTUM_STATEFUL_DOMAINS`, and cookie secure settings.
