<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Models\Cart;

interface ICartProductService
{
    public function addProductToCart(array $data): Cart;

    public function removeProductFromCart(array $data): Cart;
}
