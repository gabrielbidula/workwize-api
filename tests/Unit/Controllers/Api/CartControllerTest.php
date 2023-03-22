<?php

declare(strict_types=1);

namespace Tests\Unit\Controllers\Api;

use App\Enums\CustomerPermissionEnum;
use App\Enums\RoleEnum;
use App\Models\Cart;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

test('can create a cart', function () {
    /** @var CustomerPermissionEnum $permission */
    $permission = Permission::create(['name' => CustomerPermissionEnum::CREATE_CART, 'guard_name' => 'api']);
    /** @var Role $role */
    $role = Role::create(['name' => RoleEnum::CUSTOMER, 'guard_name' => 'api']);

    $role->givePermissionTo($permission->name);
    app()->make(PermissionRegistrar::class)->registerPermissions();

    Sanctum::actingAs(User::factory()->create()->assignRole($role), [$permission]);

    $this->withHeaders([
        'Accept' => 'application/json',
    ])->json('POST', route('api.carts.store'), [])->assertCreated();
});

test('can view a cart', function () {
    /** @var CustomerPermissionEnum $permission */
    $permission = Permission::create(['name' => CustomerPermissionEnum::VIEW_CART, 'guard_name' => 'api']);
    /** @var Role $role */
    $role = Role::create(['name' => RoleEnum::CUSTOMER, 'guard_name' => 'api']);

    $role->givePermissionTo($permission->name);
    app()->make(PermissionRegistrar::class)->registerPermissions();

    /** @var User $user */
    $user = User::factory()->create()->assignRole($role);
    /** @var Cart $cart */
    $cart = Cart::factory()->for($user, 'customer')->create();

    Sanctum::actingAs($user, [$permission]);

    $this->withHeaders([
        'Accept' => 'application/json',
    ])->json('GET', route('api.carts.show', ['cart' => $cart]))->assertOk();
});

test('can delete a cart', function () {
    /** @var CustomerPermissionEnum $permission */
    $permission = Permission::create(['name' => CustomerPermissionEnum::DELETE_CART, 'guard_name' => 'api']);
    /** @var Role $role */
    $role = Role::create(['name' => RoleEnum::CUSTOMER, 'guard_name' => 'api']);

    $role->givePermissionTo($permission->name);
    app()->make(PermissionRegistrar::class)->registerPermissions();

    /** @var User $user */
    $user = User::factory()->create()->assignRole($role);
    /** @var Cart $cart */
    $cart = Cart::factory()->for($user, 'customer')->create();

    Sanctum::actingAs($user, [$permission]);

    $this->actingAs($user)->withHeaders([
        'Accept' => 'application/json',
    ])->json('DELETE', route('api.carts.destroy', ['cart' => $cart]))->assertNoContent();
});

test('can clear a cart', function () {
    /** @var CustomerPermissionEnum $permission */
    $permission = Permission::create(['name' => CustomerPermissionEnum::CLEAR_CART, 'guard_name' => 'api']);
    /** @var Role $role */
    $role = Role::create(['name' => RoleEnum::CUSTOMER, 'guard_name' => 'api']);

    $role->givePermissionTo($permission->name);
    app()->make(PermissionRegistrar::class)->registerPermissions();

    /** @var User $user */
    $user = User::factory()->create()->assignRole($role);
    /** @var Cart $cart */
    $cart = Cart::factory()->for($user, 'customer')->create();

    Sanctum::actingAs($user, [$permission]);

    $this->actingAs($user)->withHeaders([
        'Accept' => 'application/json',
    ])->json('PUT', route('api.carts.clear-cart', ['cart' => $cart]))->assertOk();
});
