@props(['deal_product'])

@if($deal_product)
<section class="relative mt-24 overflow-hidden bg-gray-900 py-24 sm:py-32">
    {{-- Decorative background elements --}}
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-[30%] -left-[10%] h-[70%] w-[40%] rounded-full bg-blue-600/20 blur-[120px]"></div>
        <div class="absolute -bottom-[30%] -right-[10%] h-[70%] w-[40%] rounded-full bg-blue-900/30 blur-[120px]"></div>
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10"></div>
    </div>

    <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
        <div class="grid grid-cols-1 items-center gap-x-12 gap-y-16 lg:grid-cols-2">
            
            {{-- Left Content: Text & Info --}}
            <div class="order-2 lg:order-1">
                <div class="inline-flex items-center gap-2 rounded-full bg-blue-600/10 px-4 py-1.5 text-sm font-semibold leading-6 text-blue-500 ring-1 ring-inset ring-blue-600/20">
                    <span class="relative flex h-2 w-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-blue-500"></span>
                    </span>
                    {{ __('Offre Limitée') }}
                </div>
                
                <h2 class="mt-6 text-4xl font-black tracking-tight text-white sm:text-6xl uppercase italic">
                    {{ __('Le Deal') }}<br/>
                    <span class="text-blue-600">{{ __('de la Semaine') }}</span>
                </h2>
                
                <p class="mt-6 text-lg leading-8 text-gray-300">
                    {{ __('Ne manquez pas notre sélection hebdomadaire. Un produit exceptionnel à un prix imbattable, disponible seulement pour quelques jours.') }}
                </p>

                <div class="mt-10 flex flex-col gap-6 sm:flex-row sm:items-center">
                    <div class="flex flex-col">
                        <span class="text-sm font-medium uppercase tracking-widest text-gray-400">{{ __('Prix Exceptionnel') }}</span>
                        @if($deal_product->price_ttc)
                            <div class="mt-1 flex items-baseline gap-2">
                                <span class="text-4xl font-black text-white">{{ number_format($deal_product->price_ttc, 2, ',', ' ') }} €</span>
                                @if($deal_product->price_ht)
                                    <span class="text-lg text-gray-500 line-through">{{ number_format($deal_product->price_ht * 1.2, 2, ',', ' ') }} €</span>
                                @endif
                            </div>
                        @else
                            <span class="mt-1 text-2xl font-bold text-white uppercase italic">{{ __('Sur Devis') }}</span>
                        @endif
                    </div>

                    <div class="h-px w-full bg-gray-800 sm:h-12 sm:w-px"></div>

                    {{-- Real Countdown --}}
                    <div class="flex gap-4" x-data="{ 
                        days: '00', 
                        hours: '00', 
                        mins: '00', 
                        secs: '00',
                        init() {
                            const updateCountdown = () => {
                                const now = new Date();
                                // Target next Sunday 23:59:59
                                const target = new Date();
                                target.setDate(now.getDate() + (7 - now.getDay()));
                                target.setHours(23, 59, 59, 999);
                                
                                const diff = target - now;
                                
                                if (diff > 0) {
                                    this.days = Math.floor(diff / (1000 * 60 * 60 * 24)).toString().padStart(2, '0');
                                    this.hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString().padStart(2, '0');
                                    this.mins = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0');
                                    this.secs = Math.floor((diff % (1000 * 60)) / 1000).toString().padStart(2, '0');
                                }
                            };
                            updateCountdown();
                            setInterval(updateCountdown, 1000);
                        }
                    }">
                        <div class="flex flex-col items-center">
                            <span class="text-2xl font-black text-white" x-text="days"></span>
                            <span class="text-[10px] font-bold uppercase tracking-widest text-gray-500">{{ __('Jours') }}</span>
                        </div>
                        <span class="text-2xl font-black text-blue-600">:</span>
                        <div class="flex flex-col items-center">
                            <span class="text-2xl font-black text-white" x-text="hours"></span>
                            <span class="text-[10px] font-bold uppercase tracking-widest text-gray-500">{{ __('Hrs') }}</span>
                        </div>
                        <span class="text-2xl font-black text-blue-600">:</span>
                        <div class="flex flex-col items-center">
                            <span class="text-2xl font-black text-white" x-text="mins"></span>
                            <span class="text-[10px] font-bold uppercase tracking-widest text-gray-500">{{ __('Min') }}</span>
                        </div>
                        <span class="text-2xl font-black text-blue-600">:</span>
                        <div class="flex flex-col items-center">
                            <span class="text-2xl font-black text-white" x-text="secs"></span>
                            <span class="text-[10px] font-bold uppercase tracking-widest text-gray-500">{{ __('Sec') }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-10 flex items-center gap-x-6">
                    <a href="{{ route('products.show', ['locale' => app()->getLocale(), 'product' => $deal_product->slug]) }}" class="group relative z-20 inline-flex items-center gap-2 overflow-hidden rounded-full bg-blue-600 px-8 py-4 text-sm font-black uppercase tracking-widest text-white shadow-xl transition-all hover:bg-blue-700 hover:shadow-red-900/40">
                        <span class="relative z-10">{{ __('Profiter de l\'offre') }}</span>
                        <svg class="relative z-10 h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                        <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/20 to-transparent transition-transform duration-500 group-hover:translate-x-full"></div>
                    </a>
                </div>
            </div>

            {{-- Right Content: Product Image Card --}}
            <div class="order-1 lg:order-2">
                <div class="group relative">
                    {{-- Decorative Rings --}}
                    <div class="absolute -inset-4 rounded-[3rem] border border-blue-600/20 bg-blue-600/5 transition-transform duration-700 group-hover:scale-105"></div>
                    <div class="absolute -inset-8 rounded-[4rem] border border-white/5 bg-white/5 transition-transform duration-1000 group-hover:scale-110"></div>
                    
                    <div class="relative overflow-hidden rounded-[2.5rem] bg-gray-800 p-4 shadow-2xl ring-1 ring-white/10">
                        @if ($deal_product->media->isNotEmpty())
                            @php
                                $featured = $deal_product->media->firstWhere('is_primary', true) ?? $deal_product->media->first();
                            @endphp
                            <div class="relative aspect-[4/3] overflow-hidden rounded-[2rem]">
                                <img
                                    src="{{ Str::startsWith($featured->path, ['http://', 'https://']) ? $featured->path : asset($featured->path) }}"
                                    alt="{{ $deal_product->title }}"
                                    class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-transparent to-transparent"></div>
                                
                                {{-- Floating Info Badge --}}
                                <div class="absolute bottom-6 left-6 right-6">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-xs font-bold uppercase tracking-widest text-blue-500">{{ __('Produit Vedette') }}</p>
                                            <h3 class="mt-1 text-xl font-bold text-white">{{ $deal_product->title }}</h3>
                                        </div>
                                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10 backdrop-blur-md">
                                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endif