@extends('layouts.admin')

@section('header', isset($category) ? 'Modifier la catégorie' : 'Nouvelle catégorie')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
        <form action="{{ isset($category) ? route('admin.categories.update', ['locale' => app()->getLocale(), 'category' => $category]) : route('admin.categories.store', ['locale' => app()->getLocale()]) }}" method="POST">
            @csrf
            @if(isset($category)) @method('PUT') @endif

            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Nom de la catégorie (FR)</label>
                    <input type="text" name="name_fr" value="{{ old('name_fr', $category->name_fr ?? '') }}" required
                        class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-600 font-bold transition-all">
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Nom de la catégorie (DE)</label>
                    <input type="text" name="name_de" value="{{ old('name_de', $category->name_de ?? '') }}"
                        class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-600 font-bold transition-all">
                </div>

                <div class="hidden">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Nom Technique (Interne)</label>
                    <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}"
                        class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-600 font-bold transition-all">
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Description (Optionnel)</label>
                    <textarea name="description" rows="4"
                        class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-600 font-medium transition-all">{{ old('description', $category->description ?? '') }}</textarea>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 bg-blue-600 text-white font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-red-900/20 hover:bg-blue-700 hover:scale-[1.02] active:scale-95 transition-all">
                        {{ isset($category) ? 'Mettre à jour' : 'Créer la catégorie' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
