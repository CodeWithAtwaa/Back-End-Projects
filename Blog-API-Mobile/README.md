# Blog API

A Laravel 10 REST API for a simple blog system. The project includes authentication with Laravel Sanctum, blog posts with image uploads, categories, comments, subscribers, and contact messages.

## Features

- User registration, login, and logout
- Token-based authentication using Laravel Sanctum
- Create, read, update, and delete blog posts
- Upload blog images to public storage
- List categories
- Add and list comments
- Add and list subscribers
- Store contact messages
- JSON API responses with validation errors

## Requirements

- PHP 8.1 or higher
- Composer
- MySQL or another Laravel-supported database
- Laravel 10

## Installation

Clone the project and enter the project directory:

```bash
git clone <repository-url>
cd Blog-API
```

Install PHP dependencies:

```bash
composer install
```

Create the environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Configure your database in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blog_api
DB_USERNAME=root
DB_PASSWORD=
```

Run migrations and seeders:

```bash
php artisan migrate --seed
```

Create the public storage link for uploaded blog images:

```bash
php artisan storage:link
```

Start the local development server:

```bash
php artisan serve
```

The API will be available at:

```text
http://127.0.0.1:8000/api
```

## Authentication

Protected endpoints require a Bearer token.

Register a user:

```http
POST /api/register
```

JSON body:

```json
{
  "name": "Test User",
  "email": "test@example.com",
  "password": "password",
  "password_confirmation": "password"
}
```

Login:

```http
POST /api/login
```

JSON body:

```json
{
  "email": "test@example.com",
  "password": "password"
}
```

Copy the returned token and send it in protected requests:

```http
Authorization: Bearer YOUR_TOKEN_HERE
```

Logout:

```http
POST /api/logout
```

Requires authentication.

## API Endpoints

### Auth

| Method | Endpoint | Auth | Description |
| --- | --- | --- | --- |
| POST | `/api/register` | No | Register a new user |
| POST | `/api/login` | No | Login and create a token |
| POST | `/api/logout` | Yes | Delete user tokens |

### Blogs

| Method | Endpoint | Auth | Description |
| --- | --- | --- | --- |
| GET | `/api/blogs` | No | List blogs |
| GET | `/api/blogs/{blog}` | No | Show one blog |
| POST | `/api/blogs` | Yes | Create a blog |
| PUT | `/api/blogs/{blog}` | Yes | Update a blog |
| PATCH | `/api/blogs/{blog}` | Yes | Update a blog |
| DELETE | `/api/blogs/{blog}` | Yes | Delete a blog |

Create blog using Postman `form-data`:

| Key | Type | Required | Example |
| --- | --- | --- | --- |
| name | Text | Yes | `My First Blog` |
| description | Text | Yes | `This is a blog description.` |
| category_id | Text | Yes | `1` |
| image | File | Yes | Select an image |

Do not send blog image uploads as raw JSON. Use `Body -> form-data` in Postman and set the `image` field type to `File`.

### Categories

| Method | Endpoint | Auth | Description |
| --- | --- | --- | --- |
| GET | `/api/categories` | No | List categories |

### Comments

| Method | Endpoint | Auth | Description |
| --- | --- | --- | --- |
| GET | `/api/comments` | Yes | List comments |
| POST | `/api/comments` | Yes | Create a comment |

Create comment JSON body:

```json
{
  "name": "Visitor Name",
  "email": "visitor@example.com",
  "subject": "Nice post",
  "message": "I enjoyed reading this blog.",
  "blog_id": 1
}
```

### Subscribers

| Method | Endpoint | Auth | Description |
| --- | --- | --- | --- |
| GET | `/api/subscribers` | No | List subscribers |
| POST | `/api/subscribers` | No | Create subscriber |

Create subscriber JSON body:

```json
{
  "email": "subscriber@example.com"
}
```

### Contact

| Method | Endpoint | Auth | Description |
| --- | --- | --- | --- |
| POST | `/api/contact` | No | Store contact message |

Create contact JSON body:

```json
{
  "name": "Visitor Name",
  "email": "visitor@example.com",
  "subject": "Question",
  "message": "I want to contact you."
}
```

## Response Format

Most endpoints return this JSON format:

```json
{
  "status": 200,
  "message": "success",
  "data": []
}
```

Validation errors return:

```json
{
  "status": 422,
  "message": "Validation Error",
  "data": {
    "field": [
      "The field is required."
    ]
  }
}
```

## Testing With Postman

1. Register or login to get a token.
2. For protected routes, open the `Authorization` tab.
3. Choose `Bearer Token`.
4. Paste the token.
5. For blog create/update requests with an image, use `Body -> form-data`.
6. For normal JSON requests, use `Body -> raw -> JSON`.

## Useful Commands

Run tests:

```bash
php artisan test
```

Clear cache:

```bash
php artisan optimize:clear
```

Refresh database with seeders:

```bash
php artisan migrate:fresh --seed
```

List routes:

```bash
php artisan route:list
```

## Notes

- Blog images are stored in `storage/app/public/blogs`.
- Public image URLs use `/storage/blogs/{image-name}`.
- Run `php artisan storage:link` before testing image URLs.
- Blog creation requires a valid category ID from the `categories` table.
