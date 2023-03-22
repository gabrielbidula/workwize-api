<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\UserAlreadyHasACartException;
use App\Exceptions\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CartResource;
use App\Interfaces\ICartService;
use App\Models\Cart;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    public function __construct(protected ICartService $cartService)
    {
    }

    public function store(): JsonResponse
    {
        try {
            $this->authorize('create', Cart::class);
            $cart = $this->cartService->store(['user_id' => auth()->user()->id]);
        } catch (AuthorizationException $exception) {
            return response()->json(['message' => $exception->getMessage()], 403);
        } catch (UserNotFoundException $exception) {
            return response()->json(['message' => $exception->getMessage()], 404);
        } catch (UserAlreadyHasACartException $exception) {
            return response()->json(['message' => $exception->getMessage()], 422);
        }

        return response()->json(new CartResource($cart), 201);
    }

    public function show(Cart $cart): JsonResponse
    {
        try {
            $this->authorize('view', $cart);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

        return response()->json(new CartResource($cart->load('products')));
    }

    public function destroy(Cart $cart): JsonResponse
    {
        try {
            $this->authorize('delete', $cart);
            $this->cartService->destroy(['user_id' => auth()->user()->id]);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        } catch (UserNotFoundException $exception) {
            return response()->json(['message' => $exception->getMessage()], 404);
        }

        return response()->json(['message' => 'Resource successfully deleted.'], 204);
    }

    public function clearCart(Cart $cart): JsonResponse
    {
        try {
            $this->authorize('clear-cart', $cart);
            $this->cartService->clearCart(['user_id' => auth()->user()->id]);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        } catch (UserNotFoundException $exception) {
            return response()->json(['message' => $exception->getMessage()], 404);
        }

        return response()->json(['message' => 'Cart successfully cleared.']);
    }
}
