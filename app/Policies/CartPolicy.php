<?php

namespace App\Policies;

use App\Enums\CustomerPermissionEnum;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CartPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Cart $cart): bool
    {
        if ($user->cannot(CustomerPermissionEnum::VIEW_CART)) {
            return false;
        }

        return $cart->customer()->is($user);
    }

    public function create(User $user): bool
    {
        if ($user->cannot(CustomerPermissionEnum::CREATE_CART)) {
            return false;
        }

        return true;
    }

    public function delete(User $user, Cart $cart): bool
    {
        if ($user->cannot(CustomerPermissionEnum::DELETE_CART)) {
            return false;
        }

        return $cart->customer()->is($user);
    }

    public function clearCart(User $user, Cart $cart): bool
    {
        if ($user->cannot(CustomerPermissionEnum::CLEAR_CART)) {
            return false;
        }

        return $cart->customer()->is($user);
    }

    public function addProductToCart(User $user, Cart $cart): bool
    {
        if ($user->cannot(CustomerPermissionEnum::ADD_PRODUCT_TO_CART)) {
            return false;
        }

        return $cart->customer()->is($user);
    }

    public function removeProductFromCart(User $user, Cart $cart): bool
    {
        if ($user->cannot(CustomerPermissionEnum::REMOVE_PRODUCT_FROM_CART)) {
            return false;
        }

        return $cart->customer()->is($user);
    }
}
