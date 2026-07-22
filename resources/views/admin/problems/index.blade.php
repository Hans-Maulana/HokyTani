<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-extrabold text-xl sm:text-2xl text-slate-900 leading-tight">
                    <i class="fa-solid fa-bug text-amber-600 mr-1"></i> Kelola Hama & Penyakit
                </h2>
                <p class="text-xs text-slate-500 mt-1">Daftar hama/penyakit dan pemetaan obat pembasminya.</p>
            </div>
            <a href="{{ route('admin.problems.create') }}" class="self-start sm:self-auto bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs px-4 py-3 rounded-xl shadow flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Tambah Masalah
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8" x-data="{ searchQuery: '', selectedType: 'all' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                {{-- Search & Filter Bar --}}
                <div class="p-4 sm:p-6 bg-slate-50/80 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="relative w-full sm:w-80">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-slate-400 text-xs"></i>
                        <input type="text" x-model="searchQuery" placeholder="Cari nama hama atau penyakit..."
                               class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-300 text-xs font-bold bg-white focus:ring-2 focus:ring-amber-500 shadow-sm outline-none">
                    </div>
                    <div class="flex items-center gap-1 bg-white p-1 rounded-xl border border-slate-200 text-xs font-bold shadow-sm overflow-x-auto">
                        <button type="button" @click="selectedType = 'all'" :class="selectedType === 'all' ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100'" class="px-3 py-1.5 rounded-lg transition-all whitespace-nowrap">Semua</button>
                        <button type="button" @click="selectedType = 'hama'" :class="selectedType === 'hama' ? 'bg-red-600 text-white' : 'text-slate-600 hover:bg-red-50'" class="px-3 py-1.5 rounded-lg transition-all whitespace-nowrap">🐛 Hama</button>
                        <button type="button" @click="selectedType = 'penyakit'" :class="selectedType === 'penyakit' ? 'bg-amber-600 text-white' : 'text-slate-600 hover:bg-amber-50'" class="px-3 py-1.5 rounded-lg transition-all whitespace-nowrap">🍄 Penyakit</button>
                        <button type="button" @click="selectedType = 'gulma'" :class="selectedType === 'gulma' ? 'bg-emerald-600 text-white' : 'text-slate-600 hover:bg-emerald-50'" class="px-3 py-1.5 rounded-lg transition-all whitespace-nowrap">🌿 Gulma</button>
                    </div>
                </div>

                {{-- DESKTOP: Table (hidden on mobile) --}}
                <div class="hidden sm:block overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-700 uppercase text-[11px] font-bold tracking-wider border-b border-slate-200">
                            <tr>
                                <th class="py-4 px-6">Foto</th>
                                <th class="py-4 px-6">Nama Masalah</th>
                                <th class="py-4 px-6">Tipe</th>
                                <th class="py-4 px-6">Obat Terkait</th>
                                <th class="py-4 px-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($problems as $prob)
                                <tr class="hover:bg-slate-50/80 transition"
                                    x-show="(selectedType === 'all' || '{{ strtolower($prob->tipe) }}' === selectedType) && (!searchQuery || '{{ strtolower($prob->nama) }}'.includes(searchQuery.toLowerCase()))">
                                    <td class="py-4 px-6">
                                        @if($prob->foto)
                                            <img src="{{ asset('storage/' . $prob->foto) }}" alt="{{ $prob->nama }}" class="w-14 h-14 object-cover rounded-xl border border-slate-200">
                                        @else
                                            <div class="w-14 h-14 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100">
                                                <i class="fa-solid fa-bug text-xl"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 font-bold text-slate-900">{{ $prob->nama }}</td>
                                    <td class="py-4 px-6">
                                        <span class="inline-block text-xs font-extrabold uppercase px-3 py-1 rounded-full
                                            @if(strtolower($prob->tipe) == 'hama') bg-red-100 text-red-700
                                            @elseif(strtolower($prob->tipe) == 'penyakit') bg-amber-100 text-amber-700
                                            @else bg-emerald-100 text-emerald-700 @endif">
                                            {{ $prob->tipe }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 font-bold text-slate-700">{{ $prob->products_count }} Produk</td>
                                    <td class="py-4 px-6 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.problems.edit', $prob->id) }}" class="inline-flex items-center gap-1 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition shadow">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.problems.destroy', $prob->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
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
                                    <td colspan="5" class="text-center py-10 text-slate-400">Belum ada data hama & penyakit.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- MOBILE: Card list (visible only on mobile) --}}
                <div class="sm:hidden divide-y divide-slate-100">
                    @forelse($problems as $prob)
                        <div class="p-4 flex gap-3"
                             x-show="(selectedType === 'all' || '{{ strtolower($prob->tipe) }}' === selectedType) && (!searchQuery || '{{ strtolower($prob->nama) }}'.includes(searchQuery.toLowerCase()))">
                            {{-- Foto --}}
                            <div class="shrink-0">
                                @if($prob->foto)
                                    <img src="{{ asset('storage/' . $prob->foto) }}" alt="{{ $prob->nama }}" class="w-14 h-14 object-cover rounded-xl border border-slate-200">
                                @else
                                    <div class="w-14 h-14 rounded-xl bg-amber-50 flex items-center justify-center border border-amber-100">
                                        <i class="fa-solid fa-bug text-amber-400 text-xl"></i>
                                    </div>
                                @endif
                            </div>
                            {{-- Info --}}
                            <div class="flex-1 min-w-0">
                                <div class="font-extrabold text-slate-900 text-sm leading-tight">{{ $prob->nama }}</div>
                                <div class="flex flex-wrap gap-1.5 mt-1.5">
                                    <span class="inline-block text-[10px] font-extrabold uppercase px-2.5 py-0.5 rounded-full
                                        @if(strtolower($prob->tipe) == 'hama') bg-red-100 text-red-700
                                        @elseif(strtolower($prob->tipe) == 'penyakit') bg-amber-100 text-amber-700
                                        @else bg-emerald-100 text-emerald-700 @endif">
                                        {{ $prob->tipe }}
                                    </span>
                                    <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2.5 py-0.5 rounded-full">
                                        {{ $prob->products_count }} Obat
                                    </span>
                                </div>
                                <div class="flex gap-2 mt-3">
                                    <a href="{{ route('admin.problems.edit', $prob->id) }}" class="flex-1 text-center bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold px-3 py-2.5 rounded-xl transition shadow">
                                        <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.problems.destroy', $prob->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full bg-red-100 hover:bg-red-600 text-red-600 hover:text-white text-xs font-bold px-3 py-2.5 rounded-xl transition">
                                            <i class="fa-solid fa-trash mr-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-slate-400">
                            <i class="fa-solid fa-bug text-3xl mb-2 opacity-30"></i>
                            <p class="font-semibold text-sm">Belum ada data masalah</p>
                        </div>
                    @endforelse
                </div>

                <div class="p-4 sm:p-6 border-t border-slate-100">
                    {{ $problems->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
