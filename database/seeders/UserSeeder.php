<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Hashing\HashManager;

abstract class UserSeeder extends Seeder
{
    protected HashManager $hashManager;

    public function __construct(HashManager $hashManager)
    {
        $this->hashManager = $hashManager;
    }
}
