<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;

class SupplierSeeder extends UserSeeder
{
    public function run(): void
    {
        /** @var User $supplier */
        $supplier = User::factory()->create([
            'name' => 'Supplier',
            'email' => 'supplier@workwize.com',
        ]);

        $supplier->assignRole(RoleEnum::SUPPLIER);
    }
}
