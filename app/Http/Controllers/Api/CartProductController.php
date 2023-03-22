<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CartProductRequest;
use App\Http\Resources\Api\CartResource;
use App\Interfaces\ICartProductService;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class CartProductController extends Controller
{
    public function __construct(protected ICartProductService $cartProductService)
    {
    }

    public function addProductToCart(CartProductRequest $request, Cart $cart): JsonResponse
    {
        $productId = $request->validated();

        try {
            $this->authorize('add-product-to-cart', $cart);
            $this->cartProductService->addProductToCart(
                ['user_id' => auth()->user()->id, 'cart_id' => $cart->getKey(), 'product_id' => $productId]
            );
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

        return response()->json(new CartResource($cart->load('products')));
    }

    public function removeProductFromCart(Cart $cart, Product $product): JsonResponse
    {
        try {
            $this->authorize('remove-product-from-cart', $cart);
            $this->cartProductService->removeProductFromCart(
                ['user_id' => auth()->user()->id, 'cart_id' => $cart->getKey(), 'product_id' => $product->getKey()]
            );
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

        return response()->json(new CartResource($cart->load('products')));
    }
}
