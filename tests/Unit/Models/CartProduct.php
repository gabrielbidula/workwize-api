<?php

declare(strict_types=1);

use App\Models\Cart;
use App\Models\Product;

test('creates a cart product', function () {
    /** @var Cart $cart */
    $cart = Cart::factory()->create();
    /** @var Product $product */
    $product = Product::factory()->create();

    $cart->products()->attach($product);
    $this->assertDatabaseHas('carts', ['id' => $cart->getKey()]);
});
