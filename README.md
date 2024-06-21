# URL Shortener Project

This is a Laravel-based URL Shortener application. Users can register, log in, and manage their shortened URLs via a web interface or API.

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js and npm

## Installation

### Step 1: Clone the Repository

```bash
git clone https://github.com/ghezelbash/gt-url-shortener.git
cd gt-url-shortener
```
### Step 2: Install Dependencies
Install PHP dependencies using Composer:

```bash
composer install
```
Install JavaScript dependencies using npm:

```bash
npm install
npm run dev
```
### Step 3: Set Up Environment Variables
Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```
Generate an application key:

```bash
php artisan key:generate
```

### Optional Step (e.g. if you want to use MySQL):

Update your `.env` file with your database credentials and other necessary settings.

### Step 4: Run Migrations
Run the migrations to create the necessary tables:

```bash
php artisan migrate
```

### Step 5: Serve the Application
Serve the application using the built-in Laravel server:

```bash
php artisan serve
```
The application will be available at http://localhost:8000.

# API Usage

#### There is a POSTMAN collection [here](/docs/URLShortener.postman_collection.json) that includes complete endpoints and examples.


## Authentication
#### Generate Token
#### Endpoint: `POST /api/token/generate`

#### Body:

```json
{
    "email": "user@example.com",
    "password": "password"
}
```

## URL Management
All URL management endpoints require authentication via a Bearer token.

### List URLs
#### Endpoint: `GET /api/urls`

#### Headers:

```plaintext
Authorization: Bearer your-api-token
Content-Type: application/json
```

### Get URL
#### Endpoint: `GET /api/urls/{uuid}`

#### Headers:

```plaintext
Authorization: Bearer your-api-token
Content-Type: application/json
```

### Create URL
#### Endpoint: `POST /api/urls`

#### Headers:

```plaintext
Authorization: Bearer your-api-token
Content-Type: application/json
```
#### Body:

```json
{
    "original_url": "https://example.com"
}
```
#### Response:

```json
{
    "uuid": "5a93d8ec-a2f2-4605-b540-0eda5259cad0",
    "original_url": "https://example.com",
    "shortened_url": "http://localhost:8000/abcdefg",
    "created_at": "2024-07-19T10:30:00.000000Z",
    "updated_at": "2024-07-19T10:30:00.000000Z"
}
```

### Update URL
#### Endpoint: `PUT /api/urls/{uuid}`


#### Headers:

```plaintext
Authorization: Bearer your-api-token
Content-Type: application/json
```
#### Body:

```json
{
    "original_url": "https://new-example.com/"
}
```

### Delete URL
#### Endpoint: `DELETE /api/urls/{uuid}`

#### Headers:

```plaintext
Authorization: Bearer your-api-token
Content-Type: application/json
```

# Tests
#### You can simply run all tests via this command:

```bash
php artsian test
```
