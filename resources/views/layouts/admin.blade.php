<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin - {{ config('app.name', 'Remorques Industrie') }}</title>
    @php $company_info = \App\Models\CompanyInfo::first(); @endphp
    @if($company_info?->logo_path)
        <link rel="icon" type="image/png" href="{{ $company_info->logo_path }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <div class="flex min-h-screen" x-data="{ sidebarOpen: true }">
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 w-72 bg-gray-900 text-white transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-0"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center justify-between px-8 py-6 bg-gray-950">
                    <span class="text-xl font-black tracking-tighter uppercase">
                        Admin<span class="text-blue-600">.</span>
                    </span>
                    <button @click="sidebarOpen = false" class="lg:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                    <x-admin-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Tableau de bord
                    </x-admin-nav-link>

                    <div class="pt-4 pb-2">
                        <span class="px-4 text-[10px] font-bold tracking-widest text-gray-500 uppercase">Catalogue</span>
                    </div>

                    <x-admin-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        Produits
                    </x-admin-nav-link>

                    <x-admin-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        Catégories
                    </x-admin-nav-link>

                    <x-admin-nav-link :href="route('admin.brands.index')" :active="request()->routeIs('admin.brands.*')">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        Marques
                    </x-admin-nav-link>

                    <div class="pt-4 pb-2">
                        <span class="px-4 text-[10px] font-bold tracking-widest text-gray-500 uppercase">Site</span>
                    </div>

                    <x-admin-nav-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Informations site
                    </x-admin-nav-link>

                    <x-admin-nav-link :href="route('admin.legal-pages.index')" :active="request()->routeIs('admin.legal-pages.*')">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Pages Légales
                    </x-admin-nav-link>
                </nav>

                <!-- Footer -->
                <div class="p-4 bg-gray-950">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center w-full px-4 py-3 text-sm font-bold text-gray-400 hover:text-white transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Topbar -->
            <header class="flex items-center justify-between px-8 py-4 bg-white border-b border-gray-100 lg:py-6">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="mr-4 lg:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <h2 class="text-xl font-bold tracking-tight text-gray-900">
                        @yield('header')
                    </h2>
                </div>
                <div class="flex items-center space-y-1">
                    <a href="{{ url('/') }}" target="_blank" class="flex items-center px-4 py-2 text-sm font-bold text-gray-600 hover:text-gray-900 transition-colors">
                        Voir le site
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>
            </header>

            <!-- Page Body -->
            <main class="flex-1 overflow-y-auto p-8 lg:p-12">
                @if(session('success'))
                    <div class="mb-8 p-4 bg-green-50 border border-green-100 text-green-700 rounded-2xl flex items-center shadow-sm">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-8 p-4 bg-blue-50 border border-blue-100 text-blue-700 rounded-2xl shadow-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
