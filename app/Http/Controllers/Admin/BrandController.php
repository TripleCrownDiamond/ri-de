<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index($locale)
    {
        $brands = Brand::latest('id')->paginate(10);
        return view('admin.brands.index', compact('brands'));
    }

    public function create($locale)
    {
        return view('admin.brands.create');
    }

    public function store(Request $request, $locale)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
            'logo_path' => 'nullable|string', // Cloudinary URL
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        Brand::create($validated);

        return redirect()->route('admin.brands.index', ['locale' => $locale])->with('success', 'Marque créée avec succès.');
    }

    public function edit($locale, Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, $locale, Brand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
            'logo_path' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $brand->update($validated);

        return redirect()->route('admin.brands.index', ['locale' => $locale])->with('success', 'Marque mise à jour.');
    }

    public function destroy($locale, Brand $brand)
    {
        $brand->delete();
        return redirect()->route('admin.brands.index', ['locale' => $locale])->with('success', 'Marque supprimée.');
    }
}
