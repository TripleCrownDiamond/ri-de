<section class="relative z-10 -mt-12 px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <div class="grid grid-cols-1 overflow-hidden rounded-[2.5rem] border border-gray-100 bg-white shadow-2xl shadow-gray-200/50 sm:grid-cols-2 lg:grid-cols-4">
            {{-- Badge 1 --}}
            <div class="group relative flex items-center gap-6 border-b border-gray-50 p-8 transition-colors hover:bg-blue-50/30 sm:border-r lg:border-b-0">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 transition-transform duration-500 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-black uppercase tracking-widest text-gray-900">{{ __('Paiement Sécurisé') }}</h3>
                    <p class="mt-1 text-sm font-medium text-gray-500">{{ __('Transactions cryptées SSL') }}</p>
                </div>
                <div class="absolute bottom-0 left-0 h-1 w-0 bg-blue-600 transition-all duration-500 group-hover:w-full"></div>
            </div>

            {{-- Badge 2 --}}
            <div class="group relative flex items-center gap-6 border-b border-gray-50 p-8 transition-colors hover:bg-blue-50/30 lg:border-b-0 lg:border-r">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 transition-transform duration-500 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-black uppercase tracking-widest text-gray-900">{{ __('Livraison Express') }}</h3>
                    <p class="mt-1 text-sm font-medium text-gray-500">{{ __('Livraison partout en France') }}</p>
                </div>
                <div class="absolute bottom-0 left-0 h-1 w-0 bg-blue-600 transition-all duration-500 group-hover:w-full"></div>
            </div>

            {{-- Badge 3 --}}
            <div class="group relative flex items-center gap-6 border-b border-gray-50 p-8 transition-colors hover:bg-blue-50/30 sm:border-r lg:border-b-0">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 transition-transform duration-500 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 01-.923 1.785A5.969 5.969 0 006 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-black uppercase tracking-widest text-gray-900">{{ __('Support Client') }}</h3>
                    <p class="mt-1 text-sm font-medium text-gray-500">{{ __('Une équipe à votre écoute') }}</p>
                </div>
                <div class="absolute bottom-0 left-0 h-1 w-0 bg-blue-600 transition-all duration-500 group-hover:w-full"></div>
            </div>

            {{-- Badge 4 --}}
            <div class="group relative flex items-center gap-6 p-8 transition-colors hover:bg-blue-50/30">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 transition-transform duration-500 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-black uppercase tracking-widest text-gray-900">{{ __('Garantie Incluse') }}</h3>
                    <p class="mt-1 text-sm font-medium text-gray-500">{{ __('Qualité certifiée') }}</p>
                </div>
                <div class="absolute bottom-0 left-0 h-1 w-0 bg-blue-600 transition-all duration-500 group-hover:w-full"></div>
            </div>
        </div>
    </div>
</section>