<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ShopController extends Controller
{
    public function index(Request $request): Response
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
            ->paginate(200);

        // dd($products);

        return Inertia::render('Shop/Shop', [
            'products' => $products,
        ]);
    }

    public function product(Product $product): Response
    {
        $product->load('photos', 'sizes');

        return Inertia::render('Shop/Description', [
            'product' => $product,
        ]);
    }
}
