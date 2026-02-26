@extends('layouts.admin')

@section('header', isset($brand) ? 'Modifier la marque' : 'Nouvelle marque')

@section('content')
<div class="max-w-2xl" x-data="cloudinaryUpload()">
    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
        <form action="{{ isset($brand) ? route('admin.brands.update', ['locale' => app()->getLocale(), 'brand' => $brand]) : route('admin.brands.store', ['locale' => app()->getLocale()]) }}" method="POST">
            @csrf
            @if(isset($brand)) @method('PUT') @endif

            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Nom de la marque</label>
                    <input type="text" name="name" value="{{ old('name', $brand->name ?? '') }}" required
                        class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-600 font-bold transition-all">
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Logo de la marque</label>
                    
                    <div class="flex items-center gap-6 mt-2">
                        <div class="relative w-32 h-32 rounded-2xl bg-gray-50 border border-gray-100 overflow-hidden flex items-center justify-center">
                            <template x-if="logoUrl">
                                <img :src="logoUrl" class="w-full h-full object-contain">
                            </template>
                            <template x-if="!logoUrl">
                                <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </template>
                            
                            <div x-show="uploading" class="absolute inset-0 bg-white/80 flex items-center justify-center">
                                <div class="w-12 h-12 border-4 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                            </div>
                        </div>

                        <div class="flex-1">
                            <label class="cursor-pointer inline-flex items-center px-6 py-3 bg-gray-900 text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-blue-600 transition-colors">
                                Choisir un logo
                                <input type="file" class="hidden" @change="uploadLogo($event)">
                            </label>
                            <p class="mt-2 text-[10px] text-gray-400 font-bold uppercase tracking-widest">PNG, JPG ou SVG (Max. 2MB)</p>
                        </div>
                    </div>

                    <input type="hidden" name="logo_path" :value="logoUrl">
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 bg-blue-600 text-white font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-red-900/20 hover:bg-blue-700 hover:scale-[1.02] active:scale-95 transition-all">
                        {{ isset($brand) ? 'Mettre à jour' : 'Créer la marque' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function cloudinaryUpload() {
    return {
        uploading: false,
        logoUrl: '{{ old('logo_path', $brand->logo_path ?? '') }}',
        cloudName: '{{ env('CLOUDINARY_CLOUD_NAME') }}',
        unsignedPreset: '{{ env('CLOUDINARY_UPLOAD_PRESET') }}',

        async uploadLogo(event) {
            const file = event.target.files[0];
            if (!file) return;

            this.uploading = true;
            const formData = new FormData();
            formData.append('file', file);
            formData.append('upload_preset', this.unsignedPreset);

            try {
                const response = await fetch(`https://api.cloudinary.com/v1_1/${this.cloudName}/upload`, {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
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
