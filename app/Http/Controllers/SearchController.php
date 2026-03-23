<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->q;
        
        if (strlen($query) < 2) {
            return redirect()->back();
        }

        $products = Product::with(['category', 'images'])
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                    ->orWhereHas('category', function($cat) use ($query) {
                        $cat->where('name', 'LIKE', "%{$query}%");
                    });
            })
            ->where('is_active', true)
            ->paginate(12);

        $categories = Category::where('is_active', true)->get();
        
        $title = "Search Results for '{$query}'";

        return view('shop.index', compact('products', 'categories', 'query', 'title'));
    }
}
