<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-extrabold text-xl sm:text-2xl text-slate-900 leading-tight">
                <i class="fa-solid fa-plus-circle text-blue-600 mr-1"></i> Tambah Kategori Baru
            </h2>
            <a href="{{ route('admin.categories.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 flex items-center gap-1.5 bg-slate-100 hover:bg-slate-200 px-3 py-2 rounded-xl transition">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('admin.categories.store') }}" method="POST" class="bg-white p-5 sm:p-8 rounded-2xl sm:rounded-3xl border border-slate-200 shadow-sm space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nama Kategori / Sub-Kategori *</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Fungisida / Insektisida / Herbisida" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 text-sm font-medium outline-none transition">
                    @error('nama') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Kategori Induk (Opsional)</label>
                    <select name="parent_id" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 text-sm font-medium outline-none transition">
                        <option value="">-- Tidak ada (Jadikan Kategori Utama) --</option>
                        @foreach($mainCategories as $main)
                            <option value="{{ $main->id }}" {{ old('parent_id') == $main->id ? 'selected' : '' }}>
                                Sub-kategori dari: {{ $main->nama }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-[11px] text-slate-400 mt-1">Pilih jika ini adalah sub-kategori (misal: Fungisida → Pestisida).</p>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Deskripsi Kategori</label>
                    <textarea name="deskripsi" rows="3" placeholder="Penjelasan singkat seputar barang dalam kategori ini..." class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 text-sm font-medium outline-none transition">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="pt-4 flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3 border-t border-slate-100">
                    <a href="{{ route('admin.categories.index') }}" class="text-center px-5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-700 hover:bg-slate-50">Batal</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-6 py-3 rounded-xl shadow-lg">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
