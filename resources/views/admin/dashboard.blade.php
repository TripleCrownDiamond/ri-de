@extends('layouts.admin')

@section('header', 'Tableau de bord')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
    <!-- Stats Cards -->
    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl hover:shadow-gray-200/50 transition-all duration-500">
        <div>
            <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Produits</p>
            <h3 class="text-4xl font-black text-gray-900">{{ $stats['products_count'] }}</h3>
        </div>
        <div class="p-4 bg-red-50 text-red-600 rounded-2xl group-hover:bg-red-600 group-hover:text-white transition-colors duration-500">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        </div>
    </div>

    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl hover:shadow-gray-200/50 transition-all duration-500">
        <div>
            <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Catégories</p>
            <h3 class="text-4xl font-black text-gray-900">{{ $stats['categories_count'] }}</h3>
        </div>
        <div class="p-4 bg-gray-50 text-gray-600 rounded-2xl group-hover:bg-gray-900 group-hover:text-white transition-colors duration-500">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
        </div>
    </div>

    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl hover:shadow-gray-200/50 transition-all duration-500">
        <div>
            <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Marques</p>
            <h3 class="text-4xl font-black text-gray-900">{{ $stats['brands_count'] }}</h3>
        </div>
        <div class="p-4 bg-gray-50 text-gray-600 rounded-2xl group-hover:bg-gray-900 group-hover:text-white transition-colors duration-500">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
        </div>
    </div>
</div>

<div class="mt-12">
    <div class="flex items-center justify-between mb-8">
        <h3 class="text-2xl font-black text-gray-900 uppercase tracking-tighter">Actions rapides</h3>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <a href="{{ route('admin.products.create', ['locale' => app()->getLocale()]) }}" class="p-6 bg-red-600 text-white rounded-[2rem] shadow-lg shadow-red-900/20 hover:scale-[1.02] transition-transform flex flex-col items-center text-center">
            <svg class="w-8 h-8 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span class="font-bold">Ajouter un produit</span>
        </a>
        <a href="{{ route('admin.categories.create', ['locale' => app()->getLocale()]) }}" class="p-6 bg-gray-900 text-white rounded-[2rem] shadow-lg shadow-gray-900/20 hover:scale-[1.02] transition-transform flex flex-col items-center text-center">
            <svg class="w-8 h-8 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span class="font-bold">Nouvelle catégorie</span>
        </a>
        <a href="{{ route('admin.settings.index', ['locale' => app()->getLocale()]) }}" class="p-6 bg-white text-gray-900 border border-gray-100 rounded-[2rem] shadow-sm hover:shadow-xl hover:shadow-gray-200/50 hover:scale-[1.02] transition-all flex flex-col items-center text-center">
            <svg class="w-8 h-8 mb-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span class="font-bold">Modifier les infos</span>
        </a>
        <a href="{{ url(app()->getLocale() . '/') }}" target="_blank" class="p-6 bg-white text-gray-900 border border-gray-100 rounded-[2rem] shadow-sm hover:shadow-xl hover:shadow-gray-200/50 hover:scale-[1.02] transition-all flex flex-col items-center text-center">
            <svg class="w-8 h-8 mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span class="font-bold text-gray-400">Voir le site</span>
        </a>
    </div>
</div>
@endsection
