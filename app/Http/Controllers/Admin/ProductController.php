<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index($locale)
    {
        $products = Product::with('brand', 'categories')->latest('id')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create($locale)
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request, $locale)
    {
        $validated = $request->validate([
            'title_de' => 'required|string|max:255',
            'description_de' => 'required|string',
            'brand_id' => 'nullable|exists:brands,id',
            'price_ht' => 'nullable|numeric|min:0',
            'price_ttc' => 'nullable|numeric|min:0',
            'sku' => 'required|string|unique:products,sku',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'is_active' => 'boolean',
            'main_image' => 'nullable|string',
            'images' => 'nullable|array', // Cloudinary public IDs or URLs
            'images.*' => 'string',
        ]);

        $validated['title'] = $validated['title_de'];
        $validated['description'] = $validated['description_de'];
        $validated['slug'] = Str::slug($validated['title_de']);
        $product = Product::create($validated);
        $product->categories()->sync($validated['categories']);

        // Main Image
        if ($request->has('main_image') && $request->main_image) {
            ProductMedia::create([
                'product_id' => $product->id,
                'type' => 'image',
                'path' => $request->main_image,
                'position' => 0,
                'is_primary' => true,
            ]);
        }

        // Gallery Images
        if ($request->has('images')) {
            foreach ($request->images as $index => $imageUrl) {
                ProductMedia::create([
                    'product_id' => $product->id,
                    'type' => 'image',
                    'path' => $imageUrl,
                    'position' => $index + 1,
                    'is_primary' => false,
                ]);
            }
        }

        return redirect()->route('admin.products.index', ['locale' => $locale])->with('success', 'Produit créé avec succès.');
    }

    public function edit(Request $request, $locale, Product $product)
    {
        $product->load('categories', 'media');
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, $locale, Product $product)
    {
        $validated = $request->validate([
            'title_de' => 'required|string|max:255',
            'description_de' => 'required|string',
            'brand_id' => 'nullable|exists:brands,id',
            'price_ht' => 'nullable|numeric|min:0',
            'price_ttc' => 'nullable|numeric|min:0',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'is_active' => 'boolean',
            'main_image' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'string',
        ]);

        $validated['title'] = $validated['title_de'];
        $validated['description'] = $validated['description_de'];
        $validated['slug'] = Str::slug($validated['title_de']);
        $validated['is_active'] = $request->has('is_active');
        $product->update($validated);
        $product->categories()->sync($validated['categories']);

        // Main Image Update
        if ($request->has('main_image') && $request->main_image) {
            // Delete old primary image
            $product->media()->where('is_primary', true)->delete();
            
            ProductMedia::create([
                'product_id' => $product->id,
                'type' => 'image',
                'path' => $request->main_image,
                'position' => 0,
                'is_primary' => true,
            ]);
        }

        // New Gallery Images
        if ($request->has('images')) {
            foreach ($request->images as $index => $imageUrl) {
                ProductMedia::create([
                    'product_id' => $product->id,
                    'type' => 'image',
                    'path' => $imageUrl,
                    'position' => $product->media()->max('position') + 1,
                    'is_primary' => false,
                ]);
            }
        }

        return redirect()->route('admin.products.index', ['locale' => $locale])->with('success', 'Produit mis à jour avec succès.');
    }

    public function destroy($locale, Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index', ['locale' => $locale])->with('success', 'Produit supprimé.');
    }

    public function removeMedia(ProductMedia $media)
    {
        $media->delete();
        
        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
        
        return back()->with('success', 'Image supprimée.');
    }

    public function addMedia(Request $request, Product $product)
    {
        $request->validate([
            'image_url' => 'required|string',
        ]);

        $media = ProductMedia::create([
            'product_id' => $product->id,
            'type' => 'image',
            'path' => $request->image_url,
            'position' => $product->media()->count(),
            'is_primary' => $product->media()->count() === 0,
        ]);

        return response()->json([
            'success' => true,
            'media' => $media
        ]);
    }
}
