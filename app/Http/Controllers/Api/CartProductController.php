<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CartProductRequest;
use App\Http\Resources\Api\CartResource;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class CartProductController extends Controller
{
    public function addProductToCart(CartProductRequest $request, Cart $cart): JsonResponse
    {
        $data = $request->validated();

        try {
            $this->authorize('add-product-to-cart', $cart);

            $cart = Cart::with('products')->findOrFail($cart->getKey());
            $product = Product::findOrFail($data['product_id']);

            $cart->products()->syncWithoutDetaching($product);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

        $cart->products()->syncWithoutDetaching($product);

        return response()->json(new CartResource($cart->refresh()), 201);
    }

    public function removeProductFromCart(Cart $cart, Product $product): JsonResponse
    {
        try {
            $this->authorize('remove-product-from-cart', $cart);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

        $cart->products()->detach($product);

        return response()->json(['message' => 'Product removed from cart.']);
    }
}
