<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'variants' => 'nullable|array'
        ]);

        $variants = null;
        if ($request->variants) {
            $variants = array_map('trim', explode(',', $request->variants[0] ?? ''));
            $variants = array_filter($variants);
        }

        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'category_id' => $request->category_id,
            'delivery_charge' => $request->delivery_charge ?? 0,
            'stock' => $request->stock,
            'is_featured' => $request->has('is_featured'),
            'variants' => $variants,
            'is_active' => $request->has('is_active') ? true : false
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer'
        ]);

        $product = Product::findOrFail($id);

        $variants = null;
        if ($request->variants) {
            $variants = array_map('trim', explode(',', $request->variants[0] ?? ''));
            $variants = array_filter($variants);
        }

        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'category_id' => $request->category_id,
            'delivery_charge' => $request->delivery_charge ?? 0,
            'stock' => $request->stock,
            'is_featured' => $request->has('is_featured'),
            'variants' => $variants,
            'is_active' => $request->has('is_active') ? true : false
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image);
            $image->delete();
        }
        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully.');
    }

    public function toggleFeatured($id)
    {
        $product = Product::findOrFail($id);
        $product->is_featured = !$product->is_featured;
        $product->save();
        return response()->json(['success' => true, 'is_featured' => $product->is_featured]);
    }
}
