<x-public-layout>
    <div class="relative min-h-screen bg-[#FDFDFC]">
        {{-- Decorative background --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-[10%] -right-[5%] h-[500px] w-[500px] rounded-full bg-red-50/50 blur-[120px]"></div>
            <div class="absolute top-[20%] -left-[5%] h-[600px] w-[600px] rounded-full bg-gray-100/50 blur-[120px]"></div>
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-[0.03]"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-6 py-16 lg:px-8">
            {{-- Header Section --}}
            <div class="flex flex-col gap-6 mb-16">
                <nav class="flex text-[10px] font-black uppercase tracking-[0.2em] text-gray-400" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2">
                        <li><a href="{{ route('home') }}" class="hover:text-red-600 transition">{{ __('Accueil') }}</a></li>
                        <li><span class="mx-2 text-gray-200">/</span></li>
                        <li class="text-gray-900">{{ __('Boutique') }}</li>
                    </ol>
                </nav>
                <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-8">
                    <div class="max-w-3xl">
                        <h1 class="text-5xl font-black tracking-tighter text-gray-900 sm:text-7xl uppercase italic">
                            {{ __('Le') }} <span class="text-red-600">{{ __('Catalogue') }}</span>
                        </h1>
                        <p class="mt-6 text-xl text-gray-500 leading-relaxed font-medium">
                            {{ __('Découvrez notre gamme complète d\'équipements professionnels. Performance, durabilité et innovation pour tous vos projets.') }}
                        </p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="hidden sm:flex items-center gap-2 rounded-2xl bg-white p-2 shadow-sm border border-gray-100">
                            <button class="p-2 text-gray-900 rounded-xl bg-gray-50"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" /></svg></button>
                            <button class="p-2 text-gray-400 hover:text-gray-900 transition"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-16">
                <!-- Sidebar Filters -->
                <aside class="w-full lg:w-80 shrink-0">
                    <div class="sticky top-28 space-y-8">
                        <div class="overflow-hidden rounded-[2.5rem] border border-gray-100 bg-white shadow-2xl shadow-gray-200/50 transition-all hover:shadow-red-900/5">
                            <div class="bg-gray-900 px-8 py-6">
                                <h2 class="text-xs font-black uppercase tracking-[0.2em] text-white">{{ __('Filtres') }}</h2>
                            </div>
                            <form action="{{ route('shop.index') }}" method="GET" class="p-8 space-y-10">
                                <!-- Search -->
                                <div class="group space-y-4">
                                    <label for="search" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 group-hover:text-red-600 transition-colors">{{ __('Recherche') }}</label>
                                    <div class="relative">
                                        <input type="text" name="search" id="search" value="{{ request('search') }}" class="block w-full rounded-2xl border-gray-100 bg-gray-50 px-5 py-4 text-sm font-bold text-gray-900 placeholder-gray-300 focus:border-red-500 focus:bg-white focus:ring-red-500/20 transition-all" placeholder="{{ __('Modèle, SKU...') }}">
                                        <div class="absolute right-5 top-4 text-gray-400">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Categories -->
                                <div class="space-y-4">
                                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">{{ __('Catégories') }}</h3>
                                    <div class="space-y-2">
                                        @foreach($categories as $category)
                                            <label class="group flex cursor-pointer items-center justify-between rounded-xl p-2 transition-colors hover:bg-red-50/50">
                                                <div class="flex items-center">
                                                    <div class="relative flex h-5 w-5 items-center justify-center">
                                                        <input type="checkbox" name="category[]" value="{{ $category->slug }}" {{ in_array($category->slug, (array)request('category')) ? 'checked' : '' }} class="peer h-5 w-5 rounded-lg border-gray-200 text-red-600 focus:ring-red-500/20 transition-all">
                                                        <svg class="pointer-events-none absolute h-3.5 w-3.5 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                                    </div>
                                                    <span class="ml-4 text-sm font-bold text-gray-600 group-hover:text-gray-900 transition-colors">{{ $category->name }}</span>
                                                </div>
                                                <span class="rounded-lg bg-gray-50 px-2 py-1 text-[10px] font-black text-gray-400 group-hover:bg-red-600 group-hover:text-white transition-all">{{ $category->products_count }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Price -->
                                <div class="space-y-4">
                                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">{{ __('Budget') }}</h3>
                                    <div class="flex items-center gap-3">
                                        <div class="relative flex-1">
                                            <span class="absolute left-4 top-4 text-[10px] font-bold text-gray-400">€</span>
                                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="block w-full rounded-2xl border-gray-100 bg-gray-50 pl-8 pr-4 py-4 text-sm font-bold focus:border-red-500 focus:bg-white focus:ring-red-500/20 transition-all">
                                        </div>
                                        <div class="relative flex-1">
                                            <span class="absolute left-4 top-4 text-[10px] font-bold text-gray-400">€</span>
                                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="block w-full rounded-2xl border-gray-100 bg-gray-50 pl-8 pr-4 py-4 text-sm font-bold focus:border-red-500 focus:bg-white focus:ring-red-500/20 transition-all">
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-6 space-y-4">
                                    <button type="submit" class="group relative flex w-full items-center justify-center gap-3 overflow-hidden rounded-2xl bg-gray-900 px-6 py-5 text-xs font-black uppercase tracking-widest text-white shadow-xl transition-all hover:bg-red-600 hover:shadow-red-900/20 active:scale-95">
                                        <span class="relative z-10">{{ __('Appliquer') }}</span>
                                        <svg class="relative z-10 h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                                        <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/10 to-transparent transition-transform duration-500 group-hover:translate-x-full"></div>
                                    </button>
                                    @if(request()->anyFilled(['search', 'category', 'brand', 'min_price', 'max_price']))
                                        <a href="{{ route('shop.index') }}" class="flex items-center justify-center gap-2 text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-red-600 transition-colors">
                                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" /></svg>
                                            {{ __('Réinitialiser') }}
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </aside>

                <!-- Product Grid -->
                <div class="flex-1">
                    <div class="mb-12 flex flex-col sm:flex-row sm:items-center justify-between gap-6 rounded-[2rem] bg-white px-8 py-6 shadow-sm border border-gray-100 transition-all hover:shadow-md">
                        <div class="flex items-center gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-red-50 text-red-600 font-black">
                                {{ $products->total() }}
                            </div>
                            <div>
                                <h3 class="text-sm font-black text-gray-900 uppercase tracking-tight">{{ __('Produits trouvés') }}</h3>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ __('Dans tout le catalogue') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400">{{ __('Trier par') }} :</label>
                            <select name="sort" class="rounded-xl border-gray-100 bg-gray-50 text-xs font-black text-gray-900 focus:border-red-500 focus:ring-red-500/20 cursor-pointer py-2.5 px-4 transition-all"
                                onchange="window.location.href = '{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => ''])) }}'.replace('sort=', 'sort=' + this.value)">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>{{ __('Plus récents') }}</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>{{ __('Prix croissant') }}</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>{{ __('Prix décroissant') }}</option>
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>{{ __('Nom A-Z') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
                        @foreach ($products as $product)
                            <div class="group relative flex flex-col overflow-hidden rounded-[2.5rem] border border-gray-100 bg-white p-2 shadow-sm transition-all duration-500 hover:-translate-y-2 hover:border-red-100 hover:shadow-2xl hover:shadow-red-900/5">
                                {{-- Badge Promo / New --}}
                                @if($loop->index < 3)
                                    <div class="absolute top-6 left-6 z-10">
                                        <span class="inline-flex items-center rounded-full bg-red-600 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-white shadow-lg shadow-red-600/20">
                                            {{ __('Nouveau') }}
                                        </span>
                                    </div>
                                @endif

                                <div class="relative aspect-[4/5] overflow-hidden rounded-[2rem] bg-gray-50">
                                    @if ($product->media->isNotEmpty())
                                        @php $featured = $product->media->firstWhere('is_primary', true) ?? $product->media->first(); @endphp
                                        <img
                                            src="{{ Str::startsWith($featured->path, ['http://', 'https://']) ? $featured->path : asset($featured->path) }}"
                                            alt="{{ $product->title }}"
                                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                                            loading="lazy"
                                        >
                                    @endif
                                    
                                    {{-- Hover Actions --}}
                                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 via-transparent to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100"></div>
                                    <div class="absolute inset-x-0 bottom-0 flex translate-y-full items-center justify-center gap-3 p-8 transition-transform duration-500 group-hover:translate-y-0">
                                        <a href="{{ route('products.show', $product) }}" class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-gray-900 shadow-2xl transition hover:bg-red-600 hover:text-white hover:scale-110 active:scale-95">
                                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        </a>
                                    </div>
                                </div>

                                <div class="flex flex-1 flex-col p-6 pt-5" x-data="{ qty: 1 }">
                                    <div class="mb-6">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-red-600">{{ $product->brand?->name ?? __('Premium') }}</span>
                                            <span class="text-[10px] font-bold text-gray-400">SKU: {{ $product->sku }}</span>
                                        </div>
                                        <h3 class="line-clamp-2 text-base font-bold tracking-tight text-gray-900 transition-colors group-hover:text-red-600">
                                            <a href="{{ route('products.show', $product) }}">{{ $product->title }}</a>
                                        </h3>
                                    </div>

                                    <div class="mb-8 flex items-end justify-between">
                                        <div class="flex flex-col">
                                            @if ($product->price_ttc)
                                                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">{{ __('À partir de') }}</span>
                                                <span class="text-2xl font-black text-gray-900 tracking-tighter">{{ number_format($product->price_ttc, 2, ',', ' ') }} €</span>
                                            @else
                                                <span class="text-sm font-black text-red-600 uppercase italic">{{ __('Sur devis') }}</span>
                                            @endif
                                        </div>
                                        @if($product->price_ttc)
                                            <div class="flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-[10px] font-black uppercase text-emerald-600">
                                                <span class="relative flex h-2 w-2">
                                                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                                                    <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                                                </span>
                                                {{ __('Stock') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mt-auto">
                                        <div class="flex flex-col gap-3">
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
                                                class="group/btn relative flex w-full items-center justify-center gap-2 overflow-hidden rounded-xl bg-red-600 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-white shadow-lg shadow-red-900/20 transition-all hover:bg-red-700 hover:shadow-red-900/40 active:scale-95"
                                            >
                                                <span class="relative z-10">{{ $product->price_ttc ? __('Commander') : __('Devis') }}</span>
                                                <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/10 to-transparent transition-transform duration-500 group-hover/btn:translate-x-full"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-20">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
