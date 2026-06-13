<nav x-data="{ mobileMenuOpen: false }" class="sticky top-0 z-50 pt-6 p-4 max-w-7xl mx-auto">
    @php
        $isAdmin = auth()->check() && auth()->user()->role === 'admin';
        // Sub-navigasi admin hanya muncul jika user sedang mengakses route dengan prefix 'admin.'
        $isInAdminArea = request()->routeIs('admin.*');
    @endphp

    {{-- BARIS ATAS: Navigasi Utama & Auth --}}
    <div class="shadow-navbar relative z-20 bg-white flex items-center justify-between gap-8 px-1 py-1 rounded-4xl">
        {{-- Logo --}}
        <a href="/" class="flex items-center ml-4 gap-2.5">
            <span class="font-display text-2xl font-bold pl-2 text-bark-500">Pustaka Nusantara</span>
        </a>

        {{-- Navigasi Desktop (Tengah/Kiri) --}}
        <div class="hidden md:flex items-center gap-2">
            <x-atoms.navigation-link href="/" :active="request()->is('/')">
                Home
            </x-atoms.navigation-link>

            <x-atoms.navigation-link href="/catalog" :active="request()->is('catalog')">
                Catalog
            </x-atoms.navigation-link>

            {{-- Link Dashboard dipindah ke Navigasi Utama --}}
            @if($isAdmin)
                <x-atoms.navigation-link href="{{ route('admin.dashboard') }}" :active="$isInAdminArea">
                    Dashboard
                </x-atoms.navigation-link>
            @endif
        </div>

        {{-- Area Auth Desktop (Kanan) --}}
        <div class="hidden md:flex items-center gap-2 pr-1">
            @auth
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <x-atoms.navigation-link type="submit" class="text-terra-500 hover:bg-terra-50">
                        Logout
                    </x-atoms.navigation-link>
                </form>
            @else
                <x-atoms.navigation-link href="{{ route('show.login') }}" class="font-semibold bg-terra-400 hover:bg-terra-500 text-white">
                    Masuk
                </x-atoms.navigation-link>
                <x-atoms.navigation-link href="{{ route('show.register') }}">
                    Daftar
                </x-atoms.navigation-link>
            @endauth
        </div>

        {{-- Tombol Hamburger Mobile --}}
        <div class="flex md:hidden pr-3">
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-dusty hover:text-bark-800 focus:outline-none p-2 rounded-full hover:bg-cream-100 transition-colors">
                <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    {{-- BARIS BAWAH: Sub-Navigasi Admin CRUD --}}
    {{-- HANYA MUNCUL JIKA (User adalah Admin) DAN (Sedang di area Admin) --}}
    @if($isAdmin && $isInAdminArea)
        <div class="hidden md:block shadow-navbar relative -mt-13 bg-white text-bark-700 px-1 py-1 pt-15 rounded-3xl z-10">
            <div class="flex flex-wrap items-center lg:justify-start justify-left gap-1">
                {{-- Route Dashboard dihapus dari sini karena sudah pindah ke atas --}}
                <x-atoms.navigation-link href="{{ route('admin.books.index') }}" :active="request()->routeIs('admin.books.*')">
                    Books
                </x-atoms.navigation-link>
                <x-atoms.navigation-link href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.users.*')">
                    User
                </x-atoms.navigation-link>
                <x-atoms.navigation-link href="{{ route('admin.items.index') }}" :active="request()->routeIs('admin.items.*')">
                    Items
                </x-atoms.navigation-link>
                <x-atoms.navigation-link href="{{ route('admin.reservations.index') }}" :active="request()->routeIs('admin.reservations.*')">
                    Reservations
                </x-atoms.navigation-link>
                <x-atoms.navigation-link href="{{ route('admin.loans.index') }}" :active="request()->routeIs('admin.loans.*')">
                    Loans
                </x-atoms.navigation-link>
                <x-atoms.navigation-link href="{{ route('admin.fines.index') }}" :active="request()->routeIs('admin.fines.*')">
                    Fines
                </x-atoms.navigation-link>
                <x-atoms.navigation-link href="{{ route('admin.authors.index') }}" :active="request()->routeIs('admin.authors.*')">
                    Authors
                </x-atoms.navigation-link>
                <x-atoms.navigation-link href="{{ route('admin.genres.index') }}" :active="request()->routeIs('admin.genres.*')">
                    Genres
                </x-atoms.navigation-link>
                <x-atoms.navigation-link href="{{ route('admin.publishers.index') }}" :active="request()->routeIs('admin.publishers.*')">
                    Publishers
                </x-atoms.navigation-link>
            </div>
        </div>
    @endif

    {{-- MENU DROPDOWN MOBILE --}}
    <div
        x-show="mobileMenuOpen"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="md:hidden absolute top-24 left-4 right-4 bg-white shadow-navbar rounded-3xl p-4 flex flex-col gap-2 z-40 border border-cream-200"
    >
        {{-- Navigasi Utama Mobile --}}
        <div class="flex flex-col gap-1 border-b border-cream-200 pb-3 mb-1">
            <x-atoms.navigation-link href="/" :active="request()->is('/')" class="justify-start">Home</x-atoms.navigation-link>
            <x-atoms.navigation-link href="/catalog" :active="request()->is('catalog')" class="justify-start">Catalog</x-atoms.navigation-link>
            @if($isAdmin)
                <x-atoms.navigation-link href="{{ route('admin.dashboard') }}" :active="$isInAdminArea" class="justify-start">Dashboard</x-atoms.navigation-link>
            @endif
        </div>

        {{-- Sub-Navigasi Admin Mobile (Hanya muncul jika di area Admin) --}}
        @if($isAdmin && $isInAdminArea)
            <div class="text-xs font-bold text-dusty uppercase tracking-wider pl-2 mb-1 mt-2">Menu Kelola Data</div>
            <div class="flex flex-col gap-1 border-b border-cream-200 pb-3 mb-1">
                <x-atoms.navigation-link href="{{ route('admin.books.index') }}" :active="request()->routeIs('admin.books.*')" class="justify-start">Books</x-atoms.navigation-link>
                <x-atoms.navigation-link href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.users.*')" class="justify-start">User</x-atoms.navigation-link>
                <x-atoms.navigation-link href="{{ route('admin.items.index') }}" :active="request()->routeIs('admin.items.*')" class="justify-start">Items</x-atoms.navigation-link>
                <x-atoms.navigation-link href="{{ route('admin.reservations.index') }}" :active="request()->routeIs('admin.reservations.*')" class="justify-start">Reservations</x-atoms.navigation-link>
                <x-atoms.navigation-link href="{{ route('admin.loans.index') }}" :active="request()->routeIs('admin.loans.*')" class="justify-start">Loans</x-atoms.navigation-link>
                <x-atoms.navigation-link href="{{ route('admin.fines.index') }}" :active="request()->routeIs('admin.fines.*')" class="justify-start">Fines</x-atoms.navigation-link>
                <x-atoms.navigation-link href="{{ route('admin.authors.index') }}" :active="request()->routeIs('admin.authors.*')" class="justify-start">Authors</x-atoms.navigation-link>
                <x-atoms.navigation-link href="{{ route('admin.genres.index') }}" :active="request()->routeIs('admin.genres.*')" class="justify-start">Genres</x-atoms.navigation-link>
                <x-atoms.navigation-link href="{{ route('admin.publishers.index') }}" :active="request()->routeIs('admin.publishers.*')" class="justify-start">Publishers</x-atoms.navigation-link>
            </div>
        @endif

        {{-- Area Auth Mobile --}}
        @auth
            <form action="{{ route('logout') }}" method="POST" class="w-full mt-1">
                @csrf
                <x-atoms.navigation-link type="submit" class="w-full justify-center text-red-500 hover:bg-red-50 hover:text-red-600">
                    Logout
                </x-atoms.navigation-link>
            </form>
        @else
            <x-atoms.navigation-link href="{{ route('show.login') }}" class="w-full justify-center font-semibold bg-terra-400 hover:bg-terra-500 text-white mt-2">
                Masuk
            </x-atoms.navigation-link>
            <x-atoms.navigation-link href="{{ route('show.register') }}" class="w-full justify-center">
                Daftar
            </x-atoms.navigation-link>
        @endauth
    </div>
</nav>
