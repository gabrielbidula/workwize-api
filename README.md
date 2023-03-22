# Running the application

(**Highly recommended**) Run the application using [Sail](https://laravel.com/docs/10.x/sail).

1. Run `sail artiasn migrate:fresh --seed` to setup and seed the database.
2. Run `sail pest` to run all the tests in the app container.

*Check the dependencies if you decide to run the application using your local environment*

# After setup

1. The application is seeded with Roles, Permissions, Products and Cart Products.
2. There are two users seeded:
    * User with Customer role
        * customer@workwize / password
    * User with Supplier role
        * supplier@workwize.com / password

# Dependencies

* Laravel 10
* PHP 8.1+
* MySQL 8

# Features

### As a User with Customer role

* Can create a cart
* Can have one cart
* Can delete a cart
* Can clear a cart
* Can add products to his cart
* Can remove products from his cart
* Can not perform any actions to other Customer's cart
* Can not CRUD supplier's products

### As a User with Supplier role

* Can create a product
* Can edit a product
* Can delete a product
* Can view owned products
* Can not perform CRUD actions to other Supplier's product
* Can not perform any Customer action


# Authentication

For the authentication, I am using [Laravel Sanctum](https://laravel.com/docs/10.x/sanctum) which provides me with exactly what I need for the assignment (token based APIs).

*Hiting endpoints without being authenticatad will lead into Unauthenticaded error.*

# Authorization

For the authorization, I am using a combination of [Laravel Policies](https://laravel.com/docs/10.x/authorization#creating-policies) and [Laravel Gate](https://laravel.com/docs/10.x/authorization#gates) with [Spatie's Permissions package](https://spatie.be/docs/laravel-permission/v5/introduction).
This allows me to cover User's actions based on its Roles and Permissions.

*Hiting resources endpoints which are not owned by the user will lead into Unauthorized error.*

# Testing

For the tests, I am using [Pest](https://pestphp.com/) which is a Testing Framework powered by PHPUnit.

# Code Analysis / Style

I am using [Larastan](https://github.com/nunomaduro/larastan) and [Laravel Pint](https://laravel.com/docs/10.x/pint#introduction) for code analysis and style fixer.

# API Documentation

The API documentation can be found at: [Postman API Documentation](https://documenter.getpostman.com/view/25810211/2s93RL1vzk).