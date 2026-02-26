<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index($locale)
    {
        $stats = [
            'products_count' => Product::count(),
            'categories_count' => Category::count(),
            'brands_count' => Brand::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
