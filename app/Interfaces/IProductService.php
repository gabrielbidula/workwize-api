<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Models\Product;

interface IProductService
{
    public function store(array $data): Product;

    public function show(array $data): Product;

    public function update(array $data): Product;

    public function destroy(array $data): void;
}
