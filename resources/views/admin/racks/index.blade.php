<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-extrabold text-xl sm:text-2xl text-slate-900 leading-tight">
                    <i class="fa-solid fa-map-location-dot text-amber-500 mr-1"></i> Edit Denah & Rak
                </h2>
                <p class="text-xs text-slate-500 mt-1">Kelola lokasi rak, kode zona, dan deskripsi baris simpan barang.</p>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <a href="{{ route('admin.store_map') }}" class="bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs px-3 py-2.5 rounded-xl shadow flex items-center gap-2">
                    <i class="fa-solid fa-eye text-emerald-400"></i> <span class="hidden sm:inline">Lihat</span> Denah
                </a>
                <a href="{{ route('admin.racks.create') }}" class="bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs px-3 py-2.5 rounded-xl shadow flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Tambah Rak
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                {{-- DESKTOP: Table --}}
                <div class="hidden sm:block overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-700 uppercase text-[11px] font-bold tracking-wider border-b border-slate-200">
                            <tr>
                                <th class="py-4 px-6">Kode Zona</th>
                                <th class="py-4 px-6">Nama Rak / Area</th>
                                <th class="py-4 px-6">Deskripsi</th>
                                <th class="py-4 px-6">Keterangan Baris</th>
                                <th class="py-4 px-6">Jumlah Produk</th>
                                <th class="py-4 px-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($racks as $r)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-4 px-6 font-mono text-xs font-bold text-brand-700">
                                        <span class="bg-brand-50 border border-brand-200 px-2.5 py-1 rounded-lg">{{ $r->kode_zona }}</span>
                                    </td>
                                    <td class="py-4 px-6 font-extrabold text-slate-900">{{ $r->nama }}</td>
                                    <td class="py-4 px-6 text-xs text-slate-500">{{ $r->deskripsi ?? '-' }}</td>
                                    <td class="py-4 px-6 text-xs font-semibold text-slate-700">{{ $r->keterangan_baris ?? '-' }}</td>
                                    <td class="py-4 px-6 font-bold text-amber-600">{{ $r->products_count }} Produk</td>
                                    <td class="py-4 px-6 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.racks.edit', $r->id) }}" class="inline-flex items-center gap-1 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition shadow">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.racks.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Hapus zona rak ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-1 bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition shadow">
                                                    <i class="fa-solid fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-10 text-slate-400">Belum ada lokasi rak terdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- MOBILE: Card list --}}
                <div class="sm:hidden divide-y divide-slate-100">
                    @forelse($racks as $r)
                        <div class="p-4">
                            <div class="flex items-start justify-between gap-2 mb-3">
                                <div class="flex-1 min-w-0">
                                    <div class="font-extrabold text-slate-900 text-sm">{{ $r->nama }}</div>
                                    <div class="flex flex-wrap gap-1.5 mt-1.5">
                                        <span class="bg-brand-50 border border-brand-200 text-brand-700 font-mono text-[10px] font-bold px-2.5 py-0.5 rounded-lg">
                                            {{ $r->kode_zona }}
                                        </span>
                                        <span class="bg-amber-50 border border-amber-200 text-amber-700 text-[10px] font-bold px-2.5 py-0.5 rounded-lg">
                                            {{ $r->products_count }} Produk
                                        </span>
                                    </div>
                                    @if($r->deskripsi)
                                        <p class="text-xs text-slate-400 mt-1.5">{{ $r->deskripsi }}</p>
                                    @endif
                                    @if($r->keterangan_baris)
                                        <p class="text-[11px] font-semibold text-slate-500 mt-1">📋 {{ $r->keterangan_baris }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.racks.edit', $r->id) }}" class="flex-1 text-center bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold px-3 py-2.5 rounded-xl transition shadow">
                                    <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                </a>
                                <form action="{{ route('admin.racks.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Hapus zona rak ini?')" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-red-100 hover:bg-red-600 text-red-600 hover:text-white text-xs font-bold px-3 py-2.5 rounded-xl transition">
                                        <i class="fa-solid fa-trash mr-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-slate-400">
                            <i class="fa-solid fa-map text-3xl mb-2 opacity-30"></i>
                            <p class="font-semibold text-sm">Belum ada lokasi rak</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
