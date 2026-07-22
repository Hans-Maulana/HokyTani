<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-extrabold text-xl sm:text-2xl text-slate-900 leading-tight">
                <i class="fa-solid fa-plus-circle text-brand-600 mr-1"></i> Tambah Produk Baru
            </h2>
            <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 flex items-center gap-1.5 bg-slate-100 hover:bg-slate-200 px-3 py-2 rounded-xl transition">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-5 sm:p-8 rounded-2xl sm:rounded-3xl border border-slate-200 shadow-sm space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div x-data="{ 
                        barcode: '{{ old('barcode', 'HKT-' . rand(100000, 999999)) }}',
                        generateNew() {
                            this.barcode = 'HKT-' + Math.floor(100000 + Math.random() * 900000);
                            this.render();
                        },
                        render() {
                            this.$nextTick(() => {
                                if (this.barcode) {
                                    try {
                                        JsBarcode('#previewBarcodeSvg', this.barcode, {
                                            format: 'CODE128',
                                            width: 1.8,
                                            height: 45,
                                            fontSize: 12,
                                            margin: 2,
                                            displayValue: true
                                        });
                                    } catch(e) {}
                                }
                            });
                        }
                    }" x-init="render()">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Kode Barcode / SKU Produk 🏷️</label>
                        <div class="flex gap-2 mb-3">
                            <input type="text" name="barcode" x-model="barcode" @input="render()" placeholder="Contoh: HKT-8801" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 font-mono text-sm font-bold bg-slate-50">
                            <button type="button" @click="generateNew()" class="bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold px-3.5 py-3 rounded-xl shrink-0 flex items-center gap-1.5 shadow-sm transition-all">
                                <i class="fa-solid fa-wand-magic-sparkles"></i> Auto Generate
                            </button>
                        </div>
                        
                        <!-- Visual 1D Linear Barcode Striped Lines Live Preview -->
                        <div class="bg-white p-3 rounded-2xl border border-slate-200 shadow-sm flex flex-col items-center justify-center">
                            <span class="text-[10px] font-bold text-slate-400 mb-1">PREVIEW BARCODE 1D (GARIS-GARIS VERTIKAL PANJANG)</span>
                            <svg id="previewBarcodeSvg"></svg>
                        </div>

                        <p class="text-[11px] text-slate-400 mt-1">Kode dibuat otomatis. Klik <b>Auto Generate</b> untuk acak ulang atau ketik manual jika ada barcode asli.</p>
                        @error('barcode') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nama Produk *</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Fungisida Amistartop 325 SC" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 text-sm font-medium">
                        @error('nama') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Merk / Produsen</label>
                        <input type="text" name="merk" value="{{ old('merk') }}" placeholder="Contoh: Syngenta / FMC / Bayer" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 text-sm font-medium">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Harga (Rp) *</label>
                        <input type="number" name="harga" value="{{ old('harga') }}" required placeholder="145000" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 text-sm font-medium">
                        @error('harga') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Interactive Location Picker from Denah Map & Manual Row Input -->
                    <div class="md:col-span-2 bg-slate-50 p-5 rounded-2xl border border-slate-200" x-data="{ 
                        showMapModal: false, 
                        areaName: '{{ old('lokasi_area', '') }}',
                        rowDetail: '{{ old('detail_baris', '') }}',
                        fullLocation: '{{ old('lokasi_rak', '') }}',

                        combineLocation() {
                            if (this.areaName && this.rowDetail) {
                                this.fullLocation = this.areaName + ' - ' + this.rowDetail;
                            } else if (this.areaName) {
                                this.fullLocation = this.areaName;
                            } else if (this.rowDetail) {
                                this.fullLocation = this.rowDetail;
                            }
                        },
                        pickArea(name) {
                            this.areaName = name;
                            this.combineLocation();
                            this.showMapModal = false;
                        }
                    }">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            <i class="fa-solid fa-location-dot text-brand-600 mr-1"></i> Lokasi Rak, Etalase, & Baris Toko
                        </label>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-3">
                            <!-- 1. Pilih Area dari Denah / Dropdown -->
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 mb-1">1. Area / Rak Denah Toko</label>
                                <div class="flex gap-2">
                                    <input type="text" x-model="areaName" @input="combineLocation()" placeholder="Contoh: Rak Oli / Etalase Benih" class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs font-bold bg-white focus:ring-2 focus:ring-brand-500">
                                    <button type="button" @click="showMapModal = true" class="bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold px-3 py-2.5 rounded-xl flex items-center gap-1.5 shrink-0 shadow-sm transition-all">
                                        <i class="fa-solid fa-map-location-dot"></i> Klik Denah
                                    </button>
                                </div>
                            </div>

                            <!-- 2. Isi Manual Detail Baris -->
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 mb-1">2. Detail Baris (Isi Bebas / Manual)</label>
                                <input type="text" x-model="rowDetail" @input="combineLocation()" placeholder="Contoh: Baris 1, Baris 2, Tingkat Atas" class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs font-bold bg-white focus:ring-2 focus:ring-brand-500">
                            </div>

                            <!-- 3. Hasil Lokasi Rak Lengkap -->
                            <div>
                                <label class="block text-[11px] font-bold text-brand-700 mb-1">Hasil Tampilan Lokasi Rak Produk</label>
                                <input type="text" name="lokasi_rak" x-model="fullLocation" placeholder="Tampilan lokasi di pencarian" class="w-full px-3 py-2.5 rounded-xl border border-brand-300 text-xs font-extrabold bg-brand-50/50 text-brand-900 focus:ring-2 focus:ring-brand-500">
                            </div>
                        </div>

                        <p class="text-[11px] text-slate-500">
                            💡 Klik tombol <span class="font-bold text-brand-700">"Klik Denah"</span> untuk memilih kotak lokasi dari denah toko, lalu isi nomor/keterangan baris secara manual.
                        </p>

                        <!-- Modal Picker Denah Toko (10x8 Grid) -->
                        <div x-show="showMapModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-4" x-transition>
                            <div @click.away="showMapModal = false" class="bg-slate-900 border border-slate-800 rounded-3xl p-6 max-w-3xl w-full text-white shadow-2xl space-y-4">
                                <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                                    <div>
                                        <h3 class="font-black text-lg text-amber-400 flex items-center gap-2">
                                            <i class="fa-solid fa-map"></i> Pilih Lokasi Rak / Area dari Denah Toko
                                        </h3>
                                        <p class="text-xs text-slate-400">Klik salah satu kotak denah di bawah untuk memasukkan nama lokasi ke produk ini.</p>
                                    </div>
                                    <button type="button" @click="showMapModal = false" class="text-slate-400 hover:text-white text-xl font-bold px-2">&times;</button>
                                </div>

                                <!-- Denah Grid 10x8 -->
                                <div class="grid grid-cols-8 gap-1.5 bg-slate-950 p-3 rounded-2xl border border-slate-800 max-h-[60vh] overflow-y-auto">
                                    @foreach($gridCells as $cell)
                                        <button type="button" @click="pickArea('{{ addslashes($cell->label) }}')" 
                                                class="aspect-square p-1.5 rounded-xl text-left border flex flex-col justify-between transition-all hover:scale-105 hover:z-10
                                                @if($cell->color == 'green' || $cell->zone_type == 'etalase') bg-emerald-950/90 border-emerald-500/60 text-emerald-200 hover:bg-emerald-800
                                                @elseif($cell->color == 'blue' || $cell->zone_type == 'rak') bg-blue-950/90 border-blue-500/60 text-blue-200 hover:bg-blue-800
                                                @elseif($cell->color == 'amber' || $cell->zone_type == 'kasir') bg-amber-950/90 border-amber-500/60 text-amber-200 hover:bg-amber-800
                                                @elseif($cell->color == 'red' || $cell->zone_type == 'tumpukan') bg-red-950/90 border-red-500/60 text-red-200 hover:bg-red-800
                                                @else bg-slate-900 border-slate-800 text-slate-600 hover:bg-slate-800 @endif">
                                            <span class="text-[8px] font-bold opacity-60">R{{ $cell->row_idx }}C{{ $cell->col_idx }}</span>
                                            <span class="text-[10px] font-extrabold line-clamp-2 leading-tight">{{ $cell->label }}</span>
                                        </button>
                                    @endforeach
                                </div>

                                <div class="flex items-center justify-between pt-2">
                                    <div class="flex items-center gap-2 text-[10px] font-bold text-slate-400">
                                        <span>🔵 Rak</span>
                                        <span>🟢 Etalase</span>
                                        <span>🟡 Kasir</span>
                                        <span>🔴 Tumpukan</span>
                                        <span>⚪ Jalan</span>
                                    </div>
                                    <button type="button" @click="showMapModal = false" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 rounded-xl text-xs font-bold text-slate-300">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Status Stok</label>
                        <select name="status" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 text-sm font-medium">
                            <option value="Tersedia">Tersedia</option>
                            <option value="Stok Habis">Stok Habis</option>
                        </select>
                    </div>
                </div>

                <x-photo-input
                    name="foto"
                    label="Foto Produk 📸"
                    accent-color="brand"
                />

                <!-- Hierarchical Category Checkboxes -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Pilih Kategori & Sub-Kategori Produk</label>
                    <div class="space-y-4 bg-slate-50 p-5 rounded-2xl border border-slate-200">
                        @foreach($mainCategories as $mainCat)
                            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                                <label class="inline-flex items-center gap-2 text-xs font-extrabold text-slate-900 cursor-pointer">
                                    <input type="checkbox" name="categories[]" value="{{ $mainCat->id }}" class="rounded text-brand-600 focus:ring-brand-500 w-4 h-4">
                                    <span>📁 {{ $mainCat->nama }}</span>
                                </label>

                                @if($mainCat->children->isNotEmpty())
                                    <div class="mt-2 ml-6 grid grid-cols-1 sm:grid-cols-3 gap-2 pt-2 border-t border-slate-100">
                                        @foreach($mainCat->children as $sub)
                                            <label class="inline-flex items-center gap-2 text-xs font-semibold text-slate-700 cursor-pointer">
                                                <input type="checkbox" name="categories[]" value="{{ $sub->id }}" class="rounded text-emerald-600 focus:ring-emerald-500 w-3.5 h-3.5">
                                                <span>└─ {{ $sub->nama }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Interactive Hama, Penyakit, & Gulma Search + Filter Component -->
                <div x-data="{
                    searchQuery: '',
                    selectedType: 'all',
                    selectedCount: {{ count(old('problems', [])) }},
                    updateCount() {
                        this.selectedCount = document.querySelectorAll('input[name=\'problems[]\']:checked').length;
                    }
                }" class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-4">
                    
                    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 pb-3">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                                <i class="fa-solid fa-bug text-amber-600 mr-1"></i> Solusi Atasi Masalah Hama, Penyakit, & Gulma
                            </label>
                            <p class="text-[11px] text-slate-400 mt-0.5">Pilih masalah pertanian yang dapat diatasi oleh produk obat/pupuk ini.</p>
                        </div>
                        <span class="text-xs font-extrabold bg-amber-100 text-amber-800 px-3 py-1 rounded-full border border-amber-200">
                            <span x-text="selectedCount"></span> Terpilih
                        </span>
                    </div>

                    <!-- Search Box & Filter Tabs -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <!-- Live Search Input -->
                        <div class="relative">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-slate-400 text-xs"></i>
                            <input type="text" x-model="searchQuery" placeholder="🔎 Cari hama, penyakit, atau gulma (misal: wereng, ulat, jamur)..." class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-300 text-xs font-bold bg-white focus:ring-2 focus:ring-amber-500">
                        </div>

                        <!-- Filter Type Tabs -->
                        <div class="flex flex-wrap items-center gap-1.5 bg-white p-1 rounded-xl border border-slate-200 text-xs font-bold">
                            <button type="button" @click="selectedType = 'all'" :class="selectedType === 'all' ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100'" class="px-3 py-1.5 rounded-lg transition-all">Semua</button>
                            <button type="button" @click="selectedType = 'hama'" :class="selectedType === 'hama' ? 'bg-red-600 text-white' : 'text-slate-600 hover:bg-red-50'" class="px-3 py-1.5 rounded-lg transition-all">🐛 Hama</button>
                            <button type="button" @click="selectedType = 'penyakit'" :class="selectedType === 'penyakit' ? 'bg-amber-600 text-white' : 'text-slate-600 hover:bg-amber-50'" class="px-3 py-1.5 rounded-lg transition-all">🍄 Penyakit</button>
                            <button type="button" @click="selectedType = 'gulma'" :class="selectedType === 'gulma' ? 'bg-emerald-600 text-white' : 'text-slate-600 hover:bg-emerald-50'" class="px-3 py-1.5 rounded-lg transition-all">🌿 Gulma</button>
                        </div>
                    </div>

                    <!-- Problem Checkboxes Grid with Live Filter -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-60 overflow-y-auto p-1">
                        @foreach($problems as $prob)
                            <label x-show="(selectedType === 'all' || '{{ strtolower($prob->tipe) }}' === selectedType) && (!searchQuery || '{{ strtolower($prob->nama) }}'.includes(searchQuery.toLowerCase()) || '{{ strtolower($prob->tipe) }}'.includes(searchQuery.toLowerCase()))"
                                   class="bg-white p-3 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between gap-2 cursor-pointer hover:border-amber-400 transition-all">
                                <div class="flex items-center gap-2.5">
                                    <input type="checkbox" name="problems[]" value="{{ $prob->id }}" @change="updateCount()" class="rounded text-amber-600 focus:ring-amber-500 w-4 h-4">
                                    <span class="text-xs font-bold text-slate-800">{{ $prob->nama }}</span>
                                </div>
                                <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-md shrink-0
                                    @if(strtolower($prob->tipe) == 'hama') bg-red-100 text-red-700
                                    @elseif(strtolower($prob->tipe) == 'penyakit') bg-amber-100 text-amber-700
                                    @else bg-emerald-100 text-emerald-700 @endif">
                                    {{ $prob->tipe }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Bahan Aktif (Khusus Pestisida/Obat)</label>
                    <input type="text" name="bahan_aktif" value="{{ old('bahan_aktif') }}" placeholder="Contoh: Abamektin 18 g/l, Klorpirifos 200 g/l" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 text-sm font-medium">
                    @error('bahan_aktif') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Deskripsi Produk</label>
                    <textarea name="deskripsi" rows="4" placeholder="Jelaskan spesifikasi produk, petunjuk penggunaan, dosis..." class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 text-sm font-medium">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="pt-4 flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3 border-t border-slate-100">
                    <a href="{{ route('admin.products.index') }}" class="text-center px-5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-700 hover:bg-slate-50">Batal</a>
                    <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs px-6 py-3 rounded-xl shadow-lg">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
