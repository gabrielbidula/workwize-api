<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\UserAlreadyHasACartException;
use App\Exceptions\UserNotFoundException;
use App\Interfaces\ICartService;
use App\Models\Cart;
use App\Models\User;

class CartService implements ICartService
{
    /**
     * @throws UserNotFoundException
     * @throws UserAlreadyHasACartException
     */
    public function store(array $data): Cart
    {
        /** @var User $user */
        $user = User::find($data['user_id']);
        if (! $user) {
            throw new UserNotFoundException('User not found.');
        }

        /** @var Cart $cart */
        $cart = Cart::where('user_id', $user->getKey())->whereNull('deleted_at')->first();
        if ($cart) {
            throw new UserAlreadyHasACartException('User already has a cart.');
        }

        return Cart::create(['user_id' => $user->getKey()]);
    }

    /**
     * @throws UserNotFoundException
     */
    public function destroy(array $data): void
    {
        /** @var User $user */
        $user = User::find($data['user_id']);
        if (! $user) {
            throw new UserNotFoundException('User not found.');
        }

        $user->cart()->delete();
    }

    /**
     * @throws UserNotFoundException
     */
    public function clearCart(array $data): void
    {
        /** @var User $user */
        $user = User::find($data['user_id']);
        if (! $user) {
            throw new UserNotFoundException('User not found.');
        }

        $user->cart->products()->detach();
    }
}
