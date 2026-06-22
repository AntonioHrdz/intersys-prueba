<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\JsonResponse;
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('Category')->latest()->get();
        $categories = Category::all();
        return view('products.index', compact('products', 'categories'));
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $product = Product::create($request->validated());
        $product->load('category'); 

        return response()->json([
            'success' => true,
            'message' => 'Producto creado con éxito.',
            'product' => $product
        ]);
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json($product);
    }

    public function update(ProductRequest $request, Product $product): JsonResponse
    {
        $product->update($request->validated());
        $product->load('category');

        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado con éxito.',
            'product' => $product
        ]);
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();
        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado con éxito.'
        ]);
    }
}
