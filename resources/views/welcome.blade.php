<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hokytani — Dashboard Toko Pertanian</title>
    <meta name="description" content="Dashboard toko pertanian Hokytani - Produk, denah toko, hama & penyakit.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { 50:'#f0fdf4', 100:'#dcfce7', 200:'#bbf7d0', 400:'#4ade80', 500:'#22c55e', 600:'#16a34a', 700:'#15803d', 800:'#166534', 900:'#14532d', 950:'#052e16' },
                    },
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    boxShadow: {
                        'glass': '0 8px 32px rgba(0,0,0,0.12)',
                        'card': '0 2px 8px rgba(0,0,0,0.06)',
                        'card-hover': '0 8px 24px rgba(0,0,0,0.12)',
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }

        body { background: #f1f5f9; }

        /* Sidebar */
        .sidebar { background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%); }
        .sidebar-link {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 14px; border-radius: 12px;
            font-size: 13px; font-weight: 600; color: #94a3b8;
            transition: all 0.2s; cursor: pointer;
        }
        .sidebar-link:hover { background: rgba(255,255,255,0.07); color: #e2e8f0; }
        .sidebar-link.active { background: linear-gradient(135deg, #16a34a, #15803d); color: white; box-shadow: 0 4px 14px rgba(22,163,74,0.4); }
        .sidebar-link .icon { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 13px; transition: all 0.2s; flex-shrink: 0; }
        .sidebar-link:not(.active) .icon { background: rgba(255,255,255,0.06); }
        .sidebar-link.active .icon { background: rgba(255,255,255,0.2); }

        /* Top nav glass */
        .topnav { background: rgba(255,255,255,0.92); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); }

        /* Stat cards */
        .stat-card { position: relative; overflow: hidden; border-radius: 20px; padding: 20px; border: 1px solid rgba(255,255,255,0.8); }
        .stat-card::before { content:''; position:absolute; inset:0; background: inherit; z-index:-1; }

        /* Panel */
        .panel { background: white; border-radius: 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }

        /* Product card */
        .product-card { background: white; border-radius: 20px; border: 1px solid #e2e8f0; overflow: hidden; transition: all 0.25s ease; cursor: pointer; }
        .product-card:hover { box-shadow: 0 12px 32px rgba(0,0,0,0.12); transform: translateY(-3px); border-color: #bbf7d0; }
        @media (hover: none) { .product-card:hover { transform: none; box-shadow: none; } }

        /* Barcode tab mini */
        .barcode-mini-card { background: white; border-radius: 16px; border: 1px solid #e2e8f0; padding: 12px; text-align:center; cursor:pointer; transition: all 0.2s; }
        .barcode-mini-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,0.1); transform: translateY(-2px); border-color: #86efac; }

        /* Denah grid zones */
        .zone-jalan  { background:#f8fafc; border:1px solid #e2e8f0; color:#94a3b8; }
        .zone-rak    { background:linear-gradient(135deg,#eff6ff,#dbeafe); border:1px solid #93c5fd; color:#1d4ed8; }
        .zone-etalase{ background:linear-gradient(135deg,#f0fdf4,#dcfce7); border:1px solid #86efac; color:#15803d; }
        .zone-kasir  { background:linear-gradient(135deg,#fffbeb,#fef3c7); border:1px solid #fcd34d; color:#92400e; }
        .zone-tumpukan{ background:linear-gradient(135deg,#fef2f2,#fee2e2); border:1px solid #fca5a5; color:#b91c1c; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Pill badge */
        .pill { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 99px; font-size: 10px; font-weight: 800; }

        /* Gradient text */
        .gradient-text { background: linear-gradient(135deg, #16a34a, #4ade80); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

        /* Hero gradient */
        .hero-bg { background: linear-gradient(135deg, #052e16 0%, #14532d 40%, #166534 70%, #15803d 100%); }

        /* Input */
        .input-modern { padding: 10px 16px; border-radius: 12px; border: 1.5px solid #e2e8f0; font-size: 13px; font-weight: 500; background: #f8fafc; transition: all 0.2s; outline: none; width: 100%; }
        .input-modern:focus { border-color: #22c55e; background: white; box-shadow: 0 0 0 3px rgba(34,197,94,0.12); }

        /* Tab transition */
        [x-cloak] { display: none !important; }

        /* Fade in */
        @keyframes fadeInUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
        .fade-in-up { animation: fadeInUp 0.4s ease forwards; }

        /* Hama card */
        .hama-card { background: white; border-radius: 20px; border: 1px solid #e2e8f0; overflow: hidden; transition: all 0.2s; }
        .hama-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.10); transform: translateY(-2px); }

        /* Modal overlay */
        .modal-overlay { background: rgba(15,23,42,0.75); backdrop-filter: blur(8px); }

        /* Mobile search bar below header */
        .mobile-searchbar { background: rgba(255,255,255,0.95); backdrop-filter: blur(16px); border-bottom: 1px solid #e2e8f0; }

        /* Zone highlighted pulse ring */
        .zone-highlighted { animation: zoneRingPulse 1.5s ease-in-out infinite; }
        @keyframes zoneRingPulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(16,185,129,0.5); }
            50% { box-shadow: 0 0 0 6px rgba(16,185,129,0); }
        }

        /* Mobile bottom nav active indicator */
        .mobile-nav-active {
            color: #16a34a;
        }
        .mobile-nav-active i {
            transform: scale(1.15);
        }

        /* Responsive touches */
        @media (max-width: 640px) {
            .panel { border-radius: 16px; }
            .product-card { border-radius: 16px; }
            .hama-card { border-radius: 16px; }
        }
    </style>
</head>
<body class="font-sans antialiased" x-data="dashboardApp()" x-init="init()">

{{-- ========== TOP NAV ========== --}}
<header class="topnav fixed top-0 left-0 right-0 z-50 border-b border-slate-200/80 shadow-sm">
    <div class="h-14 md:h-16 flex items-center px-3 sm:px-4 lg:px-6 gap-3">
        {{-- Logo --}}
        <div class="flex items-center gap-2 shrink-0">
            <div class="w-8 h-8 md:w-9 md:h-9 rounded-xl bg-gradient-to-br from-brand-600 to-brand-800 flex items-center justify-center shadow-lg shadow-brand-600/30">
                <i class="fa-solid fa-wheat-awn text-white text-sm md:text-base"></i>
            </div>
            <div class="hidden sm:block">
                <div class="font-black text-slate-900 text-sm md:text-base leading-none">Hokytani</div>
                <div class="text-[10px] font-semibold text-slate-400 tracking-wider uppercase">Toko Pertanian</div>
            </div>
        </div>

        {{-- Search Desktop (md+) --}}
        <div class="flex-1 max-w-lg mx-auto hidden md:flex gap-2">
            <div class="relative w-full">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                <input type="text"
                       x-model="globalSearch"
                       @input="onGlobalSearchInput()"
                       placeholder="Cari produk, merk, barcode, bahan aktif..."
                       class="input-modern w-full pl-10">
            </div>
        </div>

        <div class="ml-auto flex items-center gap-1.5 sm:gap-2.5">
            <button @click="activeTab='barcode'" class="text-xs font-bold flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 sm:px-3.5 py-2 rounded-xl hover:bg-emerald-100 transition-all shadow-sm">
                <i class="fa-solid fa-barcode text-sm"></i> <span class="hidden sm:inline">Scan Barcode</span>
            </button>
            @auth
            <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold flex items-center gap-1.5 bg-slate-900 text-white px-2.5 sm:px-3.5 py-2 rounded-xl hover:bg-brand-700 transition-all shadow-md">
                <i class="fa-solid fa-gauge-high text-sm"></i> <span class="hidden sm:inline">Admin Panel</span>
            </a>
            @else
            <a href="{{ route('login') }}" class="text-xs font-bold flex items-center gap-1.5 bg-slate-900 text-white px-2.5 sm:px-3.5 py-2 rounded-xl hover:bg-slate-700 transition-all shadow-md">
                <i class="fa-solid fa-lock text-sm"></i> <span class="hidden sm:inline">Login</span>
            </a>
            @endauth
        </div>
    </div>

    {{-- Mobile Search Bar (visible only on small screens) --}}
    <div class="mobile-searchbar md:hidden px-3 py-2">
        <div class="relative">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
            <input type="text"
                   x-model="globalSearch"
                   @input="onGlobalSearchInput()"
                   placeholder="Cari produk, merk, barcode..."
                   class="input-modern w-full pl-9 text-sm" style="padding-top:9px;padding-bottom:9px;">
        </div>
    </div>
</header>

{{-- ========== LAYOUT ========== --}}
<div class="flex pt-[100px] md:pt-16 min-h-screen">

    {{-- ========== SIDEBAR (Desktop) ========== --}}
    <aside class="sidebar fixed left-0 top-16 bottom-0 w-56 hidden lg:flex flex-col z-40 overflow-y-auto">
        <div class="p-4 flex-1 space-y-1">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-600 px-2 pb-1 pt-3">Navigasi</p>

            <div @click="activeTab='beranda'" :class="activeTab==='beranda' ? 'active' : ''" class="sidebar-link">
                <span class="icon"><i class="fa-solid fa-house"></i></span>
                <span>Beranda</span>
            </div>
            <div @click="activeTab='katalog'" :class="activeTab==='katalog' ? 'active' : ''" class="sidebar-link">
                <span class="icon"><i class="fa-solid fa-box-open"></i></span>
                <span>Katalog Produk</span>
                <span class="ml-auto bg-slate-700 text-slate-300 text-[9px] font-black px-1.5 py-0.5 rounded-md">{{ count($products) }}</span>
            </div>
            <div @click="activeTab='hama'" :class="activeTab==='hama' ? 'active' : ''" class="sidebar-link">
                <span class="icon"><i class="fa-solid fa-bug"></i></span>
                <span>Hama & Penyakit</span>
                <span class="ml-auto bg-slate-700 text-slate-300 text-[9px] font-black px-1.5 py-0.5 rounded-md">{{ count($problems) }}</span>
            </div>
            <div @click="activeTab='denah'" :class="activeTab==='denah' ? 'active' : ''" class="sidebar-link">
                <span class="icon"><i class="fa-solid fa-map-location-dot"></i></span>
                <span>Denah Toko</span>
            </div>
            <div @click="activeTab='barcode'" :class="activeTab==='barcode' ? 'active' : ''" class="sidebar-link">
                <span class="icon"><i class="fa-solid fa-barcode"></i></span>
                <span>Scan Barcode</span>
            </div>
        </div>

        {{-- Bottom info --}}
        <div class="p-4 border-t border-slate-800">
            <div class="rounded-2xl p-4" style="background: linear-gradient(135deg, rgba(22,163,74,0.15), rgba(21,128,61,0.1)); border: 1px solid rgba(22,163,74,0.25);">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-7 h-7 rounded-lg bg-brand-600 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-store text-white text-xs"></i>
                    </div>
                    <span class="text-xs font-black text-white">Hokytani</span>
                </div>
                <div class="text-[11px] text-slate-400 leading-relaxed">
                    📦 <span class="text-slate-300 font-bold">{{ count($products) }}</span> produk tersedia<br>
                    🐛 <span class="text-slate-300 font-bold">{{ count($problems) }}</span> solusi hama
                </div>
            </div>
        </div>
    </aside>

    {{-- ========== MOBILE BOTTOM NAV ========== --}}
    <nav class="fixed bottom-0 left-0 right-0 z-50 lg:hidden border-t border-slate-200 shadow-2xl" style="background: rgba(255,255,255,0.96); backdrop-filter: blur(16px);">
        <div class="flex items-stretch">
            @foreach([['beranda','fa-house','Beranda'],['katalog','fa-box-open','Produk'],['hama','fa-bug','Hama'],['denah','fa-map','Denah'],['barcode','fa-barcode','Scan']] as [$tab,$icon,$label])
            <button @click="activeTab='{{ $tab }}'" class="flex-1 flex flex-col items-center justify-center gap-0.5 py-3 text-[10px] font-bold transition-all relative"
                    :class="activeTab==='{{ $tab }}' ? 'text-brand-600' : 'text-slate-400 hover:text-slate-600'">
                <span x-show="activeTab==='{{ $tab }}'" class="absolute top-0 left-1/2 -translate-x-1/2 w-6 h-0.5 bg-brand-500 rounded-full"></span>
                <i class="fa-solid {{ $icon }} text-base transition-transform" :class="activeTab==='{{ $tab }}' ? 'scale-110' : ''"></i>
                {{ $label }}
            </button>
            @endforeach
        </div>
    </nav>

    {{-- ========== MAIN CONTENT ========== --}}
    <main class="flex-1 lg:ml-56 p-3 sm:p-4 lg:p-6 pb-24 lg:pb-8 min-h-screen">

        {{-- ======================================================== --}}
        {{-- TAB: BERANDA --}}
        {{-- ======================================================== --}}
        <div x-show="activeTab==='beranda'" class="space-y-5">

            {{-- Hero Banner --}}
            <div class="hero-bg relative rounded-2xl sm:rounded-3xl overflow-hidden p-5 sm:p-7 text-white shadow-2xl">
                {{-- Decorative dots --}}
                <div class="absolute inset-0 opacity-[0.07]" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 22px 22px;"></div>
                {{-- Glow --}}
                <div class="absolute -top-12 -right-12 w-48 h-48 rounded-full opacity-20" style="background: radial-gradient(circle, #4ade80, transparent);"></div>
                <div class="absolute -bottom-8 left-24 w-36 h-36 rounded-full opacity-10" style="background: radial-gradient(circle, #86efac, transparent);"></div>

                <div class="relative flex flex-col lg:flex-row lg:items-center justify-between gap-4 lg:gap-6">
                    <div class="space-y-2.5 sm:space-y-3">
                        <div class="inline-flex items-center gap-1.5 bg-white/15 border border-white/20 rounded-full px-3 py-1.5 text-[11px] sm:text-xs font-bold backdrop-blur-sm">
                            <span class="w-1.5 h-1.5 bg-brand-400 rounded-full animate-pulse"></span>
                            Hokytani Farm & Supplies — Buka Hari Ini
                        </div>
                        <h1 class="text-xl sm:text-2xl lg:text-3xl font-black leading-tight tracking-tight">
                            Solusi Pertanian Terlengkap<br class="hidden sm:block"> untuk Petani Indonesia
                        </h1>
                        <p class="text-emerald-200 text-xs sm:text-sm max-w-md">Pupuk, pestisida, benih unggul, hingga alat tani. Cek denah toko &amp; scan barcode langsung!</p>
                    </div>
                    <div class="flex gap-2 sm:gap-2.5 shrink-0">
                        <button @click="activeTab='katalog'" class="flex items-center gap-2 bg-white text-brand-900 font-extrabold text-xs px-4 sm:px-5 py-2.5 sm:py-3 rounded-xl shadow-lg hover:bg-brand-50 transition-all">
                            <i class="fa-solid fa-box-open"></i> Katalog
                        </button>
                        <button @click="activeTab='denah'" class="flex items-center gap-2 bg-white/15 border border-white/25 text-white font-extrabold text-xs px-4 sm:px-5 py-2.5 sm:py-3 rounded-xl hover:bg-white/25 transition-all backdrop-blur-sm">
                            <i class="fa-solid fa-map-location-dot"></i> Denah
                        </button>
                    </div>
                </div>
            </div>

            {{-- Stats Row --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                @php
                $stats = [
                    ['value'=>count($products), 'label'=>'Total Produk', 'icon'=>'fa-box', 'from'=>'#16a34a', 'to'=>'#15803d', 'bg'=>'#f0fdf4', 'tab'=>'katalog'],
                    ['value'=>count($mainCategories), 'label'=>'Kategori', 'icon'=>'fa-tags', 'from'=>'#2563eb', 'to'=>'#1d4ed8', 'bg'=>'#eff6ff', 'tab'=>'katalog'],
                    ['value'=>count($problems), 'label'=>'Jenis Hama/Penyakit', 'icon'=>'fa-bug', 'from'=>'#d97706', 'to'=>'#b45309', 'bg'=>'#fffbeb', 'tab'=>'hama'],
                    ['value'=>count($racks), 'label'=>'Rak & Etalase', 'icon'=>'fa-store', 'from'=>'#7c3aed', 'to'=>'#6d28d9', 'bg'=>'#f5f3ff', 'tab'=>'denah'],
                ];
                @endphp
                @foreach($stats as $s)
                <div class="panel p-4 sm:p-5 cursor-pointer hover:shadow-md hover:-translate-y-0.5 transition-all" @click="activeTab='{{ $s['tab'] }}'">
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-11 h-11 rounded-2xl flex items-center justify-center shadow-md" style="background: linear-gradient(135deg, {{ $s['from'] }}, {{ $s['to'] }});">
                            <i class="fa-solid {{ $s['icon'] }} text-white text-base"></i>
                        </div>
                        <i class="fa-solid fa-arrow-trend-up text-slate-300 text-sm mt-1"></i>
                    </div>
                    <div class="text-2xl font-black text-slate-900">{{ $s['value'] }}</div>
                    <div class="text-xs font-semibold text-slate-500 mt-0.5">{{ $s['label'] }}</div>
                </div>
                @endforeach
            </div>

            {{-- Feature Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 sm:gap-4">
                {{-- Quick Access --}}
                <div class="panel p-5">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded-xl bg-brand-100 flex items-center justify-center"><i class="fa-solid fa-grid-2 text-brand-600 text-sm"></i></div>
                        <h3 class="font-black text-sm text-slate-800">Akses Cepat</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-2.5">
                        @foreach([['katalog','fa-box-open','Katalog','from-brand-500 to-brand-700'],['hama','fa-bug','Hama/Penyakit','from-amber-500 to-orange-600'],['denah','fa-map-location-dot','Denah Toko','from-blue-500 to-blue-700'],['barcode','fa-barcode','Scan Barcode','from-slate-600 to-slate-800']] as [$tab,$icon,$label,$grad])
                        <button @click="activeTab='{{ $tab }}'"
                                class="flex flex-col items-center gap-2 p-4 rounded-2xl border border-slate-100 hover:border-slate-200 hover:shadow-sm bg-slate-50 hover:bg-white transition-all group">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-md bg-gradient-to-br {{ $grad }} group-hover:scale-110 transition-transform">
                                <i class="fa-solid {{ $icon }} text-white text-sm"></i>
                            </div>
                            <span class="text-[11px] font-bold text-slate-700">{{ $label }}</span>
                        </button>
                        @endforeach
                    </div>
                </div>

                {{-- Kategori --}}
                <div class="panel p-5 lg:col-span-2">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded-xl bg-blue-100 flex items-center justify-center"><i class="fa-solid fa-layer-group text-blue-600 text-sm"></i></div>
                        <h3 class="font-black text-sm text-slate-800">Kategori Produk</h3>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-56 overflow-y-auto pr-1">
                        @foreach($mainCategories as $cat)
                        <div class="group flex items-center justify-between p-3 rounded-xl border border-slate-100 bg-slate-50 hover:bg-white hover:border-brand-200 hover:shadow-sm cursor-pointer transition-all" @click="activeTab='katalog'">
                            <div class="flex-1 min-w-0">
                                <div class="text-xs font-extrabold text-slate-800 flex items-center gap-1.5">
                                    <i class="fa-solid fa-folder text-amber-500 text-[11px]"></i>
                                    {{ $cat->nama }}
                                </div>
                                @if($cat->children->isNotEmpty())
                                <div class="text-[10px] text-slate-400 mt-0.5 truncate">{{ $cat->children->take(3)->pluck('nama')->join(', ') }}</div>
                                @endif
                            </div>
                            <span class="ml-2 text-[10px] font-extrabold bg-brand-100 text-brand-700 px-2 py-0.5 rounded-lg shrink-0">{{ $cat->products_count }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- ======================================================== --}}
        {{-- TAB: KATALOG PRODUK --}}
        {{-- ======================================================== --}}
        <div x-show="activeTab==='katalog'" x-data="katalogData()" x-init="init()">
            {{-- Header --}}
            <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
                <div>
                    <h2 class="text-xl font-black text-slate-900 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-xl bg-brand-100 inline-flex items-center justify-center"><i class="fa-solid fa-box-open text-brand-600 text-sm"></i></span>
                        Katalog Produk
                    </h2>
                    <p class="text-xs text-slate-400 mt-0.5 ml-10">Semua produk pertanian yang tersedia</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-brand-700 bg-brand-50 border border-brand-200 px-3 py-1.5 rounded-full" x-text="filtered.length + ' produk'"></span>
                </div>
            </div>

            {{-- Search Bar --}}
            <div class="panel p-3 mb-5 flex flex-wrap gap-2.5">
                <div class="relative flex-1 min-w-[180px]">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                    <input type="text" x-model="search" placeholder="Ketik untuk memfilter hasil..."
                           class="input-modern w-full pl-9 text-xs">
                </div>
                <select class="input-modern text-xs font-semibold text-slate-700">
                    <option>Semua Kategori</option>
                    @foreach($mainCategories as $cat)
                    <option>📁 {{ $cat->nama }}</option>
                    @foreach($cat->children as $sub)
                    <option>&nbsp;&nbsp;└ {{ $sub->nama }}</option>
                    @endforeach
                    @endforeach
                </select>
            </div>

            {{-- Product Grid --}}
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-4">
                <template x-for="p in filtered" :key="p.id">
                    <div class="product-card" @click="openDetail(p)">
                        {{-- Image --}}
                        <div class="relative h-44 overflow-hidden" style="background: linear-gradient(135deg,#f1f5f9,#e2e8f0);">
                            <template x-if="p.foto">
                                <img :src="'/storage/' + p.foto" :alt="p.nama" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                            </template>
                            <template x-if="!p.foto">
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fa-solid fa-flask-vial text-5xl text-slate-300"></i>
                                </div>
                            </template>
                            <div class="absolute top-2.5 right-2.5">
                                <span :class="p.status === 'Tersedia' ? 'bg-brand-600 text-white' : 'bg-red-500 text-white'"
                                      class="pill shadow-md" x-text="p.status || 'Tersedia'"></span>
                            </div>
                        </div>
                        {{-- Info --}}
                        <div class="p-4 space-y-1.5">
                            <div class="flex items-center justify-between gap-2">
                                <div class="text-[10px] font-extrabold uppercase tracking-wider text-brand-600" x-text="p.merk || 'Hokytani'"></div>
                                <template x-if="p.bahan_aktif">
                                    <span class="text-[8px] bg-emerald-50 text-emerald-700 font-extrabold border border-emerald-200 px-1 rounded">Bahan Aktif</span>
                                </template>
                            </div>
                            <h3 class="font-extrabold text-slate-900 text-sm leading-snug line-clamp-2" x-text="p.nama"></h3>
                            <div class="text-base font-black" style="background: linear-gradient(90deg,#16a34a,#15803d); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(p.harga)"></div>
                            <template x-if="p.lokasi_rak">
                                <div class="flex items-center gap-1.5 text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-1.5 rounded-xl">
                                    <i class="fa-solid fa-location-dot text-[9px]"></i>
                                    <span class="line-clamp-1" x-text="p.lokasi_rak"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
                <template x-if="filtered.length === 0">
                    <div class="col-span-full panel p-16 text-center text-slate-400 space-y-3">
                        <i class="fa-solid fa-box-open text-5xl opacity-30"></i>
                        <p class="font-semibold">Produk tidak ditemukan</p>
                    </div>
                </template>
            </div>

            {{-- Product Detail Modal --}}
            <div x-show="selected" x-cloak x-transition.opacity
                 class="modal-overlay fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm"
                 @click.self="selected = null">
                <div x-show="selected" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                     class="bg-white rounded-3xl shadow-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto border border-slate-100 relative scrollbar-thin" @click.stop>
                    
                    {{-- Floating Close Button --}}
                    <button @click="selected = null" class="absolute top-3 right-3 z-30 w-9 h-9 bg-white/90 backdrop-blur rounded-full flex items-center justify-center text-slate-700 hover:bg-white shadow-lg hover:scale-105 transition-all">
                        <i class="fa-solid fa-xmark text-base"></i>
                    </button>

                    <template x-if="selected">
                        <div>
                            <div class="relative h-48 overflow-hidden" style="background: linear-gradient(135deg,#f1f5f9,#e2e8f0);">
                                <template x-if="selected.foto">
                                    <img :src="'/storage/' + selected.foto" :alt="selected.nama" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!selected.foto">
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fa-solid fa-flask-vial text-6xl text-slate-300"></i>
                                    </div>
                                </template>
                                <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(0,0,0,0.4), transparent);"></div>
                                <div class="absolute bottom-3 left-4">
                                    <span :class="selected.status === 'Tersedia' ? 'bg-brand-600 text-white' : 'bg-red-500 text-white'"
                                          class="pill" x-text="selected.status || 'Tersedia'"></span>
                                </div>
                            </div>

                            <div class="p-6 space-y-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <div class="text-[10px] font-extrabold uppercase tracking-wider text-brand-600 mb-0.5" x-text="selected.merk || 'Hokytani'"></div>
                                        <h3 class="text-lg font-black text-slate-900 leading-tight" x-text="selected.nama"></h3>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <div class="text-xl font-black" style="background: linear-gradient(135deg,#16a34a,#15803d); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(selected.harga)"></div>
                                    </div>
                                </div>

                                <template x-if="selected.lokasi_rak">
                                    <div class="flex items-center gap-2.5 bg-emerald-50 border border-emerald-200 rounded-2xl px-4 py-3">
                                        <div class="w-8 h-8 bg-brand-600 rounded-xl flex items-center justify-center shrink-0">
                                            <i class="fa-solid fa-location-dot text-white text-xs"></i>
                                        </div>
                                        <div>
                                            <div class="text-[10px] text-emerald-600 font-bold">Lokasi di Toko</div>
                                            <div class="text-xs font-extrabold text-emerald-900" x-text="selected.lokasi_rak"></div>
                                        </div>
                                        <button @click="locateOnMap(selected.lokasi_rak, selected.nama); selected=null" class="ml-auto bg-brand-600 text-white text-[10px] font-black px-3 py-1.5 rounded-xl hover:bg-brand-700 transition-all shadow-sm">
                                            Cari di Denah 🗺️
                                        </button>
                                    </div>
                                </template>

                                <template x-if="selected.barcode">
                                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 flex flex-col items-center">
                                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-2">BARCODE PRODUK</p>
                                        <svg id="modalBarcode" class="mx-auto"></svg>
                                    </div>
                                </template>

                                <template x-if="selected.bahan_aktif">
                                    <div class="bg-emerald-50/50 border border-emerald-200/60 rounded-2xl p-4">
                                        <p class="text-[10px] font-black uppercase text-emerald-700 mb-1">BAHAN AKTIF</p>
                                        <p class="text-xs font-bold text-slate-800" x-text="selected.bahan_aktif"></p>
                                    </div>
                                </template>

                                <template x-if="selected.deskripsi">
                                    <div class="bg-slate-50 rounded-2xl p-4">
                                        <p class="text-[10px] font-black uppercase text-slate-400 mb-1.5">Deskripsi</p>
                                        <p class="text-xs text-slate-600 leading-relaxed" x-text="selected.deskripsi"></p>
                                    </div>
                                </template>

                                <a :href="'https://wa.me/6281234567890?text=Halo%20Hokytani,%20saya%20ingin%20bertanya%20tentang%20' + encodeURIComponent(selected.nama)" target="_blank"
                                   class="flex w-full items-center justify-center gap-2 text-white font-extrabold text-sm py-3.5 rounded-2xl shadow-lg shadow-brand-600/25 transition-all hover:opacity-90"
                                   style="background: linear-gradient(135deg, #16a34a, #15803d);">
                                    <i class="fa-brands fa-whatsapp text-lg"></i> Tanya / Pesan via WhatsApp
                                </a>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        {{-- ======================================================== --}}
        {{-- TAB: HAMA & PENYAKIT --}}
        {{-- ======================================================== --}}
        <div x-show="activeTab==='hama'" x-data="{
            search: '',
            tipe: 'all',
            problems: {{ json_encode($problems->map(fn($p) => ['id'=>$p->id,'nama'=>$p->nama,'tipe'=>$p->tipe,'foto'=>$p->foto,'products_count'=>$p->products_count])) }},
            get filtered() {
                return this.problems.filter(p => {
                    const t = this.tipe === 'all' || p.tipe.toLowerCase() === this.tipe;
                    const s = !this.search || p.nama.toLowerCase().includes(this.search.toLowerCase());
                    return t && s;
                });
            }
        }">
            <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
                <div>
                    <h2 class="text-xl font-black text-slate-900 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-xl bg-amber-100 inline-flex items-center justify-center"><i class="fa-solid fa-bug text-amber-600 text-sm"></i></span>
                        Hama, Penyakit & Gulma
                    </h2>
                    <p class="text-xs text-slate-400 mt-0.5 ml-10">Informasi hama dan produk obatnya</p>
                </div>
                <span class="text-xs font-bold text-amber-700 bg-amber-50 border border-amber-200 px-3 py-1.5 rounded-full" x-text="filtered.length + ' jenis'"></span>
            </div>

            {{-- Filter Bar --}}
            <div class="panel p-3 mb-5 flex flex-wrap gap-2.5">
                <div class="relative flex-1 min-w-[180px]">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                    <input type="text" x-model="search" placeholder="Cari nama hama, penyakit, gulma..." class="input-modern w-full pl-9 text-xs">
                </div>
                <div class="flex items-center gap-1.5 bg-slate-100 p-1 rounded-xl text-xs font-bold">
                    @foreach([['all','Semua','slate'],['hama','🐛 Hama','red'],['penyakit','🍄 Penyakit','amber'],['gulma','🌿 Gulma','brand']] as [$val,$lbl,$clr])
                    <button @click="tipe='{{ $val }}'"
                            :class="tipe==='{{ $val }}' ? '{{ $clr === 'brand' ? 'bg-brand-600' : 'bg-'.$clr.'-600' }} text-white shadow-sm' : 'text-slate-500 hover:bg-white hover:text-slate-700'"
                            class="px-3.5 py-2 rounded-xl transition-all">{{ $lbl }}</button>
                    @endforeach
                </div>
            </div>

            {{-- Problem Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                <template x-for="p in filtered" :key="p.id">
                    <div class="hama-card">
                        <div class="h-36 overflow-hidden relative">
                            <template x-if="p.foto">
                                <img :src="'/storage/' + p.foto" :alt="p.nama" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!p.foto">
                                <div class="w-full h-full flex items-center justify-center"
                                     :style="'background: linear-gradient(135deg,' + (p.tipe.toLowerCase()==='hama' ? '#fef2f2,#fee2e2' : p.tipe.toLowerCase()==='penyakit' ? '#fffbeb,#fef3c7' : '#f0fdf4,#dcfce7') + ')'">
                                    <i :class="p.tipe.toLowerCase()==='hama' ? 'fa-bug text-red-200' : p.tipe.toLowerCase()==='penyakit' ? 'fa-biohazard text-amber-200' : 'fa-seedling text-brand-200'"
                                       class="fa-solid text-5xl"></i>
                                </div>
                            </template>
                            <div class="absolute top-2.5 right-2.5">
                                <span class="pill"
                                      :class="p.tipe.toLowerCase()==='hama' ? 'bg-red-600 text-white' : p.tipe.toLowerCase()==='penyakit' ? 'bg-amber-600 text-white' : 'bg-brand-600 text-white'"
                                      x-text="p.tipe"></span>
                            </div>
                        </div>
                        <div class="p-4 space-y-2">
                            <h3 class="font-extrabold text-slate-900 text-sm" x-text="p.nama"></h3>
                            <div class="flex items-center gap-1.5 text-xs font-semibold text-slate-500">
                                <i class="fa-solid fa-flask-vial text-brand-500 text-[10px]"></i>
                                <span x-text="p.products_count + ' produk obat tersedia'"></span>
                            </div>
                            <button @click="activeTab='katalog'" class="w-full text-xs font-bold bg-slate-50 hover:bg-brand-50 border border-slate-200 hover:border-brand-300 text-slate-600 hover:text-brand-700 py-2.5 rounded-xl transition-all flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-arrow-right text-[10px]"></i> Lihat Produk Obat
                            </button>
                        </div>
                    </div>
                </template>
                <template x-if="filtered.length === 0">
                    <div class="col-span-full panel p-16 text-center text-slate-400 space-y-3">
                        <i class="fa-solid fa-bug text-5xl opacity-20"></i>
                        <p class="font-semibold">Data tidak ditemukan</p>
                    </div>
                </template>
            </div>
        </div>

        {{-- ======================================================== --}}
        {{-- TAB: DENAH TOKO --}}
        {{-- ======================================================== --}}
        <div x-show="activeTab==='denah'">
            <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
                <div>
                    <h2 class="text-xl font-black text-slate-900 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-xl bg-blue-100 inline-flex items-center justify-center"><i class="fa-solid fa-map-location-dot text-blue-600 text-sm"></i></span>
                        Denah Toko
                    </h2>
                    <p class="text-xs text-slate-400 mt-0.5 ml-10">Layout posisi rak, etalase, dan area toko</p>
                </div>
            </div>

            {{-- Locating Product Alert Notice --}}
            <template x-if="selectedProductLocation">
                <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 text-white rounded-2xl p-4 mb-5 shadow-lg flex items-center justify-between gap-3 animate-pulse">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-location-crosshairs text-lg"></i>
                        </div>
                        <div>
                            <div class="text-[10px] font-black uppercase tracking-wider text-emerald-200">Sedang Mencari Lokasi Produk</div>
                            <div class="text-xs font-black"><span x-text="selectedProductName"></span> (Lokasi: <span x-text="selectedProductLocation"></span>)</div>
                        </div>
                    </div>
                    <button @click="selectedProductLocation = ''; selectedProductName = ''" 
                            class="bg-white text-emerald-800 text-xs font-bold px-3 py-1.5 rounded-xl hover:bg-emerald-50 transition-all shrink-0">
                        Selesai / Reset
                    </button>
                </div>
            </template>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
                {{-- Keterangan + Rak List --}}
                <div class="space-y-4">
                    <div class="panel p-5">
                        <h3 class="font-black text-sm text-slate-700 mb-3">Keterangan Zona</h3>
                        <div class="space-y-2">
                            @foreach([['zone-rak','Rak'],['zone-etalase','Etalase'],['zone-kasir','Kasir'],['zone-tumpukan','Tumpukan'],['zone-jalan','Jalan / Lorong']] as [$cls,$lbl])
                            <div class="flex items-center gap-2.5 text-xs font-semibold text-slate-600">
                                <span class="{{ $cls }} w-7 h-7 rounded-lg flex-shrink-0 block"></span>
                                {{ $lbl }}
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="panel p-5">
                        <h3 class="font-black text-sm text-slate-700 mb-3">Rak & Etalase</h3>
                        <div class="space-y-2 max-h-72 overflow-y-auto pr-1">
                            @foreach($racks as $rack)
                            <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 hover:border-brand-200 hover:bg-brand-50 transition-all cursor-default">
                                <div class="font-bold text-xs text-slate-800">{{ $rack->nama }}</div>
                                @if($rack->deskripsi)<div class="text-[11px] text-slate-400 mt-0.5">{{ Str::limit($rack->deskripsi, 40) }}</div>@endif
                                <div class="text-[10px] font-bold text-brand-600 mt-1">{{ $rack->products_count }} produk</div>
                            </div>
                            @endforeach
                            @if(count($racks) === 0)
                            <p class="text-xs text-slate-400 text-center py-4">Belum ada rak terdaftar</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Grid Denah --}}
                <div class="lg:col-span-3 panel p-5 overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-black text-sm text-slate-800">
                            Peta Layout Toko
                            <span class="ml-2 text-[10px] font-bold text-slate-400">({{ collect($gridCells)->max('row_idx') }} baris × {{ collect($gridCells)->max('col_idx') }} kolom)</span>
                        </h3>
                    </div>
                    <div class="overflow-auto">
                        <div class="grid gap-1.5 min-w-[480px]"
                             style="grid-template-columns: repeat({{ collect($gridCells)->max('col_idx') }}, minmax(58px, 1fr));">
                            @foreach($gridCells as $cell)
                            <div class="rounded-xl p-1.5 min-h-[58px] flex flex-col justify-between cursor-default transition-all hover:scale-105 hover:z-10 hover:shadow-md relative
                                @if($cell->zone_type == 'rak') zone-rak
                                @elseif($cell->zone_type == 'etalase') zone-etalase
                                @elseif($cell->zone_type == 'kasir') zone-kasir
                                @elseif($cell->zone_type == 'tumpukan') zone-tumpukan
                                @else zone-jalan @endif"
                                 :class="selectedProductLocation && isMatchingLocation('{{ addslashes($cell->label) }}') ? 'zone-highlighted ring-4 ring-emerald-500 scale-105 shadow-xl z-20 border-emerald-500' : ''">
                                
                                {{-- Target pointer indicator --}}
                                <template x-if="selectedProductLocation && isMatchingLocation('{{ addslashes($cell->label) }}')">
                                    <div class="absolute -top-2.5 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-[8px] font-black px-1.5 py-0.5 rounded-md shadow-md flex items-center gap-1 border border-slate-700 whitespace-nowrap z-30">
                                        <span class="w-1.5 h-1.5 bg-brand-400 rounded-full animate-ping"></span>
                                        PRODUK ADA DI SINI
                                    </div>
                                </template>

                                <div class="text-[7px] opacity-40 font-black">R{{ $cell->row_idx }}·C{{ $cell->col_idx }}</div>
                                <div class="text-[9px] font-extrabold text-center leading-tight mt-auto">{{ $cell->label }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ======================================================== --}}
        {{-- TAB: SCAN BARCODE --}}
        {{-- ======================================================== --}}
        <div x-show="activeTab==='barcode'" x-data="barcodeData()">
            <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
                <div>
                    <h2 class="text-xl font-black text-slate-900 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-xl bg-slate-200 inline-flex items-center justify-center"><i class="fa-solid fa-barcode text-slate-600 text-sm"></i></span>
                        Cari / Scan Barcode
                    </h2>
                    <p class="text-xs text-slate-400 mt-0.5 ml-10">Masukkan kode barcode untuk menemukan produk</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-4 mb-5">
                {{-- Input Panel --}}
                <div class="lg:col-span-2 panel p-6 space-y-5">
                    {{-- Camera Scanner Area --}}
                    <div class="relative rounded-2xl overflow-hidden bg-slate-950" style="min-height: 200px;">
                        <div id="barcode-reader" x-show="cameraActive" style="width:100%;"></div>
                        <div x-show="!cameraActive" class="flex flex-col items-center justify-center py-10 px-4 text-center space-y-3">
                            <div class="w-20 h-20 mx-auto rounded-3xl flex items-center justify-center" style="background: linear-gradient(135deg,#1e293b,#334155);">
                                <i class="fa-solid fa-camera text-3xl text-white/60"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-white/70">Kamera Barcode Scanner</p>
                                <p class="text-xs text-white/40 mt-0.5">Arahkan kamera ke label barcode produk</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button @click="toggleCamera()" class="flex-1 flex items-center justify-center gap-2 font-extrabold py-3 rounded-2xl shadow-lg transition-all text-sm"
                                :class="cameraActive ? 'bg-red-600 hover:bg-red-700 text-white' : 'bg-gradient-to-r from-brand-600 to-brand-700 text-white hover:opacity-90'">
                            <i :class="cameraActive ? 'fa-solid fa-stop' : 'fa-solid fa-camera'"></i>
                            <span x-text="cameraActive ? 'Stop Kamera' : 'Buka Kamera Scan'"></span>
                        </button>
                    </div>

                    {{-- Divider --}}
                    <div class="flex items-center gap-3">
                        <div class="flex-1 border-t border-slate-200"></div>
                        <span class="text-xs font-bold text-slate-400">ATAU KETIK MANUAL</span>
                        <div class="flex-1 border-t border-slate-200"></div>
                    </div>

                    {{-- Manual Input --}}
                    <div>
                        <input type="text" x-model="code" @keydown.enter="scan()" placeholder="Contoh: HKT-123456"
                               class="input-modern w-full font-mono text-base font-black text-center tracking-widest uppercase">
                    </div>
                    <button @click="scan()" class="w-full flex items-center justify-center gap-2 text-white font-extrabold py-3.5 rounded-2xl shadow-lg transition-all hover:opacity-90"
                            style="background: linear-gradient(135deg, #1e293b, #334155);">
                        <i class="fa-solid fa-magnifying-glass"></i> Cari Produk
                    </button>

                    <template x-if="notFound">
                        <div class="bg-red-50 border border-red-200 rounded-2xl p-4 text-center space-y-1">
                            <i class="fa-solid fa-circle-xmark text-red-500 text-xl"></i>
                            <p class="text-xs font-bold text-red-700">Barcode tidak ditemukan di sistem.</p>
                        </div>
                    </template>
                </div>

                {{-- Result Panel --}}
                <div class="lg:col-span-3 panel p-6" x-show="result">
                    <template x-if="result">
                        <div class="space-y-4">
                            <h3 class="font-black text-sm text-slate-700">Hasil Pencarian Barcode</h3>
                            <div class="flex items-center gap-4 p-4 rounded-2xl" style="background:linear-gradient(135deg,#f8fafc,#f1f5f9); border:1px solid #e2e8f0;">
                                <template x-if="result.foto">
                                    <img :src="'/storage/' + result.foto" :alt="result.nama" class="w-20 h-20 object-cover rounded-2xl border border-slate-200 shadow-sm shrink-0">
                                </template>
                                <template x-if="!result.foto">
                                    <div class="w-20 h-20 bg-slate-200 rounded-2xl flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-box text-slate-400 text-2xl"></i>
                                    </div>
                                </template>
                                <div class="min-w-0">
                                    <div class="text-[10px] font-extrabold uppercase text-brand-600" x-text="result.merk || 'Hokytani'"></div>
                                    <div class="font-extrabold text-slate-900 text-sm leading-snug" x-text="result.nama"></div>
                                    <div class="font-black text-brand-700 mt-1" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(result.harga)"></div>
                                    <span :class="result.status === 'Tersedia' ? 'bg-brand-100 text-brand-700' : 'bg-red-100 text-red-700'"
                                          class="pill mt-1" x-text="result.status || 'Tersedia'"></span>
                                </div>
                            </div>

                            <template x-if="result.lokasi_rak">
                                <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 rounded-2xl px-4 py-3">
                                    <div class="w-8 h-8 bg-brand-600 rounded-xl flex items-center justify-center shrink-0"><i class="fa-solid fa-location-dot text-white text-xs"></i></div>
                                    <div>
                                        <div class="text-[10px] text-emerald-600 font-bold">Lokasi di Toko</div>
                                        <div class="text-xs font-extrabold text-emerald-900" x-text="result.lokasi_rak"></div>
                                    </div>
                                </div>
                            </template>

                            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 flex flex-col items-center gap-2">
                                <p class="text-[9px] font-black uppercase tracking-widest text-slate-400">BARCODE PRODUK</p>
                                <svg id="scanResultSvg" class="mx-auto"></svg>
                            </div>

                            <a :href="'https://wa.me/6281234567890?text=Halo%20Hokytani,%20saya%20tertarik%20dengan%20' + encodeURIComponent(result.nama)" target="_blank"
                               class="flex w-full items-center justify-center gap-2 text-white font-extrabold text-sm py-3 rounded-2xl shadow-md transition-all hover:opacity-90"
                               style="background: linear-gradient(135deg,#16a34a,#15803d);">
                                <i class="fa-brands fa-whatsapp text-base"></i> Pesan via WhatsApp
                            </a>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Semua Barcode --}}
            <div>
                <h3 class="font-black text-sm text-slate-700 mb-3 flex items-center gap-2">
                    <i class="fa-solid fa-list text-slate-500 text-xs"></i> Semua Barcode Produk
                </h3>
                <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-2 sm:gap-3">
                    @foreach($products as $p)
                    @if($p->barcode)
                    <div class="barcode-mini-card" @click="code='{{ $p->barcode }}'; scan()">
                        <svg class="barcode-mini mx-auto" data-code="{{ $p->barcode }}"></svg>
                        <div class="text-[10px] font-extrabold text-slate-700 mt-2 line-clamp-1">{{ $p->nama }}</div>
                        <div class="text-[9px] font-mono font-bold text-brand-600">{{ $p->barcode }}</div>
                    </div>
                    @endif
                    @endforeach
                    @if($products->where('barcode', '!=', null)->count() === 0)
                    <div class="col-span-full text-center py-12 text-slate-400">
                        <i class="fa-solid fa-barcode text-4xl opacity-20 mb-2"></i>
                        <p class="font-semibold text-sm">Belum ada produk dengan barcode</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </main>
</div>

<script>
const _allProducts = {!! json_encode($products->map(fn($p) => [
    'id'=>$p->id,'nama'=>$p->nama,'merk'=>$p->merk,'harga'=>$p->harga,
    'barcode'=>$p->barcode,'foto'=>$p->foto,'deskripsi'=>$p->deskripsi,
    'bahan_aktif'=>$p->bahan_aktif,
    'status'=>$p->status,'lokasi_rak'=>$p->lokasi_rak,
    'cats'=>$p->categories->pluck('nama')->join(', ')
])) !!};

function dashboardApp() {
    return {
        activeTab: '{{ request("q") || request("category_id") ? "katalog" : "beranda" }}',
        globalSearch: '{{ request("q") }}',
        selectedProductLocation: '',
        selectedProductName: '',
        init() {
            this.$nextTick(() => {
                document.querySelectorAll('.barcode-mini').forEach(el => {
                    const code = el.getAttribute('data-code');
                    if (code) {
                        try { JsBarcode(el, code, {format:'CODE128',width:0.9,height:22,fontSize:0,margin:1,displayValue:false}); } catch(e) {}
                    }
                });
            });
        },
        onGlobalSearchInput() {
            this.activeTab = 'katalog';
            // Dispatch custom event to sync with katalogData component
            window.dispatchEvent(new CustomEvent('global-search-updated', { detail: this.globalSearch }));
        },
        locateOnMap(lokasiRak, namaProduk) {
            this.selectedProductLocation = lokasiRak;
            this.selectedProductName = namaProduk;
            this.activeTab = 'denah';
        },
        isMatchingLocation(cellLabel) {
            if (!this.selectedProductLocation || !cellLabel) return false;
            // Extract area name before ' - ' (e.g. "Tumpukan Benih - Baris 1" → "Tumpukan Benih")
            const areaName = this.selectedProductLocation.split(' - ')[0].trim().toLowerCase();
            return cellLabel.trim().toLowerCase() === areaName;
        }
    }
}

function katalogData() {
    return {
        search: '{{ request("q") }}',
        products: _allProducts,
        selected: null,
        init() {
            window.addEventListener('global-search-updated', (e) => {
                this.search = e.detail;
            });
        },
        get filtered() {
            const q = this.search.toLowerCase();
            return this.products.filter(p => !q || 
                p.nama.toLowerCase().includes(q) || 
                (p.merk||'').toLowerCase().includes(q) || 
                (p.barcode||'').toLowerCase().includes(q) || 
                (p.bahan_aktif||'').toLowerCase().includes(q) || 
                (p.cats||'').toLowerCase().includes(q)
            );
        },
        openDetail(p) {
            this.selected = p;
            if (p.barcode) {
                this.$nextTick(() => {
                    try { JsBarcode('#modalBarcode', p.barcode, {format:'CODE128',width:1.8,height:45,fontSize:12,margin:3,displayValue:true}); } catch(e){}
                });
            }
        }
    }
}

function barcodeData() {
    return {
        code: '',
        result: null,
        notFound: false,
        cameraActive: false,
        scanner: null,
        products: _allProducts,

        scan() {
            const c = this.code.trim().toUpperCase();
            if (!c) return;
            const found = this.products.find(p => p.barcode && p.barcode.toUpperCase() === c);
            if (found) {
                this.result = found;
                this.notFound = false;
                this.$nextTick(() => {
                    try { JsBarcode('#scanResultSvg', found.barcode, {format:'CODE128',width:2,height:55,fontSize:13,margin:4,displayValue:true}); } catch(e){}
                });
            } else {
                this.result = null;
                this.notFound = true;
            }
        },

        toggleCamera() {
            if (this.cameraActive) {
                this.stopCamera();
            } else {
                this.startCamera();
            }
        },

        startCamera() {
            const self = this;
            this.cameraActive = true;
            this.$nextTick(() => {
                self.scanner = new Html5Qrcode("barcode-reader");
                self.scanner.start(
                    { facingMode: "environment" },
                    {
                        fps: 10,
                        qrbox: { width: 280, height: 120 },
                        formatsToSupport: [
                            Html5QrcodeSupportedFormats.CODE_128,
                            Html5QrcodeSupportedFormats.CODE_39,
                            Html5QrcodeSupportedFormats.EAN_13,
                            Html5QrcodeSupportedFormats.EAN_8,
                            Html5QrcodeSupportedFormats.UPC_A,
                            Html5QrcodeSupportedFormats.UPC_E,
                        ]
                    },
                    (decodedText) => {
                        // Barcode detected!
                        self.code = decodedText;
                        self.scan();
                        self.stopCamera();
                    },
                    (errorMessage) => { /* ignore scan errors */ }
                ).catch(err => {
                    console.error("Camera error:", err);
                    self.cameraActive = false;
                    alert("Tidak bisa mengakses kamera. Pastikan izin kamera diaktifkan.");
                });
            });
        },

        stopCamera() {
            if (this.scanner) {
                this.scanner.stop().then(() => {
                    this.scanner.clear();
                    this.cameraActive = false;
                    this.scanner = null;
                }).catch(err => {
                    console.error(err);
                    this.cameraActive = false;
                });
            } else {
                this.cameraActive = false;
            }
        }
    }
}
</script>
</body>
</html>

