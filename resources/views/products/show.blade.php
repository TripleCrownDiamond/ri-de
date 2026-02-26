@php
    $brandName = $product->brand?->name;
    $title = $brandName ? $brandName.' '.$product->title : $product->title;
    $appName = config('app.name', 'Remorques Industrie');
    $pageTitle = $title.' – '.$appName;
    $metaDescription = $product->description
        ? \Illuminate\Support\Str::limit($product->description, 160)
        : __('messages.meta.home.description');

    $primaryCategory = $product->categories->first();
    $isDevisCategory = $primaryCategory && $primaryCategory->slug === 'containers';

    $extra = $product->extra_attributes ?? [];
    $technicalSpecs = [];
    $advantages = [];

    if (is_array($extra)) {
        $technicalSpecs = isset($extra['technical_specs']) && is_array($extra['technical_specs'])
            ? $extra['technical_specs']
            : [];
        $advantages = isset($extra['advantages']) && is_array($extra['advantages'])
            ? $extra['advantages']
            : [];
    }
@endphp

<x-public-layout :title="$pageTitle">
    <x-slot name="meta">
        <meta name="description" content="{{ $metaDescription }}">
        <meta name="application-name" content="{{ $appName }}">
        <meta property="og:title" content="{{ $pageTitle }}">
        <meta property="og:description" content="{{ $metaDescription }}">
        <meta property="og:locale" content="{{ app()->getLocale() }}">
    </x-slot>

    <div class="mx-auto mt-12 max-w-7xl px-6 pb-20" x-data="{ 
        mainImage: '{{ $featuredMedia ? (Str::startsWith($featuredMedia->path, ['http://', 'https://']) ? $featuredMedia->path : asset($featuredMedia->path)) : '' }}' 
    }">
        <nav class="mb-6 text-xs text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-gray-900">{{ __('Accueil') }}</a>
            <span class="mx-1">/</span>
            @if ($product->categories->isNotEmpty())
                <span class="capitalize">{{ $product->categories->first()->name }}</span>
                <span class="mx-1">/</span>
            @endif
            <span class="text-gray-700">{{ $product->title }}</span>
        </nav>

        <div class="grid gap-10 lg:grid-cols-2">
            <div class="space-y-4">
                @if ($featuredMedia)
                    <div class="space-y-2">
                        <div class="flex justify-start">
                            <x-application-logo class="h-7 w-auto" loading="lazy" />
                        </div>
                        <div class="overflow-hidden rounded-3xl bg-gray-100">
                            <img
                                :src="mainImage"
                                alt="{{ $product->title }}"
                                class="h-80 w-full object-cover transition-all duration-300"
                                loading="lazy"
                            >
                        </div>
                    </div>
                @else
                    <div class="flex h-80 items-center justify-center rounded-3xl border border-dashed border-gray-200 bg-gray-50 text-sm text-gray-400">
                        {{ __('Visuel à venir') }}
                    </div>
                @endif

                @php
                    $galleryMedia = $product->media;
                @endphp

                @if ($galleryMedia->isNotEmpty())
                    <div class="space-y-2">
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                            {{ __('Galerie photos') }}
                        </p>
                        <div class="grid grid-cols-4 gap-3">
                            @foreach ($galleryMedia as $media)
                                @php 
                                    $mediaUrl = Str::startsWith($media->path, ['http://', 'https://']) ? $media->path : asset($media->path);
                                @endphp
                                <div 
                                    class="cursor-pointer overflow-hidden rounded-2xl bg-gray-100 ring-offset-2 transition-all hover:opacity-80"
                                    :class="mainImage === '{{ $mediaUrl }}' ? 'ring-2 ring-blue-600' : ''"
                                    @click="mainImage = '{{ $mediaUrl }}'"
                                >
                                    <img
                                        src="{{ $mediaUrl }}"
                                        alt="{{ $media->title ?? $product->title }}"
                                        class="h-20 w-full object-cover"
                                        loading="lazy"
                                    >
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="flex flex-col gap-6">
                <div class="space-y-2">
                    @if ($brandName)
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                            {{ $brandName }}
                        </p>
                    @endif
                    <h1 class="text-2xl font-semibold tracking-tight text-gray-900 sm:text-3xl">
                        {{ $product->title }}
                    </h1>
                    <p class="text-xs font-medium text-gray-500">
                        @if ($product->ean)
                            EAN {{ $product->ean }}
                            &middot;
                        @endif
                        SKU {{ $product->sku }}
                    </p>
                </div>

                <div class="space-y-2">
                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                        {{ __('Base pour devis') }}
                    </p>
                    @if ($product->price_ttc)
                        @if ($isDevisCategory)
                            <div class="inline-flex items-baseline gap-2 rounded-2xl bg-amber-50 px-4 py-2">
                                <span class="text-[11px] font-semibold uppercase tracking-wide text-amber-800">
                                    {{ __('À partir de') }}
                                </span>
                                <span class="text-2xl font-semibold text-amber-900">
                                    {{ number_format($product->price_ttc, 2, ',', ' ') }} € TTC
                                </span>
                            </div>
                        @else
                            <div class="inline-flex items-baseline gap-2 rounded-2xl bg-amber-50 px-4 py-2">
                                <span class="text-2xl font-semibold text-amber-900">
                                    {{ number_format($product->price_ttc, 2, ',', ' ') }} € TTC
                                </span>
                            </div>
                        @endif
                    @else
                        <p class="text-sm font-semibold text-gray-900">
                            {{ __('Nous consulter') }}
                        </p>
                    @endif
                </div>

                @if ($product->description)
                    <div>
                        <h2 class="mb-2 text-sm font-semibold text-gray-900">
                            {{ __('Description') }}
                        </h2>
                        <div class="prose prose-sm max-w-none text-gray-700">
                            {!! $product->description !!}
                        </div>
                    </div>
                @endif

                @if (! empty($technicalSpecs))
                    <div>
                        <h2 class="mb-2 text-sm font-semibold text-gray-900">
                            {{ __('Caractéristiques techniques') }}
                        </h2>
                        <ul class="space-y-1 text-sm leading-relaxed text-gray-700">
                            @foreach ($technicalSpecs as $line)
                                @if ($line)
                                    <li>• {{ $line }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (! empty($advantages))
                    <div>
                        <h2 class="mb-2 text-sm font-semibold text-gray-900">
                            {{ __('Avantages') }}
                        </h2>
                        <ul class="space-y-1 text-sm leading-relaxed text-gray-700">
                            @foreach ($advantages as $line)
                                @if ($line)
                                    <li>• {{ $line }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mt-3 space-y-4" x-data="{ qty: 1 }">
                    {{-- Quantity Selector --}}
                    <div class="flex items-center justify-between rounded-2xl bg-gray-50 p-3 transition-colors">
                        <span class="pl-2 text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ __('Quantité') }}</span>
                        <div class="flex items-center gap-3">
                            <button @click="qty > 1 ? qty-- : null" class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-gray-900 shadow-sm transition hover:bg-gray-100">-</button>
                            <input type="number" x-model.number="qty" class="w-14 border-none bg-transparent p-0 text-center text-sm font-black focus:ring-0" min="1">
                            <button @click="qty++" class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-gray-900 shadow-sm transition hover:bg-gray-100">+</button>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <a
                            :href="'{{ route('order.index') }}' + '?product=' + encodeURIComponent('{{ addslashes($product->title) }}') + '&sku=' + encodeURIComponent('{{ addslashes($product->sku) }}') + '&qty=' + qty"
                            class="group relative flex w-full items-center justify-center gap-2 overflow-hidden rounded-xl bg-blue-600 px-8 py-5 text-xs font-black uppercase tracking-widest text-white shadow-xl shadow-red-900/20 transition-all hover:bg-blue-700 hover:shadow-red-900/40 active:scale-95"
                        >
                            <span class="relative z-10">{{ $isDevisCategory ? __('Demander un devis') : __('Commander ce modèle') }}</span>
                            <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/20 to-transparent transition-transform duration-500 group-hover:translate-x-full"></div>
                        </a>
                        <a
                            :href="'{{ route('quote.index') }}' + '?product=' + encodeURIComponent('{{ addslashes($product->title) }}') + '&sku=' + encodeURIComponent('{{ addslashes($product->sku) }}') + '&qty=' + qty"
                            class="flex w-full items-center justify-center rounded-xl border-2 border-gray-100 bg-white px-8 py-4 text-xs font-black uppercase tracking-widest text-gray-400 transition-all hover:border-gray-200 hover:text-gray-900 active:scale-95"
                        >
                            {{ __('Demande de renseignements') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @if ($similarProducts->isNotEmpty())
            <div class="mt-12 border-t border-gray-100 pt-10">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-semibold tracking-tight text-gray-900">
                        {{ __('Produits similaires') }}
                    </h2>
                    <p class="text-xs text-gray-500">
                        {{ __('D\'autres modèles de la même famille') }}
                    </p>
                </div>
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($similarProducts as $similar)
                        <div class="group relative flex flex-col overflow-hidden rounded-[2.5rem] border border-gray-100 bg-white p-2 shadow-sm transition-all duration-500 hover:-translate-y-2 hover:border-blue-100 hover:shadow-2xl hover:shadow-red-900/5">
                            <!-- Image Container -->
                            <div class="relative aspect-[4/5] overflow-hidden rounded-[2rem] bg-gray-50">
                                @php
                                    $similarFeatured = $similar->media->firstWhere('is_primary', true) ?? $similar->media->first();
                                @endphp
                                @if ($similarFeatured)
                                    <img
                                        src="{{ Str::startsWith($similarFeatured->path, ['http://', 'https://']) ? $similarFeatured->path : asset($similarFeatured->path) }}"
                                        alt="{{ $similar->title }}"
                                        class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                                        loading="lazy"
                                    >
                                @endif
                                
                                <!-- Badges -->
                                <div class="absolute left-4 top-4 flex flex-col gap-2">
                                    @if ($similar->brand)
                                        <span class="rounded-full bg-white/90 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-gray-900 shadow-sm backdrop-blur-md">
                                            {{ $similar->brand->name }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Quick View Overlay -->
                                <div class="absolute inset-x-0 bottom-0 flex translate-y-full items-center justify-center gap-2 p-6 transition-transform duration-500 group-hover:translate-y-0">
                                    <a href="{{ route('products.show', $similar) }}" class="flex h-12 w-12 items-center justify-center rounded-full bg-white text-gray-900 shadow-xl transition hover:bg-blue-600 hover:text-white">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    </a>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="flex flex-1 flex-col p-6 pt-5" x-data="{ qty: 1 }">
                                <div class="mb-4">
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-blue-600">{{ __('Réf') }}: {{ $similar->sku }}</span>
                                    <h3 class="mt-1 line-clamp-2 text-base font-bold text-gray-900 transition-colors group-hover:text-blue-600">
                                        <a href="{{ route('products.show', $similar) }}">{{ $similar->title }}</a>
                                    </h3>
                                </div>

                                <div class="mb-6 flex items-center gap-3">
                                    @if ($similar->price_ttc)
                                        <span class="text-xl font-black text-gray-900">{{ number_format($similar->price_ttc, 2, ',', ' ') }} €</span>
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
                                    @if ($similar->price_ttc)
                                        <a
                                            :href="'{{ route('order.index') }}' + '?product=' + encodeURIComponent('{{ addslashes($similar->title) }}') + '&sku=' + encodeURIComponent('{{ addslashes($similar->sku) }}') + '&qty=' + qty"
                                            class="group/btn relative flex w-full items-center justify-center gap-2 overflow-hidden rounded-xl bg-blue-600 px-8 py-5 text-[11px] font-black uppercase tracking-widest text-white shadow-lg shadow-red-900/20 transition-all hover:bg-blue-700 hover:shadow-red-900/40"
                                        >
                                            <span class="relative z-10">{{ __('Commander') }}</span>
                                            <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/20 to-transparent transition-transform duration-500 group-hover/btn:translate-x-full"></div>
                                        </a>
                                    @else
                                        <a
                                            :href="'{{ route('quote.index') }}' + '?product=' + encodeURIComponent('{{ addslashes($similar->title) }}') + '&sku=' + encodeURIComponent('{{ addslashes($similar->sku) }}') + '&qty=' + qty"
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
            </div>
        @endif
    </div>
</x-public-layout>
