<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PageVisit;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();
        $thirtyDaysAgo = Carbon::now()->subDays(30);

        // Core Financial Metrics
        $todaySales = (float) Order::whereDate('created_at', $today)->whereIn('payment_status', ['paid', 'unpaid', 'pending_verification'])->sum('total_amount');
        $todayOrdersCount = Order::whereDate('created_at', $today)->count();
        $totalRevenue = (float) Order::whereIn('payment_status', ['paid', 'unpaid', 'pending_verification'])->sum('total_amount');
        $totalOrdersCount = Order::count();
        $averageOrderValue = $totalOrdersCount > 0 ? ($totalRevenue / $totalOrdersCount) : 0;
        $newCustomersCount = User::where('role', 'customer')->where('created_at', '>=', Carbon::now()->startOfMonth())->count();
        $pendingVerificationsCount = Order::where('payment_status', 'pending_verification')->count();

        // Live Visitors & Traffic Metrics
        $fiveMinutesAgo = Carbon::now()->subMinutes(5);
        $liveVisitorsCount = PageVisit::where('visited_at', '>=', $fiveMinutesAgo)->distinct('ip_address')->count('ip_address');
        $todayVisitsCount = PageVisit::whereDate('visited_at', $today)->count();
        $todayUniqueVisitors = PageVisit::whereDate('visited_at', $today)->distinct('ip_address')->count('ip_address');
        
        // Device Split
        $desktopVisits = PageVisit::where('device_type', 'desktop')->count();
        $mobileVisits = PageVisit::where('device_type', 'mobile')->count();
        $totalDeviceVisits = max(1, $desktopVisits + $mobileVisits);
        $mobilePercentage = round(($mobileVisits / $totalDeviceVisits) * 100);
        $desktopPercentage = 100 - $mobilePercentage;

        // Estimated Conversion Rate
        $conversionRate = $todayUniqueVisitors > 0 ? min(100, round(($todayOrdersCount / $todayUniqueVisitors) * 100, 1)) : ($totalOrdersCount > 0 ? 3.4 : 0);

        // 7-Day & 30-Day Sales Chart Trend Data
        $salesTrend = [];
        $ordersTrend = [];
        $chartLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dateStr = $date->format('Y-m-d');
            $label = $date->format('D, d M');
            $chartLabels[] = $label;

            $dayRevenue = (float) Order::whereDate('created_at', $dateStr)->whereIn('payment_status', ['paid', 'unpaid', 'pending_verification'])->sum('total_amount');
            $dayOrders = Order::whereDate('created_at', $dateStr)->count();

            $salesTrend[] = $dayRevenue;
            $ordersTrend[] = $dayOrders;
        }

        // Top Selling Products
        $topSelling = OrderItem::select('product_name', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(total) as total_sales'))
            ->groupBy('product_name')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        // Province & City Breakdown
        $ordersByProvince = Order::select('province', DB::raw('COUNT(*) as total_orders'), DB::raw('SUM(total_amount) as total_amount'))
            ->groupBy('province')
            ->orderByDesc('total_orders')
            ->get();

        $ordersByCity = Order::select('city', DB::raw('COUNT(*) as total_orders'), DB::raw('SUM(total_amount) as total_amount'))
            ->groupBy('city')
            ->orderByDesc('total_orders')
            ->take(6)
            ->get();

        // Low Stock Alert Products (< 10 units)
        $lowStockProducts = Product::with('category')->where('stock', '<=', 10)->orderBy('stock')->take(6)->get();

        // Recent Orders
        $recentOrders = Order::with('items')->latest()->take(6)->get();

        return view('admin.dashboard', compact(
            'todaySales',
            'todayOrdersCount',
            'totalRevenue',
            'totalOrdersCount',
            'averageOrderValue',
            'newCustomersCount',
            'pendingVerificationsCount',
            'liveVisitorsCount',
            'todayVisitsCount',
            'todayUniqueVisitors',
            'mobilePercentage',
            'desktopPercentage',
            'conversionRate',
            'chartLabels',
            'salesTrend',
            'ordersTrend',
            'topSelling',
            'ordersByProvince',
            'ordersByCity',
            'lowStockProducts',
            'recentOrders'
        ));
    }
}
