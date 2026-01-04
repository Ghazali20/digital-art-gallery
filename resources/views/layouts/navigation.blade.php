<nav x-data="{ open: false, showNotif: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                {{-- LOGO SVG INLINE MONOKROM --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('landing') }}" class="flex items-center space-x-2 text-gray-900 hover:text-gray-600 transition duration-150">
                        <svg class="block h-8 w-auto fill-current" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <rect width="100" height="100" fill="white"/>
                            <path d="M 15 80 L 15 20 L 50 50 L 85 20 L 85 80" stroke="currentColor" stroke-width="8" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="50" cy="50" r="5" fill="currentColor"/>
                        </svg>
                        <span class="text-lg font-bold ml-2">Mentality</span>
                    </a>
                </div>

                {{-- NAVIGASI DESKTOP UTAMA --}}
                <div class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex items-center">
                    @auth
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @endauth

                    <x-nav-link :href="route('gallery.terpilih')" :active="request()->routeIs('gallery.terpilih')">
                        {{ __('Galeri Terpilih') }}
                    </x-nav-link>

                    <x-nav-link :href="route('contests.index')" :active="request()->routeIs('contests.index')">
                        {{ __('Kompetisi Seni') }}
                    </x-nav-link>

                    @auth
                        @if (Auth::user()->role !== 'admin')
                            <x-nav-link :href="route('artworks.index')" :active="request()->routeIs('artworks.index')">
                                {{ __('Karya Seni Saya') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>

                {{-- Link Admin (Desktop) --}}
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
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                @auth
                    {{-- === FITUR BARU: DROPDOWN NOTIFIKASI === --}}
                    <div class="relative mr-2">
                        <button @click="showNotif = !showNotif; if(showNotif) markAsRead()" class="relative p-1 text-gray-400 hover:text-gray-900 transition focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>

                            {{-- Badge Angka Notifikasi --}}
                            @if(Auth::user()->unreadNotifications->count() > 0)
                                <span id="notif-badge" class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-600 text-[9px] font-bold text-white border border-white">
                                    {{ Auth::user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </button>

                        {{-- Dropdown Isi Notifikasi --}}
                        <div x-show="showNotif" @click.away="showNotif = false" class="absolute right-0 mt-2 w-80 bg-white border border-gray-100 shadow-xl rounded-xl overflow-hidden z-50" x-transition>
                            <div class="px-4 py-3 bg-gray-50 border-b border-gray-100">
                                <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest">Notifikasi</h3>
                            </div>
                            <div class="max-h-80 overflow-y-auto">
                                @forelse(Auth::user()->notifications->take(10) as $notification)
                                    <a href="{{ $notification->data['url'] ?? '#' }}" class="block px-4 py-3 border-b border-gray-50 hover:bg-gray-50 transition {{ $notification->read_at ? 'opacity-60' : '' }}">
                                        <p class="text-[13px] {{ $notification->read_at ? 'text-gray-600' : 'text-black font-semibold' }}">
                                            {{ $notification->data['message'] }}
                                        </p>
                                        <span class="text-[10px] text-gray-400 block mt-1 uppercase">{{ $notification->created_at->diffForHumans() }}</span>
                                    </a>
                                @empty
                                    <div class="px-4 py-8 text-center">
                                        <p class="text-xs text-gray-400 italic">Tidak ada notifikasi baru.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    {{-- Dropdown Profile --}}
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
                            <x-dropdown-link :href="route('profile.show', Auth::id())">{{ __('Profil Saya') }}</x-dropdown-link>
                            <div class="border-t border-gray-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-900 hover:text-gray-600 transition duration-150">{{ __('Login') }}</a>
                    <a href="{{ route('register') }}" class="bg-black hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded text-sm transition duration-150">{{ __('Register') }}</a>
                @endauth
            </div>

            {{-- Hamburger (Mobile) --}}
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
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>

                @if (Auth::user()->role !== 'admin')
                    <x-responsive-nav-link :href="route('artworks.index')" :active="request()->routeIs('artworks.index')">
                        {{ __('Karya Seni Saya') }}
                    </x-responsive-nav-link>
                @endif
            @endauth

            <x-responsive-nav-link :href="route('gallery.terpilih')" :active="request()->routeIs('gallery.terpilih')">
                {{ __('Galeri Terpilih') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('contests.index')" :active="request()->routeIs('contests.index')">
                {{ __('Kompetisi Seni') }}
            </x-responsive-nav-link>

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
        </div>

        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.show', Auth::id())">{{ __('Profil Saya') }}</x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>

{{-- SCRIPT AJAX UNTUK MARK AS READ --}}
<script>
    function markAsRead() {
        // Hanya kirim request jika badge ada (masih ada notif unread)
        const badge = document.getElementById('notif-badge');
        if (badge) {
            fetch("{{ route('notifications.markAsRead') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    badge.remove(); // Hapus angka merah dari UI
                }
            })
            .catch(error => console.error('Error marking notifications as read:', error));
        }
    }
</script>