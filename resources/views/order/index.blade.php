<x-public-layout>
    <div class="bg-gray-50 py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ __('Bestellung aufgeben') }}</h2>
                <p class="mt-2 text-lg leading-8 text-gray-600">
                    {{ __('Bitte füllen Sie das folgende Formular aus, um Ihre Bestellung abzuschließen.') }}
                </p>
            </div>

            <div class="mx-auto mt-16 max-w-xl sm:mt-20">
                <div class="rounded-[2.5rem] border border-gray-100 bg-white p-8 shadow-xl shadow-gray-200/50 sm:p-10" x-data="{ createAccount: false }">
                    <form action="{{ route('order.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="product" value="{{ $product }}">
                        <input type="hidden" name="sku" value="{{ $sku }}">
                        <input type="hidden" name="qty" value="{{ $qty ?? 1 }}">

                        <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label for="name" class="block text-sm font-bold text-gray-900 mb-2">{{ __('Vollständiger Name') }}</label>
                                <input type="text" name="name" id="name" required value="{{ old('name', auth()->user()->name ?? '') }}"
                                    class="block w-full rounded-2xl border-gray-100 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all @error('name') border-blue-500 @enderror">
                                @error('name')
                                    <p class="mt-1 text-xs text-blue-600 font-bold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label for="email" class="block text-sm font-bold text-gray-900 mb-2">{{ __('E-Mail Adresse') }}</label>
                                <input type="email" name="email" id="email" required value="{{ old('email', auth()->user()->email ?? '') }}"
                                    class="block w-full rounded-2xl border-gray-100 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all @error('email') border-blue-500 @enderror">
                                @error('email')
                                    <p class="mt-1 text-xs text-blue-600 font-bold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label for="phone" class="block text-sm font-bold text-gray-900 mb-2">{{ __('Telefonnummer') }}</label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                    class="block w-full rounded-2xl border-gray-100 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all @error('phone') border-blue-500 @enderror">
                                @error('phone')
                                    <p class="mt-1 text-xs text-blue-600 font-bold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label for="address" class="block text-sm font-bold text-gray-900 mb-2">{{ __('Lieferadresse') }}</label>
                                <textarea name="address" id="address" rows="3"
                                    class="block w-full rounded-2xl border-gray-100 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all @error('address') border-blue-500 @enderror">{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="mt-1 text-xs text-blue-600 font-bold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label for="message" class="block text-sm font-bold text-gray-900 mb-2">{{ __('Zusätzliche Details oder Nachricht') }}</label>
                                <textarea name="message" id="message" rows="4"
                                    class="block w-full rounded-2xl border-gray-100 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all @error('message') border-blue-500 @enderror">@if($product){{ __('Ich möchte folgendes bestellen:') }} {{ $product }} (SKU: {{ $sku }}) x{{ $qty ?? 1 }}@endif</textarea>
                                @error('message')
                                    <p class="mt-1 text-xs text-blue-600 font-bold">{{ $message }}</p>
                                @enderror
                            </div>

                            @guest
                            <div class="sm:col-span-2 pt-4 border-t border-gray-100">
                                <div class="flex items-center mb-4">
                                    <input type="checkbox" name="create_account" id="create_account" value="1" x-model="createAccount"
                                        class="w-5 h-5 text-blue-600 bg-gray-50 border-gray-200 rounded-lg focus:ring-blue-600 focus:ring-2 transition-all cursor-pointer">
                                    <label for="create_account" class="ml-3 text-sm font-bold text-gray-900 cursor-pointer">
                                        {{ __('Ein Konto erstellen, um meine Bestellung zu verfolgen') }}
                                    </label>
                                </div>

                                <div x-show="createAccount" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                                    <div>
                                        <label for="password" class="block text-sm font-bold text-gray-900 mb-2">{{ __('Passwort') }}</label>
                                        <input type="password" name="password" id="password" x-bind:required="createAccount"
                                            class="block w-full rounded-2xl border-gray-100 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all @error('password') border-blue-500 @enderror">
                                        @error('password')
                                            <p class="mt-1 text-xs text-blue-600 font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-bold text-gray-900 mb-2">{{ __('Passwort bestätigen') }}</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" x-bind:required="createAccount"
                                            class="block w-full rounded-2xl border-gray-100 bg-gray-50 px-4 py-3 text-gray-900 shadow-sm focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                                    </div>
                                </div>
                            </div>
                            @endguest

                            <div class="sm:col-span-2 pt-4 border-t border-gray-100">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" name="accept_terms" id="accept_terms" required
                                            class="w-5 h-5 text-blue-600 bg-gray-50 border-gray-200 rounded-lg focus:ring-blue-600 focus:ring-2 transition-all cursor-pointer">
                                    </div>
                                    <label for="accept_terms" class="ml-3 text-sm font-medium text-gray-900 cursor-pointer leading-6">
                                        {{ __('Ich akzeptiere die') }} 
                                        <a href="{{ route('legal.show', ['locale' => app()->getLocale(), 'legalPage' => 'agb']) }}" target="_blank" class="text-blue-600 font-bold hover:underline">
                                            {{ __('Allgemeinen Geschäftsbedingungen (AGB)') }}
                                        </a>
                                    </label>
                                </div>
                                @error('accept_terms')
                                    <p class="mt-2 text-xs text-blue-600 font-bold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-10">
                            <button type="submit" class="block w-full rounded-2xl bg-blue-600 px-8 py-4 text-center text-sm font-black uppercase tracking-widest text-white shadow-xl shadow-red-900/20 hover:bg-blue-700 hover:scale-[1.02] active:scale-95 transition-all">
                                {{ __('Bestellung absenden') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
