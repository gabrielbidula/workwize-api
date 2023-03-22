<?php

declare(strict_types=1);

use App\Models\Cart;
use App\Models\Product;

test('creates a cart', function () {
    /** @var Cart $cart */
    $cart = Cart::factory()->create();
    $this->assertDatabaseHas('carts', ['id' => $cart->getKey()]);
});

test('associates a cart with products', function () {
    /** @var Cart $cart */
    $cart = Cart::factory()->create();
    $this->assertDatabaseHas('carts', ['id' => $cart->getKey()]);

    /** @var Product $product */
    $product = Product::factory()->create();
    $this->assertDatabaseHas('products', ['id' => $product->getKey()]);

    $cart->products()->attach($product);
    $this->assertCount(1, $cart->products()->get());
});
