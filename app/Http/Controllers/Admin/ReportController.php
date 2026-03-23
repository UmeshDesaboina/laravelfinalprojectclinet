<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total');
        $totalUsers = User::where('role', 'user')->count();
        $totalProducts = Product::count();

        $monthlySales = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total) as total'),
                DB::raw('COUNT(*) as orders')
            )
            ->where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $topProducts = Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->limit(10)
            ->get();

        $topCategories = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('COUNT(order_items.id) as total_sold'))
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();

        return view('admin.reports.index', compact(
            'totalOrders', 'totalRevenue', 'totalUsers', 'totalProducts',
            'monthlySales', 'topProducts', 'topCategories'
        ));
    }

    public function exportOrders(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : now()->subMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : now();

        $orders = Order::with(['user', 'items.product'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $filename = "orders-report-" . $startDate->format('Y-m-d') . "-to-" . $endDate->format('Y-m-d') . ".csv";
        
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['Order ID', 'Customer', 'Email', 'Items', 'Subtotal', 'Delivery', 'Discount', 'Total', 'Status', 'Payment', 'Date'];

        $callback = function() use($orders, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($orders as $order) {
                $items = $order->items->map(function($item) {
                    return "{$item->product->name} x {$item->quantity}";
                })->implode(', ');

                fputcsv($file, [
                    $order->id,
                    $order->user->name,
                    $order->user->email,
                    $items,
                    number_format($order->subtotal, 2),
                    number_format($order->shipping_cost, 2),
                    number_format($order->discount, 2),
                    number_format($order->total, 2),
                    ucfirst($order->status),
                    ucfirst($order->payment_status),
                    $order->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
