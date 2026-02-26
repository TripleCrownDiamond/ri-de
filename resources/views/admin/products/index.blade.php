@extends('layouts.admin')

@section('header', 'Gestion des Produits')

@section('content')
<div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-8 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
        <h3 class="text-xl font-black text-gray-900 uppercase tracking-tighter">Liste des produits</h3>
        <a href="{{ route('admin.products.create', ['locale' => app()->getLocale()]) }}" class="px-6 py-3 bg-blue-600 text-white text-sm font-bold rounded-2xl shadow-lg shadow-red-900/20 hover:scale-105 transition-all">
            + Ajouter un produit
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50">
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Image</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Titre / SKU</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Marque</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Prix TTC</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Statut</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($products as $product)
                <tr class="group hover:bg-gray-50/50 transition-colors">
                    <td class="px-8 py-5">
                        <div class="w-16 h-16 rounded-2xl overflow-hidden bg-gray-100 border border-gray-100">
                            @if($product->media->first())
                                <img src="{{ $product->media->first()->path }}" class="w-full h-full object-cover" alt="">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        <div class="font-bold text-gray-900">{{ $product->title }}</div>
                        <div class="text-xs text-gray-400 font-medium">{{ $product->sku }}</div>
                    </td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 text-[11px] font-bold rounded-full uppercase">
                            {{ $product->brand->name ?? 'N/A' }}
                        </span>
                    </td>
                    <td class="px-8 py-5">
                        <div class="font-black text-gray-900">{{ number_format($product->price_ttc, 2, ',', ' ') }} €</div>
                    </td>
                    <td class="px-8 py-5">
                        @if($product->is_active)
                            <span class="flex items-center text-[10px] font-black uppercase tracking-widest text-green-600">
                                <span class="w-2 h-2 rounded-full bg-green-600 mr-2"></span>
                                Actif
                            </span>
                        @else
                            <span class="flex items-center text-[10px] font-black uppercase tracking-widest text-gray-400">
                                <span class="w-2 h-2 rounded-full bg-gray-400 mr-2"></span>
                                Inactif
                            </span>
                        @endif
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.products.edit', ['locale' => app()->getLocale(), 'product' => $product]) }}" class="p-2 text-gray-400 hover:text-gray-900 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('admin.products.destroy', ['locale' => app()->getLocale(), 'product' => $product]) }}" method="POST" onsubmit="return confirm('Supprimer ce produit ?')">
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
                    <td colspan="6" class="px-8 py-20 text-center">
                        <div class="flex flex-col items-center">
                            <svg class="w-16 h-16 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">Aucun produit trouvé</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
    <div class="px-8 py-6 border-t border-gray-50 bg-gray-50/30">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
