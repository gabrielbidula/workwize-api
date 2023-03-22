<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;

test('logs in a user', function () {
    /** @var User $user */
    $user = User::factory()->create(['email' => 'user@gmail.com', 'password' => bcrypt('Secret@2023')]);

    Sanctum::actingAs($user);

    $this->json('POST', route('api.auth.login'), ['email' => $user->email, 'password' => 'Secret@2023'])
        ->assertOk()
        ->assertJson(fn (AssertableJson $json) => $json->has('access_token')->where('token_type', 'Bearer'));
});

test('can not login without a email', function () {
    $this->json('POST', route('api.auth.login'), [
        'password' => 'Secret@2023',
        'password_confirmation' => 'Secret@2023',
    ])->assertUnprocessable()->assertJsonValidationErrors(['email' => 'The email field is required.']);
});

test('can not login without a password', function () {
    $this->json('POST', route('api.auth.login'), [
        'email' => 'user@gmail.com',
    ])->assertUnprocessable()->assertJsonValidationErrors(['password' => 'The password field is required.']);
});

test('can not login if password does not match', function () {
    $user = User::factory()->create(['email' => 'user@gmail.com', 'password' => bcrypt('Secret@2023')]);
    Sanctum::actingAs($user);

    $this->json('POST', route('api.auth.login'), [
        'email' => 'user@gmail.com',
        'password' => 'WrongPassword',
    ])->assertUnprocessable()->assertJson(
        fn (AssertableJson $json) => $json->has('message')->where('message', 'Provided credentials are incorrect.')
    );
});
