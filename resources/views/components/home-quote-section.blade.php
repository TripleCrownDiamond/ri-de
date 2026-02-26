<section id="devis" class="mx-auto mt-10 max-w-7xl px-6 pb-20" x-data="{ quoteMessage: '' }" @prefill-quote.window="quoteMessage = '{{ __('Je souhaite commander : ') }}' + $event.detail.product + ' (SKU: ' + $event.detail.sku + ') x' + $event.detail.qty + '\n\n{{ __('Mes précisions : ') }}'">
    <div class="rounded-[2rem] border border-gray-200 bg-gradient-to-r from-gray-900 via-gray-900 to-gray-800 px-6 py-8 text-white shadow-[0_18px_40px_rgba(15,23,42,0.55)] sm:px-10 sm:py-10">
        <div class="flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">
            <div class="space-y-3">
                <p class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-emerald-300">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                    {{ __('Demande de devis en ligne') }}
                </p>
                <h3 class="text-2xl font-semibold tracking-tight sm:text-3xl">
                    {{ __('Transformez ces tarifs en proposition personnalisée') }}
                </h3>
                <p class="max-w-xl text-sm text-gray-200 sm:text-base">
                    {{ __('Indiquez la catégorie, les références repérées et vos besoins. Nous vous répondons avec un devis détaillé, adapté à votre activité et à votre budget.') }}
                </p>
            </div>
            <form class="w-full max-w-lg space-y-4">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-medium uppercase tracking-wide text-gray-300">
                            {{ __('Nom / société') }}
                        </label>
                        <input
                            type="text"
                            class="block w-full rounded-xl border border-gray-600 bg-gray-900/60 px-3 py-2 text-sm text-white placeholder-gray-500 shadow-sm focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-400/40"
                            placeholder="{{ __('Dupont SARL') }}"
                        >
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-medium uppercase tracking-wide text-gray-300">
                            {{ __('E-mail') }}
                        </label>
                        <input
                            type="email"
                            class="block w-full rounded-xl border border-gray-600 bg-gray-900/60 px-3 py-2 text-sm text-white placeholder-gray-500 shadow-sm focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-400/40"
                            placeholder="{{ __('contact@exemple.fr') }}"
                        >
                    </div>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-medium uppercase tracking-wide text-gray-300">
                            {{ __('Catégorie') }}
                        </label>
                        <select
                            class="block w-full rounded-xl border border-gray-600 bg-gray-900/60 px-3 py-2 text-sm text-white shadow-sm focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-400/40"
                        >
                            <option>{{ __('Remorques') }}</option>
                            <option>{{ __('Tondeuses & robots') }}</option>
                            <option>{{ __('Bois, bûches & granulés') }}</option>
                            <option>{{ __('Conteneurs aménagés') }}</option>
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-medium uppercase tracking-wide text-gray-300">
                            {{ __('Budget indicatif') }}
                        </label>
                        <input
                            type="text"
                            class="block w-full rounded-xl border border-gray-600 bg-gray-900/60 px-3 py-2 text-sm text-white placeholder-gray-500 shadow-sm focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-400/40"
                            placeholder="{{ __('Ex. 3 000 € HT') }}"
                        >
                    </div>
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-medium uppercase tracking-wide text-gray-300">
                        {{ __('Produits repérés et précisions') }}
                    </label>
                    <textarea
                        rows="3"
                        x-model="quoteMessage"
                        class="block w-full rounded-xl border border-gray-600 bg-gray-900/60 px-3 py-2 text-sm text-white placeholder-gray-500 shadow-sm focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-400/40"
                        placeholder="{{ __('Ex. Remorque benne 1,5T + robot de tonte résidentiel, utilisation pro, besoin de livraison...') }}"
                    ></textarea>
                </div>
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <p class="text-xs text-gray-400">
                        {{ __('Envoi de devis sans engagement, réponse sous 24 à 48 h ouvrées.') }}
                    </p>
                    <button
                        type="button"
                        class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-5 py-2.5 text-xs font-semibold uppercase tracking-wide text-emerald-950 shadow-sm shadow-emerald-300/80 transition hover:-translate-y-0.5 hover:bg-emerald-400 hover:shadow-md hover:shadow-emerald-300/90"
                    >
                        {{ __('Envoyer une demande de devis') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
