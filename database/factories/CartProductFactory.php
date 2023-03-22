<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartProductFactory extends Factory
{
    protected $model = CartProduct::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cart_id' => Cart::factory(),
            'product_id' => Product::factory(),
        ];
    }
}
