<x-app-layout>
    <x-slot name="header">
        {{-- Header profil kustom untuk menggantikan header default --}}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Header Profil --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 mb-6 border-b-4 border-black">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div class="flex items-center space-x-6">
                        <div class="h-24 w-24 bg-black text-white rounded-full flex items-center justify-center text-3xl font-bold shrink-0">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h1 class="text-4xl font-extrabold text-gray-900">{{ $user->name }}</h1>
                            <p class="text-gray-500 font-medium uppercase tracking-widest text-sm">
                                Status: <span class="text-black">{{ $user->role }}</span> • Bergabung: {{ $user->created_at->format('M Y') }}
                            </p>
                        </div>
                    </div>

                    {{-- TOMBOL EDIT PROFIL: Hanya muncul jika melihat profil sendiri --}}
                    @if(Auth::id() === $user->id)
                        <div class="flex shrink-0">
                            <a href="{{ route('profile.edit') }}"
                               class="bg-white border-2 border-black text-black px-6 py-2 text-sm font-bold hover:bg-black hover:text-white transition duration-200 uppercase tracking-widest">
                                Edit Profil
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Pesan Sukses Update --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Statistik & Koleksi --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                {{-- Sidebar Info --}}
                <div class="md:col-span-1">
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <h3 class="font-bold text-gray-900 mb-4 border-b pb-2">Informasi Akun</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">Total Karya</p>
                                <p class="text-xl font-extrabold text-gray-900">{{ $artworks->count() }} Karya</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">Email</p>
                                <p class="text-sm text-gray-900 truncate">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Grid Karya --}}
                <div class="md:col-span-3">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Koleksi Karya</h2>
                        <div class="h-1 flex-grow mx-4 bg-gray-100"></div>
                    </div>

                    @if($artworks->isEmpty())
                        <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-lg p-12 text-center">
                            <p class="text-gray-500 italic">Belum ada karya yang disetujui untuk ditampilkan di profil publik.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($artworks as $artwork)
                                <div class="bg-white border rounded-lg overflow-hidden hover:shadow-xl transition group">
                                    <div class="relative overflow-hidden h-48">
                                        <img src="{{ asset('storage/' . $artwork->image_path) }}"
                                             class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-500">
                                    </div>
                                    <div class="p-4 border-t">
                                        <h4 class="font-bold text-lg truncate text-gray-900">{{ $artwork->title }}</h4>
                                        <p class="text-xs text-gray-500 font-medium uppercase tracking-tighter">
                                            {{ $artwork->category->name ?? 'Uncategorized' }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>