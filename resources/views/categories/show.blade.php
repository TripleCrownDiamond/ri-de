<x-public-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $category->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar Filters -->
                <aside class="w-full lg:w-72 flex-shrink-0 space-y-8" x-data="{ open: true }">
                    <div class="bg-white rounded-[2rem] border border-gray-100 p-8 shadow-sm">
                        <form action="{{ url()->current() }}" method="GET" id="filter-form">
                            <h3 class="text-sm font-black uppercase tracking-widest text-gray-900 mb-6 flex items-center gap-2">
                                <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>
                                {{ __('Filtres') }}
                            </h3>

                            <!-- Brands -->
                            @if($brands->isNotEmpty())
                                <div class="mb-8">
                                    <h4 class="text-[11px] font-bold uppercase tracking-wider text-gray-400 mb-4">{{ __('Marques') }}</h4>
                                    <div class="space-y-3">
                                        @foreach($brands as $brand)
                                            <label class="flex items-center gap-3 group cursor-pointer">
                                                <input type="checkbox" name="brand[]" value="{{ $brand->id }}" 
                                                    {{ in_array($brand->id, (array)request('brand')) ? 'checked' : '' }}
                                                    class="h-5 w-5 rounded-lg border-gray-200 text-blue-600 focus:ring-blue-500 transition-all"
                                                    onchange="document.getElementById('filter-form').submit()">
                                                <span class="text-sm font-medium text-gray-600 group-hover:text-gray-900 transition-colors">{{ $brand->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Price Range -->
                            <div class="mb-8">
                                <h4 class="text-[11px] font-bold uppercase tracking-wider text-gray-400 mb-4">{{ __('Prix (TTC)') }}</h4>
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="space-y-1">
                                        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" 
                                            class="w-full rounded-xl border-gray-100 bg-gray-50 text-sm font-bold focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div class="space-y-1">
                                        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" 
                                            class="w-full rounded-xl border-gray-100 bg-gray-50 text-sm font-bold focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                                <button type="submit" class="mt-4 w-full rounded-xl bg-gray-900 py-3 text-[10px] font-black uppercase tracking-widest text-white transition-all hover:bg-blue-600">
                                    {{ __('Appliquer') }}
                                </button>
                            </div>

                            @if(request()->anyFilled(['brand', 'min_price', 'max_price']))
                                <a href="{{ url()->current() }}" class="text-[10px] font-bold text-blue-600 uppercase tracking-widest hover:underline">
                                    {{ __('Réinitialiser les filtres') }}
                                </a>
                            @endif
                        </form>
                    </div>
                </aside>

                <!-- Products Section -->
                <div class="flex-1">
                    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="text-sm font-medium text-gray-500">
                            <span class="font-black text-gray-900">{{ $products->total() }}</span> {{ __('produits trouvés') }}
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <span class="text-[11px] font-bold uppercase tracking-widest text-gray-400">{{ __('Trier par') }} :</span>
                            <select name="sort" class="rounded-xl border-gray-100 bg-white text-sm font-bold focus:border-blue-500 focus:ring-blue-500"
                                onchange="window.location.href = '{{ url()->current() }}?{{ http_build_query(request()->except('sort')) }}' + (this.value ? '&sort=' + this.value : '')">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>{{ __('Nouveautés') }}</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>{{ __('Prix croissant') }}</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>{{ __('Prix décroissant') }}</option>
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>{{ __('Nom A-Z') }}</option>
                            </select>
                        </div>
                    </div>

                    @if ($products->isEmpty())
                        <div class="bg-white rounded-[2.5rem] p-12 text-center border border-gray-100 shadow-sm">
                            <div class="inline-flex h-20 w-20 items-center justify-center rounded-full bg-gray-50 mb-6">
                                <svg class="h-10 w-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('Aucun produit trouvé') }}</h3>
                            <p class="text-gray-500 max-w-xs mx-auto">{{ __('Essayez de modifier vos filtres pour trouver ce que vous cherchez.') }}</p>
                            <a href="{{ url()->current() }}" class="mt-8 inline-flex items-center justify-center rounded-full bg-blue-600 px-8 py-4 text-[10px] font-black uppercase tracking-widest text-white shadow-lg shadow-red-900/20 transition-all hover:bg-blue-700">
                                {{ __('Voir tout') }}
                            </a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
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
                                            @if ($product->brand)
                                                <span class="rounded-full bg-white/90 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-gray-900 shadow-sm backdrop-blur-md">
                                                    {{ $product->brand->name }}
                                                </span>
                                            @endif
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
                                            <span class="text-[10px] font-bold uppercase tracking-widest text-blue-600">{{ __('Réf') }}: {{ $product->sku }}</span>
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
                                            @if ($product->price_ttc)
                                                <a
                                                    :href="'{{ route('order.index') }}' + '?product=' + encodeURIComponent('{{ addslashes($product->title) }}') + '&sku=' + encodeURIComponent('{{ addslashes($product->sku) }}') + '&qty=' + qty"
                                                    class="group/btn relative flex w-full items-center justify-center gap-2 overflow-hidden rounded-xl bg-blue-600 px-8 py-5 text-[11px] font-black uppercase tracking-widest text-white shadow-lg shadow-red-900/20 transition-all hover:bg-blue-700 hover:shadow-red-900/40"
                                                >
                                                    <span class="relative z-10">{{ __('Commander') }}</span>
                                                    <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/20 to-transparent transition-transform duration-500 group-hover/btn:translate-x-full"></div>
                                                </a>
                                            @else
                                                <a
                                                    :href="'{{ route('quote.index') }}' + '?product=' + encodeURIComponent('{{ addslashes($product->title) }}') + '&sku=' + encodeURIComponent('{{ addslashes($product->sku) }}') + '&qty=' + qty"
                                                    class="group/btn relative flex w-full items-center justify-center gap-2 overflow-hidden rounded-xl bg-gray-900 px-8 py-5 text-[11px] font-black uppercase tracking-widest text-white shadow-lg shadow-gray-900/20 transition-all hover:bg-blue-600 hover:shadow-red-900/40"
                                                >
                                                    <span class="relative z-10">{{ __('Demande de devis') }}</span>
                                                    <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/20 to-transparent transition-transform duration-500 group-hover/btn:translate-x-full"></div>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
