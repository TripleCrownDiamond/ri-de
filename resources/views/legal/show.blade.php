<x-public-layout>
    <div class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-3xl px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-4xl font-black text-gray-900 uppercase tracking-tighter sm:text-6xl">
                    {{ $legalPage->title }}
                </h1>
                <div class="mt-4 flex justify-center">
                    <div class="h-1.5 w-24 bg-blue-600 rounded-full"></div>
                </div>
            </div>

            <div class="prose prose-lg prose-red max-w-none text-gray-600 font-medium">
                {!! nl2br($legalPage->content) !!}
            </div>
            
            <div class="mt-20 pt-10 border-t border-gray-100 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-black uppercase tracking-widest text-gray-400 hover:text-blue-600 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    {{ __('Retour à l\'accueil') }}
                </a>
            </div>
        </div>
    </div>
</x-public-layout>
