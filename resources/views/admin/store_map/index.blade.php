<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-extrabold text-2xl text-slate-900 leading-tight flex items-center gap-2">
                    <i class="fa-solid fa-border-all text-emerald-600"></i> Edit Denah Toko (Peta Grid 10 Baris x 8 Kolom)
                </h2>
                <p class="text-xs text-slate-500 mt-1">Klik kotak mana saja pada matriks 80 kotak denah untuk memilih Tipe Zona (Warna akan otomatis mengikuti).</p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.racks.index') }}" class="bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-amber-400"></i> Kelola Daftar Rak (`/admin/racks`)
                </a>
                <a href="{{ route('admin.products.create') }}" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Tambah Produk Baru
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8" x-data="{ editingCell: null }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Color Legend Banner (4 Zone Types Only) -->
            <div class="bg-slate-900 p-6 rounded-3xl text-white shadow-xl border border-slate-800 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold">
                        <i class="fa-solid fa-palette text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-base text-white">Panduan 4 Warna Tipe Zona Toko</h3>
                        <p class="text-xs text-slate-400">Pilih Tipe Zona di modal edit, warna kotak denah akan berubah secara otomatis.</p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3 text-xs font-bold">
                    <span class="inline-flex items-center gap-1.5 bg-blue-950 border border-blue-500/40 text-blue-300 px-3.5 py-1.5 rounded-xl">
                        <span class="w-3.5 h-3.5 rounded-md bg-blue-500"></span>Rak
                    </span>
                    <span class="inline-flex items-center gap-1.5 bg-emerald-950 border border-emerald-500/40 text-emerald-300 px-3.5 py-1.5 rounded-xl">
                        <span class="w-3.5 h-3.5 rounded-md bg-emerald-500"></span>Etalase
                    </span>
                    <span class="inline-flex items-center gap-1.5 bg-amber-950 border border-amber-500/40 text-amber-300 px-3.5 py-1.5 rounded-xl">
                        <span class="w-3.5 h-3.5 rounded-md bg-amber-500"></span>Kasir
                    </span>
                    <span class="inline-flex items-center gap-1.5 bg-red-950 border border-red-500/40 text-red-300 px-3.5 py-1.5 rounded-xl">
                        <span class="w-3.5 h-3.5 rounded-md bg-red-500"></span>Tumpukan
                    </span>
                    <span class="inline-flex items-center gap-1.5 bg-slate-800 border border-slate-700 text-slate-300 px-3.5 py-1.5 rounded-xl">
                        <span class="w-3.5 h-3.5 rounded-md bg-slate-500"></span>Jalan
                    </span>
                </div>
            </div>

            <!-- Cinema-Seating Matrix Grid Blueprint -->
            <div class="bg-slate-950 p-8 rounded-3xl text-white shadow-2xl border border-slate-800">
                <div class="text-center mb-8 pb-4 border-b border-slate-800">
                    <span class="text-[11px] font-extrabold uppercase tracking-widest text-emerald-400 bg-emerald-950 border border-emerald-800 px-4 py-1 rounded-full">
                        AREA DEPAN PINTU MASUK TOKO (BARIS 1 - 10)
                    </span>
                </div>

                <!-- 10 Rows x 8 Columns Matrix Grid -->
                <div class="grid grid-cols-8 gap-2.5 max-w-6xl mx-auto overflow-x-auto pb-4">
                    @foreach($gridCells as $cell)
                        <div @click="editingCell = {{ json_encode($cell) }}"
                             class="group relative h-20 rounded-2xl border-2 transition-all duration-300 cursor-pointer flex flex-col justify-between p-2 text-center shadow-lg hover:scale-105 hover:z-20
                             @if($cell->color == 'green' || $cell->zone_type == 'etalase') bg-emerald-950/80 border-emerald-500/60 text-emerald-200 hover:border-emerald-400
                             @elseif($cell->color == 'blue' || $cell->zone_type == 'rak') bg-blue-950/80 border-blue-500/60 text-blue-200 hover:border-blue-400
                             @elseif($cell->color == 'amber' || $cell->zone_type == 'kasir') bg-amber-950/80 border-amber-500/60 text-amber-200 hover:border-amber-400
                             @elseif($cell->color == 'red' || $cell->zone_type == 'tumpukan') bg-red-950/80 border-red-500/60 text-red-200 hover:border-red-400
                             @else bg-slate-900/80 border-slate-800 text-slate-500 hover:border-slate-600 @endif">
                            
                            <div class="flex items-center justify-between text-[9px] font-bold opacity-60">
                                <span>R{{ $cell->row_idx }}C{{ $cell->col_idx }}</span>
                                <i class="fa-solid fa-pen text-[8px] group-hover:opacity-100"></i>
                            </div>

                            <div class="font-extrabold text-[11px] tracking-tight line-clamp-2 leading-tight">
                                {{ $cell->label ?? 'R'.$cell->row_idx.'-C'.$cell->col_idx }}
                            </div>

                            <div class="text-[8px] uppercase font-bold tracking-wider opacity-70">
                                {{ $cell->zone_type }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 text-center text-xs text-slate-400 border-t border-slate-800 pt-4">
                    💡 Klik kotak manapun dari 80 kotak denah di atas untuk memilih zona (Rak, Etalase, Kasir, Jalan).
                </div>
            </div>

            <!-- Edit Grid Cell Modal -->
            <div x-show="editingCell" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
                <div class="flex items-center justify-center min-h-screen px-4 text-center sm:p-0">
                    <div x-show="editingCell" x-transition.opacity class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm" @click="editingCell = null"></div>

                    <div x-show="editingCell" x-transition.scale.95 class="inline-block bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all max-w-md w-full border border-slate-200 p-6">
                        <template x-if="editingCell">
                            <form :action="'/admin/store-map/grid/' + editingCell.id" method="POST" class="space-y-5">
                                @csrf
                                @method('PUT')

                                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                                    <h3 class="font-extrabold text-lg text-slate-900">
                                        Edit Kotak Denah R<span x-text="editingCell.row_idx"></span>C<span x-text="editingCell.col_idx"></span>
                                    </h3>
                                    <button type="button" @click="editingCell = null" class="text-slate-400 hover:text-slate-700">
                                        <i class="fa-solid fa-xmark text-lg"></i>
                                    </button>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Label Kotak Denah *</label>
                                    <input type="text" name="label" :value="editingCell.label" required placeholder="Contoh: Rak B1-2 / Etalase Depan" class="w-full px-4 py-3 rounded-xl border border-slate-300 font-bold text-sm focus:ring-2 focus:ring-brand-500">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Pilih Tipe Zona (Warna Otomatis Mengikuti) *</label>
                                    <select name="zone_type" :value="editingCell.zone_type" x-model="editingCell.zone_type" class="w-full px-4 py-3 rounded-xl border border-slate-300 font-extrabold text-sm focus:ring-2 focus:ring-brand-500">
                                        <option value="rak">🔵 Rak (Warna Biru)</option>
                                        <option value="etalase">🟢 Etalase (Warna Hijau)</option>
                                        <option value="kasir">🟡 Kasir (Warna Kuning)</option>
                                        <option value="tumpukan">🔴 Tumpukan (Warna Merah)</option>
                                        <option value="jalan">⚪ Jalan (Warna Abu-abu)</option>
                                    </select>
                                    <p class="text-[11px] text-slate-400 mt-1.5">Warna kotak denah akan berubah secara otomatis sesuai Tipe Zona yang Anda pilih.</p>
                                </div>

                                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                                    <button type="button" @click="editingCell = null" class="px-4 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-700">Batal</button>
                                    <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-lg">Simpan Kotak</button>
                                </div>
                            </form>
                        </template>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
