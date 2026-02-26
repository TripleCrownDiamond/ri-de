<main
    class="relative mt-0 pb-16"
    x-data="{
        current: 0,
        slides: [
            {
                key: 'trailers',
                badge: '{{ __('Remorques') }}',
                title: '{{ addslashes(__('messages.hero.trailers.title')) }}',
                description: '{{ addslashes(__('messages.hero.trailers.description')) }}',
                images: [
                    {
                        webp: '{{ asset('img/slides/slide1-remorques/remorque-fermee-fixe-derriere-vehicule.webp') }}',
                        fallback: '{{ asset('img/slides/slide1-remorques/remorque-fermee-fixe-derriere-vehicule.jpg') }}',
                    },
                    {
                        webp: '{{ asset('img/slides/slide1-remorques/remorque-fermee.webp') }}',
                        fallback: '{{ asset('img/slides/slide1-remorques/remorque-fermee.jpg') }}',
                    },
                    {
                        webp: '{{ asset('img/slides/slide1-remorques/remorque-fixe-derriere-vehicule.webp') }}',
                        fallback: '{{ asset('img/slides/slide1-remorques/remorque-fixe-derriere-vehicule.jpg') }}',
                    },
                ],
            },
            {
                key: 'mowers',
                badge: '{{ __('Tondeuses') }}',
                title: '{{ addslashes(__('messages.hero.mowers.title')) }}',
                description: '{{ addslashes(__('messages.hero.mowers.description')) }}',
                images: [
                    {
                        webp: '{{ asset('img/slides/slide2-tondeuses/image-tondeuse-3.webp') }}',
                        fallback: '{{ asset('img/slides/slide2-tondeuses/image-tondeuse-3.webp') }}',
                    },
                    {
                        webp: '{{ asset('img/slides/slide2-tondeuses/tondeuse-image-2.webp') }}',
                        fallback: '{{ asset('img/slides/slide2-tondeuses/tondeuse-image-2.webp') }}',
                    },
                    {
                        webp: '{{ asset('img/slides/slide2-tondeuses/tondeuse-robot.webp') }}',
                        fallback: '{{ asset('img/slides/slide2-tondeuses/tondeuse-robot.jpg') }}',
                    },
                ],
            },
            {
                key: 'containers',
                badge: '{{ __('Conteneurs') }}',
                title: '{{ addslashes(__('messages.hero.containers.title')) }}',
                description: '{{ addslashes(__('messages.hero.containers.description')) }}',
                images: [
                    {
                        webp: '{{ asset('img/slides/slide3-conteneurs/conteneur1.webp') }}',
                        fallback: '{{ asset('img/slides/slide3-conteneurs/conteneur1.webp') }}',
                    },
                    {
                        webp: '{{ asset('img/slides/slide3-conteneurs/conteneur2.webp') }}',
                        fallback: '{{ asset('img/slides/slide3-conteneurs/conteneur2.jpg') }}',
                    },
                    {
                        webp: '{{ asset('img/slides/slide3-conteneurs/conteneur-aménagé.webp') }}',
                        fallback: '{{ asset('img/slides/slide3-conteneurs/conteneur-aménagé.webp') }}',
                    },
                ],
            },
        ],
        intervalId: null,
        init() {
            this.start();
        },
        start() {
            this.intervalId = setInterval(() => {
                this.current = (this.current + 1) % this.slides.length;
            }, 7000);
        },
        goTo(index) {
            this.current = index;
        },
    }"
>
    <div class="relative overflow-hidden bg-gray-950">
        <div class="relative h-[80vh] min-h-[600px]">
            <template x-for="(slide, index) in slides" :key="slide.key">
                <div
                    x-show="current === index"
                    x-transition:enter="transition ease-out duration-1000"
                    x-transition:enter-start="opacity-0 scale-105"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-1000"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute inset-0"
                >
                    <div class="absolute inset-0 overflow-hidden">
                        <picture>
                            <source :srcset="slide.images[2].webp" type="image/webp">
                            <img
                                :src="slide.images[2].fallback"
                                class="h-full w-full object-cover transition-transform duration-[10000ms] ease-linear"
                                :class="current === index ? 'scale-110' : 'scale-100'"
                                loading="lazy"
                                alt=""
                            >
                        </picture>
                        <div class="absolute inset-0 bg-gradient-to-r from-gray-950 via-gray-950/60 to-transparent"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-950/80 via-transparent to-transparent"></div>
                    </div>

                    <div class="relative z-10 mx-auto flex h-full max-w-7xl items-center px-6">
                        <article class="flex h-full flex-1 flex-col justify-center space-y-8 text-white lg:max-w-2xl">
                           
                            
                            <h1 class="text-4xl font-black leading-[1.1] tracking-tight sm:text-6xl lg:text-8xl">
                                <span class="block text-white" x-text="slide.title.split(' ').slice(0, -1).join(' ')"></span>
                                <span class="block bg-gradient-to-r from-blue-500 to-blue-700 bg-clip-text text-transparent" x-text="slide.title.split(' ').pop()"></span>
                            </h1>

                            <p class="max-w-xl text-lg leading-relaxed text-gray-300 sm:text-xl font-medium" x-text="slide.description"></p>

                            <div class="flex flex-wrap items-center gap-5 pt-4">
                                <a
                                    href="{{ route('shop.index') }}"
                                    class="group relative inline-flex items-center justify-center overflow-hidden rounded-full bg-blue-600 px-10 py-5 text-sm font-black uppercase tracking-widest text-white shadow-2xl shadow-red-900/40 transition-all hover:bg-blue-700 hover:-translate-y-1 active:scale-95"
                                >
                                    <span class="relative z-10">{{ __('messages.hero.cta.trailers') }}</span>
                                    <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/20 to-transparent transition-transform duration-500 group-hover:translate-x-full"></div>
                                </a>
                                <a
                                    href="{{ route('shop.index') }}"
                                    class="group inline-flex items-center justify-center rounded-full border-2 border-white/20 bg-white/5 px-10 py-5 text-sm font-black uppercase tracking-widest text-white backdrop-blur-md transition-all hover:border-white hover:bg-white hover:text-gray-950 hover:-translate-y-1"
                                >
                                    {{ __('messages.hero.cta.mowers') }}
                                </a>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-8 border-t border-white/10">
                                <div class="flex items-center gap-4 group">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/5 border border-white/10 group-hover:border-blue-500/50 transition-colors">
                                        <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                                    </div>
                                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400 group-hover:text-white transition-colors">{{ __('messages.hero.badges.security') }}</span>
                                </div>
                                <div class="flex items-center gap-4 group">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/5 border border-white/10 group-hover:border-blue-500/50 transition-colors">
                                        <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                    </div>
                                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400 group-hover:text-white transition-colors">{{ __('messages.hero.badges.warranty') }}</span>
                                </div>
                                <div class="flex items-center gap-4 group">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/5 border border-white/10 group-hover:border-blue-500/50 transition-colors">
                                        <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                    </div>
                                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400 group-hover:text-white transition-colors">{{ __('messages.hero.badges.workshop') }}</span>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </template>
        </div>

        <!-- Progress bar indicator -->
        <div class="absolute bottom-0 left-0 h-1 bg-blue-600 transition-all duration-[7000ms] ease-linear" :style="`width: ${((current + 1) / slides.length) * 100}%`" :key="current"></div>

        <div class="relative z-20 mx-auto flex max-w-7xl items-center justify-between px-6 py-8">
            <div class="flex items-center gap-6">
                <template x-for="(slide, index) in slides" :key="slide.key + '-nav'">
                    <button
                        @click="goTo(index)"
                        class="group flex flex-col gap-2 text-left transition-all"
                        :class="current === index ? 'opacity-100' : 'opacity-40 hover:opacity-70'"
                    >
                        <span class="text-[10px] font-black uppercase tracking-widest text-white" x-text="`0${index + 1}`"></span>
                        <div class="h-1 w-12 overflow-hidden rounded-full bg-white/20">
                            <div class="h-full bg-blue-600 transition-all duration-500" :class="current === index ? 'w-full' : 'w-0'"></div>
                        </div>
                        <span class="hidden text-xs font-bold text-white sm:block" x-text="slide.badge"></span>
                    </button>
                </template>
            </div>
            
            <div class="flex items-center gap-4">
                <button @click="current = (current - 1 + slides.length) % slides.length" class="flex h-12 w-12 items-center justify-center rounded-full border border-white/20 bg-white/5 text-white transition-all hover:bg-white hover:text-gray-950">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </button>
                <button @click="current = (current + 1) % slides.length" class="flex h-12 w-12 items-center justify-center rounded-full border border-white/20 bg-white/5 text-white transition-all hover:bg-white hover:text-gray-950">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </button>
            </div>
        </div>
    </div>
</main>
