<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-extrabold text-xl sm:text-2xl text-slate-900 leading-tight">
                <i class="fa-solid fa-plus-circle text-amber-500 mr-1"></i> Tambah Rak / Zona Baru
            </h2>
            <a href="{{ route('admin.racks.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 flex items-center gap-1.5 bg-slate-100 hover:bg-slate-200 px-3 py-2 rounded-xl transition">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('admin.racks.store') }}" method="POST" class="bg-white p-5 sm:p-8 rounded-2xl sm:rounded-3xl border border-slate-200 shadow-sm space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nama Rak / Zona *</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Rak E (Pestisida Organik & Hayati)" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 text-sm font-medium outline-none transition">
                    @error('nama') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Kode Zona Unik *</label>
                    <input type="text" name="kode_zona" value="{{ old('kode_zona') }}" required placeholder="Contoh: RAK_E" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 font-mono text-sm font-bold uppercase outline-none transition">
                    <p class="text-[11px] text-slate-400 mt-1">Gunakan kode unik (contoh: RAK_A, RAK_B, ETALASE, GUDANG).</p>
                    @error('kode_zona') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Deskripsi Area</label>
                    <textarea name="deskripsi" rows="3" placeholder="Penjelasan barang apa saja yang disimpan di rak ini..." class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 text-sm font-medium outline-none transition">{{ old('deskripsi') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Rincian Baris (Opsional)</label>
                    <input type="text" name="keterangan_baris" value="{{ old('keterangan_baris') }}" placeholder="Contoh: Baris 1: Cairan | Baris 2: Bubuk" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 text-sm font-medium outline-none transition">
                </div>

                <div class="pt-4 flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3 border-t border-slate-100">
                    <a href="{{ route('admin.racks.index') }}" class="text-center px-5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-700 hover:bg-slate-50">Batal</a>
                    <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs px-6 py-3 rounded-xl shadow-lg">Simpan Lokasi Rak</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
