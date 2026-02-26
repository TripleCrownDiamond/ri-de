@extends('layouts.admin')

@section('header', 'Informations du site')

@section('content')
<div class="max-w-4xl" x-data="cloudinaryUpload()">
    <div class="mb-8 p-6 bg-blue-50 rounded-[2rem] border border-blue-100 flex items-start gap-4">
        <div class="p-3 bg-blue-600 rounded-2xl shadow-lg shadow-blue-900/20 text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <h4 class="text-sm font-black text-blue-900 uppercase tracking-tighter mb-1">Astuce : Contenu Dynamique</h4>
            <p class="text-xs text-blue-800/80 font-medium leading-relaxed">
                Les informations saisies ici peuvent être insérées automatiquement dans vos <strong>pages légales</strong> en utilisant des codes comme <code class="bg-blue-100 px-1 rounded text-blue-900">[NOM_SITE]</code> ou <code class="bg-blue-100 px-1 rounded text-blue-900">[EMAIL_CONTACT]</code>.
            </p>
        </div>
    </div>

    <form action="{{ route('admin.settings.update', ['locale' => app()->getLocale()]) }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 space-y-6">
                <h3 class="text-lg font-black text-gray-900 uppercase tracking-tighter mb-6">Coordonnées</h3>
                
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Logo du site</label>
                    <div class="flex items-center gap-6 mt-2">
                        <div class="relative w-24 h-24 rounded-2xl bg-gray-50 border border-gray-100 overflow-hidden flex items-center justify-center">
                            <template x-if="logoUrl">
                                <img :src="logoUrl" class="w-full h-full object-contain p-2">
                            </template>
                            <template x-if="!logoUrl">
                                <svg class="w-8 h-8 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </template>
                            <div x-show="uploading" class="absolute inset-0 bg-white/80 flex items-center justify-center">
                                <div class="w-8 h-8 border-4 border-red-600 border-t-transparent rounded-full animate-spin"></div>
                            </div>
                        </div>
                        <label class="cursor-pointer inline-flex items-center px-4 py-2 bg-gray-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-red-600 transition-colors">
                            Changer le logo
                            <input type="file" class="hidden" @change="uploadLogo($event)">
                        </label>
                    </div>
                    <input type="hidden" name="logo_path" :value="logoUrl">
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Nom de l'entreprise</label>
                    <input type="text" name="nom" value="{{ old('nom', $settings->nom ?? '') }}" required
                        class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-600 font-bold transition-all">
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Email de contact</label>
                    <input type="email" name="email_contact" value="{{ old('email_contact', $settings->email_contact ?? '') }}" required
                        class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-600 font-bold transition-all">
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Téléphone</label>
                    <input type="text" name="telephone" value="{{ old('telephone', $settings->telephone ?? '') }}"
                        class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-600 font-bold transition-all">
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Adresse</label>
                    <textarea name="adresse_siege" rows="3"
                        class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-600 font-medium transition-all">{{ old('adresse_siege', $settings->adresse_siege ?? '') }}</textarea>
                </div>
            </div>

            <div class="space-y-8">
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 space-y-6">
                    <h3 class="text-lg font-black text-gray-900 uppercase tracking-tighter mb-6">Informations Légales</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">SIREN</label>
                            <input type="text" name="siren" value="{{ old('siren', $settings->siren ?? '') }}"
                                class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-600 font-bold transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">SIRET</label>
                            <input type="text" name="siret" value="{{ old('siret', $settings->siret ?? '') }}"
                                class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-600 font-bold transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Numéro TVA</label>
                        <input type="text" name="numero_tva" value="{{ old('numero_tva', $settings->numero_tva ?? '') }}"
                            class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-600 font-bold transition-all">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Forme Juridique</label>
                            <input type="text" name="forme_juridique" value="{{ old('forme_juridique', $settings->forme_juridique ?? '') }}"
                                class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-600 font-bold transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Capital Social (€)</label>
                            <input type="number" step="0.01" name="capital_social" value="{{ old('capital_social', $settings->capital_social ?? '') }}"
                                class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-600 font-bold transition-all">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">RCS Ville</label>
                            <input type="text" name="rcs_ville" value="{{ old('rcs_ville', $settings->rcs_ville ?? '') }}"
                                class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-600 font-bold transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Code NAF / APE</label>
                            <input type="text" name="activite_naf_ape" value="{{ old('activite_naf_ape', $settings->activite_naf_ape ?? '') }}"
                                class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-600 font-bold transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Date de création</label>
                        <input type="date" name="date_creation" value="{{ old('date_creation', $settings->date_creation ? $settings->date_creation->format('Y-m-d') : '') }}"
                            class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-600 font-bold transition-all">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Dirigeants (séparés par des virgules)</label>
                        <!-- Version 5.0 - Ultimate Fix -->
                        @php
                            $rawVal = old('dirigeants', $settings->dirigeants);
                            $out = '';
                            if (is_array($rawVal)) {
                                $out = implode(', ', array_map(function($i) {
                                    return is_scalar($i) ? (string)$i : json_encode($i);
                                }, $rawVal));
                            } else {
                                $out = is_scalar($rawVal) ? (string)$rawVal : json_encode($rawVal);
                            }
                        @endphp
                        <input type="text" name="dirigeants" value="{{ $out }}"
                            class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-600 font-bold transition-all"
                            placeholder="Ex: Jean Dupont, Marie Martin">
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 space-y-6">
                    <h3 class="text-lg font-black text-gray-900 uppercase tracking-tighter mb-6">Réseaux Sociaux</h3>
                    
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Facebook (URL)</label>
                        <input type="url" name="facebook" value="{{ old('facebook', $settings->facebook ?? '') }}"
                            class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-600 font-bold transition-all">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Instagram (URL)</label>
                        <input type="url" name="instagram" value="{{ old('instagram', $settings->instagram ?? '') }}"
                            class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-600 font-bold transition-all">
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 space-y-6">
                    <h3 class="text-lg font-black text-gray-900 uppercase tracking-tighter mb-6">Horaires d'ouverture</h3>
                    
                    <div>
                        <textarea name="opening_hours" rows="4" placeholder="Ex: Lun-Ven: 9h-18h"
                            class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-600 font-medium transition-all">{{ old('opening_hours', $settings->opening_hours ?? '') }}</textarea>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 space-y-6">
                    <h3 class="text-lg font-black text-gray-900 uppercase tracking-tighter mb-6">Informations Bancaires (RIB)</h3>
                    
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">IBAN</label>
                        <input type="text" name="iban" value="{{ old('iban', $settings->iban ?? '') }}"
                            class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-600 font-bold transition-all">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">BIC / SWIFT</label>
                            <input type="text" name="bic" value="{{ old('bic', $settings->bic ?? '') }}"
                                class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-600 font-bold transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Nom de la banque</label>
                            <input type="text" name="bank_name" value="{{ old('bank_name', $settings->bank_name ?? '') }}"
                                class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-600 font-bold transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Adresse de la banque</label>
                        <textarea name="bank_address" rows="2"
                            class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-600 font-medium transition-all">{{ old('bank_address', $settings->bank_address ?? '') }}</textarea>
                    </div>

                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-2xl">
                        <input type="checkbox" name="show_rib_on_order" id="show_rib_on_order" value="1" {{ old('show_rib_on_order', $settings->show_rib_on_order) ? 'checked' : '' }}
                            class="w-6 h-6 text-red-600 border-none rounded-lg focus:ring-red-600 focus:ring-offset-0">
                        <label for="show_rib_on_order" class="text-xs font-bold text-gray-700">Afficher le RIB sur les confirmations de commande (hors devis)</label>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Instructions de paiement (DE)</label>
                            <textarea name="payment_instructions_de" rows="4" placeholder="Instructions en allemand..."
                                class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-600 font-medium transition-all">{{ old('payment_instructions_de', $settings->payment_instructions_de ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Instructions de paiement (FR)</label>
                            <textarea name="payment_instructions_fr" rows="4" placeholder="Instructions en français..."
                                class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-600 font-medium transition-all">{{ old('payment_instructions_fr', $settings->payment_instructions_fr ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full py-4 bg-red-600 text-white font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-red-900/20 hover:bg-red-700 hover:scale-[1.02] active:scale-95 transition-all">
                    Enregistrer les informations
                </button>
            </div>
        </div>
    </form>
</div>

<script>
function cloudinaryUpload() {
    return {
        uploading: false,
        logoUrl: '{{ old('logo_path', $settings->logo_path ?? '') }}',
        cloudName: '{{ env('CLOUDINARY_CLOUD_NAME') }}',
        unsignedPreset: '{{ env('CLOUDINARY_UPLOAD_PRESET') }}',

        async uploadLogo(event) {
            const file = event.target.files[0];
            if (!file) return;

            this.uploading = true;
            
            const uploadFile = (file) => {
                return new Promise((resolve, reject) => {
                    const xhr = new XMLHttpRequest();
                    const formData = new FormData();
                    formData.append('file', file);
                    formData.append('upload_preset', this.unsignedPreset);

                    xhr.open('POST', `https://api.cloudinary.com/v1_1/${this.cloudName}/upload`, true);

                    xhr.onload = () => {
                        if (xhr.status >= 200 && xhr.status < 300) {
                            const data = JSON.parse(xhr.responseText);
                            resolve(data);
                        } else {
                            reject(new Error('Upload failed'));
                        }
                    };

                    xhr.onerror = () => reject(new Error('Upload error'));
                    xhr.send(formData);
                });
            };

            try {
                const data = await uploadFile(file);
                if (data.secure_url) {
                    this.logoUrl = data.secure_url;
                }
            } catch (error) {
                console.error('Upload error:', error);
                alert('Erreur lors du téléchargement du logo');
            }

            this.uploading = false;
        }
    }
}
</script>
@endsection
