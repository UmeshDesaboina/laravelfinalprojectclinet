<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        $cartItems = CartItem::with(['product.images', 'product.category'])
            ->where('user_id', auth()->id())
            ->get();

        $subtotal = $cartItems->sum(function($item) {
            $price = $item->product->discount_price ?? $item->product->price;
            return $price * $item->quantity;
        });

        $deliveryCharge = $cartItems->sum(function($item) {
            return $item->product->delivery_charge;
        });

        return view('cart.index', compact('cartItems', 'subtotal', 'deliveryCharge'));
    }

    public function add(Request $request, Product $product)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false, 
                'message' => 'Please login to add items to cart',
                'redirect' => route('login')
            ], 401);
        }

        $request->validate([
            'quantity' => 'integer|min:1',
            'variant' => 'nullable|string'
        ]);

        $cartItem = CartItem::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->where(function($query) use ($request) {
                $query->where('variant', $request->variant)->orWhereNull('variant');
            })
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity ?? 1);
        } else {
            CartItem::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity ?? 1,
                'variant' => $request->variant
            ]);
        }

        $count = CartItem::where('user_id', auth()->id())->sum('quantity');
        return response()->json(['success' => true, 'message' => 'Product added to cart!', 'count' => $count]);
    }

    public function update(Request $request, CartItem $cartItem)
    {
        if ($cartItem->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json(['success' => true]);
    }

    public function remove(CartItem $cartItem)
    {
        if ($cartItem->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        $cartItem->delete();
        return response()->json(['success' => true]);
    }

    public function count()
    {
        $count = 0;
        if (auth()->check()) {
            $count = CartItem::where('user_id', auth()->id())->sum('quantity');
        }
        return response()->json(['count' => $count]);
    }
}
