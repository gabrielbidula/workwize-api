<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Product;
use App\Models\User;
use Throwable;

class ProductSeeder extends AbstractSeeder
{
    /**
     * @throws Throwable
     */
    public function run(): void
    {
        /** @var User $supplier */
        $supplier = User::whereHas('roles', function ($q) {
            $q->where('name', RoleEnum::SUPPLIER);
        })->first();

        Product::factory(5)->for($supplier, 'supplier')->create();
    }
}
