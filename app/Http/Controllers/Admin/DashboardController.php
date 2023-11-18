<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\Admin;

class DashboardController
{
    public function generalInformation(){
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('order_status', 1)->sum('order_total');
        $totalAdmins = Admin::count();

        return [
            ['title' => "Tổng sản phẩm", 'total_count' => $totalProducts],
            ['title' => "Tổng đơn hàng", 'total_count' => $totalOrders],
            ['title' => "Tổng doanh thu", 'total_count' => number_format($totalRevenue, 0, ',', '.') . ' đ'],
            ['title' => "Tổng quản trị viên ", 'total_count' => $totalAdmins],
        ];
    }

    public function topCategories(Request $request){
    $time_type = $request->time_type;

    $products = Category::join('products', 'products.category_id', '=', 'categories.id')
    ->join('order_details', 'order_details.product_id', '=', 'products.id')
    ->join('orders', 'orders.order_id', '=', 'order_details.order_id')
    ->select('categories.name as category_name', \DB::raw('CAST(SUM(products.new_price * order_details.product_quantity) AS UNSIGNED) as total'))
    ->groupBy('categories.id', 'categories.name')
    ->orderBy('total', 'desc')
    ->when($time_type == 'day', function ($query) {
        return $query->whereDate('orders.order_date', now()->toDateString());
    })
    ->when($time_type == 'week', function ($query) {
        return $query->whereBetween('orders.order_date', [
            now()->subDays(7),
            now()
        ]);
    })
    ->when($time_type == 'month', function ($query) {
        return $query->whereBetween('orders.order_date', [
            now()->subDays(30),
            now()
        ]);
    })
    ->take(10)->get();

    $products->each(function ($product) {
        $productInfo = [
            'name' => $product->name,
            'Lượt xem' => $product->total,
        ];
    });


    //name
    //Lượt xem

    return $products;
    }

    public function topProducts(){
        $common = Product::join('order_details', 'order_details.product_id', '=', 'products.id')
        ->join('orders', 'orders.order_id', '=', 'order_details.order_id')
        ->select('products.name', 'orders.order_date as order_date', 
        \DB::raw('CAST(SUM(products.new_price * order_details.product_quantity) AS UNSIGNED) as total'))
        ->groupBy('products.name', 'order_date');

        $top_products_by_day = clone $common;
        $top_products_by_day = $top_products_by_day->whereDate('order_date', now())->get()
        ->sortByDesc('total')->take(10)->values();

        $top_products_by_week = clone $common;
        $top_products_by_week = $top_products_by_week->whereBetween('order_date', [now()->subDays(7)->toDateString(), now()->toDateString()])->get()
        ->sortByDesc('total')->take(10)->values();

        $top_products_by_month = clone $common;
        $top_products_by_month = $top_products_by_month->whereBetween('order_date', [now()->subDays(30)->toDateString(), now()->toDateString()])->get()
        ->sortByDesc('total')->take(10)->values();
    
        $data =  [
            'top_products_by_day' => $top_products_by_day,
            'top_products_by_week' => $top_products_by_week,
            'top_products_by_month' => $top_products_by_month,
        ];
    
    return $data;
    }
}
