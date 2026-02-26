<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CompanyInfo;

class ProductController extends Controller
{
    public function show($locale, Product $product)
    {
        $product->load(['brand', 'media' => function ($query) {
            $query->orderBy('position');
        }, 'categories']);

        $featuredMedia = $product->media->firstWhere('is_primary', true) ?? $product->media->first();

        $primaryCategory = $product->categories->first();

        $similarProducts = collect();

        if ($primaryCategory) {
            $similarProducts = Product::query()
                ->whereHas('categories', function ($query) use ($primaryCategory) {
                    $query->where('categories.id', $primaryCategory->id);
                })
                ->where('id', '!=', $product->id)
                ->where('is_active', true)
                ->with(['brand', 'media' => function ($query) {
                    $query->orderBy('position');
                }])
                ->latest('id')
                ->limit(4)
                ->get();
        }

        return view('products.show', [
            'product' => $product,
            'featuredMedia' => $featuredMedia,
            'similarProducts' => $similarProducts,
        ]);
    }
}
