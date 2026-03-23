<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Wishlist;
use App\Models\Product;

class WishlistController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        $wishlistItems = Wishlist::with('product.images', 'product.category')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('wishlist.index', compact('wishlistItems'));
    }

    public function toggle(Product $product)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false, 
                'message' => 'Please login to use wishlist',
                'redirect' => route('login')
            ], 401);
        }

        $wishlist = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['success' => true, 'message' => 'Removed from wishlist']);
        }

        Wishlist::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id
        ]);

        return response()->json(['success' => true, 'message' => 'Added to wishlist']);
    }
}
