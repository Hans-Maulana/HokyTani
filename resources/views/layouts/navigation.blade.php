<nav x-data="{ open: false }" class="bg-slate-900 text-white border-b border-slate-800 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-4 lg:gap-8">
                {{-- Logo --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-brand-500 flex items-center justify-center text-white font-bold shadow-md shadow-brand-500/30">
                            <i class="fa-solid fa-leaf text-lg"></i>
                        </div>
                        <div class="hidden sm:block">
                            <span class="text-base font-extrabold tracking-tight text-white flex items-center gap-1">
                                HOKY<span class="text-brand-400">TANI</span>
                            </span>
                            <span class="block text-[9px] font-bold text-emerald-400 uppercase tracking-wider">Admin Panel</span>
                        </div>
                    </a>
                </div>

                {{-- Navigation Links (desktop only) --}}
                <div class="hidden lg:flex items-center space-x-1">
                    <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-xl text-xs font-bold transition-colors flex items-center gap-2 {{ request()->routeIs('admin.dashboard') ? 'bg-brand-600 text-white shadow' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-gauge-high"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="px-3 py-2 rounded-xl text-xs font-bold transition-colors flex items-center gap-2 {{ request()->routeIs('admin.products.*') ? 'bg-brand-600 text-white shadow' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-box"></i> Produk
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="px-3 py-2 rounded-xl text-xs font-bold transition-colors flex items-center gap-2 {{ request()->routeIs('admin.categories.*') ? 'bg-brand-600 text-white shadow' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-layer-group"></i> Kategori
                    </a>
                    <a href="{{ route('admin.problems.index') }}" class="px-3 py-2 rounded-xl text-xs font-bold transition-colors flex items-center gap-2 {{ request()->routeIs('admin.problems.*') ? 'bg-brand-600 text-white shadow' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-bug"></i> Hama
                    </a>
                    <a href="{{ route('admin.store_map') }}" class="px-3 py-2 rounded-xl text-xs font-bold transition-colors flex items-center gap-2 {{ request()->routeIs('admin.store_map') ? 'bg-brand-600 text-white shadow' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-map-location-dot text-amber-400"></i> Denah
                    </a>
                    <a href="{{ route('admin.racks.index') }}" class="px-3 py-2 rounded-xl text-xs font-bold transition-colors flex items-center gap-2 {{ request()->routeIs('admin.racks.*') ? 'bg-brand-600 text-white shadow' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-pen-ruler text-amber-400"></i> Edit Denah
                    </a>
                </div>
            </div>

            {{-- Right: Landing page + user + hamburger --}}
            <div class="flex items-center gap-2">
                <a href="{{ route('landing') }}" target="_blank" class="hidden lg:flex text-xs font-bold bg-slate-800 hover:bg-slate-700 text-emerald-300 px-3 py-2 rounded-xl transition-colors border border-slate-700 items-center gap-2">
                    <i class="fa-solid fa-globe"></i> Landing
                </a>

                {{-- User Dropdown (sm+) --}}
                <div class="hidden sm:block">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-2 px-3 py-2 border border-slate-700 text-xs font-bold rounded-xl text-slate-200 bg-slate-800 hover:bg-slate-700 transition">
                                <i class="fa-solid fa-user-gear text-brand-400"></i>
                                <span class="hidden md:inline">{{ Auth::user()->name }}</span>
                                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                <i class="fa-solid fa-id-card mr-2"></i> {{ __('Profile Admin') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="fa-solid fa-right-from-bracket mr-2 text-red-500"></i> {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                {{-- Hamburger (mobile, hidden on lg) --}}
                <button @click="open = !open" class="lg:hidden inline-flex items-center justify-center p-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 transition">
                    <i x-show="!open" class="fa-solid fa-bars text-lg"></i>
                    <i x-show="open" class="fa-solid fa-xmark text-lg" x-cloak></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Dropdown Menu --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-end="opacity-0 -translate-y-1"
         class="lg:hidden bg-slate-900 border-t border-slate-800 px-4 pt-3 pb-5 space-y-1"
         x-cloak>

        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 px-3 pb-1">Menu Navigasi</p>

        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-bold transition {{ request()->routeIs('admin.dashboard') ? 'bg-brand-600 text-white' : 'text-slate-200 hover:bg-slate-800' }}">
            <i class="fa-solid fa-gauge-high w-4 text-center text-sm"></i> Dashboard
        </a>
        <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-bold transition {{ request()->routeIs('admin.products.*') ? 'bg-brand-600 text-white' : 'text-slate-200 hover:bg-slate-800' }}">
            <i class="fa-solid fa-box w-4 text-center text-sm"></i> Kelola Produk
        </a>
        <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-bold transition {{ request()->routeIs('admin.categories.*') ? 'bg-brand-600 text-white' : 'text-slate-200 hover:bg-slate-800' }}">
            <i class="fa-solid fa-layer-group w-4 text-center text-sm"></i> Kelola Kategori
        </a>
        <a href="{{ route('admin.problems.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-bold transition {{ request()->routeIs('admin.problems.*') ? 'bg-brand-600 text-white' : 'text-slate-200 hover:bg-slate-800' }}">
            <i class="fa-solid fa-bug w-4 text-center text-sm"></i> Hama & Penyakit
        </a>
        <a href="{{ route('admin.store_map') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-bold transition {{ request()->routeIs('admin.store_map') ? 'bg-brand-600 text-white' : 'text-slate-200 hover:bg-slate-800' }}">
            <i class="fa-solid fa-map-location-dot w-4 text-center text-sm text-amber-400"></i> Denah Toko
        </a>
        <a href="{{ route('admin.racks.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-bold transition {{ request()->routeIs('admin.racks.*') ? 'bg-brand-600 text-white' : 'text-slate-200 hover:bg-slate-800' }}">
            <i class="fa-solid fa-pen-ruler w-4 text-center text-sm text-amber-400"></i> Edit Denah
        </a>

        <div class="border-t border-slate-800 pt-3 mt-2 space-y-1">
            <a href="{{ route('landing') }}" target="_blank" class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-bold text-emerald-400 hover:bg-slate-800 transition">
                <i class="fa-solid fa-globe w-4 text-center text-sm"></i> Lihat Landing Page
            </a>
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-bold text-slate-200 hover:bg-slate-800 transition sm:hidden">
                <i class="fa-solid fa-id-card w-4 text-center text-sm"></i> Profile
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-3 text-sm font-bold text-red-400 hover:bg-slate-800 rounded-xl transition">
                    <i class="fa-solid fa-right-from-bracket w-4 text-center text-sm"></i> Logout
                </button>
            </form>
        </div>
    </div>
</nav>
