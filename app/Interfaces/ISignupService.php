<?php

declare(strict_types=1);

namespace App\Interfaces;

interface ISignupService
{
    public function signup(array $data): string;
}
