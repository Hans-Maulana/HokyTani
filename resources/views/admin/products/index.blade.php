<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-extrabold text-xl sm:text-2xl text-slate-900 leading-tight">
                    <i class="fa-solid fa-box text-brand-600 mr-1"></i> Kelola Produk
                </h2>
                <p class="text-xs text-slate-500 mt-1">Kelola data pupuk, pestisida, benih, barcode, dan lokasi rak.</p>
            </div>
            <a href="{{ route('admin.products.create') }}" class="self-start sm:self-auto bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs px-4 py-3 rounded-xl shadow flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Tambah Produk
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                {{-- DESKTOP: Table view (hidden on mobile) --}}
                <div class="hidden sm:block overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-700 uppercase text-[11px] font-bold tracking-wider border-b border-slate-200">
                            <tr>
                                <th class="py-4 px-5">Foto</th>
                                <th class="py-4 px-5">Barcode / SKU</th>
                                <th class="py-4 px-5">Nama & Merk</th>
                                <th class="py-4 px-5">Kategori</th>
                                <th class="py-4 px-5">Lokasi Rak</th>
                                <th class="py-4 px-5">Harga</th>
                                <th class="py-4 px-5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($products as $p)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-4 px-5">
                                        @if($p->foto)
                                            <img src="{{ asset('storage/' . $p->foto) }}" alt="{{ $p->nama }}" class="w-12 h-12 object-cover rounded-xl border border-slate-200">
                                        @else
                                            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-xs border border-emerald-100">
                                                <i class="fa-solid fa-box text-lg"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-4 px-5 font-mono text-xs font-bold text-slate-800">
                                        @if($p->barcode)
                                            <div class="bg-white p-2 rounded-xl border border-slate-200 shadow-sm inline-block text-center cursor-pointer hover:border-amber-400 transition"
                                                 onclick="printBarcodeModal('{{ addslashes($p->nama) }}', '{{ addslashes($p->barcode) }}', '{{ number_format($p->harga, 0, ',', '.') }}', '{{ addslashes($p->lokasi_rak ?? '-') }}')">
                                                <svg class="barcode-svg mx-auto" data-barcode="{{ $p->barcode }}"></svg>
                                                <div class="text-[10px] text-amber-700 font-bold mt-1 flex items-center justify-center gap-1">
                                                    <i class="fa-solid fa-print text-[9px]"></i> Cetak
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-slate-400 font-normal">Belum ada</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-5">
                                        <div class="font-bold text-slate-900">{{ $p->nama }}</div>
                                        <div class="text-xs text-slate-400 font-semibold uppercase">{{ $p->merk ?? '-' }}</div>
                                        @if($p->bahan_aktif)
                                            <div class="text-[10px] text-emerald-700 bg-emerald-50 border border-emerald-100 rounded px-1.5 py-0.5 mt-1 inline-block font-extrabold">Bahan Aktif: {{ $p->bahan_aktif }}</div>
                                        @endif
                                    </td>
                                    <td class="py-4 px-5">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($p->categories as $c)
                                                <span class="bg-brand-50 text-brand-700 text-[10px] font-bold px-2.5 py-0.5 rounded-md border border-brand-200">{{ $c->nama }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="py-4 px-5">
                                        <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-800 bg-emerald-50 border border-emerald-200 px-3 py-1 rounded-full">
                                            <i class="fa-solid fa-location-dot text-brand-600 text-[11px]"></i>
                                            {{ $p->lokasi_rak ?? 'Belum set' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-5 font-bold text-slate-900">
                                        Rp {{ number_format($p->harga, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-5 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.products.edit', $p->id) }}" class="inline-flex items-center gap-1 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition shadow">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
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
                                    <td colspan="7" class="text-center py-10 text-slate-400">Belum ada produk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- MOBILE: Card list view (hidden on sm+) --}}
                <div class="sm:hidden divide-y divide-slate-100">
                    @forelse($products as $p)
                        <div class="p-4 flex gap-3">
                            {{-- Foto --}}
                            <div class="shrink-0">
                                @if($p->foto)
                                    <img src="{{ asset('storage/' . $p->foto) }}" alt="{{ $p->nama }}" class="w-14 h-14 object-cover rounded-xl border border-slate-200">
                                @else
                                    <div class="w-14 h-14 rounded-xl bg-emerald-50 flex items-center justify-center border border-emerald-100">
                                        <i class="fa-solid fa-box text-emerald-400 text-xl"></i>
                                    </div>
                                @endif
                            </div>
                            {{-- Info --}}
                            <div class="flex-1 min-w-0">
                                <div class="font-extrabold text-slate-900 text-sm leading-tight">{{ $p->nama }}</div>
                                <div class="text-[11px] font-semibold text-slate-400 uppercase mt-0.5">{{ $p->merk ?? 'Tanpa merk' }}</div>
                                @if($p->bahan_aktif)
                                    <div class="text-[10px] text-emerald-700 bg-emerald-50 border border-emerald-100 rounded px-1.5 py-0.5 mt-1 inline-block font-extrabold">{{ $p->bahan_aktif }}</div>
                                @endif
                                <div class="flex flex-wrap items-center gap-1.5 mt-1.5">
                                    <span class="font-black text-brand-700 text-sm">Rp {{ number_format($p->harga, 0, ',', '.') }}</span>
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-800 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full">
                                        <i class="fa-solid fa-location-dot text-[9px]"></i> {{ $p->lokasi_rak ?? 'Belum set' }}
                                    </span>
                                </div>
                                @if($p->categories->isNotEmpty())
                                    <div class="flex flex-wrap gap-1 mt-1">
                                        @foreach($p->categories->take(2) as $c)
                                            <span class="bg-brand-50 text-brand-700 text-[10px] font-bold px-2 py-0.5 rounded-md border border-brand-200">{{ $c->nama }}</span>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="flex gap-2 mt-3">
                                    <a href="{{ route('admin.products.edit', $p->id) }}" class="flex-1 text-center bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold px-3 py-2 rounded-xl transition shadow">
                                        <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                    </a>
                                    @if($p->barcode)
                                        <button onclick="printBarcodeModal('{{ addslashes($p->nama) }}', '{{ addslashes($p->barcode) }}', '{{ number_format($p->harga, 0, ',', '.') }}', '{{ addslashes($p->lokasi_rak ?? '-') }}')" class="bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold px-3 py-2 rounded-xl transition">
                                            <i class="fa-solid fa-print"></i>
                                        </button>
                                    @endif
                                    <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin hapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-100 hover:bg-red-600 text-red-600 hover:text-white text-xs font-bold px-3 py-2 rounded-xl transition">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-slate-400">
                            <i class="fa-solid fa-box-open text-3xl mb-2 opacity-30"></i>
                            <p class="font-semibold text-sm">Belum ada produk</p>
                        </div>
                    @endforelse
                </div>

                <div class="p-4 sm:p-6 border-t border-slate-100">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cetak Stiker Barcode (Linear 1D Barcode Striped Lines) -->
    <div id="printModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-8 max-w-sm w-full text-slate-900 shadow-2xl space-y-6 border border-slate-200">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-black text-base text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-barcode text-brand-600"></i> Stiker Barcode Produk
                </h3>
                <button onclick="closePrintModal()" class="text-slate-400 hover:text-slate-700 text-xl font-bold px-2">&times;</button>
            </div>

            <!-- Preview Card Stiker Barcode -->
            <div id="printableArea" class="bg-white border-2 border-dashed border-slate-300 p-5 rounded-2xl text-center space-y-2">
                <div class="text-xs font-black uppercase tracking-wider text-slate-900" id="printProductName">Nama Produk</div>
                <div class="text-[10px] font-bold text-emerald-700" id="printProductLocation">Lokasi Rak</div>
                
                <!-- SVG Linear 1D Barcode -->
                <div class="py-2 flex justify-center">
                    <svg id="modalBarcodeSvg"></svg>
                </div>
                
                <div class="text-sm font-black text-slate-900">Rp <span id="printProductPrice">0</span></div>
                <div class="text-[9px] text-slate-400 font-bold">HOKYTANI FARM & SUPPLIES</div>
            </div>

            <div class="flex gap-3 pt-2">
                <button onclick="closePrintModal()" class="w-1/2 py-3 rounded-xl border border-slate-300 text-xs font-bold text-slate-700 hover:bg-slate-50">Tutup</button>
                <button onclick="window.print()" class="w-1/2 py-3 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold shadow-lg flex items-center justify-center gap-2">
                    <i class="fa-solid fa-print"></i> Cetak Stiker
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            renderBarcodes();
        });

        function renderBarcodes() {
            document.querySelectorAll('.barcode-svg').forEach(function(el) {
                const code = el.getAttribute('data-barcode');
                if (code) {
                    try {
                        JsBarcode(el, code, {
                            format: "CODE128",
                            width: 1.5,
                            height: 40,
                            fontSize: 11,
                            margin: 2,
                            displayValue: true
                        });
                    } catch (e) {
                        console.error('Barcode render error:', e);
                    }
                }
            });
        }

        function printBarcodeModal(name, code, price, location) {
            document.getElementById('printProductName').innerText = name;
            document.getElementById('printProductLocation').innerText = '📍 ' + location;
            document.getElementById('printProductPrice').innerText = price;
            
            try {
                JsBarcode("#modalBarcodeSvg", code, {
                    format: "CODE128",
                    width: 2,
                    height: 55,
                    fontSize: 13,
                    margin: 4,
                    displayValue: true
                });
            } catch (e) {
                console.error(e);
            }

            document.getElementById('printModal').classList.remove('hidden');
        }

        function closePrintModal() {
            document.getElementById('printModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
