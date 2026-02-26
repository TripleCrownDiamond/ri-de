<x-public-layout>
    <div class="bg-gray-50 py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8 text-center">
            <div class="mb-8 flex justify-center">
                <div class="p-4 bg-green-50 text-green-500 rounded-full shadow-inner">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            
            <h2 class="text-3xl font-black tracking-tight text-gray-900 sm:text-5xl uppercase tracking-tighter mb-4">
                {{ __('Vielen Dank!') }}
            </h2>
            <p class="text-xl font-bold text-gray-600 mb-12">
                {{ __('Ihre Bestellung wurde erfolgreich versendet.') }}
            </p>

            <div class="mx-auto max-w-2xl bg-white rounded-[2.5rem] p-8 shadow-xl shadow-gray-200/50 border border-gray-100 text-left">
                <h3 class="text-xs font-black uppercase tracking-widest text-gray-400 mb-6 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 11h14a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2z"/></svg>
                    {{ __('Zusammenfassung der Bestellung') }}
                </h3>

                <div class="space-y-4 mb-8">
                    @if($order->product_image)
                    <div class="flex justify-center mb-6">
                        <img src="{{ $order->product_image }}" alt="{{ $order->product_name }}" class="h-32 w-auto object-contain rounded-xl">
                    </div>
                    @endif
                    <div class="flex justify-between border-b border-gray-50 pb-4">
                        <span class="text-gray-400 font-bold uppercase text-[10px] tracking-widest">{{ __('Produkt') }}</span>
                        <span class="font-bold text-gray-900 text-right">{{ $order->product_name }}</span>
                    </div>
                    @if($order->product_price)
                    <div class="flex justify-between border-b border-gray-50 pb-4">
                        <span class="text-gray-400 font-bold uppercase text-[10px] tracking-widest">{{ __('Preis') }}</span>
                        <span class="font-bold text-gray-900">{{ number_format($order->product_price, 2, ',', '.') }} €</span>
                    </div>
                    @endif
                    <div class="flex justify-between border-b border-gray-50 pb-4">
                        <span class="text-gray-400 font-bold uppercase text-[10px] tracking-widest">{{ __('Referenz (SKU)') }}</span>
                        <span class="font-mono font-bold text-gray-900">{{ $order->sku ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-50 pb-4">
                        <span class="text-gray-400 font-bold uppercase text-[10px] tracking-widest">{{ __('Menge') }}</span>
                        <span class="font-bold text-gray-900">{{ $order->quantity }}</span>
                    </div>
                    @if($order->product_price)
                    <div class="flex justify-between pt-2">
                        <span class="text-gray-900 font-black uppercase text-xs tracking-widest">{{ __('Gesamtbetrag') }}</span>
                        <span class="font-black text-xl text-blue-600">{{ number_format($order->product_price * $order->quantity, 2, ',', '.') }} €</span>
                    </div>
                    @endif
                </div>

                @if($company_info)
                    @php
                        $instructions = app()->getLocale() == 'de' ? $company_info->payment_instructions_de : $company_info->payment_instructions_fr;
                        $hasRib = $company_info->show_rib_on_order && ($company_info->iban || $company_info->bic || $company_info->bank_name);
                    @endphp

                    @if($instructions || $hasRib)
                        <div class="p-6 bg-blue-50 rounded-2xl border border-blue-100 mb-8">
                            <h4 class="text-xs font-black uppercase tracking-widest text-blue-600 mb-4 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                {{ __('Zahlungsinformationen') }}
                            </h4>

                            @if($instructions)
                                <div class="mb-6 prose prose-sm max-w-none text-gray-700 font-medium">
                                    {!! $instructions !!}
                                </div>
                            @endif

                            @if($hasRib)
                                <div class="space-y-3 text-sm border-t border-blue-100 pt-4">
                                    @if($company_info->bank_name)
                                    <div class="flex justify-between">
                                        <span class="text-gray-500 font-bold uppercase text-[9px] tracking-widest">{{ __('Bank') }}</span>
                                        <span class="font-bold text-gray-900">{{ $company_info->bank_name }}</span>
                                    </div>
                                    @endif
                                    @if($company_info->iban)
                                    <div class="flex flex-col">
                                        <span class="text-gray-500 font-bold uppercase text-[9px] tracking-widest mb-1">{{ __('IBAN') }}</span>
                                        <span class="font-mono font-bold text-gray-900 break-all">{{ $company_info->iban }}</span>
                                    </div>
                                    @endif
                                    @if($company_info->bic)
                                    <div class="flex justify-between">
                                        <span class="text-gray-500 font-bold uppercase text-[9px] tracking-widest">{{ __('BIC / SWIFT') }}</span>
                                        <span class="font-mono font-bold text-gray-900">{{ $company_info->bic }}</span>
                                    </div>
                                    @endif
                                </div>
                            @endif
                            
                            <p class="mt-4 text-[10px] text-gray-500 italic leading-relaxed">
                                {{ __('* Ihre Bestellung wird bearbeitet, sobald wir Ihre Zahlung erhalten haben.') }}
                            </p>
                        </div>
                    @endif
                @endif

                <div class="mt-10">
                    <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="block w-full rounded-2xl bg-gray-900 px-8 py-4 text-center text-sm font-black uppercase tracking-widest text-white shadow-xl shadow-gray-900/20 hover:bg-blue-600 transition-all">
                        {{ __('Zurück zur Startseite') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>