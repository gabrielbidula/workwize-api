<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Auth;

use App\Enums\RoleEnum;
use Illuminate\Testing\Fluent\AssertableJson;
use Spatie\Permission\Models\Role;

test('can register a supplier', function () {
    Role::create(['name' => RoleEnum::SUPPLIER, 'guard_name' => 'api']);

    $this->json('POST', route('api.auth.suppliers.signup'), [
        'name' => 'User',
        'email' => 'user@gmail.com',
        'password' => 'Secret@2023',
        'password_confirmation' => 'Secret@2023',
    ])->assertCreated()->assertJson(
        fn (AssertableJson $json) => $json->has('access_token')->where('token_type', 'Bearer')
    );
});

test('can not register a supplier without a name', function () {
    $this->json('POST', route('api.auth.suppliers.signup'), [
        'email' => 'user@gmail.com',
        'password' => 'Secret@2023',
        'password_confirmation' => 'Secret@2023',
    ])->assertUnprocessable()->assertJsonValidationErrors(['name' => 'The name field is required.']);
});

test('can not register a supplier without an email', function () {
    $this->json('POST', route('api.auth.suppliers.signup'), [
        'name' => 'User',
        'password' => 'Secret@2023',
        'password_confirmation' => 'Secret@2023',
    ])->assertUnprocessable()->assertJsonValidationErrors(['email' => 'The email field is required.']);
});

test('can not register a supplier without a password', function () {
    $this->json('POST', route('api.auth.suppliers.signup'), [
        'name' => 'User',
        'email' => 'user@gmail.com',
        'password_confirmation' => 'Secret@2023',
    ])->assertUnprocessable()->assertJsonValidationErrors(['password' => 'The password field is required.']);
});

test('can not register a supplier without a password confirmation', function () {
    $this->json('POST', route('api.auth.suppliers.signup'), [
        'name' => 'User',
        'email' => 'user@gmail.com',
        'password' => 'Secret@2023',
    ])->assertUnprocessable()->assertJsonValidationErrors(['password' => 'The password field confirmation does not match.']
    );
});
