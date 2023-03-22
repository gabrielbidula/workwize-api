<?php

declare(strict_types=1);

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\QueryException;

test('creates a product', function () {
    $product = [
        'name' => 'Pioneer DJ Mixer',
    ];

    Product::factory()->create($product);

    $this->assertDatabaseHas('products', $product);
});

test('can not create a product without a name', function () {
    $this->expectException(QueryException::class);

    $product = [
        'name' => null,
    ];

    Product::factory()->create($product);

    $this->assertDatabaseMissing('products', $product);
});

test('can not create a product without a price', function () {
    $this->expectException(QueryException::class);

    $product = [
        'name' => null,
    ];

    Product::factory()->create($product);

    $this->assertDatabaseMissing('products', $product);
});

test('can not create a product without a quantity', function () {
    $this->expectException(QueryException::class);

    $product = [
        'name' => null,
    ];

    Product::factory()->create($product);

    $this->assertDatabaseMissing('products', $product);
});

test('associates a product with carts', function () {
    /** @var User $customer */
    $customer = User::factory()->create();

    $product = Product::factory()->create();
    $this->assertDatabaseHas('products', ['id' => $product->getKey()]);

    $cart = Cart::factory()->create();
    $this->assertDatabaseHas('carts', ['id' => $cart->getKey()]);

    $product->carts()->attach($cart);
    $this->assertCount(1, $product->carts()->get());
});
