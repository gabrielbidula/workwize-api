<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\CustomerPermissionEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class CustomerPermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        foreach (CustomerPermissionEnum::asArray() as $permission) {
            Permission::create(['guard_name' => 'api', 'name' => $permission]);
        }
    }
}
