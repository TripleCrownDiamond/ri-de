<x-public-layout>
    <div class="bg-white">
        <!-- Hero Section -->
        <div class="relative isolate overflow-hidden bg-gray-900 py-24 sm:py-32">
            <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&crop=focalpoint&fp-y=.8&w=2830&h=1500&q=80&blend=111827&sat=-100&exp=15&blend-mode=multiply" alt="" class="absolute inset-0 -z-10 h-full w-full object-cover">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:mx-0">
                    <h2 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">{{ __('Contactez-nous') }}</h2>
                    <p class="mt-6 text-lg leading-8 text-gray-300">{{ __('Nous sommes à votre disposition pour répondre à toutes vos questions concernant nos remorques, matériels de motoculture et solutions d\'énergie.') }}</p>
                </div>
            </div>
        </div>

        <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
            <div class="grid grid-cols-1 gap-x-12 gap-y-16 lg:grid-cols-2">
                <!-- Contact Info -->
                <div>
                    <h3 class="text-3xl font-bold tracking-tight text-gray-900">{{ __('Nos coordonnées') }}</h3>
                    <p class="mt-4 text-lg leading-7 text-gray-600">
                        {{ __('N\'hésitez pas à nous rendre visite ou à nous contacter par téléphone ou email.') }}
                    </p>
                    <div class="mt-10 space-y-8 text-base leading-7 text-gray-600">
                        @if($company_info)
                            <div class="flex gap-x-4">
                                <dt class="flex-none">
                                    <span class="sr-only">Adresse</span>
                                    <svg class="h-7 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                </dt>
                                <dd>
                                    {{ $company_info->adresse_siege }}
                                </dd>
                            </div>
                            <div class="flex gap-x-4">
                                <dt class="flex-none">
                                    <span class="sr-only">Téléphone</span>
                                    <svg class="h-7 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                    </svg>
                                </dt>
                                <dd><a class="hover:text-gray-900" href="tel:{{ str_replace(' ', '', $company_info->telephone) }}">{{ $company_info->telephone }}</a></dd>
                            </div>
                            <div class="flex gap-x-4">
                                <dt class="flex-none">
                                    <span class="sr-only">Email</span>
                                    <svg class="h-7 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                    </svg>
                                </dt>
                                <dd><a class="hover:text-gray-900" href="mailto:{{ $company_info->email_contact }}">{{ $company_info->email_contact }}</a></dd>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Contact Form -->
                <form action="{{ route('contact.store') }}" method="POST" class="rounded-3xl border border-gray-200 bg-white p-8 shadow-sm">
                    @csrf
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-2xl font-bold">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
                        <div>
                            <label for="first_name" class="block text-sm font-semibold leading-6 text-gray-900">{{ __('Prénom') }}</label>
                            <div class="mt-2.5">
                                <input type="text" name="first_name" id="first_name" required value="{{ old('first_name') }}"
                                    class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm leading-6">
                            </div>
                            @error('first_name') <p class="mt-1 text-xs text-blue-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-semibold leading-6 text-gray-900">{{ __('Nom') }}</label>
                            <div class="mt-2.5">
                                <input type="text" name="last_name" id="last_name" required value="{{ old('last_name') }}"
                                    class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm leading-6">
                            </div>
                            @error('last_name') <p class="mt-1 text-xs text-blue-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="email" class="block text-sm font-semibold leading-6 text-gray-900">{{ __('Email') }}</label>
                            <div class="mt-2.5">
                                <input type="email" name="email" id="email" required value="{{ old('email') }}"
                                    class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm leading-6">
                            </div>
                            @error('email') <p class="mt-1 text-xs text-blue-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="message" class="block text-sm font-semibold leading-6 text-gray-900">{{ __('Message') }}</label>
                            <div class="mt-2.5">
                                <textarea name="message" id="message" rows="4" required
                                    class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm leading-6">{{ old('message') }}</textarea>
                            </div>
                            @error('message') <p class="mt-1 text-xs text-blue-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="mt-10">
                        <button type="submit" class="block w-full rounded-full bg-blue-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                            {{ __('Envoyer le message') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-public-layout>
