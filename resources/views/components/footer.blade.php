<footer class="bg-gray-900" aria-labelledby="footer-heading">
    <h2 id="footer-heading" class="sr-only">{{ __('Footer') }}</h2>
    <div class="mx-auto max-w-7xl px-6 pb-8 pt-16 sm:pt-24 lg:px-8 lg:pt-32">
        <div class="xl:grid xl:grid-cols-3 xl:gap-8">
            <div class="space-y-8">
                <div class="flex items-center gap-2">
                    <x-application-logo class="h-12 w-auto" />
                </div>
                <p class="text-sm leading-6 text-gray-300">
                    {{ __('Votre partenaire de confiance pour remorques, motoculture et solutions de stockage.') }}
                </p>
                <div class="flex space-x-6">
                    @if($company_info?->facebook)
                    <a href="{{ $company_info->facebook }}" target="_blank" class="text-gray-400 hover:text-gray-300">
                        <span class="sr-only">{{ __('Facebook') }}</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                    </a>
                    @endif
                    @if($company_info?->instagram)
                    <a href="{{ $company_info->instagram }}" target="_blank" class="text-gray-400 hover:text-gray-300">
                        <span class="sr-only">{{ __('Instagram') }}</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 5.838a6.162 6.162 0 10.001 12.324A6.162 6.162 0 0012 5.838zM12 16.3a4.3 4.3 0 110-8.598 4.3 4.3 0 010 8.598zm7.046-10.33a1.44 1.44 0 11-2.88 0 1.44 1.44 0 012.88 0z" clip-rule="evenodd" /></svg>
                    </a>
                    @endif
                </div>
            </div>
            <div class="mt-16 grid grid-cols-2 gap-8 xl:col-span-2 xl:mt-0">
                <div class="md:grid md:grid-cols-2 md:gap-8">
                    <div>
                        <h3 class="text-sm font-semibold leading-6 text-white">{{ __('Boutique') }}</h3>
                        <ul role="list" class="mt-6 space-y-4">
                            <li>
                                <a href="{{ route('shop.index') }}" class="text-sm leading-6 text-gray-300 hover:text-white">{{ __('Tous les produits') }}</a>
                            </li>
                            @foreach($nav_categories as $category)
                            <li>
                                <a href="{{ route('categories.show', $category->slug) }}" class="text-sm leading-6 text-gray-300 hover:text-white">{{ __($category->name) }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="mt-10 md:mt-0">
                        <h3 class="text-sm font-semibold leading-6 text-white">{{ __('Support') }}</h3>
                        <ul role="list" class="mt-6 space-y-4">
                            <li>
                                <a href="{{ route('contact.index') }}" class="text-sm leading-6 text-gray-300 hover:text-white">{{ __('Contact') }}</a>
                            </li>
                            @auth
                                <li>
                                    <a href="{{ route('profile.edit') }}" class="text-sm leading-6 text-gray-300 hover:text-white">{{ __('Mon compte') }}</a>
                                </li>
                                <li>
                                    <a href="{{ route('orders.user') }}" class="text-sm leading-6 text-gray-300 hover:text-white">{{ __('Mes commandes') }}</a>
                                </li>
                            @else
                                <li>
                                    <a href="{{ route('login') }}" class="text-sm leading-6 text-gray-300 hover:text-white">{{ __('Connexion') }}</a>
                                </li>
                            @endauth
                            @foreach($active_legal_pages as $page)
                            <li>
                                <a href="{{ route('legal.show', $page->slug) }}" class="text-sm leading-6 text-gray-300 hover:text-white">{{ __($page->title) }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="md:grid md:grid-cols-2 md:gap-8">
                    <div>
                        <h3 class="text-sm font-semibold leading-6 text-white">{{ __('Contact') }}</h3>
                        <ul role="list" class="mt-6 space-y-4">
                            <li class="flex gap-x-3">
                                <svg class="h-6 w-5 flex-none text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                                <span class="text-sm leading-6 text-gray-300">
                                    <span class="block text-white">{{ __('Adresse :') }}</span>
                                    {{ __($company_info?->adresse_siege) }}
                                </span>
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="h-6 w-5 flex-none text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                </svg>
                                <span class="text-sm leading-6 text-gray-300">
                                    <span class="block text-white">{{ __('Téléphone :') }}</span>
                                    {{ $company_info?->telephone }}
                                </span>
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="h-6 w-5 flex-none text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                                <span class="text-sm leading-6 text-gray-300">
                                    <span class="block text-white">{{ __('Email :') }}</span>
                                    {{ __($company_info?->email_contact) }}
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-10 md:mt-0">
                        <h3 class="text-sm font-semibold leading-6 text-white">{{ __('Horaires d\'ouverture') }}</h3>
                        <div class="mt-6 space-y-4">
                            <div class="flex gap-x-3">
                                <svg class="h-6 w-5 flex-none text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="text-sm leading-6 text-gray-300">
                                    <div class="space-y-1 text-xs whitespace-pre-line">
                                        {{ __($company_info?->opening_hours) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-10">
                            <h3 class="text-sm font-semibold leading-6 text-white">{{ __('Paiement') }}</h3>
                            <div class="mt-6 flex flex-col gap-4">
                                <div class="flex flex-wrap gap-2">
                                    <!-- Visa -->
                                    <div class="bg-white p-1 rounded h-8 w-12 flex items-center justify-center">
                                        <svg viewBox="0 0 48 48" class="h-full w-auto" xmlns="http://www.w3.org/2000/svg"><path fill="#1a1f71" d="M22.688 28.528l2.25-13.888h-3.612l-2.25 13.888zm15.656-13.59c-1.396-.548-3.568-.82-5.748-.82-6.336 0-10.796 3.372-10.824 8.196-.036 3.564 3.18 5.548 5.604 6.728 2.492 1.216 3.332 2.004 3.332 3.092-.012 1.672-2.008 2.44-3.868 2.44-2.584 0-3.956-.396-6.072-1.332l-.852 3.988c1.416.656 4.032 1.228 6.752 1.24 6.364 0 10.512-3.136 10.552-8.004.02-2.668-1.588-4.708-5.068-6.368-2.108-1.064-3.404-1.788-3.404-2.88.004-.992 1.108-1.684 3.508-1.684 1.984-.032 3.424.424 4.536.92l.808-3.776c-.392-.164-1.556-.472-3.12-.66M48 14.64H41.16c-2.172 0-3.8 1.12-4.544 2.896l-12.8 30.292h5.128l2.544-7.04h6.228l.588 2.684h4.524l-6.72-15.688 6.892 15.688zm-8.816 10.6l2.968 8.12h-4.04l1.072-8.12M13.56 28.312l-1.34-6.832c-.228-.916-.928-1.28-2.14-1.344H.048L0 20.66c3.056.66 6.544 2.308 8.68 4.792l6.236 22.372h5.276L13.56 28.312z"/></svg>
                                    </div>
                                    <!-- Mastercard -->
                                    <div class="bg-white p-1 rounded h-8 w-12 flex items-center justify-center">
                                        <svg viewBox="0 0 24 24" class="h-full w-auto" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><path fill="#FF5F00" d="M15.228 12a8.004 8.004 0 01-3.228 6.435A8.004 8.004 0 018.772 12c0-2.553 1.194-4.832 3.228-6.435A8.004 8.004 0 0115.228 12"/><path fill="#EB001B" d="M8.772 12a8.004 8.004 0 01-5.544 7.749A8.004 8.004 0 118.772 4.251 8.004 8.004 0 018.772 12"/><path fill="#F79E1B" d="M15.228 12a8.004 8.004 0 01-5.544 7.749A8.004 8.004 0 1115.228 4.251 8.004 8.004 0 0115.228 12"/></g></svg>
                                    </div>
                                    <!-- Amex -->
                                    <div class="bg-white p-1 rounded h-8 w-12 flex items-center justify-center">
                                        <svg viewBox="0 0 1024 1024" class="h-full w-auto" xmlns="http://www.w3.org/2000/svg"><path fill="#006fcf" d="M110.16 110.16h803.68v803.68H110.16z"/><path fill="#fff" d="M690.64 365.2h-58.4l-32.8 79.2-28.8-79.2H476l-17.6 113.6h-54.4l13.6-113.6h-66.4l-38.4 113.6h-48l-15.2-46.4-19.2 46.4H172l55.2-132.8h-74.4v171.2h217.6l23.2-68.8h37.6l7.2 68.8h60l17.6-121.6 36 121.6h58.4l35.2-96 36 96h55.2l39.2-171.2h-68.8M262.8 384.4l-36.8 90.4-36-90.4h72.8m233.6 132.8l-13.6-104-14.4 104h28M770.16 430h-35.2v-26.4h35.2v-38.4h-82.4v171.2h82.4v-40h-35.2v-28h35.2M714.16 572.8l36-58.4 39.2 58.4h55.2l-64.8-93.6 57.6-77.6h-53.6l-34.4 56.8-31.2-56.8h-53.6l54.4 78.4-60.8 92.8M287.6 658.8h179.2v-47.2H334.8v-61.6h117.6v-47.2H334.8v-51.2h125.6v-47.2H287.6m360.8 190.8L590 736l58.4-113.6H596l-28.8 69.6-32.8-69.6h-55.2l60.8 127.2-22.4 46.4h-56l31.2 53.6h52.8m223.2-164.8h-35.2v-26.4h35.2V620h-82.4v171.2h82.4v-40h-35.2v-28h35.2"/></svg>
                                    </div>
                                    <!-- Apple Pay -->
                                    <div class="bg-white p-1 rounded h-8 w-12 flex items-center justify-center">
                                        <svg viewBox="0 0 38 24" class="h-full w-auto" xmlns="http://www.w3.org/2000/svg"><path d="M15.4 11.8c0-1.8 1.5-3.4 3.4-3.4.1 0 .2 0 .3.1-.8-1.2-2-2-3.3-2-1.4 0-2.7 1-3.2 1-.5 0-1.6-1-2.9-1-1.5 0-2.9.9-3.7 2.3 0 .1 0 .1-.1.2-1.6 2.8-.4 7 2.7 11.5 1.5 2.2 3.3 4.6 5.6 4.6s3.1-1.5 5.8-1.5c2.6 0 3.3 1.5 5.6 1.5 2.3 0 3.8-2.1 5.2-4.2.5-.7 1-1.5 1.5-2.2-.1 0-.1-.1-.2-.1-3-1.4-4.9-4.3-4.9-7.7 0-.3 0-.6.1-.9l-.3.1c-.2.1-.5.1-.7.1-1.6 0-3.3-1.1-4.2-2.7-.8-1.5-.5-3.2-.5-3.5 1.7.1 3.4 1.2 4.1 2.8.6 1.3.4 2.8.2 3.6 0 0-.1.1-.1.2-1.6 0-3.1 1.2-3.1 3.4 0 1.9 1.5 3.5 3.4 3.5.2 0 .4 0 .6-.1-.9 1.2-2.1 1.9-3.4 1.9z" fill="#000"/><path d="M22.5 12.3c0-.3 0-.6.1-.9-.1 0-.1.1-.2.1-3 1.4-4.9 4.3-4.9 7.7 0 1.8 1.5 3.4 3.4 3.4.1 0 .2 0 .3.1-.8 1.2-2 2-3.3 2-1.4 0-2.7-1-3.2-1-.5 0-1.6 1-2.9 1-1.5 0-2.9-.9-3.7-2.3 0-.1 0-.1-.1-.2-1.6-2.8-.4-7 2.7-11.5 1.5-2.2 3.3-4.6 5.6-4.6s3.1 1.5 5.8 1.5c2.6 0 3.3-1.5 5.6-1.5 2.3 0 3.8 2.1 5.2 4.2.5.7 1 1.5 1.5 2.2-.1 0-.1.1-.2.1-3-1.4-4.9-4.3-4.9-7.7z" fill="white"/></svg>
                                    </div>
                                    <!-- GPay -->
                                    <div class="bg-white p-1 rounded h-8 w-12 flex items-center justify-center">
                                        <svg viewBox="0 0 42 22" class="h-full w-auto" xmlns="http://www.w3.org/2000/svg"><path fill="#4285F4" d="M6.3 9.4v6.8H4.1V9.4H1.8V7.3h6.6v2.1zM10.8 16.4c-1 0-1.8-.3-2.5-1-.7-.7-1-1.5-1-2.5s.4-1.9 1-2.5c.7-.7 1.6-1 2.5-1 1 0 1.8.3 2.5 1 .7.7 1 1.5 1 2.5s-.4 1.9-1 2.5c-.7.7-1.5 1-2.5 1zm0-1.9c.5 0 1-.2 1.3-.6.3-.4.5-.9.5-1.5s-.2-1.1-.5-1.5c-.3-.4-.8-.6-1.3-.6s-1 .2-1.3.6c-.3.4-.5.9-.5 1.5s.2 1.1.5 1.5c.3.4.8.6 1.3.6zM18.7 16.4c-1 0-1.8-.3-2.5-1-.7-.7-1-1.5-1-2.5s.4-1.9 1-2.5c.7-.7 1.6-1 2.5-1 1 0 1.8.3 2.5 1 .7.7 1 1.5 1 2.5s-.4 1.9-1 2.5c-.7.7-1.5 1-2.5 1zm0-1.9c.5 0 1-.2 1.3-.6.3-.4.5-.9.5-1.5s-.2-1.1-.5-1.5c-.3-.4-.8-.6-1.3-.6s-1 .2-1.3.6c-.3.4-.5.9-.5 1.5s.2 1.1.5 1.5c.3.4.8.6 1.3.6zM26.2 16.4c-.6 0-1.2-.2-1.7-.5-.4-.4-.7-.9-.8-1.5h1.9c.1.3.3.5.5.7.2.2.5.3.8.3.3 0 .6-.1.8-.3.2-.2.3-.5.3-.8v-.2c-.3.4-.7.6-1.3.6-.6 0-1.2-.2-1.6-.6-.5-.5-.7-1.1-.7-1.9 0-.8.2-1.5.7-2 .5-.5 1.1-.7 1.7-.7.5 0 .9.1 1.2.4V9.4h1.9v4.5c0 1-.3 1.8-.8 2.2-.5.5-1.3.7-2.1.7zm.3-3.6c.5 0 .9-.2 1.2-.5.3-.4.5-.8.5-1.4 0-.5-.2-1-.5-1.4-.3-.3-.7-.5-1.2-.5-.5 0-.9.2-1.2.5-.3.4-.5.8-.5 1.4 0 .5.2 1 .5 1.4.3.3.7.5 1.2.5zM29.8 7.3h2v9h-2zM36.9 16.4c-.9 0-1.7-.3-2.3-.8-.6-.6-.9-1.3-.9-2.2 0-1 .3-1.7 1-2.3.6-.6 1.4-.8 2.3-.8.9 0 1.6.3 2.2.8.6.6.9 1.4.9 2.3v.3h-4.2c.1.5.3.9.6 1.2.3.3.7.5 1.2.5.5 0 .9-.1 1.2-.4.3-.2.5-.6.6-1l1.7.4c-.3.8-.7 1.4-1.4 1.8-.8.5-1.7.7-2.7.7zm-.1-4.4c-.4 0-.8.1-1.1.4-.3.3-.5.7-.5 1.1h3.2c0-.4-.1-.8-.4-1.1-.3-.3-.7-.4-1.2-.4z"/><path fill="#34A853" d="M37.8 2.2c1.3 0 2.4.4 3.3 1.3l-1.6 1.6c-.4-.4-1-.7-1.7-.7-1.4 0-2.5 1.1-2.5 2.5s1.1 2.5 2.5 2.5c1.2 0 2.1-.7 2.3-1.7h-2.3V5.4h4.6v.6c0 2.5-1.7 4.7-4.6 4.7-2.7 0-4.9-2.2-4.9-4.9C32.9 3.1 35.1.9 37.8.9v1.3z"/></svg>
                                    </div>
                                    <!-- Klarna -->
                                    <div class="bg-white p-1 rounded h-8 w-12 flex items-center justify-center">
                                        <svg viewBox="0 0 35 10" class="h-full w-auto" xmlns="http://www.w3.org/2000/svg"><path fill="#FFB3C7" d="M5.9 9.1c0-.4-.3-.8-.8-.8h-1.3v1.6H5c.5 0 .9-.4.9-.8zM8.3.9H5.5L3.8 5.4v-4.5H1.4v9h2.4v-2.8h1.1l1.9 2.8h2.8l-2.6-3.7c1-.3 1.6-1.1 1.6-2.2 0-1.8-1.4-3.1-3.3-3.1zM11.9.9H9.5v9h2.4zM19.1 5.3c0-1.4-1.1-2.5-2.5-2.5-1.4 0-2.5 1.1-2.5 2.5s1.1 2.5 2.5 2.5c1.4 0 2.5-1.1 2.5-2.5zM16.6 9.9c-2.5 0-4.5-2.1-4.5-4.6S14.1.7 16.6.7s4.6 2.1 4.6 4.6-2.1 4.6-4.6 4.6zM24.7 3.3c-.6 0-1.1.3-1.4.7V3.4h-2.2v6.5h2.4V6c0-.8.6-1.5 1.4-1.5h.3V3.3h-.5zM29.6 3.3v1.1c-.3-.6-.9-1.1-1.6-1.1-1.6 0-2.8 1.3-2.8 2.9v.1c0 1.6 1.2 2.9 2.8 2.9.7 0 1.3-.4 1.6-1.1v1h2.2V3.3h-2.2zm0 4.6c-.3.5-.8.8-1.4.8-.9 0-1.6-.7-1.6-1.6v-.1c0-.9.7-1.6 1.6-1.6.6 0 1.1.3 1.4.8v1.7zM32.8 9c.7 0 1.3-.6 1.3-1.3 0-.7-.6-1.3-1.3-1.3-.7 0-1.3.6-1.3 1.3 0 .7.6 1.3 1.3 1.3z"/></svg>
                                    </div>
                                    <!-- Shop Pay -->
                                    <div class="bg-white p-1 rounded h-8 w-12 flex items-center justify-center">
                                        <svg viewBox="0 0 120 40" class="h-full w-auto" xmlns="http://www.w3.org/2000/svg"><path fill="#5A31F4" d="M107.5 40h-7.6l-2-6.2h-11l-2 6.2H77.1l11.4-33.8h8L107.5 40zm-14.2-12.7L90 16.1l-3.3 11.2h6.6zM42.2 27.6c-2.9 2.1-6.7 3.2-11.4 3.2-4.5 0-8.1-.9-10.7-2.6-2.7-1.8-4-4.2-4-7.4h7.6c.1 1.4.6 2.4 1.5 3.1.9.7 2.3 1.1 4.1 1.1 1.9 0 3.3-.3 4.1-1 .8-.6 1.2-1.4 1.2-2.3 0-1.9-2-3.2-6-4-5.3-1-8.6-2-10.1-3-1.5-1-2.2-2.5-2.2-4.6 0-2.6 1.1-4.7 3.2-6.1 2.2-1.4 5.3-2.1 9.3-2.1 4 0 7.3.7 9.8 2 2.5 1.3 3.8 3.4 4 6.3h-7.4c-.1-1.3-.6-2.2-1.4-2.8-.8-.6-2.1-.8-3.9-.8-1.6 0-2.8.3-3.6.8-.7.5-1.1 1.2-1.1 2 0 1.5 1.8 2.6 5.5 3.4 5.4 1.1 8.8 2.2 10.3 3.3 1.5 1.1 2.2 2.7 2.2 4.9 0 2.7-1.1 4.9-3.4 6.6z"/><path fill="#5A31F4" d="M62.6 20.3v19.7h-7.6V6.2h7.6v11.9c1.6-2.5 4.3-3.8 8.1-3.8 3 0 5.4.9 7.1 2.6 1.7 1.8 2.6 4.1 2.6 7.1v15.9h-7.6V24.5c0-1.5-.4-2.6-1.1-3.4-.7-.8-1.8-1.2-3.1-1.2-1.8 0-3.3.6-4.5 1.9-1.2 1.3-1.5 3-1.5 5.1z"/></svg>
                                    </div>
                                    <!-- Union Pay -->
                                    <div class="bg-white p-1 rounded h-8 w-12 flex items-center justify-center">
                                        <svg viewBox="0 0 153 96" class="h-full w-auto" xmlns="http://www.w3.org/2000/svg"><path fill="#006497" d="M115.8 45.9c-2.4-5.6-5.1-10.9-8.4-16.1l-14.5 40.5h15.2l7.7-24.4z"/><path fill="#E60012" d="M137.6 29.8h-14.7l-9.8 28.3c4.6 4.5 8.3 9.4 11.2 14.7l13.3-43z"/><path fill="#007F3E" d="M84.1 29.8H69.4l9.8 28.3c-4.6 4.5-8.3 9.4-11.2 14.7l-13.3-43H40l20.2 59.9c2.5 5.7 5.3 11.1 8.6 16.3l15.3-76.2z"/><path fill="#000" d="M153 29.8h-14.7l-20.2 59.9c-2.5 5.7-5.3 11.1-8.6 16.3l37.2-24.7 6.3-51.5z"/><path fill="#006497" d="M22.9 66.4L10.6 29.8H0l18.4 55c4.1-1.8 8.1-3.9 11.9-6.3l-7.4-12.1z"/><path fill="#E60012" d="M48.8 66.4l12.2-36.6H54.9l-18.4 55c-4.1-1.8-8.1-3.9-11.9-6.3l14.2-12.1z"/></svg>
                                    </div>
                                </div>

                                <div class="flex min-h-[3rem] w-full items-center gap-3 rounded-2xl bg-white/5 p-3 border border-white/10 transition-all hover:bg-white/10 group">
                                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-blue-600 text-white shadow-lg shadow-blue-900/20 group-hover:scale-110 transition-transform">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                        </svg>
                                    </div>
                                    <span class="text-[9px] font-bold uppercase tracking-tighter text-gray-300 group-hover:text-white transition-colors leading-tight">{{ __('Virement Bancaire') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-16 border-t border-white/10 pt-8 sm:mt-20 lg:mt-24">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-xs leading-5 text-gray-400">&copy; {{ date('Y') }}. {{ __('Tous droits réservés.') }}</p>
                <div class="text-xs leading-5 text-gray-500 flex flex-col md:flex-row gap-4 text-center md:text-right">
                    <span>SIREN : {{ $company_info->siren ?? '983 234 321' }}</span>
                    <span>SIRET : {{ $company_info->siret ?? '983 234 321 00012' }}</span>
                    <span>TVA : {{ $company_info->tva ?? 'FR 12 983234321' }}</span>
                </div>
            </div>
        </div>
    </div>
</footer>