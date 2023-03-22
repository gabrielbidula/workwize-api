<?php

declare(strict_types=1);

namespace Tests\Unit\Controllers\Api;

use App\Enums\RoleEnum;
use App\Enums\SupplierPermissionEnum;
use App\Models\Product;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

test('can view all products', function () {
    Sanctum::actingAs(User::factory()->create());

    $this->withHeaders([
        'Accept' => 'application/json',
    ])->json('GET', route('api.products.index'))->assertOk();
});

test('can create a product', function () {
    /** @var SupplierPermissionEnum $permission */
    $permission = Permission::create(['name' => SupplierPermissionEnum::CREATE_PRODUCT, 'guard_name' => 'api']);
    /** @var Role $role */
    $role = Role::create(['name' => RoleEnum::SUPPLIER, 'guard_name' => 'api']);

    $role->givePermissionTo($permission->name);
    app()->make(PermissionRegistrar::class)->registerPermissions();

    /** @var User $user */
    $user = User::factory()->create()->assignRole($role);

    Sanctum::actingAs($user, [$permission]);

    $this->withHeaders([
        'Accept' => 'application/json',
    ])->json('POST', route('api.products.store'), ['name' => 'Product', 'price' => 100.0, 'quantity' => 5]
    )->assertCreated();
});

test('can view a product', function () {
    /** @var SupplierPermissionEnum $permission */
    $permission = Permission::create(['name' => SupplierPermissionEnum::VIEW_PRODUCT, 'guard_name' => 'api']);
    /** @var Role $role */
    $role = Role::create(['name' => RoleEnum::SUPPLIER, 'guard_name' => 'api']);

    $role->givePermissionTo($permission->name);
    app()->make(PermissionRegistrar::class)->registerPermissions();

    /** @var User $user */
    $user = User::factory()->create()->assignRole($role);
    /** @var Product $product */
    $product = Product::factory()->for($user, 'supplier')->create();

    Sanctum::actingAs($user, [$permission]);

    $this->withHeaders([
        'Accept' => 'application/json',
    ])->json('GET', route('api.products.show', ['product' => $product]))->assertOk();
});

test('can update a product', function () {
    /** @var SupplierPermissionEnum $permission */
    $permission = Permission::create(['name' => SupplierPermissionEnum::UPDATE_PRODUCT, 'guard_name' => 'api']);
    /** @var Role $role */
    $role = Role::create(['name' => RoleEnum::SUPPLIER, 'guard_name' => 'api']);

    $role->givePermissionTo($permission->name);
    app()->make(PermissionRegistrar::class)->registerPermissions();

    /** @var User $user */
    $user = User::factory()->create()->assignRole($role);
    /** @var Product $product */
    $product = Product::factory()->for($user, 'supplier')->create();

    Sanctum::actingAs($user, [$permission]);

    $this->withHeaders([
        'Accept' => 'application/json',
    ])->json(
        'PUT',
        route('api.products.show', ['product' => $product]),
        ['name' => 'Product', 'price' => 100.0, 'quantity' => 5]
    )
        ->assertOk();
});

test('can delete a product', function () {
    /** @var SupplierPermissionEnum $permission */
    $permission = Permission::create(['name' => SupplierPermissionEnum::DELETE_PRODUCT, 'guard_name' => 'api']);
    /** @var Role $role */
    $role = Role::create(['name' => RoleEnum::SUPPLIER, 'guard_name' => 'api']);

    $role->givePermissionTo($permission->name);
    app()->make(PermissionRegistrar::class)->registerPermissions();

    /** @var User $user */
    $user = User::factory()->create()->assignRole($role);
    /** @var Product $product */
    $product = Product::factory()->for($user, 'supplier')->create();

    Sanctum::actingAs($user, [$permission]);

    $this->withHeaders([
        'Accept' => 'application/json',
    ])->json('DELETE', route('api.products.destroy', ['product' => $product]))->assertNoContent();
});

test('without a supplier role user can not create a product', function () {
    /** @var SupplierPermissionEnum $permission */
    $permission = Permission::create(['name' => SupplierPermissionEnum::CREATE_PRODUCT, 'guard_name' => 'api']);
    /** @var Role $role */
    $role = Role::create(['name' => RoleEnum::SUPPLIER, 'guard_name' => 'api']);

    $role->givePermissionTo($permission->name);
    app()->make(PermissionRegistrar::class)->registerPermissions();

    /** @var User $user */
    $user = User::factory()->create();

    Sanctum::actingAs($user, [$permission]);

    $this->withHeaders([
        'Accept' => 'application/json',
    ])->json('POST', route('api.products.store'), ['name' => 'Product', 'price' => 100.0, 'quantity' => 5]
    )->assertForbidden()->assertJson(
        fn (AssertableJson $json) => $json->has('message')->where('message', 'This action is unauthorized.')
    );
});

test('without a supplier role user can not update a product', function () {
    /** @var SupplierPermissionEnum $permission */
    $permission = Permission::create(['name' => SupplierPermissionEnum::UPDATE_PRODUCT, 'guard_name' => 'api']);
    /** @var Role $role */
    $role = Role::create(['name' => RoleEnum::SUPPLIER, 'guard_name' => 'api']);

    $role->givePermissionTo($permission->name);
    app()->make(PermissionRegistrar::class)->registerPermissions();

    /** @var User $user */
    $user = User::factory()->create();
    /** @var Product $product */
    $product = Product::factory()->for($user, 'supplier')->create();

    Sanctum::actingAs($user, [$permission]);

    $this->withHeaders([
        'Accept' => 'application/json',
    ])->json(
        'PUT', route('api.products.update', ['product' => $product]),
        ['name' => 'Product', 'price' => 100.0, 'quantity' => 5]
    )->assertForbidden()->assertJson(
        fn (AssertableJson $json) => $json->has('message')->where('message', 'This action is unauthorized.')
    );
});

test('without a supplier role user can not delete a product', function () {
    /** @var SupplierPermissionEnum $permission */
    $permission = Permission::create(['name' => SupplierPermissionEnum::DELETE_PRODUCT, 'guard_name' => 'api']);
    /** @var Role $role */
    $role = Role::create(['name' => RoleEnum::SUPPLIER, 'guard_name' => 'api']);

    $role->givePermissionTo($permission->name);
    app()->make(PermissionRegistrar::class)->registerPermissions();

    /** @var User $user */
    $user = User::factory()->create();
    /** @var Product $product */
    $product = Product::factory()->for($user, 'supplier')->create();

    Sanctum::actingAs($user, [$permission]);

    $this->withHeaders([
        'Accept' => 'application/json',
    ])->json(
        'DELETE',
        route('api.products.destroy', ['product' => $product])
    )->assertForbidden()->assertJson(
        fn (AssertableJson $json) => $json->has('message')->where('message', 'This action is unauthorized.')
    );
});
