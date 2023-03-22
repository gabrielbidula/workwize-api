<?php

declare(strict_types=1);

namespace Tests\Unit\Controllers\Api;

use App\Enums\CustomerPermissionEnum;
use App\Enums\RoleEnum;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

test('can add product to cart', function () {
    /** @var CustomerPermissionEnum $permission */
    $permission = Permission::create(['name' => CustomerPermissionEnum::ADD_PRODUCT_TO_CART, 'guard_name' => 'api']);
    /** @var Role $role */
    $role = Role::create(['name' => RoleEnum::CUSTOMER, 'guard_name' => 'api']);

    $role->givePermissionTo($permission->name);
    app()->make(PermissionRegistrar::class)->registerPermissions();

    /** @var User $user */
    $user = User::factory()->create()->assignRole($role);
    /** @var Cart $cart */
    $cart = Cart::factory()->for($user, 'customer')->create();
    /** @var Product $product */
    $product = Product::factory()->create();

    Sanctum::actingAs($user, [$permission]);

    $this->withHeaders([
        'Accept' => 'application/json',
    ])->json(
        'POST',
        route('api.carts.products.add-product', ['cart' => $cart]),
        ['product_id' => $product->getKey()]
    )->assertOk()->assertJson(fn (AssertableJson $json) => $json->where('id', $cart->getKey())
        ->where('products.0.id', $product->getKey())
    );
});

test('can remove product from cart', function () {
    /** @var CustomerPermissionEnum $permission */
    $permission = Permission::create(['name' => CustomerPermissionEnum::REMOVE_PRODUCT_FROM_CART, 'guard_name' => 'api']
    );
    /** @var Role $role */
    $role = Role::create(['name' => RoleEnum::CUSTOMER, 'guard_name' => 'api']);

    $role->givePermissionTo($permission->name);
    app()->make(PermissionRegistrar::class)->registerPermissions();

    /** @var User $user */
    $user = User::factory()->create()->assignRole($role);
    /** @var Cart $cart */
    $cart = Cart::factory()->for($user, 'customer')->create();
    /** @var CartProduct $cartProduct */
    $cartProduct = CartProduct::factory()->for($cart)->create();

    Sanctum::actingAs($user, [$permission]);

    $this->withHeaders(['Accept' => 'application/json'])->json(
        'DELETE',
        route('api.carts.products.remove-product', ['cart' => $cart, 'product' => $cartProduct->product])
    )->assertOk();
});

test('can not add products to other users cart', function () {
    /** @var User $user */
    $user = User::factory()->create();
    /** @var User $otherUser */
    $otherUser = User::factory()->create();
    /** @var Cart $cart */
    Cart::factory()->for($user, 'customer')->create();
    /** @var Cart $otherUserCart */
    $otherUserCart = Cart::factory()->for($otherUser, 'customer')->create();
    /** @var Product $product */
    $product = Product::factory()->create();

    Sanctum::actingAs($user);

    $this->withHeaders(['Accept' => 'application/json'])->json(
        'POST',
        route('api.carts.products.add-product', ['cart' => $otherUserCart, 'product_id' => $product->getKey()])
    )->assertForbidden()->assertJson(
        fn (AssertableJson $json) => $json->has('message')->where('message', 'This action is unauthorized.')
    );
});

test('can not remove products from other users cart', function () {
    /** @var User $user */
    $user = User::factory()->create();
    /** @var User $otherUser */
    $otherUser = User::factory()->create();
    /** @var Cart $cart */
    Cart::factory()->for($user, 'customer')->create();
    /** @var Cart $otherUserCart */
    $otherUserCart = Cart::factory()->for($otherUser, 'customer')->create();
    /** @var CartProduct $cartProduct */
    $cartProduct = CartProduct::factory()->for($otherUserCart)->create();

    Sanctum::actingAs($user);

    $this->withHeaders(['Accept' => 'application/json'])->json(
        'DELETE',
        route('api.carts.products.remove-product', ['cart' => $otherUserCart, 'product' => $cartProduct->product])
    )->assertForbidden()->assertJson(
        fn (AssertableJson $json) => $json->has('message')->where('message', 'This action is unauthorized.')
    );
});
