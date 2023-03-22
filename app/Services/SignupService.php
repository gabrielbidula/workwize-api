<?php

declare(strict_types=1);

namespace App\Services;

use App\Interfaces\ISignupService;
use App\Models\User;

class SignupService implements ISignupService
{
    public function signup(array $data): string
    {
        /** @var User $user */
        $user = User::create([
            'name' => $data['credentials']['name'],
            'email' => $data['credentials']['email'],
            'password' => bcrypt($data['credentials']['password']),
        ]);

        $user->assignRole($data['role']);

        return $user->createToken('auth_token')->plainTextToken;
    }
}
