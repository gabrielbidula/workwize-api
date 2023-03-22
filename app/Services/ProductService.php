<?php

declare(strict_types=1);

namespace App\Services;

use App\Interfaces\IProductService;
use App\Models\Product;
use App\Models\User;
use Throwable;

class ProductService implements IProductService
{
    /**
     * @throws Throwable
     */
    public function createProduct(array $data): Product
    {
        /** @var User $user */
        $user = User::findOrFail($data['user_id']);

        return $user->products()->create([
            'name' => $data['name'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
        ]);
    }
}
