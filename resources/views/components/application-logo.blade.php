@if($company_info?->logo_path)
    <img src="{{ $company_info->logo_path }}" alt="{{ $company_info->nom }}" {{ $attributes->merge(['class' => 'object-contain']) }}>
@elseif($company_info?->logo)
    <img src="{{ asset('storage/' . $company_info->logo) }}" alt="{{ $company_info->nom }}" {{ $attributes->merge(['class' => 'object-contain']) }}>
@else
    <img src="{{ asset('img/logo.png') }}" alt="Remorques Industrie" {{ $attributes->merge(['class' => 'object-contain']) }}>
@endif
