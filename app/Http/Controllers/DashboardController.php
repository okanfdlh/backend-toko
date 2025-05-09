<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
   public function dashboard()
{
    $orders = Order::with('orderItems')->get();
    $monthlyProfits = array_fill(0, 12, 0);

    foreach ($orders as $order) {
        $orderDate = \Carbon\Carbon::parse($order->transaction_time);
        $month = $orderDate->month - 1;
        $profit = $order->total - $order->discount - $order->tax - $order->service_charge;
        $monthlyProfits[$month] += $profit;
    }

    $bestSellingProducts = OrderItem::select('id_product', DB::raw('SUM(quantity) as total_sales'))
        ->groupBy('id_product')
        ->orderByDesc('total_sales')
        ->with('product') // pastikan relasi 'product' tersedia di model OrderItem
        ->limit(5)
        ->get();

    $bestSellingProductNames = $bestSellingProducts->pluck('product.name'); // nama produk
    $bestSellingProductSales = $bestSellingProducts->pluck('total_sales');  // jumlah terjual

    $salesVolumes = [350, 420, 290, 580, 600, 500, 450, 600, 700, 400, 550, 600];

    return view('pages.dashboard', compact(
        'monthlyProfits',
        'bestSellingProducts',
        'bestSellingProductNames',
        'bestSellingProductSales',
        'salesVolumes'
    ));
}

}
