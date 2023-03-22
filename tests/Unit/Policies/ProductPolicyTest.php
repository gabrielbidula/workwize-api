<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Enums\RoleEnum;
use App\Enums\SupplierPermissionEnum;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

test('with supplier role user can create a product', function () {
    /** @var SupplierPermissionEnum $permission */
    $permission = Permission::create(['name' => SupplierPermissionEnum::CREATE_PRODUCT, 'guard_name' => 'api']);
    $role = Role::create(['name' => RoleEnum::SUPPLIER, 'guard_name' => 'api']);

    $role->givePermissionTo($permission->name);
    app()->make(PermissionRegistrar::class)->registerPermissions();

    /** @var User $supplier */
    $supplier = User::factory()->create();

    $supplier->assignRole($role);
    $this->assertTrue($supplier->hasRole($role));
    $this->assertTrue($supplier->hasPermissionTo(SupplierPermissionEnum::CREATE_PRODUCT));
    $this->assertTrue($supplier->can(SupplierPermissionEnum::CREATE_PRODUCT));
});

test('with supplier role user can view a product', function () {
    /** @var SupplierPermissionEnum $permission */
    $permission = Permission::create(['name' => SupplierPermissionEnum::VIEW_PRODUCT, 'guard_name' => 'api']);
    $role = Role::create(['name' => RoleEnum::SUPPLIER, 'guard_name' => 'api']);

    $role->givePermissionTo($permission->name);
    app()->make(PermissionRegistrar::class)->registerPermissions();

    /** @var User $supplier */
    $supplier = User::factory()->create();

    $supplier->assignRole($role);
    $this->assertTrue($supplier->hasRole($role));
    $this->assertTrue($supplier->hasPermissionTo(SupplierPermissionEnum::VIEW_PRODUCT));
    $this->assertTrue($supplier->can(SupplierPermissionEnum::VIEW_PRODUCT));
});

test('with supplier role user can update a product', function () {
    /** @var SupplierPermissionEnum $permission */
    $permission = Permission::create(['name' => SupplierPermissionEnum::UPDATE_PRODUCT, 'guard_name' => 'api']);
    $role = Role::create(['name' => RoleEnum::SUPPLIER, 'guard_name' => 'api']);

    $role->givePermissionTo($permission->name);
    app()->make(PermissionRegistrar::class)->registerPermissions();

    /** @var User $supplier */
    $supplier = User::factory()->create();

    $supplier->assignRole($role);
    $this->assertTrue($supplier->hasRole($role));
    $this->assertTrue($supplier->hasPermissionTo(SupplierPermissionEnum::UPDATE_PRODUCT));
    $this->assertTrue($supplier->can(SupplierPermissionEnum::UPDATE_PRODUCT));
});

test('with supplier role user can delete a product', function () {
    /** @var SupplierPermissionEnum $permission */
    $permission = Permission::create(['name' => SupplierPermissionEnum::DELETE_PRODUCT, 'guard_name' => 'api']);
    $role = Role::create(['name' => RoleEnum::SUPPLIER, 'guard_name' => 'api']);

    $role->givePermissionTo($permission->name);
    app()->make(PermissionRegistrar::class)->registerPermissions();

    /** @var User $supplier */
    $supplier = User::factory()->create();

    $supplier->assignRole($role);
    $this->assertTrue($supplier->hasRole($role));
    $this->assertTrue($supplier->hasPermissionTo(SupplierPermissionEnum::DELETE_PRODUCT));
    $this->assertTrue($supplier->can(SupplierPermissionEnum::DELETE_PRODUCT));
});

test('without supplier role user can not create a product', function () {
    /** @var Permission $permission */
    $permission = Permission::create(['name' => SupplierPermissionEnum::CREATE_PRODUCT, 'guard_name' => 'api']);
    /** @var Role $role */
    $role = Role::create(['name' => RoleEnum::CUSTOMER, 'guard_name' => 'api']);

    $role->givePermissionTo($permission->name);
    app()->make(PermissionRegistrar::class)->registerPermissions();

    /** @var User $customer */
    $customer = User::factory()->create();

    $this->assertFalse($customer->hasRole(RoleEnum::CUSTOMER));
    $this->assertFalse($customer->hasPermissionTo(SupplierPermissionEnum::CREATE_PRODUCT));
    $this->assertFalse($customer->can(SupplierPermissionEnum::CREATE_PRODUCT));
});

test('without supplier role user can not view a product', function () {
    /** @var Permission $permission */
    $permission = Permission::create(['name' => SupplierPermissionEnum::VIEW_PRODUCT, 'guard_name' => 'api']);
    /** @var Role $role */
    $role = Role::create(['name' => RoleEnum::CUSTOMER, 'guard_name' => 'api']);

    $role->givePermissionTo($permission->name);
    app()->make(PermissionRegistrar::class)->registerPermissions();

    /** @var User $customer */
    $customer = User::factory()->create();

    $this->assertFalse($customer->hasRole(RoleEnum::CUSTOMER));
    $this->assertFalse($customer->hasPermissionTo(SupplierPermissionEnum::VIEW_PRODUCT));
    $this->assertFalse($customer->can(SupplierPermissionEnum::VIEW_PRODUCT));
});

test('without supplier role user can not update a product', function () {
    /** @var Permission $permission */
    $permission = Permission::create(['name' => SupplierPermissionEnum::UPDATE_PRODUCT, 'guard_name' => 'api']);
    /** @var Role $role */
    $role = Role::create(['name' => RoleEnum::CUSTOMER, 'guard_name' => 'api']);

    $role->givePermissionTo($permission->name);
    app()->make(PermissionRegistrar::class)->registerPermissions();

    /** @var User $customer */
    $customer = User::factory()->create();

    $this->assertFalse($customer->hasRole(RoleEnum::CUSTOMER));
    $this->assertFalse($customer->hasPermissionTo(SupplierPermissionEnum::UPDATE_PRODUCT));
    $this->assertFalse($customer->can(SupplierPermissionEnum::UPDATE_PRODUCT));
});

test('without supplier role user can not delete a product', function () {
    /** @var Permission $permission */
    $permission = Permission::create(['name' => SupplierPermissionEnum::DELETE_PRODUCT, 'guard_name' => 'api']);
    /** @var Role $role */
    $role = Role::create(['name' => RoleEnum::CUSTOMER, 'guard_name' => 'api']);

    $role->givePermissionTo($permission->name);
    app()->make(PermissionRegistrar::class)->registerPermissions();

    /** @var User $customer */
    $customer = User::factory()->create();

    $this->assertFalse($customer->hasRole(RoleEnum::CUSTOMER));
    $this->assertFalse($customer->hasPermissionTo(SupplierPermissionEnum::DELETE_PRODUCT));
    $this->assertFalse($customer->can(SupplierPermissionEnum::DELETE_PRODUCT));
});
