<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductsPhoto;
use App\Models\ProductsSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{

    public function index (Request $request): Response
    {
        $products = Product::with('sizes', 'photos')->get();

        return Inertia::render('Admin/Products',[
            'products' => $products
        ]);
    }

    public function new(Request $request): Response
    {
        return Inertia::render('Admin/Product',[
            'product' => null
        ]);
    }


    function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        // Create the product
        $product = Product::create($validated);

        // Add product sizes
        foreach ($validated['sizes'] as $size) {
            ProductsSize::create([
                'product_id' => $product->id,
                'name' => $size['name'],
                'quantity' => $size['quantity']
            ]);
        }

        // Add product photos

        $directory = "products/product-{$product->id}";
        Storage::makeDirectory("public/{$directory}");

        foreach ($request->file('photos') as $photo) {
            $path = $photo->store("public/{$directory}");
            ProductsPhoto::create([
                'product_id' => $product->id,
                'path' => Storage::url($path)
            ]);
        }

        return redirect()->route('products')->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        $product->load('sizes', 'photos'); // Eager load sizes and photos
        return Inertia::render('Admin/Product', [
            'product' => $product,
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        // Update the product

        $product->update($validated);

        // Sunc product sizes

        $product->sizes()->delete();
        foreach ($validated['sizes'] as $size) {
            ProductsSize::create([
                'product_id' => $product->id,
                'name' => $size['name'],
                'quantity' => $size['quantity']
            ]);
        }

        // Handle product photos

        foreach ($product->photos as $photo) {
            Storage::delete(['public/' . $photo->path]);
            $photo->delete();
        }

        $directory = "products/product-{$product->id}";
        Storage::makeDirectory("public/{$directory}");

        foreach ($request->file('photos') as $photo) {
            $path = $photo->store("public/{$directory}");
            ProductsPhoto::create([
                'product_id' => $product->id,
                'path' => Storage::url($path)
            ]);
        }

        return redirect()->route('products')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        // Delete product photos
        foreach ($product->photos as $photo) {
            Storage::delete(['public/' . $photo->path]);
            $photo->delete();
        }

        // Delete product sizes
        $product->sizes()->delete();

        // Delete the product
        $product->delete();

        return redirect()->route('products')->with('success', 'Product deleted successfully!');
    }
}
