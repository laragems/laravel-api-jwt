## Laravel PHP Framework for APIs with JWT authentication ##

This is a fresh copy of Laravel 5.2 with small modifications:

- Added JSON Web Token authentication using [Tymon's package](https://github.com/tymondesigns/jwt-auth);
- Added a custom Middleware that verifies the JWT token;
- Modified the routes.php to add a basic flow of authentication and to display the authenticated user;
- Added the AuthController that takes care of the JWT authentication;
- Added a UserController that uses the Middleware in order to display the authenticated user (and to create a new user);
- Added a HomeController that displays the available API routes (just for fun);

### More to come in the next versions, stay tuned! ###

### Installation ###

Before you start, make sure that you have:

- PHP >= 5.5.9
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- A database created

```
#!bash
# Get the project
mkdir myproject && cd myproject
git clone https://github.com/laragems/laravel-api-jwt.git .

# Install required packages
composer install

# Make folders writable
chmod -R o+w storage
chmod -R o+w bootstrap/cache

# Create your environment file (and then edit it as you see fit - setting the database part is important for the next step)
cp .env.example .env

# Run the default (user & password reset) migrations
php artisan migrate

# Generate application & JWT keys
php artisan key:generate
php artisan jwt:generate

# Start the application (if you are not using Apache)
php artisan serve

```

Go to http://localhost:8000/ (or your Apache vhost) and voila!

## Examples and usages ##

For the examples I will use ```api.dev``` as a hostname.

Now you can:

- Create a valid user:
```POST http://api.dev/v1/user email=youremail@example.com password=yourpassword name=Laragems```

```
{
  "status": "success",
  "message": "User created."
}
```

- Login with your user:
```POST http://api.dev/v1/auth email=youremail@example.com password=yourpassword```

```
{
  "status": "success",
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImlzcyI6Imh0dHA6XC9cL2FwaS5kZXZcL3YxXC9hdXRoIiwiaWF0IjoxNDUzNDEwNzE5LCJleHAiOjE0NTM2Njk5MTksIm5iZiI6MTQ1MzQxMDcxOSwianRpIjoiNDczMTA5OTA0MzIyN2I1MjQ1Y2U3YTJlYmVjMjc5NmYifQ.7IFbi1gDudChSxz1P1CAzOAzgsNqdE7Nhdi4LYSnUF0"
}
```

- Use the ```token``` in every other request that uses the ```auth.jwt``` middleware as an querystring parameter or in "Authorization: Bearer {yourtokenhere}" header.

- Get current logged in user:
```GET http://api.dev/v1/user?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImlzcyI6Imh0dHA6XC9cL2FwaS5kZXZcL3YxXC9hdXRoIiwiaWF0IjoxNDUzNDEwNzE5LCJleHAiOjE0NTM2Njk5MTksIm5iZiI6MTQ1MzQxMDcxOSwianRpIjoiNDczMTA5OTA0MzIyN2I1MjQ1Y2U3YTJlYmVjMjc5NmYifQ.7IFbi1gDudChSxz1P1CAzOAzgsNqdE7Nhdi4LYSnUF0```

```
{
  "user": {
    "id": 2,
    "name": "Laragems",
    "email": "youremail@example.com",
    "created_at": "2016-01-21 21:09:56",
    "updated_at": "2016-01-21 21:09:56"
  }
}
```

- Attempt to create an invalid user:

```POST http://api.dev/v1/user email=wrongemailaddress password=mypassword```

```
{
  "status": "error",
  "message": "Invalid input data.",
  "details": [
    "The email must be a valid email address.",
    "The name field is required."
  ]
}
```

- Attempt to create a user that already exists:

```POST http://api.dev/v1/user email=youremail@example.com password=yourpassword name=Laragems```

```
{
  "status": "error",
  "message": "Invalid input data.",
  "details": [
    "The email has already been taken."
  ]
}
```

- Attempt to login with wrong credentials:
```POST http://api.dev/v1/auth email=youremail@example.com password=wrong```

```
{
  "status": "error",
  "message": "Invalid credentials"
}
```

Play with those routes, explore ```routes.php```, ```AuthController.php```, ```UserController.php```.

Building an API on top of this package is very easy, just add your resources with ```auth.jwt``` middleware (as you see in ```routes.php```).

## Official Documentation ##

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

Documentation for Tymon's JWT Authentication can be found on [the Wiki](https://github.com/tymondesigns/jwt-auth/wiki).
