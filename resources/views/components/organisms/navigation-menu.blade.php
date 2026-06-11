<nav class="sticky top-0 z-50 pt-6 max-w-7xl mx-auto">
        @php
            $isAdminView = auth()->check() && auth()->user()->role === 'admin';
        @endphp

        <!-- Top Row: General Navigation -->
        <div class="shadow-navbar relative z-10 bg-white text-bark-700 flex items-center justify-between gap-8 px-1 py-1 rounded-4xl">
            <!-- Logo + nama -->
            <a href="/" class="flex items-center ml-4 gap-2.5">
                <span class="font-display text-2xl  font-bold">Pustaka Nusantara</span>
            </a>

            <!-- Right side: Auth/Guest links -->
            <div class="flex items-center gap-2">
                @auth
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <x-atoms.navigation-link type="submit">
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
        </div>

        <!-- Bottom Row: Admin Navigation -->
        @auth
            @if($isAdminView)
                <div class="shadow-navbar relative -mt-13 bg-white text-bark-700 px-1 py-1 pt-15 rounded-3xl">
                    <div class="flex items-center gap-1">
                        <x-atoms.navigation-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                            Dashboard
                        </x-atoms.navigation-link>
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
                        {{-- Add other admin links here --}}
                    </div>
                </div>
            @endif
        @endauth

</nav>
