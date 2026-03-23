<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Address;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::with(['product.images', 'product.category'])
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('shop')->with('error', 'Your cart is empty.');
        }

        $addresses = Address::where('user_id', auth()->id())->get();
        
        $subtotal = $cartItems->sum(function($item) {
            $price = $item->product->discount_price ?? $item->product->price;
            return $price * $item->quantity;
        });

        $deliveryCharge = $cartItems->sum(function($item) {
            return $item->product->delivery_charge;
        });

        $availableCoupons = Coupon::valid()->get();

        return view('checkout.index', compact('cartItems', 'addresses', 'subtotal', 'deliveryCharge', 'availableCoupons'));
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string']);
        
        $coupon = Coupon::where('code', strtoupper($request->code))->where('is_active', true)->first();
        
        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid coupon code.']);
        }

        $cartItems = CartItem::with('product')->where('user_id', auth()->id())->get();
        $subtotal = $cartItems->sum(function($item) {
            $price = $item->product->discount_price ?? $item->product->price;
            return $price * $item->quantity;
        });

        if (!$coupon->isValid($subtotal)) {
            return response()->json(['success' => false, 'message' => 'Coupon not applicable for this order.']);
        }

        $discount = $coupon->calculateDiscount($subtotal);

        return response()->json([
            'success' => true, 
            'discount' => $discount, 
            'code' => $coupon->code,
            'message' => 'Coupon applied successfully!'
        ]);
    }

    public function process(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:COD,Razorpay'
        ]);

        DB::beginTransaction();
        try {
            $cartItems = CartItem::with('product')->where('user_id', auth()->id())->get();
            $subtotal = $cartItems->sum(function($item) {
                $price = $item->product->discount_price ?? $item->product->price;
                return $price * $item->quantity;
            });
            $deliveryCharge = $cartItems->sum(function($item) {
                return $item->product->delivery_charge;
            });

            $discount = 0;
            if ($request->coupon_code) {
                $coupon = Coupon::where('code', $request->coupon_code)->first();
                if ($coupon && $coupon->isValid($subtotal)) {
                    $discount = $coupon->calculateDiscount($subtotal);
                    $coupon->increment('used_count');
                }
            }

            $order = Order::create([
                'user_id' => auth()->id(),
                'total' => $subtotal + $deliveryCharge - $discount,
                'subtotal' => $subtotal,
                'status' => 'pending',
                'address_id' => $request->address_id,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'COD' ? 'pending' : 'pending',
                'shipping_cost' => $deliveryCharge,
                'discount' => $discount,
                'coupon_code' => $request->coupon_code
            ]);

            foreach ($cartItems as $item) {
                $itemPrice = $item->product->discount_price ?? $item->product->price;
                $itemSubtotal = $itemPrice * $item->quantity;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'sku' => $item->product->sku ?? null,
                    'quantity' => $item->quantity,
                    'price' => $itemPrice,
                    'subtotal' => $itemSubtotal,
                    'total' => $itemSubtotal,
                    'variant' => $item->variant
                ]);

                // Reduce stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Clear cart
            CartItem::where('user_id', auth()->id())->delete();

            DB::commit();

            return response()->json([
                'success' => true, 
                'order_id' => $order->id,
                'redirect' => route('orders.show', $order->id)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function saveAddress(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line_1' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'postal_code' => 'required|string'
        ]);

        $address = Address::create([
            'user_id' => auth()->id(),
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'address_line_1' => $request->address_line_1,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'is_default' => !Address::where('user_id', auth()->id())->exists()
        ]);

        return response()->json(['success' => true, 'address' => $address]);
    }
}
