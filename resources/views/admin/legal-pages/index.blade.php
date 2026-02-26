@extends('layouts.admin')

@section('header', 'Pages Légales')

@section('content')
<div class="max-w-5xl">
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tighter">Liste des pages</h3>
            <a href="{{ route('admin.legal-pages.create', ['locale' => app()->getLocale()]) }}" class="px-6 py-3 bg-blue-600 text-white text-sm font-bold rounded-2xl shadow-lg shadow-red-900/20 hover:scale-105 transition-all">
                + Nouvelle page
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Titre</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Lien (Slug)</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Statut</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($pages as $page)
                    <tr class="group hover:bg-gray-50/50 transition-colors">
                        <td class="px-8 py-5">
                            <div class="font-bold text-gray-900">{{ $page->title }}</div>
                        </td>
                        <td class="px-8 py-5 text-sm text-gray-400 font-medium">
                            /pages/{{ $page->slug }}
                        </td>
                        <td class="px-8 py-5">
                            @if($page->is_active)
                                <span class="text-[10px] font-black uppercase tracking-widest text-green-600">Visible</span>
                            @else
                                <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Masquée</span>
                            @endif
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.legal-pages.edit', ['locale' => app()->getLocale(), 'legal_page' => $page]) }}" class="p-2 text-gray-400 hover:text-gray-900 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('admin.legal-pages.destroy', ['locale' => app()->getLocale(), 'legal_page' => $page]) }}" method="POST" onsubmit="return confirm('Supprimer cette page ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-blue-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center text-gray-400 font-bold uppercase tracking-widest text-xs">
                            Aucune page légale
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
