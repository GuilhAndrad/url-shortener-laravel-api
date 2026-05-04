# URL Shortening Service - Backend Project

This project is a solution for the [URL Shortening Service](https://roadmap.sh/projects/url-shortening-service) challenge from roadmap.sh. It provides a RESTful API to shorten long URLs, manage them, and track their usage statistics.

---

## Tech Stack

* PHP `^8.3`
* Laravel Framework (v13.0)
* SQLite (Lightweight database)
* Scramble (API Documentation)
* Pest PHP (Testing Framework)

---

## Installation

Follow these steps to get the project running locally:

### 1. Clone this project

```bash
git clone https://github.com/GuilhAndrad/url-shortener-laravel-api.git
cd url-shortener-laravel-api
```

### 2. Install dependencies

```bash
composer install
```

### 3. Set up Laravel configurations

```bash
# Using the built-in setup script
composer run setup
```

Or manual steps:

```bash
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
```

### 4. Serve the application

```bash
php artisan serve
```

The API will be available at: `http://localhost:8000`

The documentation will be at: `http://localhost:8000/docs/api`

---

## API Endpoints

### Create Short URL

**POST** `/api/v1/shorten`

**Request Body:**

```json
{
  "url": "https://www.example.com/some/long/url"
}
```

**Response (201 Created):**

```json
{
  "id": "1",
  "url": "https://www.example.com/some/long/url",
  "shortCode": "abc123",
  "shortUrl": "http://localhost:8000/abc123",
  "createdAt": "2026-05-04T12:00:00Z",
  "updatedAt": "2026-05-04T12:00:00Z",
  "accessCount": 0
}
```

---

### Retrieve Original URL

**GET** `/api/v1/shorten/{shortCode}`

**Response (200 OK):**

```json
{
  "id": "1",
  "url": "https://www.example.com/some/long/url",
  "shortCode": "abc123",
  "shortUrl": "http://localhost:8000/abc123",
  "createdAt": "2026-05-04T12:00:00Z",
  "updatedAt": "2026-05-04T12:00:00Z",
  "accessCount": 1
}
```

---

### Update Short URL

**PUT** `/api/v1/shorten/{shortCode}`

**Request Body:**

```json
{
  "url": "https://www.example.com/some/updated/url"
}
```

**Response (200 OK):**

```json
{
  "id": "1",
  "url": "https://www.example.com/some/updated/url",
  "shortCode": "abc123",
  "shortUrl": "http://localhost:8000/abc123",
  "createdAt": "2026-05-04T12:00:00Z",
  "updatedAt": "2026-05-04T12:30:00Z",
  "accessCount": 1
}
```

---

### Delete Short URL

**DELETE** `/api/v1/shorten/{shortCode}`
**Status:** `204 No Content`

---

### Get URL Statistics

**GET** `/api/v1/shorten/{shortCode}/stats`

**Response (200 OK):**

```json
{
  "id": "1",
  "url": "https://www.example.com/some/long/url",
  "shortCode": "abc123",
  "shortUrl": "http://localhost:8000/abc123",
  "createdAt": "2026-05-04T12:00:00Z",
  "updatedAt": "2026-05-04T12:00:00Z",
  "accessCount": 10
}
```

---

### Redirection Service

**GET** `/api/v1/{shortCode}`

**Action:** Returns a `302 Found` status code and increments the `accessCount`.

---

## Architecture Note

This project follows the Action Pattern. Business logic is extracted from controllers into dedicated Action classes (e.g., `CreateUrlAction`, `UpdateUrlAction`), making the code modular, reusable, and easy to test.

---

## Running Tests

This project uses Pest PHP. To run the tests:

```bash
composer test
```

---

## Learn More

* https://laravel.com/docs
* https://roadmap.sh/projects/url-shortening-service
* https://scramble.dedoc.co/