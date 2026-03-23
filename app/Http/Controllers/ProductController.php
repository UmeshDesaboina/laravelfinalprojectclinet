<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::with(['category', 'images', 'reviews.user'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedProducts = Product::with(['category', 'images'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function searchSuggestions(Request $request)
    {
        $query = $request->q;
        if (strlen($query) < 3) return response()->json([]);

        $products = Product::with('images')
            ->where('name', 'LIKE', "%{$query}%")
            ->where('is_active', true)
            ->take(5)
            ->get();

        $results = $products->map(function($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => number_format($product->price, 2),
                'image' => $product->images->first() ? asset('storage/' . $product->images->first()->image_path) : 'https://via.placeholder.com/150'
            ];
        });

        return response()->json($results);
    }
}
