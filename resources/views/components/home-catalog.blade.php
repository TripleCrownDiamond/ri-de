@props(['grouped_products'])

<section
    class="relative mx-auto mt-24 max-w-7xl px-6 pb-24"
    x-data="{
        activeCategory: 'trailers',
    }"
>
    {{-- Background decorative element --}}
    <div class="absolute -top-24 left-1/2 -z-10 h-96 w-screen -translate-x-1/2 bg-gradient-to-b from-gray-50 to-white"></div>

    <div class="flex flex-col gap-10 lg:flex-row lg:items-end lg:justify-between">
        <div class="max-w-3xl space-y-4">
            <div class="inline-flex items-center gap-3 rounded-full bg-red-50 px-4 py-1.5 text-[11px] font-bold uppercase tracking-widest text-red-600 shadow-sm">
                <span class="relative flex h-2 w-2">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex h-2 w-2 rounded-full bg-red-600"></span>
                </span>
                {{ __('Catalogue Premium') }}
            </div>
            <h2 class="text-3xl font-black tracking-tight text-gray-900 sm:text-5xl">
                {{ __('Nos Univers') }} <span class="text-red-600">.</span>
            </h2>
            <p class="text-base leading-relaxed text-gray-500 sm:text-lg">
                {{ __('Découvrez une sélection rigoureuse de produits haute performance. Qualité industrielle, service local.') }}
            </p>
        </div>
        
        <div class="flex flex-wrap items-center gap-3">
            @php
                $tabs = [
                    'trailers' => 'Remorques',
                    'trailers_acc' => 'Acc. Remorques',
                    'mowers' => 'Tondeuses',
                    'mowers_acc' => 'Acc. Tondeuses',
                    'wood' => 'Combustibles',
                    'wood_acc' => 'Acc. Combustibles',
                    'containers' => 'Conteneurs'
                ];

                // Determine initial active category
                $initialCategory = 'trailers';
                foreach ($tabs as $slug => $label) {
                    if (isset($grouped_products[$slug]) && $grouped_products[$slug]->isNotEmpty()) {
                        $initialCategory = $slug;
                        break;
                    }
                }
            @endphp
            @foreach ($tabs as $slug => $label)
                @if(isset($grouped_products[$slug]) && $grouped_products[$slug]->isNotEmpty())
                    <button
                        type="button"
                        class="group relative overflow-hidden rounded-2xl border-2 px-6 py-3 text-sm font-bold transition-all duration-300"
                        :class="activeCategory === '{{ $slug }}'
                            ? 'border-gray-900 bg-gray-900 text-white shadow-xl shadow-gray-200 scale-105'
                            : 'border-gray-100 bg-white text-gray-500 hover:border-gray-200 hover:text-gray-900'"
                        @click="activeCategory = '{{ $slug }}'"
                    >
                        <span class="relative z-10">{{ __($label) }}</span>
                        <div x-show="activeCategory === '{{ $slug }}'" class="absolute inset-0 bg-gradient-to-r from-gray-800 to-gray-900 opacity-50"></div>
                    </button>
                @endif
            @endforeach
        </div>
    </div>

    <div class="mt-16 grid gap-4 sm:grid-cols-2 lg:grid-cols-4" x-init="activeCategory = '{{ $initialCategory }}'">
        @foreach (['trailers', 'trailers_acc', 'mowers', 'mowers_acc', 'wood', 'wood_acc', 'containers'] as $key)
            @php
                $products = $grouped_products[$key] ?? collect();
                $isDevisCategory = $key === 'containers';
            @endphp

            @foreach ($products as $product)
                <div
                    class="group relative flex flex-col overflow-hidden rounded-[2.5rem] border border-gray-100 bg-white p-2 shadow-sm transition-all duration-500 hover:-translate-y-2 hover:border-red-100 hover:shadow-2xl hover:shadow-red-900/5"
                    x-show="activeCategory === '{{ $key }}'"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                >
                    {{-- Badge --}}
                    <div class="absolute right-6 top-6 z-10">
                        <span class="rounded-full bg-white/90 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-gray-900 shadow-sm backdrop-blur-md">
                            {{ $product->brand?->name ?? 'Premium' }}
                        </span>
                    </div>

                    {{-- Image Container --}}
                    <div class="relative aspect-[4/5] overflow-hidden rounded-[2rem] bg-gray-50">
                        @if ($product->media->isNotEmpty())
                            @php $featured = $product->media->firstWhere('is_primary', true) ?? $product->media->first(); @endphp
                            <img
                                src="{{ Str::startsWith($featured->path, ['http://', 'https://']) ? $featured->path : asset($featured->path) }}"
                                alt="{{ $product->title }}"
                                class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                            >
                        @endif
                        
                        {{-- Quick Actions Overlay --}}
                        <div class="absolute inset-x-0 bottom-0 flex translate-y-full items-center justify-center gap-2 p-6 transition-transform duration-500 group-hover:translate-y-0">
                            <a href="{{ route('products.show', $product) }}" class="flex h-12 w-12 items-center justify-center rounded-full bg-white text-gray-900 shadow-xl transition hover:bg-red-600 hover:text-white">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            </a>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="flex flex-1 flex-col p-6 pt-5" x-data="{ qty: 1 }">
                        <div class="mb-4 flex items-center justify-between">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold uppercase tracking-widest text-red-600">{{ __('Réf') }}: {{ $product->sku }}</span>
                                <h3 class="mt-1 line-clamp-1 text-base font-bold text-gray-900 transition-colors group-hover:text-red-600">
                                    <a href="{{ route('products.show', $product) }}">{{ $product->title }}</a>
                                </h3>
                            </div>
                        </div>

                        <div class="mb-6 flex items-center gap-3">
                            @if ($product->price_ttc)
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">{{ __('À partir de') }}</span>
                                    <span class="text-xl font-black text-gray-900">{{ number_format($product->price_ttc, 2, ',', ' ') }} €</span>
                                </div>
                                <div class="h-8 w-px bg-gray-100"></div>
                                <span class="text-[10px] font-bold text-emerald-600 uppercase">{{ __('En stock') }}</span>
                            @else
                                <span class="text-sm font-bold text-gray-900">{{ __('Sur devis') }}</span>
                            @endif
                        </div>

                        <div class="mt-auto flex flex-col gap-3">
                            {{-- Quantity Selector --}}
                            <div class="flex items-center justify-between rounded-2xl bg-gray-50 p-2 transition-colors group-hover:bg-red-50/50">
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
                                class="group/btn relative flex w-full items-center justify-center gap-2 overflow-hidden rounded-xl bg-red-600 px-8 py-5 text-[11px] font-black uppercase tracking-widest text-white shadow-lg shadow-red-900/20 transition-all hover:bg-red-700 hover:shadow-red-900/40"
                            >
                                <span class="relative z-10">{{ $isDevisCategory ? __('Devis') : __('Commander') }}</span>
                                <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/20 to-transparent transition-transform duration-500 group-hover/btn:translate-x-full"></div>
                            </a>

                            @if (! $isDevisCategory)
                                <a
                                    :href="'{{ route('quote.index') }}' + '?product=' + encodeURIComponent('{{ addslashes($product->title) }}') + '&sku=' + encodeURIComponent('{{ addslashes($product->sku) }}') + '&qty=' + qty"
                                    class="mt-1 text-center text-[10px] font-bold uppercase tracking-widest text-gray-400 transition hover:text-red-600"
                                >
                                    {{ __('Demande de renseignements') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    </div>
</section>
