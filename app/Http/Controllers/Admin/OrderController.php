<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ReturnRequest;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();
        
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        $order->load(['user', 'items.product', 'address', 'returnRequest']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $rules = [
            'status' => 'required|string|in:pending,processing,shipped,delivered,cancelled',
        ];

        if ($request->status === 'shipped') {
            $rules['courier_name'] = 'required|string';
            $rules['tracking_id'] = 'required|string';
        }

        $request->validate($rules);

        $updateData = ['status' => $request->status];

        if ($request->status === 'shipped') {
            $updateData['courier_name'] = $request->courier_name;
            $updateData['tracking_id'] = $request->tracking_id;
        }

        $order->update($updateData);

        return response()->json(['success' => true, 'message' => 'Order status updated successfully.']);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->back()->with('success', 'Order deleted successfully.');
    }

    public function exportCSV()
    {
        $orders = Order::with('user')->get();
        $filename = "orders-" . now()->format('Y-m-d') . ".csv";
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Order ID', 'Customer', 'Email', 'Amount', 'Status', 'Payment', 'Date'];

        $callback = function() use($orders, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_number,
                    $order->user->name,
                    $order->user->email,
                    $order->total,
                    $order->status,
                    $order->payment_status,
                    $order->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function returns()
    {
        $returns = ReturnRequest::with(['order.user', 'user'])->latest()->paginate(15);
        return view('admin.returns.index', compact('returns'));
    }

    public function showReturn($id)
    {
        $return = ReturnRequest::with(['order.user', 'order.items.product', 'user'])->findOrFail($id);
        return view('admin.returns.show', compact('return'));
    }

    public function updateReturn(Request $request, $id)
    {
        $return = ReturnRequest::findOrFail($id);

        $rules = [
            'status' => 'required|string',
        ];

        if ($request->status === 'approved' || $request->status === 'picked') {
            $rules['courier_name'] = 'required|string';
            $rules['tracking_id'] = 'required|string';
        }

        if ($request->status === 'refunded') {
            $rules['admin_notes'] = 'nullable|string';
        }

        $request->validate($rules);

        $updateData = ['status' => $request->status];

        if ($request->status === 'approved' || $request->status === 'picked') {
            $updateData['courier_name'] = $request->courier_name;
            $updateData['tracking_id'] = $request->tracking_id;
        }

        if ($request->status === 'refunded') {
            $updateData['refunded_at'] = now();
            $updateData['admin_notes'] = $request->admin_notes;
            $return->order->update(['payment_status' => 'refunded']);
        }

        if ($request->status === 'received') {
            $updateData['processed_at'] = now();
        }

        $return->update($updateData);

        return response()->json(['success' => true, 'message' => 'Return status updated successfully.']);
    }
}
