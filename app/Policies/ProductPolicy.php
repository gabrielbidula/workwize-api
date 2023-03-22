<?php

namespace App\Policies;

use App\Enums\SupplierPermissionEnum;
use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Product $product): bool
    {
        if ($user->cannot(SupplierPermissionEnum::VIEW_PRODUCT)) {
            return false;
        }

        return $product->supplier()->is($user);
    }

    public function create(User $user): bool
    {
        if ($user->cannot(SupplierPermissionEnum::CREATE_PRODUCT)) {
            return false;
        }

        return true;
    }

    public function update(User $user, Product $product): bool
    {
        if ($user->cannot(SupplierPermissionEnum::UPDATE_PRODUCT)) {
            return false;
        }

        return $product->supplier()->is($user);
    }

    public function delete(User $user, Product $product): bool
    {
        if ($user->cannot(SupplierPermissionEnum::DELETE_PRODUCT)) {
            return false;
        }

        return $product->supplier()->is($user);
    }
}
