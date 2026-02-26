<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\CompanyInfo;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true);

        // Filter by search
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $categorySlugs = (array) $request->category;
            $categories = Category::whereIn('slug', $categorySlugs)->get();
            
            if ($categories->isNotEmpty()) {
                $categoryIds = collect();
                foreach ($categories as $cat) {
                    $categoryIds = $categoryIds->merge($cat->children()->pluck('id'))->push($cat->id);
                }
                
                $query->whereHas('categories', function($q) use ($categoryIds) {
                    $q->whereIn('categories.id', $categoryIds->unique());
                });
            }
        }

        // Filter by brand
        if ($request->filled('brand')) {
            $query->whereIn('brand_id', (array) $request->brand);
        }

        // Filter by price
        if ($request->filled('min_price')) {
            $query->where('price_ttc', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price_ttc', '<=', $request->max_price);
        }

        // Sort
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price_ttc', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price_ttc', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('title', 'asc');
                break;
            default:
                $query->latest('id');
                break;
        }

        $products = $query->with('media', 'brand')->paginate(12)->withQueryString();
        
        $categories = Category::all();
        $brands = Brand::all();
        return view('shop.index', compact('products', 'categories', 'brands'));
    }
}
