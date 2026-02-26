@props(['products'])

<section class="relative mx-auto mt-24 max-w-7xl px-6 lg:px-8">
    <div class="mb-12 flex flex-col md:flex-row md:items-end md:justify-between gap-6">
        <div class="space-y-4">
            <div class="flex items-center gap-3">
                <span class="h-px w-8 bg-blue-600"></span>
                <span class="text-xs font-black uppercase tracking-widest text-blue-600">{{ __('Populaire') }}</span>
            </div>
            <h2 class="text-4xl font-black tracking-tight text-gray-900 sm:text-5xl">
                {!! __('Nos meilleures <span class="text-blue-600">ventes</span> .') !!}
            </h2>
        </div>
        <a href="{{ route('shop.index') }}" class="group inline-flex items-center gap-3 rounded-full bg-gray-900 px-8 py-4 text-xs font-black uppercase tracking-widest text-white shadow-xl shadow-gray-200 transition-all hover:bg-blue-600 hover:shadow-red-100 active:scale-95">
            {{ __('Catalogue complet') }}
            <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
        </a>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($products as $product)
            <div class="group relative flex flex-col overflow-hidden rounded-[2.5rem] border border-gray-100 bg-white p-2 shadow-sm transition-all duration-500 hover:-translate-y-2 hover:border-blue-100 hover:shadow-2xl hover:shadow-red-900/5">
                <!-- Image Container -->
                <div class="relative aspect-[4/5] overflow-hidden rounded-[2rem] bg-gray-50">
                    @if ($product->media->isNotEmpty())
                        @php $featured = $product->media->firstWhere('is_primary', true) ?? $product->media->first(); @endphp
                        <img
                            src="{{ Str::startsWith($featured->path, ['http://', 'https://']) ? $featured->path : asset($featured->path) }}"
                            alt="{{ $product->title }}"
                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                        >
                    @endif
                    
                    <!-- Badges -->
                    <div class="absolute left-4 top-4 flex flex-col gap-2">
                    </div>

                    <!-- Quick View Overlay -->
                    <div class="absolute inset-x-0 bottom-0 flex translate-y-full items-center justify-center gap-2 p-6 transition-transform duration-500 group-hover:translate-y-0">
                        <a href="{{ route('products.show', $product) }}" class="flex h-12 w-12 items-center justify-center rounded-full bg-white text-gray-900 shadow-xl transition hover:bg-blue-600 hover:text-white">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        </a>
                    </div>
                </div>

                <!-- Content -->
                <div class="flex flex-1 flex-col p-6 pt-5" x-data="{ qty: 1 }">
                    <div class="mb-4">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-blue-600">{{ $product->brand?->name ?? __('Premium') }}</span>
                        <h3 class="mt-1 line-clamp-2 text-base font-bold text-gray-900 transition-colors group-hover:text-blue-600">
                            <a href="{{ route('products.show', $product) }}">{{ $product->title }}</a>
                        </h3>
                    </div>

                    <div class="mb-6 flex items-center gap-3">
                        @if ($product->price_ttc)
                            <span class="text-xl font-black text-gray-900">{{ number_format($product->price_ttc, 2, ',', ' ') }} €</span>
                            <span class="text-[10px] font-bold text-emerald-600 uppercase">{{ __('En stock') }}</span>
                        @else
                            <span class="text-sm font-bold text-gray-900">{{ __('Sur devis') }}</span>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-auto flex flex-col gap-3">
                        {{-- Quantity Selector --}}
                        <div class="flex items-center justify-between rounded-2xl bg-gray-50 p-2 transition-colors group-hover:bg-blue-50/50">
                            <span class="pl-2 text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ __('Quantité') }}</span>
                            <div class="flex items-center gap-2">
                                <button @click="qty > 1 ? qty-- : null" class="flex h-9 w-9 items-center justify-center rounded-xl bg-white text-gray-900 shadow-sm transition hover:bg-gray-100">-</button>
                                <input type="number" x-model.number="qty" class="w-12 border-none bg-transparent p-0 text-center text-sm font-black focus:ring-0" min="1">
                                <button @click="qty++" class="flex h-9 w-9 items-center justify-center rounded-xl bg-white text-gray-900 shadow-sm transition hover:bg-gray-100">+</button>
                            </div>
                        </div>

                        {{-- Order Button --}}
                        <a
                            :href="'{{ route('order.index') }}' + '?product=' + encodeURIComponent('{{ addslashes($product->title) }}') + '&sku=' + encodeURIComponent('{{ addslashes($product->sku) }}') + '&qty=' + qty"
                            class="group/btn relative flex w-full items-center justify-center gap-2 overflow-hidden rounded-xl bg-blue-600 px-8 py-5 text-[11px] font-black uppercase tracking-widest text-white shadow-lg shadow-red-900/20 transition-all hover:bg-blue-700 hover:shadow-red-900/40"
                        >
                            <span class="relative z-10">{{ __('Commander') }}</span>
                            <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/20 to-transparent transition-transform duration-500 group-hover/btn:translate-x-full"></div>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
