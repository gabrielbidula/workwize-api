<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreProductRequest;
use App\Http\Resources\Api\ProductResource;
use App\Interfaces\IProductService;
use App\Models\Product;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(protected IProductService $productSevice)
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
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

        $product = auth()->user()->products()->create([
            'name' => $data['name'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
        ]);

        return response()->json(new ProductResource($product), 201);
    }

    public function show(Product $product): JsonResponse
    {
        try {
            $this->authorize('view', $product);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

        $product = Product::findOrFail($product->getKey());

        return response()->json(new ProductResource($product));
    }

    public function update(StoreProductRequest $request, Product $product): JsonResponse
    {
        $data = $request->validated();

        try {
            $this->authorize('update', $product);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

        $product->update($data);

        return response()->json(new ProductResource($product));
    }

    public function destroy(Product $product): JsonResponse
    {
        try {
            $this->authorize('delete', $product);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

        $product->delete();

        return response()->json(['message' => 'Resource successfully deleted.'], 204);
    }
}
