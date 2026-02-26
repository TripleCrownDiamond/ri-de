<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CompanyInfo;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($locale, Category $category, Request $request)
    {
        $query = $category->products()->where('is_active', true)->with('media', 'brand');

        // Filter by Brand
        if ($request->has('brand')) {
            $query->whereIn('brand_id', (array) $request->brand);
        }

        // Filter by Price
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

        $products = $query->paginate(12)->withQueryString();
        
        // Get all brands in this category for the filter
         $brands = \App\Models\Brand::whereHas('products.categories', function($q) use ($category) {
             $q->where('categories.id', $category->id);
         })->get();

        return view('categories.show', compact('category', 'products', 'brands'));
    }
}
