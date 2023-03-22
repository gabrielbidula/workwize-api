<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Models\Cart;

interface ICartService
{
    public function store(array $data): Cart;

    public function destroy(array $data): void;

    public function clearCart(array $data): void;
}
