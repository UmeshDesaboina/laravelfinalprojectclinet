<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->take(6)->get();
        $featuredProducts = Product::with('images')->where('is_featured', true)->where('is_active', true)->take(8)->get();
        $newArrivals = Product::with('images')->where('is_active', true)->latest()->take(8)->get();

        return view('home', compact('categories', 'featuredProducts', 'newArrivals'));
    }
}
