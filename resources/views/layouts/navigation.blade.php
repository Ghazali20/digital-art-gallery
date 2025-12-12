<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">

                {{-- LOGO SVG INLINE MONOKROM --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('landing') }}" class="flex items-center space-x-2 text-gray-900 hover:text-gray-600 transition duration-150">

                        {{-- START: KODE SVG MONOKROM (Mentality Gallery) --}}
                        <svg class="block h-8 w-auto fill-current" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <rect width="100" height="100" fill="white"/>

                            <path d="M 15 80 L 15 20 L 50 50 L 85 20 L 85 80"
                                stroke="currentColor"
                                stroke-width="8"
                                fill="none"
                                stroke-linecap="round"
                                stroke-linejoin="round"/>

                            <circle cx="50" cy="50" r="5" fill="currentColor"/>
                        </svg>
                        {{-- END: KODE SVG MONOKROM --}}

                        <span class="text-lg font-bold ml-2">Mentality</span>
                    </a>
                </div>

                {{-- NAVIGASI DESKTOP UTAMA --}}
                <div class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex items-center">

                    @auth
                        {{-- 1. Dashboard (Dipindahkan ke posisi paling kiri untuk user yang sudah login) --}}
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @endauth

                    {{-- 2. Galeri Terpilih (Publik) --}}
                    <x-nav-link :href="route('gallery.terpilih')" :active="request()->routeIs('gallery.terpilih')">
                        {{ __('Galeri Terpilih') }}
                    </x-nav-link>

                    {{-- 3. Kompetisi Seni (Publik) --}}
                    <x-nav-link :href="route('contests.index')" :active="request()->routeIs('contests.index')">
                        {{ __('Kompetisi Seni') }}
                    </x-nav-link>

                    @auth
                        {{-- 4. Karya Seni Saya (HANYA TAMPIL JIKA USER BUKAN ADMIN) --}}
                        @if (Auth::user()->role !== 'admin')
                            <x-nav-link :href="route('artworks.index')" :active="request()->routeIs('artworks.index')">
                                {{ __('Karya Seni Saya') }}
                            </x-nav-link>
                        @endif
                    @endauth

                </div>

                {{-- START: Link Admin (Desktop) --}}
                @if (Auth::check() && Auth::user()->role === 'admin')
                    <div class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex items-center border-l pl-6">
                        <x-nav-link :href="route('admin.contests.index')" :active="request()->routeIs('admin.contests.index')">
                            {{ __('Kelola Kontes') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.index')">
                            {{ __('Kategori') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.moderation.index')" :active="request()->routeIs('admin.moderation.index')">
                            {{ __('Moderasi Karya') }}
                        </x-nav-link>
                    </div>
                @endif
                {{-- END: Link Admin --}}
            </div>

            {{-- Dropdown Profile & Login/Register Buttons (Desktop) --}}
            @auth
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-semibold rounded-md text-gray-900 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            @else
            {{-- TAMPILAN JIKA BELUM LOGIN: Link Login dan Register (Desktop) --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-900 hover:text-gray-600 transition duration-150">
                    {{ __('Login') }}
                </a>
                <a href="{{ route('register') }}" class="bg-black hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded text-sm transition duration-150">
                    {{ __('Register') }}
                </a>
            </div>
            @endauth

            {{-- Hamburger --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- NAVIGASI MOBILE RESPONSIF --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">

            @auth
                {{-- Tautan User Login (Dashboard di atas) --}}
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>

                {{-- Karya Seni Saya (HANYA TAMPIL JIKA BUKAN ADMIN) --}}
                @if (Auth::user()->role !== 'admin')
                    <x-responsive-nav-link :href="route('artworks.index')" :active="request()->routeIs('artworks.index')">
                        {{ __('Karya Seni Saya') }}
                    </x-responsive-nav-link>
                @endif
            @endauth

            {{-- Tautan Publik (Diposisikan di bawah dashboard/karya saya) --}}
            <x-responsive-nav-link :href="route('gallery.terpilih')" :active="request()->routeIs('gallery.terpilih')">
                {{ __('Galeri Terpilih') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('contests.index')" :active="request()->routeIs('contests.index')">
                {{ __('Kompetisi Seni') }}
            </x-responsive-nav-link>

            {{-- START: Link Admin (Mobile) --}}
            @if (Auth::check() && Auth::user()->role === 'admin')
                <div class="border-t border-gray-200 mt-2 pt-2">
                    <div class="px-4 text-xs font-semibold uppercase text-gray-500">Admin Menu</div>
                    <x-responsive-nav-link :href="route('admin.contests.index')" :active="request()->routeIs('admin.contests.index')">
                        {{ __('Kelola Kontes') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.index')">
                        {{ __('Kategori') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.moderation.index')" :active="request()->routeIs('admin.moderation.index')">
                        {{ __('Moderasi Karya') }}
                    </x-responsive-nav-link>
                </div>
            @endif
            {{-- END: Link Admin --}}
        </div>

        @auth
            {{-- Profil Logout Mobile --}}
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            {{-- TAMPILAN JIKA BELUM LOGIN: Link Login dan Register (Mobile) --}}
            <div class="border-t border-gray-200 pt-2">
                <x-responsive-nav-link :href="route('login')">
                    {{ __('Login') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')">
                    {{ __('Register') }}
                </x-responsive-nav-link>
            </div>
        @endauth
    </div>
</nav>