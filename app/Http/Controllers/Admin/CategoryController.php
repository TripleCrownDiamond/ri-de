<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index($locale)
    {
        $categories = Category::latest('id')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create($locale)
    {
        return view('admin.categories.create');
    }

    public function store(Request $request, $locale)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255|unique:categories,name',
            'name_fr' => 'required|string|max:255',
            'name_de' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'position' => 'nullable|integer|min:0',
        ]);

        if (empty($validated['name'])) {
            $validated['name'] = $validated['name_fr'];
        }

        $validated['slug'] = Str::slug($validated['name']);
        Category::create($validated);

        return redirect()->route('admin.categories.index', ['locale' => $locale])->with('success', 'Catégorie créée avec succès.');
    }

    public function edit($locale, Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $locale, Category $category)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255|unique:categories,name,' . $category->id,
            'name_fr' => 'required|string|max:255',
            'name_de' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'position' => 'nullable|integer|min:0',
        ]);

        if (empty($validated['name'])) {
            $validated['name'] = $validated['name_fr'];
        }

        $validated['slug'] = Str::slug($validated['name']);
        $category->update($validated);

        return redirect()->route('admin.categories.index', ['locale' => $locale])->with('success', 'Catégorie mise à jour.');
    }

    public function destroy($locale, Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index', ['locale' => $locale])->with('success', 'Catégorie supprimée.');
    }
}
