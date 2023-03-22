<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    public function creating(Product $product): void
    {
        if (auth()->check()) {
            $product->user_id = auth()->id();
        }
    }
}
