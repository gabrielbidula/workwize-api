<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\CustomerPermissionEnum;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class CustomerRoleSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        Role::create(['guard_name' => 'api', 'name' => RoleEnum::CUSTOMER])->givePermissionTo(
            CustomerPermissionEnum::asArray()
        );
    }
}
