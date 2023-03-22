<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Enums\SupplierPermissionEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class SupplierRoleSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        Role::create(['guard_name' => 'api', 'name' => RoleEnum::SUPPLIER])->givePermissionTo(
            SupplierPermissionEnum::asArray()
        );
    }
}
