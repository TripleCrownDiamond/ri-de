@props(['reviews'])

<section class="relative overflow-hidden bg-white py-24 sm:py-32">
    {{-- Decorative Background Elements --}}
    <div class="absolute inset-0 -z-10">
        <div class="absolute left-1/2 top-0 h-[500px] w-full -translate-x-1/2 bg-gradient-to-b from-gray-50 to-transparent"></div>
        <div class="absolute -right-24 top-24 h-96 w-96 rounded-full bg-blue-50/50 blur-3xl"></div>
        <div class="absolute -left-24 bottom-24 h-96 w-96 rounded-full bg-gray-100/50 blur-3xl"></div>
    </div>

    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-base font-bold uppercase tracking-[0.2em] text-blue-600">{{ __('Témoignages') }}</h2>
            <p class="mt-4 text-4xl font-black tracking-tight text-gray-900 sm:text-5xl uppercase italic">
                {!! __('Avis <span class="text-blue-600">Clients</span>') !!}
            </p>
            <p class="mt-6 text-lg leading-8 text-gray-600">
                {{ __('Découvrez pourquoi nos clients nous font confiance pour leur équipement professionnel.') }}
            </p>
        </div>

        <div class="relative mt-16 sm:mt-20">
            {{-- Scrolling Container --}}
            <div class="flex overflow-hidden [mask-image:linear-gradient(to_right,transparent,black_10%,black_90%,transparent)]">
                <div class="flex animate-scroll hover:[animation-play-state:paused] gap-8 py-4">
                    {{-- First set of reviews --}}
                    @foreach($reviews as $review)
                        <div class="flex w-[350px] flex-none flex-col justify-between rounded-[2.5rem] border border-gray-100 bg-white p-8 shadow-sm transition-all duration-500 hover:-translate-y-2 hover:border-blue-100 hover:shadow-2xl hover:shadow-red-900/5">
                            {{-- Quote Icon --}}
                            <div class="absolute top-6 right-8 text-gray-100 transition-colors group-hover:text-blue-50">
                                <svg class="h-12 w-12" fill="currentColor" viewBox="0 0 32 32">
                                    <path d="M10 8c-3.3 0-6 2.7-6 6v10h10V14H7c0-1.7 1.3-3 3-3V8zm12 0c-3.3 0-6 2.7-6 6v10h10V14h-7c0-1.7 1.3-3 3-3V8z" />
                                </svg>
                            </div>

                            <div class="relative">
                                <div class="flex text-amber-400">
                                    @for($i = 0; $i < 5; $i++)
                                        <svg class="h-5 w-5 {{ $i < $review['rating'] ? 'fill-current' : 'text-gray-200 fill-current' }}" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                                <blockquote class="mt-6 text-lg font-medium leading-8 text-gray-900 italic">
                                    “{{ $review['comment'] }}”
                                </blockquote>
                            </div>

                            <div class="mt-8 flex items-center gap-x-4 border-t border-gray-50 pt-6 transition-colors group-hover:border-blue-50">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-600 to-blue-700 font-black text-white shadow-lg shadow-red-200">
                                    {{ substr($review['name'], 0, 1) }}
                                </div>
                                <div class="text-sm leading-6">
                                    <p class="font-black text-gray-900">{{ $review['name'] }}</p>
                                    <p class="font-medium text-gray-500">{{ $review['date'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- Duplicate set for seamless scrolling --}}
                    @foreach($reviews as $review)
                        <div class="flex w-[350px] flex-none flex-col justify-between rounded-[2.5rem] border border-gray-100 bg-white p-8 shadow-sm transition-all duration-500 hover:-translate-y-2 hover:border-blue-100 hover:shadow-2xl hover:shadow-red-900/5">
                            {{-- Same content as above --}}
                            <div class="absolute top-6 right-8 text-gray-100 transition-colors group-hover:text-blue-50">
                                <svg class="h-12 w-12" fill="currentColor" viewBox="0 0 32 32">
                                    <path d="M10 8c-3.3 0-6 2.7-6 6v10h10V14H7c0-1.7 1.3-3 3-3V8zm12 0c-3.3 0-6 2.7-6 6v10h10V14h-7c0-1.7 1.3-3 3-3V8z" />
                                </svg>
                            </div>

                            <div class="relative">
                                <div class="flex text-amber-400">
                                    @for($i = 0; $i < 5; $i++)
                                        <svg class="h-5 w-5 {{ $i < $review['rating'] ? 'fill-current' : 'text-gray-200 fill-current' }}" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                                <blockquote class="mt-6 text-lg font-medium leading-8 text-gray-900 italic">
                                    “{{ $review['comment'] }}”
                                </blockquote>
                            </div>

                            <div class="mt-8 flex items-center gap-x-4 border-t border-gray-50 pt-6 transition-colors group-hover:border-blue-50">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-600 to-blue-700 font-black text-white shadow-lg shadow-red-200">
                                    {{ substr($review['name'], 0, 1) }}
                                </div>
                                <div class="text-sm leading-6">
                                    <p class="font-black text-gray-900">{{ $review['name'] }}</p>
                                    <p class="font-medium text-gray-500">{{ $review['date'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <style>
            @keyframes scroll {
                0% { transform: translateX(0); }
                100% { transform: translateX(calc(-350px * {{ count($reviews) }} - 2rem * {{ count($reviews) }})); }
            }
            .animate-scroll {
                animation: scroll 40s linear infinite;
            }
        </style>

        {{-- Trust Indicators --}}
        <div class="mt-24 flex flex-wrap items-center justify-center gap-x-12 gap-y-8 border-t border-gray-100 pt-16 grayscale opacity-50 transition-all hover:grayscale-0 hover:opacity-100">
            <div class="flex items-center gap-2">
                <span class="text-2xl font-black text-gray-900">Google</span>
                <div class="flex text-amber-400">
                    @for($i = 0; $i < 5; $i++)
                        <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                    @endfor
                </div>
                <span class="text-sm font-bold text-gray-500">4.9/5</span>
            </div>
            <div class="h-4 w-px bg-gray-200 hidden sm:block"></div>
            <div class="flex items-center gap-2">
                <span class="text-2xl font-black text-gray-900">Facebook</span>
                <span class="text-sm font-bold text-gray-500">1.2k followers</span>
            </div>
            <div class="h-4 w-px bg-gray-200 hidden sm:block"></div>
            <div class="flex items-center gap-2">
                <span class="text-2xl font-black text-gray-900">Trustpilot</span>
                <div class="flex gap-1">
                    @for($i = 0; $i < 5; $i++)
                        <div class="h-4 w-4 bg-green-500"></div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</section>