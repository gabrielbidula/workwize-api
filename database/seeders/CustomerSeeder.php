<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;

class CustomerSeeder extends UserSeeder
{
    public function run(): void
    {
        /** @var User $customer */
        $customer = User::factory()->create([
            'name' => 'User',
            'email' => 'customer@workwize.com',
        ]);

        $customer->assignRole(RoleEnum::CUSTOMER);
    }
}
