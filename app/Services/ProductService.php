<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\ProductNotFoundException;
use App\Exceptions\UserNotFoundException;
use App\Interfaces\IProductService;
use App\Models\Product;
use App\Models\User;
use Throwable;

class ProductService implements IProductService
{
    /**
     * @throws Throwable
     */
    public function store(array $data): Product
    {
        /** @var User $user */
        $user = User::find($data['user_id']);
        if (! $user) {
            throw new UserNotFoundException('User not found.');
        }

        return $user->products()->create([
            'name' => $data['product']['name'],
            'price' => $data['product']['price'],
            'quantity' => $data['product']['quantity'],
        ]);
    }

    /**
     * @throws UserNotFoundException
     */
    public function show(array $data): Product
    {
        /** @var User $user */
        $user = User::find($data['user_id']);
        if (! $user) {
            throw new UserNotFoundException('User not found.');
        }

        return $user->products->where('id', $data['product_id'])->first();
    }

    /**
     * @throws UserNotFoundException
     * @throws ProductNotFoundException
     */
    public function update(array $data): Product
    {
        /** @var User $user */
        $user = User::find($data['user_id']);
        if (! $user) {
            throw new UserNotFoundException('User not found.');
        }

        /** @var Product $product */
        $product = $user->products->where('id', $data['product_id'])->first();
        if (! $product) {
            throw new ProductNotFoundException('Product not found.');
        }

        $product->update($data['attributes']);

        return $product->fresh();
    }

    /**
     * @throws UserNotFoundException
     * @throws ProductNotFoundException
     */
    public function destroy(array $data): void
    {
        /** @var User $user */
        $user = User::find($data['user_id']);
        if (! $user) {
            throw new UserNotFoundException('User not found.');
        }

        /** @var Product $product */
        $product = $user->products->where('id', $data['product_id'])->first();
        if (! $product) {
            throw new ProductNotFoundException('Product not found.');
        }

        $product->delete();
    }
}
