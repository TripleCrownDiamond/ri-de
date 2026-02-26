<x-public-layout>
    <div class="bg-gray-50 py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ __('Demande de devis') }}</h2>
                <p class="mt-2 text-lg leading-8 text-gray-600">
                    {{ __('Remplissez le formulaire ci-dessous pour recevoir une proposition adaptée à vos besoins.') }}
                </p>
            </div>

            <div class="mx-auto mt-16 max-w-xl sm:mt-20">
                @if(session('success'))
                    <div class="mb-8 p-6 bg-green-50 border border-green-100 text-green-700 rounded-3xl shadow-sm flex items-center">
                        <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="font-bold">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="rounded-[2.5rem] border border-gray-100 bg-white p-8 shadow-xl shadow-gray-200/50 sm:p-10">
                    <form action="{{ route('quote.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="product" value="{{ $product }}">
                        <input type="hidden" name="sku" value="{{ $sku }}">
                        <input type="hidden" name="qty" value="{{ $qty ?? 1 }}">

                        <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label for="name" class="block text-sm font-bold text-gray-900 mb-2">{{ __('Nom complet') }}</label>
                                <input type="text" name="name" id="name" required
                                    class="block w-full rounded-2xl border-gray-100 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                            </div>

                            <div class="sm:col-span-2">
                                <label for="email" class="block text-sm font-bold text-gray-900 mb-2">{{ __('Email') }}</label>
                                <input type="email" name="email" id="email" required
                                    class="block w-full rounded-2xl border-gray-100 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                            </div>

                            <div class="sm:col-span-2">
                                <label for="phone" class="block text-sm font-bold text-gray-900 mb-2">{{ __('Téléphone') }}</label>
                                <input type="tel" name="phone" id="phone"
                                    class="block w-full rounded-2xl border-gray-100 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                            </div>

                            <div class="sm:col-span-2">
                                <label for="message" class="block text-sm font-bold text-gray-900 mb-2">{{ __('Votre demande / Besoins spécifiques') }}</label>
                                <textarea name="message" id="message" rows="4"
                                    class="block w-full rounded-2xl border-gray-100 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">@if($product){{ __('Je souhaite obtenir un devis pour :') }} {{ $product }} (SKU: {{ $sku }}) x{{ $qty ?? 1 }}@endif</textarea>
                            </div>
                        </div>

                        <div class="mt-10">
                            <button type="submit" class="block w-full rounded-2xl bg-blue-600 px-8 py-4 text-center text-sm font-black uppercase tracking-widest text-white shadow-xl shadow-red-900/20 hover:bg-blue-700 hover:scale-[1.02] active:scale-95 transition-all">
                                {{ __('Envoyer ma demande') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
