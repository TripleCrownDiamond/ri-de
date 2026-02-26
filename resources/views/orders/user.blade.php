<x-public-layout>
    <div class="bg-gray-50 py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-12">
                <div>
                    <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tighter sm:text-4xl">{{ __('Mes Commandes') }}</h2>
                    <p class="mt-2 text-lg text-gray-600">
                        {{ __('Suivez l\'état de vos demandes et commandes en cours.') }}
                    </p>
                </div>
                <div class="mt-6 md:mt-0">
                    <a href="{{ route('shop.index') }}" class="px-8 py-4 bg-white border border-gray-200 text-sm font-black uppercase tracking-widest rounded-2xl shadow-sm hover:shadow-md transition-all">
                        {{ __('Continuer mes achats') }}
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-gray-400">{{ __('Date') }}</th>
                                <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-gray-400">{{ __('Produit') }}</th>
                                <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-gray-400 text-center">{{ __('Qté') }}</th>
                                <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-gray-400">{{ __('Statut') }}</th>
                                <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-gray-400 text-right">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($orders as $order)
                            <tr class="group hover:bg-gray-50/30 transition-colors">
                                <td class="px-8 py-6">
                                    <div class="text-sm font-bold text-gray-900">{{ $order->created_at->format('d/m/Y') }}</div>
                                    <div class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">{{ $order->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="text-sm font-black text-gray-900 uppercase tracking-tight">{{ $order->product_name }}</div>
                                    @if($order->sku)
                                    <div class="text-[10px] text-gray-400 font-bold uppercase">SKU: {{ $order->sku }}</div>
                                    @endif
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 text-xs font-black text-gray-600">
                                        {{ $order->quantity }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-amber-50 text-amber-600',
                                            'processing' => 'bg-blue-50 text-blue-600',
                                            'completed' => 'bg-green-50 text-green-600',
                                            'cancelled' => 'bg-blue-50 text-blue-600',
                                        ];
                                        $statusLabels = [
                                            'pending' => 'En attente',
                                            'processing' => 'En cours',
                                            'completed' => 'Terminée',
                                            'cancelled' => 'Annulée',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $statusClasses[$order->status] ?? 'bg-gray-50 text-gray-600' }}">
                                        {{ __($statusLabels[$order->status] ?? $order->status) }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <button class="text-xs font-black uppercase tracking-widest text-gray-400 hover:text-blue-600 transition-colors">
                                        {{ __('Détails') }}
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-24 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                        </div>
                                        <p class="text-sm font-bold text-gray-400 uppercase tracking-widest">{{ __('Aucune commande pour le moment') }}</p>
                                        <a href="{{ route('shop.index') }}" class="mt-6 text-blue-600 font-black uppercase tracking-widest text-xs hover:underline">
                                            {{ __('Parcourir la boutique') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($orders->hasPages())
                <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-50">
                    {{ $orders->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-public-layout>
