<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-extrabold text-xl sm:text-2xl text-slate-900 leading-tight">
                    <i class="fa-solid fa-layer-group text-blue-600 mr-1"></i> Kelola Kategori
                </h2>
                <p class="text-xs text-slate-500 mt-1">Daftar kategori utama dan sub-kategori produk.</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="self-start sm:self-auto bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-4 py-3 rounded-xl shadow flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Tambah Kategori
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                {{-- DESKTOP: Table (hidden on mobile) --}}
                <div class="hidden sm:block overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-700 uppercase text-[11px] font-bold tracking-wider border-b border-slate-200">
                            <tr>
                                <th class="py-4 px-6">Nama Kategori</th>
                                <th class="py-4 px-6">Tipe / Induk</th>
                                <th class="py-4 px-6">Deskripsi</th>
                                <th class="py-4 px-6">Jumlah Produk</th>
                                <th class="py-4 px-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($categories as $c)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-4 px-6 font-bold text-slate-900">{{ $c->nama }}</td>
                                    <td class="py-4 px-6">
                                        @if($c->parent)
                                            <span class="bg-blue-50 text-blue-800 border border-blue-200 text-xs font-bold px-3 py-1 rounded-full inline-flex items-center gap-1">
                                                <i class="fa-solid fa-turn-up text-[10px] rotate-90"></i> Sub dari <b>{{ $c->parent->nama }}</b>
                                            </span>
                                        @else
                                            <span class="bg-emerald-100 text-emerald-800 border border-emerald-200 text-xs font-bold px-3 py-1 rounded-full">
                                                Kategori Utama
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-slate-500 text-xs">{{ $c->deskripsi ?? '-' }}</td>
                                    <td class="py-4 px-6 font-bold text-blue-600">{{ $c->products_count }} Produk</td>
                                    <td class="py-4 px-6 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.categories.edit', $c->id) }}" class="inline-flex items-center gap-1 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition shadow">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
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
                                    <td colspan="5" class="text-center py-10 text-slate-400">Belum ada kategori.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- MOBILE: Card list (visible only on mobile) --}}
                <div class="sm:hidden divide-y divide-slate-100">
                    @forelse($categories as $c)
                        <div class="p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1 min-w-0">
                                    <div class="font-extrabold text-slate-900 text-sm">{{ $c->nama }}</div>
                                    <div class="mt-1.5 flex flex-wrap gap-1.5">
                                        @if($c->parent)
                                            <span class="bg-blue-50 text-blue-800 border border-blue-200 text-[10px] font-bold px-2.5 py-0.5 rounded-full">
                                                Sub: {{ $c->parent->nama }}
                                            </span>
                                        @else
                                            <span class="bg-emerald-100 text-emerald-800 border border-emerald-200 text-[10px] font-bold px-2.5 py-0.5 rounded-full">
                                                Kategori Utama
                                            </span>
                                        @endif
                                        <span class="bg-blue-50 text-blue-700 border border-blue-100 text-[10px] font-bold px-2.5 py-0.5 rounded-full">
                                            {{ $c->products_count }} Produk
                                        </span>
                                    </div>
                                    @if($c->deskripsi)
                                        <p class="text-xs text-slate-400 mt-1.5 line-clamp-2">{{ $c->deskripsi }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex gap-2 mt-3">
                                <a href="{{ route('admin.categories.edit', $c->id) }}" class="flex-1 text-center bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold px-3 py-2.5 rounded-xl transition shadow">
                                    <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                </a>
                                <form action="{{ route('admin.categories.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')" class="flex-1">
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
                            <i class="fa-solid fa-layer-group text-3xl mb-2 opacity-30"></i>
                            <p class="font-semibold text-sm">Belum ada kategori</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
