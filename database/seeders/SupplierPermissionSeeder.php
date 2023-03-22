<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\SupplierPermissionEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class SupplierPermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        foreach (SupplierPermissionEnum::asArray() as $permission) {
            Permission::create(['guard_name' => 'api', 'name' => $permission]);
        }
    }
}
