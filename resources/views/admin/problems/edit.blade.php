<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-extrabold text-xl sm:text-2xl text-slate-900 leading-tight truncate mr-3">
                <i class="fa-solid fa-pen-to-square text-amber-500 mr-1"></i>
                <span class="hidden sm:inline">Edit Masalah: </span>{{ $problem->nama }}
            </h2>
            <a href="{{ route('admin.problems.index') }}" class="shrink-0 text-xs font-bold text-slate-600 hover:text-slate-900 flex items-center gap-1.5 bg-slate-100 hover:bg-slate-200 px-3 py-2 rounded-xl transition">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('admin.problems.update', $problem->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-5 sm:p-8 rounded-2xl sm:rounded-3xl border border-slate-200 shadow-sm space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nama Masalah / Hama *</label>
                        <input type="text" name="nama" value="{{ old('nama', $problem->nama) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 text-sm font-medium">
                        @error('nama') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Tipe Masalah *</label>
                        <select name="tipe" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 text-sm font-medium">
                            <option value="Hama" {{ $problem->tipe == 'Hama' ? 'selected' : '' }}>Hama (Serangga, Tikus, Ulat)</option>
                            <option value="Penyakit" {{ $problem->tipe == 'Penyakit' ? 'selected' : '' }}>Penyakit (Jamur, Bakteri, Virus)</option>
                            <option value="Gulma" {{ $problem->tipe == 'Gulma' ? 'selected' : '' }}>Gulma (Rumput Liar)</option>
                        </select>
                    </div>
                </div>

                <x-photo-input
                    name="foto"
                    label="Foto Hama / Gejala Penyakit 📸"
                    accent-color="amber"
                    :current-src="$problem->foto ? asset('storage/' . $problem->foto) : null"
                />

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Pilih Produk Obat / Pestisida Rekomendasi</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 bg-slate-50 p-4 rounded-2xl border border-slate-200">
                        @foreach($products as $prod)
                            <label class="inline-flex items-center gap-2 text-xs font-semibold text-slate-700 cursor-pointer">
                                <input type="checkbox" name="products[]" value="{{ $prod->id }}" {{ $problem->products->contains($prod->id) ? 'checked' : '' }} class="rounded text-amber-600 focus:ring-amber-500 w-4 h-4">
                                <span>{{ $prod->nama }} (Rp {{ number_format($prod->harga, 0, ',', '.') }})</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="pt-4 flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3 border-t border-slate-100">
                    <a href="{{ route('admin.problems.index') }}" class="text-center px-5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-700 hover:bg-slate-50">Batal</a>
                    <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs px-6 py-3 rounded-xl shadow-lg">Perbarui Data Masalah</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
