<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index($locale)
    {
        $stats = [
            'orders_count' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'products_count' => Product::count(),
            'users_count' => User::count(),
        ];

        $recent_orders = Order::latest('id')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_orders'));
    }
}
