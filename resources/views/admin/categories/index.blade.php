@extends('layouts.admin')

@section('header', 'Gestion des Catégories')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tighter">Liste des catégories</h3>
            <a href="{{ route('admin.categories.create', ['locale' => app()->getLocale()]) }}" class="px-6 py-3 bg-red-600 text-white text-sm font-bold rounded-2xl shadow-lg shadow-red-900/20 hover:scale-105 transition-all">
                + Nouvelle catégorie
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Nom</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Slug</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400 text-center">Position</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($categories as $category)
                    <tr class="group hover:bg-gray-50/50 transition-colors">
                        <td class="px-8 py-5">
                            <div class="font-bold text-gray-900">{{ $category->name }}</div>
                        </td>
                        <td class="px-8 py-5 text-sm text-gray-400 font-medium">
                            {{ $category->slug }}
                        </td>
                        <td class="px-8 py-5 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 text-xs font-black text-gray-600">
                                {{ $category->position }}
                            </span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.categories.edit', ['locale' => app()->getLocale(), 'category' => $category]) }}" class="p-2 text-gray-400 hover:text-gray-900 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('admin.categories.destroy', ['locale' => app()->getLocale(), 'category' => $category]) }}" method="POST" onsubmit="return confirm('Supprimer cette catégorie ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-8 py-20 text-center text-gray-400 font-bold uppercase tracking-widest text-xs">
                            Aucune catégorie
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
