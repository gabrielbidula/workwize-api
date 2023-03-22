<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\CartNotFoundException;
use App\Exceptions\ProductNotFoundException;
use App\Exceptions\UserNotFoundException;
use App\Interfaces\ICartProductService;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;

class CartProductService implements ICartProductService
{
    /**
     * @throws CartNotFoundException
     * @throws ProductNotFoundException
     * @throws UserNotFoundException
     */
    public function addProductToCart(array $data): Cart
    {
        [$cart, $product] = $this->validate($data);

        $cart->products()->syncWithoutDetaching($product);

        return $cart->fresh();
    }

    /**
     * @throws CartNotFoundException
     * @throws ProductNotFoundException
     * @throws UserNotFoundException
     */
    public function removeProductFromCart(array $data): Cart
    {
        [$cart, $product] = $this->validate($data);

        $cart->products()->detach($product);

        return $cart->fresh();
    }

    /**
     * @throws CartNotFoundException
     * @throws ProductNotFoundException
     * @throws UserNotFoundException
     */
    public function validate(array $data): array
    {
        /** @var User $user */
        $user = User::find($data['user_id']);
        if (! $user) {
            throw new UserNotFoundException('User not found.');
        }

        $cart = $user->cart()->where('id', $data['cart_id'])->first();
        if (! $cart) {
            throw new CartNotFoundException('Cart not found.');
        }

        /** @var Product $product */
        $product = Product::find($data['product_id']);
        if (! $product) {
            throw new ProductNotFoundException('Product not found.');
        }

        return [$cart, $product];
    }
}
