<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;

class CartSeeder extends AbstractSeeder
{
    public function run(): void
    {
        /** @var User $customer */
        $customer = User::whereHas('roles', static function ($q) {
            $q->where('name', RoleEnum::CUSTOMER);
        })->first();

        /** @var Cart $cart */
        $cart = Cart::factory()->for($customer, 'customer')->create();

        Product::all()->each(function ($product) use ($cart) {
            $cart->products()->attach($product);
        });
    }
}
