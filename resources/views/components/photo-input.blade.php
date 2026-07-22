@props([
    'name'        => 'foto',
    'accentColor' => 'brand',   // brand | amber
    'currentSrc'  => null,      // URL foto yang sudah ada (halaman edit)
    'label'       => 'Foto 📸',
])

@php
    $btnCam  = $accentColor === 'amber' ? 'bg-amber-600 hover:bg-amber-700' : 'bg-brand-600 hover:bg-brand-700';
    $initSrc = $currentSrc ? "'" . addslashes($currentSrc) . "'" : 'null';
@endphp

<div
    x-data="{
        preview: {{ $initSrc }},
        hasNew:  false,

        /* Galeri → input biasa (tanpa capture) */
        triggerGallery() {
            this.$refs.galleryInput.click();
        },

        /* Kamera → input khusus dengan capture=environment (statis, tidak pernah berubah) */
        triggerCamera() {
            this.$refs.cameraInput.click();
        },

        /* Dipanggil saat salah satu input berubah */
        onFileChange(event) {
            const file = event.target.files[0];
            if (!file) return;

            /* Transfer file ke master input (name=foto) via DataTransfer */
            try {
                const dt = new DataTransfer();
                dt.items.add(file);
                this.$refs.masterInput.files = dt.files;
            } catch (e) {
                /* Fallback: tidak bisa transfer (browser lama) */
                console.warn('DataTransfer not supported:', e);
            }

            this.hasNew = true;
            const reader = new FileReader();
            reader.onload = e => { this.preview = e.target.result; };
            reader.readAsDataURL(file);
        },

        clearFile() {
            this.preview  = {{ $initSrc }};
            this.hasNew   = false;
            this.$refs.galleryInput.value  = '';
            this.$refs.cameraInput.value   = '';
            this.$refs.masterInput.value   = '';
        }
    }"
    class="space-y-3"
>
    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">{{ $label }}</label>

    {{-- Preview Area --}}
    <div class="relative rounded-2xl border-2 border-dashed border-slate-200 overflow-hidden bg-slate-50"
         style="min-height: 160px;">

        {{-- Placeholder --}}
        <div x-show="!preview" class="absolute inset-0 flex flex-col items-center justify-center gap-2 text-slate-400">
            <i class="fa-solid fa-image text-4xl opacity-25"></i>
            <p class="text-xs font-semibold">Belum ada foto</p>
        </div>

        {{-- Preview image --}}
        <template x-if="preview">
            <img :src="preview" alt="Preview" class="w-full object-cover" style="max-height: 240px;">
        </template>

        {{-- Badge foto baru --}}
        <span x-show="hasNew" x-cloak
              class="absolute top-2 right-2 bg-emerald-600 text-white text-[10px] font-extrabold px-2.5 py-1 rounded-full shadow flex items-center gap-1">
            <i class="fa-solid fa-check text-[9px]"></i> Foto Baru
        </span>

        {{-- Tombol hapus pilihan --}}
        <button x-show="hasNew" x-cloak type="button" @click="clearFile()"
                class="absolute top-2 left-2 w-7 h-7 rounded-full bg-white/90 border border-slate-200 shadow flex items-center justify-center text-slate-500 hover:text-red-500 hover:border-red-300 transition">
            <i class="fa-solid fa-xmark text-xs"></i>
        </button>
    </div>

    {{-- Dua tombol aksi --}}
    <div class="grid grid-cols-2 gap-2">
        {{-- Tombol galeri: memicu input TANPA capture → membuka file picker / galeri --}}
        <button type="button" @click="triggerGallery()"
                class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl border-2 border-slate-200 bg-white text-slate-700 hover:border-slate-400 hover:bg-slate-50 font-bold text-xs transition-all">
            <i class="fa-solid fa-images text-slate-500"></i>
            Pilih dari Galeri
        </button>

        {{-- Tombol kamera: memicu input DENGAN capture=environment → langsung buka kamera --}}
        <button type="button" @click="triggerCamera()"
                class="{{ $btnCam }} flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-white font-bold text-xs transition-all shadow-md">
            <i class="fa-solid fa-camera"></i>
            Ambil Foto Kamera
        </button>
    </div>

    {{--
        INPUT 1: Galeri — tidak ada atribut capture
        Browser: membuka file picker / galeri foto
    --}}
    <input
        type="file"
        accept="image/*"
        x-ref="galleryInput"
        @change="onFileChange($event)"
        class="hidden"
    >

    {{--
        INPUT 2: Kamera — capture="environment" STATIS (tidak pernah diubah JS)
        Browser mobile: langsung buka kamera belakang
        Browser desktop: membuka file picker biasa (fallback normal)
    --}}
    <input
        type="file"
        accept="image/*"
        capture="environment"
        x-ref="cameraInput"
        @change="onFileChange($event)"
        class="hidden"
    >

    {{--
        MASTER INPUT: Inilah yang dikirim ke server (name="{{ $name }}")
        File diisi via DataTransfer dari salah satu input di atas
    --}}
    <input
        type="file"
        name="{{ $name }}"
        x-ref="masterInput"
        class="hidden"
    >

    <p class="text-[11px] text-slate-400">
        Format: JPG, PNG, WEBP &bull; Maks: 2MB
    </p>

    @error($name)
        <p class="text-xs text-red-500 font-semibold">{{ $message }}</p>
    @enderror
</div>
