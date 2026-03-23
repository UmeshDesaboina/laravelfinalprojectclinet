<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ReturnRequest;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        if ($order->user_id !== auth()->id()) abort(403);
        $order->load(['items.product.images', 'address', 'returnRequest']);
        return view('orders.show', compact('order'));
    }

    public function cancel($id)
    {
        $order = Order::findOrFail($id);
        if ($order->user_id !== auth()->id()) abort(403);
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending orders can be cancelled.');
        }

        $order->update(['status' => 'cancelled']);
        return redirect()->back()->with('success', 'Order cancelled successfully.');
    }

    public function showReturnForm($id)
    {
        $order = Order::findOrFail($id);
        if ($order->user_id !== auth()->id()) abort(403);
        if ($order->status !== 'delivered') {
            return redirect()->route('orders.show', $order)->with('error', 'Only delivered orders can be returned.');
        }
        if ($order->returnRequest()->whereIn('status', ['pending', 'approved'])->exists()) {
            return redirect()->route('orders.show', $order)->with('error', 'A return request is already in progress.');
        }
        return view('returns.create', compact('order'));
    }

    public function requestReturn(Request $request, $id)
    {
        $order = Order::with('items')->findOrFail($id);
        if ($order->user_id !== auth()->id()) abort(403);
        if ($order->status !== 'delivered') {
            return redirect()->back()->with('error', 'Only delivered orders can be returned.');
        }

        if ($order->returnRequest()->whereIn('status', ['pending', 'approved'])->exists()) {
            return redirect()->back()->with('error', 'A return request is already in progress for this order.');
        }

        $request->validate([
            'reason' => 'required|string',
            'reason_description' => 'nullable|string',
            'bank_account_number' => 'required|string',
            'bank_ifsc' => 'required|string',
            'bank_account_name' => 'required|string',
        ]);

        ReturnRequest::create([
            'request_number' => 'RR' . strtoupper(uniqid()),
            'order_id' => $order->id,
            'order_item_id' => $order->items->first()->id ?? null,
            'user_id' => auth()->id(),
            'reason' => $request->reason,
            'reason_description' => $request->reason_description,
            'status' => 'pending',
            'refund_amount' => $order->total,
            'bank_account_number' => $request->bank_account_number,
            'bank_ifsc' => $request->bank_ifsc,
            'bank_account_name' => $request->bank_account_name,
        ]);

        return redirect()->route('orders.show', $order)->with('success', 'Return request submitted successfully.');
    }

    public function cancelReturn($id)
    {
        $return = ReturnRequest::findOrFail($id);
        if ($return->user_id !== auth()->id()) abort(403);
        
        if (!in_array($return->status, ['pending', 'approved'])) {
            return redirect()->back()->with('error', 'Return request cannot be cancelled at this stage.');
        }

        $return->delete();
        return redirect()->back()->with('success', 'Return request cancelled successfully.');
    }

    public function downloadInvoice($id)
    {
        $order = Order::findOrFail($id);
        return response()->streamDownload(function() use ($order) {
            echo "Invoice for Order #{$order->order_number}\n";
            echo "Customer: {$order->user->name}\n";
            echo "Total: ₹{$order->total}\n";
        }, "invoice-{$order->order_number}.txt");
    }
}
