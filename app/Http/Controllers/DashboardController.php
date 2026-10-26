<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Khusus Role Pelanggan: Tampilkan Portal Belanja & Pesanan Saya
        if (auth()->user()->isPelanggan()) {
            $user = auth()->user();
            $myOrdersCount = Sale::where('user_id', $user->id)->count();
            $myCompletedOrdersCount = Sale::where('user_id', $user->id)->where('status', 'completed')->count();
            $myTotalSpent = Sale::where('user_id', $user->id)->where('status', 'completed')->sum('total');
            $myRecentOrders = Sale::with('items.product')->where('user_id', $user->id)->latest('sold_at')->take(5)->get();
            $catalogProducts = Product::with('category')->where('stock', '>', 0)->latest()->take(8)->get();

            return view('dashboard.pelanggan', compact(
                'myOrdersCount',
                'myCompletedOrdersCount',
                'myTotalSpent',
                'myRecentOrders',
                'catalogProducts'
            ));
        }

        // 2. Dashboard Internal: Khusus Owner & Admin/Staff
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();

        // Database aggregated metrics
        $totalProducts = Product::count();
        $totalSalesCount = Sale::where('status', 'completed')->count();
        $totalPurchasesCount = Purchase::where('status', 'completed')->count();

        // Revenue calculations
        $salesToday = Sale::where('status', 'completed')
            ->whereDate('sold_at', $today)
            ->sum('total');

        $salesThisMonth = Sale::where('status', 'completed')
            ->where('sold_at', '>=', $thisMonth)
            ->sum('total');

        $purchasesThisMonth = Purchase::where('status', 'completed')
            ->where('purchased_at', '>=', $thisMonth)
            ->sum('total');

        // Total Valuasi Aset Stok di Gudang (Metrik Eksekutif Owner)
        $totalInventoryValue = Product::selectRaw('SUM(stock * purchase_price) as val')->value('val') ?? 0;

        // Low stock products
        $lowStockQuery = Product::with('category')->lowStock();
        $lowStockCount = $lowStockQuery->count();
        $lowStockProducts = $lowStockQuery->take(5)->get();

        // Recent sales and purchases
        $recentSales = Sale::with(['user', 'items.product'])
            ->latest('sold_at')
            ->take(5)
            ->get();

        $recentPurchases = Purchase::with(['supplier', 'user', 'items.product'])
            ->latest('purchased_at')
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalProducts',
            'totalSalesCount',
            'totalPurchasesCount',
            'salesToday',
            'salesThisMonth',
            'purchasesThisMonth',
            'totalInventoryValue',
            'lowStockCount',
            'lowStockProducts',
            'recentSales',
            'recentPurchases'
        ));
    }
}
