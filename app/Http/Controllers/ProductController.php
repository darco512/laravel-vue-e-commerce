<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductsPhoto;
use App\Models\ProductsSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{

    public function index (Request $request): Response
    {


        $query = Product::with('photos', 'sizes');


        // Apply search filter
        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Apply other filters
        foreach (['brand', 'category', 'type', 'color'] as $filter) {
            if ($request->has($filter) && !empty($request->input($filter))) {
                $query->where($filter, $request->input($filter));
            }
        }

        if ($request->has('size') && !empty($request->input('size'))) {
            $size = $request->input('size');
            $query->whereHas('sizes', function ($q) use ($size) {
                $q->where('name', $size);
            });
        }

        // Apply sorting
        if ($request->has('sort') && !empty($request->input('sort'))) {
            $sort = $request->input('sort');
            $direction = $request->input('direction', 'asc');
            if (in_array($sort, ['name', 'price', 'created_at'])) {
                $query->orderBy($sort, $direction);
            }
        }

        $products = $query
            ->orderBy('products.created_at', 'desc')
            ->paginate(10);

        return Inertia::render('Admin/Products', [
            'products' => $products,
            'filters' => $request->only(['search', 'brand', 'category', 'type', 'color', 'size', 'sort', 'direction']),
            'filterOptions' => $this->getFilterOptions($request)
        ]);
    }

    public function loadMoreProducts(Request $request)
    {
        $query = Product::with('photos', 'sizes');


        // Apply search filter
        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Apply other filters
        foreach (['brand', 'category', 'type', 'color'] as $filter) {
            if ($request->has($filter) && !empty($request->input($filter))) {
                $query->where($filter, $request->input($filter));
            }
        }

        if ($request->has('size') && !empty($request->input('size'))) {
            $size = $request->input('size');
            $query->whereHas('sizes', function ($q) use ($size) {
                $q->where('name', $size);
            });
        }

        // Apply sorting
        if ($request->has('sort') && !empty($request->input('sort'))) {
            $sort = $request->input('sort');
            switch ($sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
            }
        }

        $products = $query
            ->orderBy('products.created_at', 'desc')
            ->paginate(10);

        return response()->json($products);
    }

    public function getFilterOptions(Request $request = null)
    {
        $query = Product::query();

        // Apply current filters to the query
        if ($request) {
            foreach (['brand', 'category', 'type', 'color'] as $filter) {
                if ($request->has($filter) && !empty($request->input($filter))) {
                    $query->where($filter, $request->input($filter));
                }
            }

            if ($request->has('size') && !empty($request->input('size'))) {
                $size = $request->input('size');
                $query->whereHas('sizes', function ($q) use ($size) {
                    $q->where('name', $size);
                });
            }
        }

        return [
            'brands' => $query->distinct('brand')->pluck('brand')->toArray(),
            'categories' => $query->distinct('category')->pluck('category')->toArray(),
            'types' => $query->distinct('type')->pluck('type')->toArray(),
            'colors' => $query->distinct('color')->pluck('color')->toArray(),
            'sizes' => DB::table('products_sizes')
                        ->join('products', 'products_sizes.product_id', '=', 'products.id')
                        ->when($request, function ($q) use ($request) {
                            foreach (['brand', 'category', 'type', 'color'] as $filter) {
                                if ($request->has($filter) && !empty($request->input($filter))) {
                                    $q->where($filter, $request->input($filter));
                                }
                            }

                            if ($request->has('size') && !empty($request->input('size'))) {
                                $size = $request->input('size');
                                $q->where('products_sizes.name', $size);
                            }
                        })
                        ->distinct()
                        ->pluck('products_sizes.name')->toArray(),
        ];
    }

    public function filterOptions(Request $request)
    {
        return response()->json($this->getFilterOptions($request));
    }

    public function new(Request $request): Response
    {
        return Inertia::render('Admin/Product',[
            'product' => null
        ]);
    }


    function store(StoreProductRequest $request)
    {
        $product = Product::create($request->only(['name', 'brand', 'color', 'category', 'type', 'description', 'price']));

        // Handle sizes
        $sizes = collect($request->sizes)->map(function ($size) {
            return new ProductsSize($size);
        });
        $product->sizes()->saveMany($sizes);

        // Handle photos
        foreach ($request->file('photos') as $file) {
            $path = $file->store('public/products/product-' . $product->id);
            $product->photos()->create(['path' => Storage::url($path)]);
        }

        return redirect()->route('products')->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        return Inertia::render('Admin/Product', [
            'product' => $product->load('sizes', 'photos'),
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->only(['name', 'brand', 'color', 'category', 'type', 'description', 'price']));

        // Update sizes
        $product->sizes()->delete();
        $sizes = collect($request->sizes)->map(function ($size) {
            return new ProductsSize($size);
        });
        $product->sizes()->saveMany($sizes);

        // Handle photos to delete
        if ($request->has('photosToDelete')) {
            foreach ($request->photosToDelete as $photoId) {
                $photo = ProductsPhoto::find($photoId);
                if ($photo) {
                    Storage::delete('public/products/product-' . $product->id . '/' . basename($photo->path));
                    $photo->delete();
                }
            }
        }

        // Handle new photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = $file->store('public/products/product-' . $product->id);
                $product->photos()->create(['path' => Storage::url($path)]);
            }
        }

        return redirect()->route('products')->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products')->with('success', 'Product deleted successfully');
    }
}
