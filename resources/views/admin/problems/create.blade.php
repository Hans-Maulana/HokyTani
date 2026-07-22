<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-extrabold text-xl sm:text-2xl text-slate-900 leading-tight">
                <i class="fa-solid fa-plus-circle text-amber-600 mr-1"></i> Tambah Hama / Penyakit
            </h2>
            <a href="{{ route('admin.problems.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 flex items-center gap-1.5 bg-slate-100 hover:bg-slate-200 px-3 py-2 rounded-xl transition">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('admin.problems.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-5 sm:p-8 rounded-2xl sm:rounded-3xl border border-slate-200 shadow-sm space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nama Masalah / Hama *</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Wereng Cokelat / Ulat Grayak" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 text-sm font-medium">
                        @error('nama') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Tipe Masalah *</label>
                        <select name="tipe" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 text-sm font-medium">
                            <option value="Hama">Hama (Serangga, Tikus, Ulat)</option>
                            <option value="Penyakit">Penyakit (Jamur, Bakteri, Virus)</option>
                            <option value="Gulma">Gulma (Rumput Liar)</option>
                        </select>
                    </div>
                </div>

                <x-photo-input
                    name="foto"
                    label="Foto Hama / Gejala Penyakit 📸"
                    accent-color="amber"
                />

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Pilih Produk Obat / Pestisida Rekomendasi</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 bg-slate-50 p-4 rounded-2xl border border-slate-200">
                        @foreach($products as $prod)
                            <label class="inline-flex items-center gap-2 text-xs font-semibold text-slate-700 cursor-pointer">
                                <input type="checkbox" name="products[]" value="{{ $prod->id }}" class="rounded text-amber-600 focus:ring-amber-500 w-4 h-4">
                                <span>{{ $prod->nama }} (Rp {{ number_format($prod->harga, 0, ',', '.') }})</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="pt-4 flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3 border-t border-slate-100">
                    <a href="{{ route('admin.problems.index') }}" class="text-center px-5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-700 hover:bg-slate-50">Batal</a>
                    <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs px-6 py-3 rounded-xl shadow-lg">Simpan Data Masalah</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
