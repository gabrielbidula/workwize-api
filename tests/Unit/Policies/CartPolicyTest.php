<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Enums\CustomerPermissionEnum;
use App\Enums\RoleEnum;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

test('with customer role user can create a cart', function () {
    /** @var CustomerPermissionEnum $permission */
    $permission = Permission::create(['name' => CustomerPermissionEnum::CREATE_CART, 'guard_name' => 'api']);
    /** @var Role $role */
    $role = Role::create(['name' => RoleEnum::CUSTOMER, 'guard_name' => 'api']);

    $role->givePermissionTo($permission->name);
    app()->make(PermissionRegistrar::class)->registerPermissions();

    /** @var User $customer */
    $customer = User::factory()->create();

    $customer->assignRole($role);
    $this->assertTrue($customer->hasRole($role));
    $this->assertTrue($customer->hasPermissionTo(CustomerPermissionEnum::CREATE_CART));
    $this->assertTrue($customer->can(CustomerPermissionEnum::CREATE_CART));
});

test('with customer role user can delete a cart', function () {
    /** @var Permission $permission */
    $permission = Permission::create(['name' => CustomerPermissionEnum::REMOVE_PRODUCT_FROM_CART, 'guard_name' => 'api']);
    /** @var Role $role */
    $role = Role::create(['name' => RoleEnum::CUSTOMER, 'guard_name' => 'api']);

    $role->givePermissionTo($permission->name);
    app()->make(PermissionRegistrar::class)->registerPermissions();

    /** @var User $customer */
    $customer = User::factory()->create();

    $customer->assignRole($role);
    $this->assertTrue($customer->hasRole($role));
    $this->assertTrue($customer->hasPermissionTo(CustomerPermissionEnum::REMOVE_PRODUCT_FROM_CART));
    $this->assertTrue($customer->can(CustomerPermissionEnum::REMOVE_PRODUCT_FROM_CART));
});

test('with customer role user can add products to a cart', function () {
    /** @var Permission $permission */
    $permission = Permission::create(['name' => CustomerPermissionEnum::ADD_PRODUCT_TO_CART, 'guard_name' => 'api']);
    /** @var Role $role */
    $role = Role::create(['name' => RoleEnum::CUSTOMER, 'guard_name' => 'api']);

    $role->givePermissionTo($permission->name);
    app()->make(PermissionRegistrar::class)->registerPermissions();

    /** @var User $customer */
    $customer = User::factory()->create();

    $customer->assignRole($role);
    $this->assertTrue($customer->hasRole($role));
    $this->assertTrue($customer->hasPermissionTo(CustomerPermissionEnum::ADD_PRODUCT_TO_CART));
    $this->assertTrue($customer->can(CustomerPermissionEnum::ADD_PRODUCT_TO_CART));
});

test('with customer role user can remove products from a cart', function () {
    /** @var Permission $permission */
    $permission = Permission::create(['name' => CustomerPermissionEnum::REMOVE_PRODUCT_FROM_CART, 'guard_name' => 'api']);
    /** @var Role $role */
    $role = Role::create(['name' => RoleEnum::CUSTOMER, 'guard_name' => 'api']);

    $role->givePermissionTo($permission->name);
    app()->make(PermissionRegistrar::class)->registerPermissions();

    /** @var User $customer */
    $customer = User::factory()->create();

    $customer->assignRole($role);
    $this->assertTrue($customer->hasRole($role));
    $this->assertTrue($customer->hasPermissionTo(CustomerPermissionEnum::REMOVE_PRODUCT_FROM_CART));
    $this->assertTrue($customer->can(CustomerPermissionEnum::REMOVE_PRODUCT_FROM_CART));
});

test('without customer role user can not view a cart', function () {
    /** @var Permission $permission */
    $permission = Permission::create(['name' => CustomerPermissionEnum::VIEW_CART, 'guard_name' => 'api']);
    /** @var Role $role */
    $role = Role::create(['name' => RoleEnum::CUSTOMER, 'guard_name' => 'api']);

    $role->givePermissionTo($permission->name);
    app()->make(PermissionRegistrar::class)->registerPermissions();

    /** @var User $customer */
    $customer = User::factory()->create();

    $this->assertFalse($customer->hasRole(RoleEnum::CUSTOMER));
    $this->assertFalse($customer->hasPermissionTo(CustomerPermissionEnum::VIEW_CART));
    $this->assertFalse($customer->can(CustomerPermissionEnum::VIEW_CART));
});

test('without customer role user can not create a cart', function () {
    /** @var Permission $permission */
    $permission = Permission::create(['name' => CustomerPermissionEnum::CREATE_CART, 'guard_name' => 'api']);
    /** @var Role $role */
    $role = Role::create(['name' => RoleEnum::CUSTOMER, 'guard_name' => 'api']);

    $role->givePermissionTo($permission->name);
    app()->make(PermissionRegistrar::class)->registerPermissions();

    /** @var User $customer */
    $customer = User::factory()->create();

    $this->assertFalse($customer->hasRole(RoleEnum::CUSTOMER));
    $this->assertFalse($customer->hasPermissionTo(CustomerPermissionEnum::CREATE_CART));
    $this->assertFalse($customer->can(CustomerPermissionEnum::CREATE_CART));
});

test('without customer role user can not delete a cart', function () {
    /** @var Permission $permission */
    $permission = Permission::create(['name' => CustomerPermissionEnum::REMOVE_PRODUCT_FROM_CART, 'guard_name' => 'api']);
    /** @var Role $role */
    $role = Role::create(['name' => RoleEnum::CUSTOMER, 'guard_name' => 'api']);

    $role->givePermissionTo($permission->name);
    app()->make(PermissionRegistrar::class)->registerPermissions();

    /** @var User $customer */
    $customer = User::factory()->create();

    $this->assertFalse($customer->hasRole(RoleEnum::CUSTOMER));
    $this->assertFalse($customer->hasPermissionTo(CustomerPermissionEnum::REMOVE_PRODUCT_FROM_CART));
    $this->assertFalse($customer->can(CustomerPermissionEnum::REMOVE_PRODUCT_FROM_CART));
});

test('without customer role user can not add products to a cart', function () {
    /** @var Permission $permission */
    $permission = Permission::create(['name' => CustomerPermissionEnum::ADD_PRODUCT_TO_CART, 'guard_name' => 'api']);
    /** @var Role $role */
    $role = Role::create(['name' => RoleEnum::CUSTOMER, 'guard_name' => 'api']);

    $role->givePermissionTo($permission->name);
    app()->make(PermissionRegistrar::class)->registerPermissions();

    /** @var User $customer */
    $customer = User::factory()->create();

    $this->assertFalse($customer->hasRole($role));
    $this->assertFalse($customer->hasPermissionTo(CustomerPermissionEnum::ADD_PRODUCT_TO_CART));
    $this->assertFalse($customer->can(CustomerPermissionEnum::ADD_PRODUCT_TO_CART));
});

test('without customer role user can not remove products from a cart', function () {
    /** @var Permission $permission */
    $permission = Permission::create(['name' => CustomerPermissionEnum::REMOVE_PRODUCT_FROM_CART, 'guard_name' => 'api']);
    /** @var Role $role */
    $role = Role::create(['name' => RoleEnum::CUSTOMER, 'guard_name' => 'api']);

    $role->givePermissionTo($permission->name);
    app()->make(PermissionRegistrar::class)->registerPermissions();

    /** @var User $customer */
    $customer = User::factory()->create();

    $this->assertFalse($customer->hasRole($role));
    $this->assertFalse($customer->hasPermissionTo(CustomerPermissionEnum::REMOVE_PRODUCT_FROM_CART));
    $this->assertFalse($customer->can(CustomerPermissionEnum::REMOVE_PRODUCT_FROM_CART));
});
