<div class="bg-gray-900 py-1.5 text-center text-[10px] font-bold uppercase tracking-widest text-white sm:text-xs">
    <div class="mx-auto max-w-7xl px-6">
        {{ __('Livraison Express & Service Client 5 étoiles') }} ⭐⭐⭐⭐⭐
    </div>
</div>

<header class="sticky top-0 z-50 border-b border-gray-100 bg-white/95 backdrop-blur-md" x-data="{ mobileMenuOpen: false }">
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-3">
        <div class="flex items-center gap-10">
            <a href="{{ url('/') }}" class="group flex items-center">
                <x-application-logo class="h-10 w-auto transition-transform duration-300 group-hover:scale-105 sm:h-12" />
            </a>
            <nav class="hidden items-center gap-8 text-[13px] font-semibold uppercase tracking-wide text-gray-600 lg:flex">
                <a href="{{ route('home') }}" class="relative transition-colors hover:text-red-600 {{ request()->routeIs('home') ? 'text-red-600 after:absolute after:-bottom-5 after:left-0 after:h-0.5 after:w-full after:bg-red-600' : '' }}">
                    {{ __('messages.nav.home') }}
                </a>
                <a href="{{ route('shop.index') }}" class="relative transition-colors hover:text-red-600 {{ request()->routeIs('shop.index') ? 'text-red-600 after:absolute after:-bottom-5 after:left-0 after:h-0.5 after:w-full after:bg-red-600' : '' }}">
                    {{ __('messages.nav.shop') }}
                </a>
                @foreach($nav_categories as $category)
                    @if($category->children->count() > 0)
                        <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                            <button class="flex items-center gap-1 transition-colors hover:text-red-600 {{ request()->is('*/categorie/' . $category->slug . '*') ? 'text-red-600' : '' }}">
                                {{ Str::upper(__($category->name)) }}
                                <svg class="h-4 w-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="open" 
                                 x-cloak
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="absolute left-0 top-full w-56 pt-2 z-50">
                                <div class="rounded-xl bg-white p-2 shadow-xl border border-gray-100">
                                    <a href="{{ route('categories.show', $category->slug) }}" class="block px-4 py-2 text-[11px] font-black uppercase tracking-widest text-gray-700 hover:bg-gray-50 hover:text-red-600 rounded-lg transition-colors border-b border-gray-50 mb-1">
                                        {{ __('Voir tout') }}
                                    </a>
                                    @foreach($category->children as $child)
                                        <a href="{{ route('categories.show', $child->slug) }}" class="block px-4 py-2 text-[11px] font-black uppercase tracking-widest text-gray-600 hover:bg-gray-50 hover:text-red-600 rounded-lg transition-colors">
                                            {{ Str::upper(__($child->name)) }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('categories.show', $category->slug) }}" class="relative transition-colors hover:text-red-600 {{ request()->is('*/categorie/' . $category->slug) ? 'text-red-600' : '' }}">
                            {{ Str::upper(__($category->name)) }}
                        </a>
                    @endif
                @endforeach
                <a href="{{ route('contact.index') }}" class="relative transition-colors hover:text-red-600 {{ request()->routeIs('contact.index') ? 'text-red-600 after:absolute after:-bottom-5 after:left-0 after:h-0.5 after:w-full after:bg-red-600' : '' }}">
                    {{ __('messages.nav.contact') }}
                </a>
            </nav>
        </div>
        <div class="flex items-center gap-6">
            {{-- Language selector removed as DE is now the only public language --}}
            <div class="flex items-center gap-3">
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 text-[13px] font-bold text-gray-700 transition hover:text-red-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                        </button>
                        <div x-show="open" x-cloak @click.away="open = false" class="absolute right-0 mt-2 w-56 rounded-2xl bg-white p-2 shadow-xl border border-gray-100 ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                            {{-- Debug: Admin status: {{ auth()->user()->is_admin ? 'TRUE' : 'FALSE' }} --}}
                            @if(auth()->check() && (auth()->user()->is_admin || auth()->user()->email === 'admin@example.com'))
                                <div class="px-4 py-2 mb-1">
                                    <span class="text-[9px] font-black uppercase tracking-[0.2em] text-gray-400">{{ __('Gestion Admin') }}</span>
                                </div>
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2 text-[11px] font-black uppercase tracking-widest text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-xl transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                    {{ __('Dashboard') }}
                                </a>
                                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-2 text-[11px] font-black uppercase tracking-widest text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-xl transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    {{ __('Produits') }}
                                </a>
                                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-2 text-[11px] font-black uppercase tracking-widest text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-xl transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                    {{ __('Catégories') }}
                                </a>
                                <a href="{{ route('admin.legal-pages.index') }}" class="flex items-center gap-3 px-4 py-2 text-[11px] font-black uppercase tracking-widest text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-xl transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    {{ __('Pages Légales') }}
                                </a>
                                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-4 py-2 text-[11px] font-black uppercase tracking-widest text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-xl transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ __('Infos Site') }}
                                </a>
                                <hr class="my-2 border-gray-50">
                            @endif
                            <div class="px-4 py-2 mb-1">
                                <span class="text-[9px] font-black uppercase tracking-[0.2em] text-gray-400">{{ __('Mon Compte') }}</span>
                            </div>
                            <a href="{{ route('orders.user') }}" class="flex items-center gap-3 px-4 py-2 text-[11px] font-black uppercase tracking-widest text-gray-700 hover:bg-gray-50 hover:text-red-600 rounded-xl transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                                {{ __('Mes Commandes') }}
                            </a>
                            <hr class="my-2 border-gray-50">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-[11px] font-black uppercase tracking-widest text-red-600 hover:bg-red-50 rounded-xl transition-colors">
                                    {{ __('Déconnexion') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-[13px] font-bold text-gray-700 transition hover:text-red-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </a>
                @endauth
                {{-- Mobile Menu Button --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden text-gray-700 transition hover:text-red-600">
                    <svg class="h-6 w-6" x-show="!mobileMenuOpen" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    <svg class="h-6 w-6" x-show="mobileMenuOpen" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu Panel --}}
    <div 
        x-show="mobileMenuOpen" 
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="lg:hidden border-t border-gray-100 bg-white px-6 py-6 shadow-xl"
        @click.away="mobileMenuOpen = false"
    >
        <nav class="flex flex-col gap-4 text-sm font-bold uppercase tracking-widest text-gray-600">
            <a href="{{ route('home') }}" class="py-2 transition hover:text-red-600 {{ request()->routeIs('home') ? 'text-red-600' : '' }}">
                {{ __('messages.nav.home') }}
            </a>
            <a href="{{ route('shop.index') }}" class="py-2 transition hover:text-red-600 {{ request()->routeIs('shop.index') ? 'text-red-600' : '' }}">
                {{ __('messages.nav.shop') }}
            </a>
            @foreach($nav_categories as $category)
                <div x-data="{ open: false }">
                    <div class="flex items-center justify-between py-2">
                        <a href="{{ route('categories.show', $category->slug) }}" class="transition hover:text-red-600 {{ request()->is('*/categorie/' . $category->slug . '*') ? 'text-red-600' : '' }}">
                            {{ Str::upper($category->name) }}
                        </a>
                        @if($category->children->count() > 0)
                            <button @click="open = !open" class="p-1">
                                <svg class="h-4 w-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        @endif
                    </div>
                    @if($category->children->count() > 0)
                        <div x-show="open" 
                             x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="pl-4 flex flex-col gap-2 border-l border-gray-100 ml-1 mb-2">
                            @foreach($category->children as $child)
                                <a href="{{ route('categories.show', $child->slug) }}" class="py-1 text-[11px] text-gray-500 hover:text-red-600">
                                    {{ Str::upper($child->name) }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
            <a href="{{ route('contact.index') }}" class="py-2 transition hover:text-red-600 {{ request()->routeIs('contact.index') ? 'text-red-600' : '' }}">
                {{ __('messages.nav.contact') }}
            </a>

            @auth
                <div class="mt-4 pt-4 border-t border-gray-50 flex flex-col gap-4">
                    <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">{{ __('Mon Compte') }} ({{ auth()->user()->name }})</span>
                    <a href="{{ route('orders.user') }}" class="py-2 transition hover:text-red-600">
                        {{ __('Mes Commandes') }}
                    </a>
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="py-2 transition hover:text-red-600">
                            {{ __('Administration') }}
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left py-2 text-red-600">
                            {{ __('Déconnexion') }}
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="py-2 transition hover:text-red-600">
                    {{ __('Connexion') }}
                </a>
            @endauth

            {{-- Language selector removed as DE is now the only public language --}}
        </nav>
    </div>
</header>
