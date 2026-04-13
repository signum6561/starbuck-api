# Starbuck API

Laravel 11 REST API with JWT auth.

## Quick Start

```bash
# Build
docker build -t starbuck-api .

# Run
docker run -p 8080:8080 starbuck-api
```

## Endpoints

| Method | Endpoint | Auth |
|--------|----------|------|
| POST | /api/auth/register | No |
| POST | /api/auth/login | No |
| POST | /api/auth/logout | Yes |
| POST | /api/auth/refresh | Yes |
| GET | /api/auth/user | Yes |
| GET | /api/v1/customers | Yes |
| POST | /api/v1/customers | Yes |
| GET | /api/v1/customers/{id} | Yes |
| PUT | /api/v1/customers/{id} | Yes |
| DELETE | /api/v1/customers/{id} | Yes |
| GET | /api/v1/invoices | Yes |
| POST | /api/v1/invoices | Yes |
| GET | /api/v1/invoices/{id} | Yes |
| PUT | /api/v1/invoices/{id} | Yes |
| DELETE | /api/v1/invoices/{id} | Yes |

## Usage

```bash
# Register
curl -X POST http://localhost:8080/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{"name":"John","email":"john@example.com","password":"password123"}'

# Login
curl -X POST http://localhost:8080/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"john@example.com","password":"password123"}'

# Use token
curl -X GET http://localhost:8080/api/v1/customers \
  -H "Authorization: Bearer YOUR_TOKEN"
```

## Stack

- PHP 8.3
- Laravel 11
- SQLite
- JWT (tymon/jwt-auth)

## Local Dev

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```