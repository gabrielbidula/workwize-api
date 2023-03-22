<?php

declare(strict_types=1);

namespace App\Interfaces;

interface ILoginService
{
    public function login(array $data): string;
}
