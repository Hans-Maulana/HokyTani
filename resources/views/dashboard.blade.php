<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-extrabold text-xl sm:text-2xl text-slate-900 leading-tight flex items-center gap-2">
                    <i class="fa-solid fa-leaf text-brand-600"></i> Dashboard Admin Hokytani
                </h2>
                <p class="text-xs text-slate-500 mt-1">Selamat datang, <b>{{ Auth::user()->name }}</b>! Kelola katalog produk dan informasi toko di sini.</p>
            </div>
            <a href="{{ route('landing') }}" target="_blank" class="inline-flex items-center gap-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow transition self-start sm:self-auto">
                <i class="fa-solid fa-eye"></i> Tinjau Landing Page
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 sm:space-y-8">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
                <!-- Produk Card -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Produk</span>
                            <h3 class="text-3xl font-black text-slate-900 mt-1">{{ $stats['products_count'] ?? 0 }}</h3>
                            <span class="text-[11px] font-semibold text-emerald-600 mt-1 inline-block">Produk Siap Tampil</span>
                        </div>
                        <div class="w-14 h-14 rounded-2xl bg-brand-100 text-brand-600 flex items-center justify-center text-2xl">
                            <i class="fa-solid fa-box-archive"></i>
                        </div>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100">
                        <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-brand-600 hover:text-brand-700 flex items-center justify-between">
                            <span>Kelola Daftar Produk</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Kategori Card -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Kategori Produk</span>
                            <h3 class="text-3xl font-black text-slate-900 mt-1">{{ $stats['categories_count'] ?? 0 }}</h3>
                            <span class="text-[11px] font-semibold text-blue-600 mt-1 inline-block">Pupuk, Benih, Pestisida</span>
                        </div>
                        <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-2xl">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100">
                        <a href="{{ route('admin.categories.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center justify-between">
                            <span>Kelola Kategori</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Masalah Hama Card -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Hama & Penyakit</span>
                            <h3 class="text-3xl font-black text-slate-900 mt-1">{{ $stats['problems_count'] ?? 0 }}</h3>
                            <span class="text-[11px] font-semibold text-amber-600 mt-1 inline-block">Dokter Tanaman</span>
                        </div>
                        <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-2xl">
                            <i class="fa-solid fa-bug"></i>
                        </div>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100">
                        <a href="{{ route('admin.problems.index') }}" class="text-xs font-bold text-amber-600 hover:text-amber-700 flex items-center justify-between">
                            <span>Kelola Data Masalah</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Action Grid -->
            <div class="bg-white rounded-2xl sm:rounded-3xl p-5 sm:p-8 border border-slate-200 shadow-sm">
                <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-4 sm:mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-bolt text-amber-500"></i> Aksi Cepat
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
                    <a href="{{ route('admin.products.create') }}" class="group bg-slate-50 hover:bg-brand-50 border border-slate-200 hover:border-brand-300 p-6 rounded-2xl transition">
                        <div class="w-12 h-12 rounded-xl bg-brand-600 text-white flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <h4 class="font-bold text-slate-900 group-hover:text-brand-700">Tambah Produk Baru</h4>
                        <p class="text-xs text-slate-500 mt-1">Upload foto, tentukan harga, stok, serta hubungkan dengan pestisida/hama.</p>
                    </a>

                    <a href="{{ route('admin.categories.create') }}" class="group bg-slate-50 hover:bg-blue-50 border border-slate-200 hover:border-blue-300 p-6 rounded-2xl transition">
                        <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-folder-plus"></i>
                        </div>
                        <h4 class="font-bold text-slate-900 group-hover:text-blue-700">Tambah Kategori</h4>
                        <p class="text-xs text-slate-500 mt-1">Buat kelompok jenis produk pertanian baru.</p>
                    </a>

                    <a href="{{ route('admin.problems.create') }}" class="group bg-slate-50 hover:bg-amber-50 border border-slate-200 hover:border-amber-300 p-6 rounded-2xl transition">
                        <div class="w-12 h-12 rounded-xl bg-amber-600 text-white flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-viruses"></i>
                        </div>
                        <h4 class="font-bold text-slate-900 group-hover:text-amber-700">Tambah Hama / Penyakit</h4>
                        <p class="text-xs text-slate-500 mt-1">Tambahkan informasi gejala hama dan pasangkan dengan obat rekomendasinya.</p>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
