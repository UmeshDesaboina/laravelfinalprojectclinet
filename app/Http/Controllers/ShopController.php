<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'images'])->where('is_active', true);

        // Filters
        if ($request->category) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->size) {
            $query->whereJsonContains('variants', $request->size);
        }

        // Sorting
        switch ($request->sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->latest();
                break;
            case 'best_seller':
                $query->withCount('orderItems')->orderBy('order_items_count', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('shop.product-grid', compact('products'))->render(),
                'pagination' => $products->links()->render()
            ]);
        }

        return view('shop.index', compact('products', 'categories'));
    }
}
