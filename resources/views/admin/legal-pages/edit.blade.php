@extends('layouts.admin')

@section('header', isset($legalPage) ? 'Modifier la page' : 'Nouvelle page légale')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
        <form action="{{ isset($legalPage) ? route('admin.legal-pages.update', ['locale' => app()->getLocale(), 'legal_page' => $legalPage]) : route('admin.legal-pages.store', ['locale' => app()->getLocale()]) }}" method="POST">
            @csrf
            @if(isset($legalPage)) @method('PUT') @endif

            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Titre de la page</label>
                    <input type="text" name="title" value="{{ old('title', $legalPage->title ?? '') }}" required
                        class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-600 font-bold transition-all">
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Contenu (HTML possible)</label>
                    <textarea name="content" rows="15" required
                        class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-600 font-medium transition-all">{{ old('content', $legalPage->content ?? '') }}</textarea>
                    
                    <div class="mt-4 p-6 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <h4 class="text-[10px] font-black uppercase tracking-widest text-gray-500 mb-4 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Codes dynamiques (Shortcodes)
                        </h4>
                        <p class="text-[11px] text-gray-500 mb-4 font-bold italic leading-relaxed">
                            Insérez ces codes dans votre texte pour qu'ils soient remplacés automatiquement par les infos saisies dans "Infos Site".
                        </p>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @php
                                $codes = [
                                    '[NOM_SITE]' => 'Nom entreprise',
                                    '[EMAIL_CONTACT]' => 'Email contact',
                                    '[TELEPHONE]' => 'Téléphone',
                                    '[ADRESSE_SIEGE]' => 'Adresse siège',
                                    '[SIREN]' => 'N° SIREN',
                                    '[SIRET]' => 'N° SIRET',
                                    '[NUMERO_TVA]' => 'N° TVA',
                                    '[FORME_JURIDIQUE]' => 'Forme juridique',
                                    '[CAPITAL_SOCIAL]' => 'Capital social',
                                    '[RCS_VILLE]' => 'Ville RCS',
                                    '[IBAN]' => 'IBAN',
                                    '[BIC]' => 'BIC',
                                    '[BANK_NAME]' => 'Nom Banque',
                                    '[BANK_ADDRESS]' => 'Adresse Banque',
                                    '[OPENING_HOURS]' => 'Horaires',
                                    '[DATE_CREATION]' => 'Date création',
                                    '[NAF_APE]' => 'Code NAF/APE',
                                    '[DIRIGEANTS]' => 'Dirigeants',
                                ];
                            @endphp
                            @foreach($codes as $code => $label)
                                <div class="flex flex-col p-2 bg-white rounded-xl border border-gray-100 shadow-sm">
                                    <code class="text-[10px] font-black text-blue-600 mb-1">{{ $code }}</code>
                                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-tighter">{{ $label }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $legalPage->is_active ?? true) ? 'checked' : '' }}
                        class="h-6 w-6 rounded-lg border-gray-200 text-blue-600 focus:ring-blue-500 transition-all">
                    <span class="text-sm font-bold text-gray-600">Page visible sur le site</span>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 bg-blue-600 text-white font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-red-900/20 hover:bg-blue-700 hover:scale-[1.02] active:scale-95 transition-all">
                        {{ isset($legalPage) ? 'Mettre à jour la page' : 'Créer la page' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
