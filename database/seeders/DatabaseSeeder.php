<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(SupplierPermissionSeeder::class);
        $this->call(SupplierRoleSeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(CustomerPermissionSeeder::class);
        $this->call(CustomerRoleSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(CartSeeder::class);
    }
}
