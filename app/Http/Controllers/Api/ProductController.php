<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ProductNotFoundException;
use App\Exceptions\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreProductRequest;
use App\Http\Resources\Api\ProductResource;
use App\Interfaces\IProductService;
use App\Models\Product;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(protected IProductService $productService)
    {
    }

    public function index()
    {
        //scope for authenticated user
        return ProductResource::collection(Product::whereUserId(auth()->user()->id)->get());
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            $this->authorize('create', Product::class);
            $product = $this->productService->store(['user_id' => auth()->user()->id, 'product' => $data]);
        } catch (AuthorizationException $exception) {
            return response()->json(['message' => $exception->getMessage()], 403);
        } catch (UserNotFoundException $exception) {
            return response()->json(['message' => $exception->getMessage()], 404);
        }

        return response()->json(new ProductResource($product), 201);
    }

    public function show(Product $product): JsonResponse
    {
        try {
            $this->authorize('view', $product);
            $this->productService->show(['user_id' => auth()->user()->id, 'product_id' => $product->getKey()]);
        } catch (AuthorizationException $exception) {
            return response()->json(['message' => $exception->getMessage()], 403);
        } catch (UserNotFoundException $exception) {
            return response()->json(['message' => $exception->getMessage()], 404);
        }

        return response()->json(new ProductResource($product));
    }

    public function update(StoreProductRequest $request, Product $product): JsonResponse
    {
        $data = $request->validated();

        try {
            $this->authorize('update', $product);
            $this->productService->update(
                ['user_id' => auth()->user()->id, 'product_id' => $product->getKey(), 'attributes' => $data]
            );
        } catch (AuthorizationException $exception) {
            return response()->json(['message' => $exception->getMessage()], 403);
        } catch (ProductNotFoundException $exception) {
            return response()->json(['message' => $exception->getMessage()], 404);
        }

        return response()->json(new ProductResource($product));
    }

    public function destroy(Product $product): JsonResponse
    {
        try {
            $this->authorize('delete', $product);
            $this->productService->destroy(['user_id' => auth()->user()->id, 'product_id' => $product->getKey()]);
        } catch (AuthorizationException $exception) {
            return response()->json(['message' => $exception->getMessage()], 403);
        }

        $product->delete();

        return response()->json(['message' => 'Resource successfully deleted.'], 204);
    }
}
