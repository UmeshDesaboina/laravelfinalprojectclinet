<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\ReturnRequest;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();

        $totalRevenue = Order::where('payment_status', 'paid')
            ->sum('total_amount');

        $totalUsers = User::where('role', 'user')->count();

        $totalProductsSold = OrderItem::sum('quantity');

        $recentOrders = Order::with('user')->latest()->limit(5)->get();

        // ✅ SALES DATA (PostgreSQL compatible)
        $salesData = Order::select(
                DB::raw("DATE(created_at) as date"),
                DB::raw("SUM(total_amount) as total")
            )
            ->where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $lowStockProducts = Product::where('stock', '<', 10)
            ->where('is_active', true)
            ->get();

        $pendingReviews = Review::where('is_approved', false)->count();

        $pendingReturns = ReturnRequest::where('status', 'pending')->count();

        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                $item->product = Product::find($item->product_id);
                return $item;
            });

        // ✅ MONTHLY STATS (FIXED FOR POSTGRESQL)
        $monthlyStats = Order::select(
                DB::raw("EXTRACT(MONTH FROM created_at) as month"),
                DB::raw("SUM(total_amount) as revenue"),
                DB::raw("COUNT(*) as orders")
            )
            ->where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'totalUsers',
            'totalProductsSold',
            'recentOrders',
            'salesData',
            'lowStockProducts',
            'pendingReviews',
            'pendingReturns',
            'topProducts',
            'monthlyStats'
        ));
    }
}
