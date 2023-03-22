<?php

declare(strict_types=1);

namespace App\Services;

use App\Interfaces\ILoginService;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Throwable;

class LoginService implements ILoginService
{
    /**
     * @throws Throwable
     */
    public function login(array $data): string
    {
        throw_if(! Auth::guard('api')->attempt($data['credentials']), new AuthenticationException('Provided credentials are incorrect.'));

        /** @var User $user */
        $user = Auth::user();

        return $user->createToken('auth_token')->plainTextToken;
    }
}
