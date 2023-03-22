<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Models\Product;

interface IProductService
{
    public function createProduct(array $data): Product;
}
