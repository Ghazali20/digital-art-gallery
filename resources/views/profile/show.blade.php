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
                        {{-- Foto Profil Dinamis --}}
                        <div class="h-24 w-24 rounded-full overflow-hidden border-2 border-black flex items-center justify-center bg-black shrink-0">
                            @if($user->profile_photo)
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-white text-3xl font-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            @endif
                        </div>

                        <div>
                            <h1 class="text-4xl font-extrabold text-gray-900">{{ $user->name }}</h1>
                            <p class="text-gray-500 font-medium uppercase tracking-widest text-sm">
                                Status: <span class="text-black">{{ strtoupper($user->role) }}</span> • Bergabung: {{ $user->created_at->format('M Y') }}
                            </p>
                            {{-- Tautan Sosial Media --}}
                            <div class="flex gap-4 mt-2">
                                @if($user->instagram_handle)
                                    <a href="https://instagram.com/{{ $user->instagram_handle }}" target="_blank" class="text-xs font-bold text-gray-400 hover:text-black transition">
                                        IG: @<span>{{ $user->instagram_handle }}</span>
                                    </a>
                                @endif
                                @if($user->portfolio_link)
                                    <a href="{{ $user->portfolio_link }}" target="_blank" class="text-xs font-bold text-gray-400 hover:text-black transition underline">
                                        Portofolio &rarr;
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- TOMBOL EDIT PROFIL --}}
                    @if(Auth::id() === $user->id)
                        <div class="flex shrink-0">
                            <a href="{{ route('profile.edit') }}"
                               class="bg-black text-white px-6 py-2 text-sm font-bold hover:bg-gray-800 transition duration-200 uppercase tracking-widest shadow-md">
                                Kelola Profil
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Pesan Sukses Update --}}
            @if (session('success'))
                <div class="bg-black text-white px-4 py-3 rounded relative mb-6 text-sm font-bold" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Statistik & Koleksi --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                {{-- Sidebar Info --}}
                <div class="md:col-span-1 space-y-6">
                    {{-- Bio Section --}}
                    <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                        <h3 class="font-bold text-gray-900 mb-3 uppercase text-xs tracking-tighter border-b pb-2">Tentang Seniman</h3>
                        <p class="text-sm text-gray-600 leading-relaxed italic">
                            {{ $user->bio ?? 'Seniman ini belum menuliskan biografi singkat.' }}
                        </p>
                    </div>

                    {{-- Stats Section --}}
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <h3 class="font-bold text-gray-900 mb-4 border-b pb-2 text-xs uppercase">Informasi Akun</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Total Karya</p>
                                <p class="text-xl font-extrabold text-gray-900">{{ $artworks->count() }} Karya</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Kontak</p>
                                <p class="text-sm text-gray-900 truncate">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Grid Karya --}}
                <div class="md:col-span-3">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Koleksi Karya</h2>
                        <div class="h-0.5 flex-grow mx-4 bg-gray-100"></div>
                    </div>

                    @if($artworks->isEmpty())
                        <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-2xl p-12 text-center">
                            <p class="text-gray-400 italic">Belum ada karya yang disetujui untuk ditampilkan secara publik.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($artworks as $artwork)
                                <div class="bg-white border border-gray-100 rounded-xl overflow-hidden hover:shadow-2xl transition duration-500 group">
                                    <div class="relative overflow-hidden h-56">
                                        <a href="{{ route('artworks.show', $artwork) }}">
                                            <img src="{{ asset('storage/' . $artwork->image_path) }}"
                                                 class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition duration-700">
                                        </a>
                                        <div class="absolute bottom-2 left-2">
                                            <span class="bg-black/80 text-white text-[9px] px-2 py-1 rounded uppercase font-bold tracking-widest">
                                                {{ $artwork->category->name ?? 'Umum' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="p-4 border-t border-gray-50">
                                        <h4 class="font-bold text-md truncate text-gray-900">
                                            <a href="{{ route('artworks.show', $artwork) }}" class="hover:underline">{{ $artwork->title }}</a>
                                        </h4>
                                        <p class="text-[10px] text-gray-400 mt-1 uppercase font-medium">
                                            Diupload pada {{ $artwork->created_at->format('d M Y') }}
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