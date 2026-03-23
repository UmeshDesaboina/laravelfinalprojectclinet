<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Review;
use App\Models\Product;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false // Admin needs to approve
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully! It will be visible after approval.');
    }
}
