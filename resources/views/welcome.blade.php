@php
    $appName = config('app.name', 'Remorques Industrie');
    $brandTagline = __('messages.brand.tagline');
    $pageTitle = $appName.' – '.$brandTagline;
    $metaDescription = __('messages.meta.home.description');
@endphp

<x-public-layout :title="$pageTitle">
    <x-slot name="meta">
        <meta name="description" content="{{ $metaDescription }}">
        <meta name="application-name" content="{{ $appName }}">
        <meta property="og:title" content="{{ $pageTitle }}">
        <meta property="og:description" content="{{ $metaDescription }}">
        <meta property="og:locale" content="{{ app()->getLocale() }}">
        @if (! empty($company_info))
            <meta name="business:phone_number" content="{{ $company_info->telephone }}">
            <meta name="business:contact_email" content="{{ $company_info->email_contact }}">
            <meta name="business:address" content="{{ $company_info->adresse_siege }}">
        @endif
    </x-slot>

    <x-hero-slider />

    <x-home-best-sellers :products="$best_sellers" />

    <div class="py-12"></div>

    <x-home-deal-of-week :deal_product="$deal_product" />

    <x-home-catalog :grouped_products="$grouped_products" />

    <x-home-trust-badges />

    <x-home-reviews :reviews="$reviews" />
</x-public-layout>
