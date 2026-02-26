@extends('layouts.admin')

@section('header', isset($product) ? 'Modifier le produit' : 'Nouveau produit')

@section('content')
<div class="max-w-5xl mx-auto" x-data="cloudinaryUpload()">
    <form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}" method="POST">
        @csrf
        @if(isset($product)) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Main Info -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                    <h3 class="text-lg font-black text-gray-900 uppercase tracking-tighter mb-6">Informations générales (Allemand)</h3>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Titre du produit (DE)</label>
                            <input type="text" name="title_de" value="{{ old('title_de', $product->title_de ?? '') }}" required
                                class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-600 font-bold transition-all">
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Description (DE)</label>
                            <textarea name="description_de" rows="6" required
                                class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-600 font-medium transition-all">{{ old('description_de', $product->description_de ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                    <h3 class="text-lg font-black text-gray-900 uppercase tracking-tighter mb-6">Prix et Stock</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">SKU (Référence)</label>
                            <input type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}" required
                                class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-600 font-bold transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Marque</label>
                            <select name="brand_id" class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-600 font-bold transition-all">
                                <option value="">Aucune</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ (old('brand_id', $product->brand_id ?? '') == $brand->id) ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Prix HT</label>
                            <input type="number" step="0.01" name="price_ht" value="{{ old('price_ht', $product->price_ht ?? '') }}"
                                class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-600 font-bold transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Prix TTC</label>
                            <input type="number" step="0.01" name="price_ttc" value="{{ old('price_ttc', $product->price_ttc ?? '') }}"
                                class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-red-600 font-bold transition-all">
                        </div>
                    </div>
                </div>

                <!-- Images Section -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                    <h3 class="text-lg font-black text-gray-900 uppercase tracking-tighter mb-6">Image Principale</h3>
                    
                    <div class="flex flex-col items-center justify-center border-2 border-dashed border-gray-100 rounded-[2rem] p-8 transition-colors hover:border-red-100 group">
                        <template x-if="mainImageUrl">
                            <div class="relative w-full aspect-video rounded-2xl overflow-hidden border border-gray-100">
                                <img :src="mainImageUrl" class="w-full h-full object-contain">
                                <input type="hidden" name="main_image" :value="mainImageUrl">
                                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <button type="button" @click="mainImageUrl = ''" class="p-2 bg-red-600 text-white rounded-xl shadow-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                        @if(isset($product) && $product->media()->where('is_primary', true)->first())
                            <template x-if="!mainImageUrl">
                                <div class="relative w-full aspect-video rounded-2xl overflow-hidden border border-gray-100">
                                    <img src="{{ $product->media()->where('is_primary', true)->first()->path }}" class="w-full h-full object-contain">
                                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <label class="cursor-pointer p-2 bg-red-600 text-white rounded-xl shadow-lg">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            <input type="file" class="hidden" @change="uploadMainImage($event)">
                                        </label>
                                    </div>
                                </div>
                            </template>
                        @endif
                        <template x-if="!mainImageUrl && (!{{ isset($product) ? 'true' : 'false' }} || !{{ isset($product) && $product->media()->where('is_primary', true)->exists() ? 'true' : 'false' }})">
                            <label class="cursor-pointer text-center">
                                <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-red-50 transition-colors">
                                    <svg class="w-8 h-8 text-gray-300 group-hover:text-red-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <span class="text-xs font-black uppercase tracking-widest text-gray-400 group-hover:text-red-600 transition-colors">Définir l'image principale</span>
                                <input type="file" class="hidden" @change="uploadMainImage($event)">
                            </label>
                        </template>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-black text-gray-900 uppercase tracking-tighter">Galerie Images</h3>
                        <label class="cursor-pointer px-4 py-2 bg-gray-900 text-white text-[11px] font-black uppercase tracking-widest rounded-xl hover:bg-red-600 transition-colors">
                            + Ajouter des photos
                            <input type="file" multiple class="hidden" @change="uploadFiles($event)">
                        </label>
                    </div>

                    <!-- Progress Bar -->
                    <template x-if="uploading">
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[10px] font-black uppercase tracking-widest text-red-600">Téléchargement en cours...</span>
                                <span class="text-[10px] font-black text-red-600" x-text="progress + '%'"></span>
                            </div>
                            <div class="w-full h-1 bg-red-50 rounded-full overflow-hidden">
                                <div class="h-full bg-red-600 transition-all duration-300" :style="'width: ' + progress + '%'"></div>
                            </div>
                        </div>
                    </template>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="image-preview-container">
                        <!-- Existing Images (Gallery only) -->
                        @if(isset($product))
                            @foreach($product->media->where('is_primary', false) as $media)
                                <div class="relative group aspect-square rounded-2xl overflow-hidden border border-gray-100">
                                    <img src="{{ $media->path }}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <button type="button" @click="removeExistingMedia({{ $media->id }}, $event)" class="p-2 bg-red-600 text-white rounded-xl shadow-lg">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <!-- New Uploaded Images -->
                        <template x-for="(url, index) in uploadedUrls" :key="index">
                            <div class="relative group aspect-square rounded-2xl overflow-hidden border border-red-100">
                                <img :src="url" class="w-full h-full object-cover">
                                <input type="hidden" name="images[]" :value="url">
                                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <button type="button" @click="removeUploadedImage(index)" class="p-2 bg-red-600 text-white rounded-xl shadow-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar Options -->
            <div class="space-y-8">
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                    <h3 class="text-lg font-black text-gray-900 uppercase tracking-tighter mb-6">Publication</h3>
                    
                    <div class="space-y-6">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}
                                class="h-6 w-6 rounded-lg border-gray-200 text-red-600 focus:ring-red-500 transition-all">
                            <span class="text-sm font-bold text-gray-600 group-hover:text-gray-900 transition-colors">Produit actif</span>
                        </label>

                        <button type="submit" class="w-full py-4 bg-red-600 text-white font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-red-900/20 hover:bg-red-700 hover:scale-[1.02] active:scale-95 transition-all">
                            {{ isset($product) ? 'Enregistrer les modifications' : 'Créer le produit' }}
                        </button>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                    <h3 class="text-lg font-black text-gray-900 uppercase tracking-tighter mb-6">Catégories</h3>
                    
                    <div class="space-y-4 max-h-64 overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($categories as $category)
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                    {{ (isset($product) && $product->categories->contains($category->id)) || (is_array(old('categories')) && in_array($category->id, old('categories'))) ? 'checked' : '' }}
                                    class="h-5 w-5 rounded-lg border-gray-200 text-red-600 focus:ring-red-500 transition-all">
                                <span class="text-sm font-bold text-gray-600 group-hover:text-gray-900 transition-colors">{{ $category->name_fr ?? $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('categories')
                        <p class="mt-2 text-xs text-red-600 font-bold">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function cloudinaryUpload() {
    return {
        uploading: false,
        progress: 0,
        uploadedUrls: [],
        mainImageUrl: '',
        cloudName: '{{ env('CLOUDINARY_CLOUD_NAME') }}',
        unsignedPreset: '{{ env('CLOUDINARY_UPLOAD_PRESET') }}',

        async uploadMainImage(event) {
            const file = event.target.files[0];
            if (!file) return;

            this.uploading = true;
            this.progress = 0;

            const formData = new FormData();
            formData.append('file', file);
            formData.append('upload_preset', this.unsignedPreset);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', `https://api.cloudinary.com/v1_1/${this.cloudName}/upload`, true);

            xhr.upload.onprogress = (e) => {
                if (e.lengthComputable) {
                    this.progress = Math.round((e.loaded / e.total) * 100);
                }
            };

            xhr.onload = () => {
                this.uploading = false;
                if (xhr.status >= 200 && xhr.status < 300) {
                    const data = JSON.parse(xhr.responseText);
                    this.mainImageUrl = data.secure_url;
                } else {
                    alert('Erreur lors du téléchargement de l\'image');
                }
            };

            xhr.onerror = () => {
                this.uploading = false;
                alert('Erreur lors du téléchargement de l\'image');
            };

            xhr.send(formData);
        },

        async uploadFiles(event) {
            const files = event.target.files;
            if (files.length === 0) return;

            this.uploading = true;
            this.progress = 0;

            const uploadFile = (file) => {
                return new Promise((resolve, reject) => {
                    const xhr = new XMLHttpRequest();
                    const formData = new FormData();
                    formData.append('file', file);
                    formData.append('upload_preset', this.unsignedPreset);

                    xhr.open('POST', `https://api.cloudinary.com/v1_1/${this.cloudName}/upload`, true);

                    xhr.upload.onprogress = (e) => {
                        if (e.lengthComputable) {
                            const percentComplete = Math.round((e.loaded / e.total) * 100);
                            this.progress = percentComplete;
                        }
                    };

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

            for (let i = 0; i < files.length; i++) {
                try {
                    const data = await uploadFile(files[i]);
                    if (data.secure_url) {
                        this.uploadedUrls.push(data.secure_url);
                    }
                } catch (error) {
                    console.error('Upload error:', error);
                    alert('Erreur lors du téléchargement de l\'image');
                }
            }

            this.uploading = false;
            this.progress = 0;
        },

        removeUploadedImage(index) {
            this.uploadedUrls.splice(index, 1);
        },

        async removeExistingMedia(id, event) {
            if (!confirm('Supprimer définitivement cette image ?')) return;
            
            try {
                const response = await fetch(`{{ route('admin.media.remove', ['media' => ':id']) }}`.replace(':id', id), {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                if (response.ok) {
                    event.target.closest('.relative').remove();
                }
            } catch (error) {
                console.error('Delete error:', error);
            }
        }
    }
}
</script>

<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #e5e7eb;
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #d1d5db;
}
</style>
@endsection
