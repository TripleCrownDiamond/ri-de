<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LegalPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LegalPageController extends Controller
{
    public function index($locale)
    {
        $pages = LegalPage::latest()->paginate(10);
        return view('admin.legal-pages.index', compact('pages'));
    }

    public function create($locale)
    {
        return view('admin.legal-pages.create');
    }

    public function store(Request $request, $locale)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        LegalPage::create($validated);

        return redirect()->route('admin.legal-pages.index', ['locale' => $locale])->with('success', 'Page légale créée.');
    }

    public function edit($locale, LegalPage $legalPage)
    {
        return view('admin.legal-pages.edit', compact('legalPage'));
    }

    public function update(Request $request, $locale, LegalPage $legalPage)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $legalPage->update($validated);

        return redirect()->route('admin.legal-pages.index', ['locale' => $locale])->with('success', 'Page légale mise à jour.');
    }

    public function destroy($locale, LegalPage $legalPage)
    {
        $legalPage->delete();
        return redirect()->route('admin.legal-pages.index', ['locale' => $locale])->with('success', 'Page légale supprimée.');
    }
}
