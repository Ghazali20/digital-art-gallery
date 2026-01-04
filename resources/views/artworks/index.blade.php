<x-app-layout>
    <x-slot name="header">
        {{-- Header default dihapus untuk memberi ruang bagi header kustom yang lebih besar --}}
    </x-slot>

    <div class="pt-12 pb-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-6">

                {{-- Notifikasi --}}
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- === HEADER KUSTOM === --}}
                <div class="mb-12 flex flex-col md:flex-row md:items-end md:justify-between gap-6">
                    <div>
                        <p class="text-sm tracking-widest text-gray-500 font-medium uppercase">GALERI PRIBADI</p>
                        <h1 class="text-6xl font-extrabold text-gray-900 mt-2 mb-4">
                            Karya Seni Saya
                        </h1>
                        <p class="text-lg text-gray-700 max-w-3xl">
                            Kelola koleksi karya seni pribadi Anda. Upload, edit, dan bagikan karya terbaik Anda kepada komunitas.
                        </p>
                    </div>

                    {{-- Link Cepat ke Profil Publik --}}
                    @auth
                        <a href="{{ route('profile.show', Auth::id()) }}" class="text-sm font-bold text-black border-b-2 border-black pb-1 hover:text-gray-600 hover:border-gray-600 transition duration-150">
                            Lihat Profil Publik Saya →
                        </a>
                    @endauth
                </div>
                {{-- ======================== --}}

                {{-- === BAR PENCARIAN & FILTER (FITUR BARU) === --}}
                <div class="mb-10 p-6 bg-gray-50 rounded-xl border border-gray-100">
                    <form action="{{ route('artworks.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                        {{-- Input Text --}}
                        <div class="flex-1">
                            <label for="search" class="block text-xs font-bold text-gray-400 uppercase mb-1 ml-1">Cari Judul</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                   placeholder="Ketik judul karya seni..."
                                   class="w-full border-gray-200 rounded-lg focus:ring-black focus:border-black text-sm">
                        </div>

                        {{-- Filter Kategori --}}
                        <div class="w-full md:w-64">
                            <label for="category" class="block text-xs font-bold text-gray-400 uppercase mb-1 ml-1">Kategori</label>
                            <select name="category" id="category"
                                    class="w-full border-gray-200 rounded-lg focus:ring-black focus:border-black text-sm text-gray-600">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex items-end gap-2">
                            <button type="submit" class="bg-black text-white px-6 py-2 rounded-lg font-bold text-sm hover:bg-gray-800 transition shadow-sm">
                                Terapkan
                            </button>

                            @if(request('search') || request('category'))
                                <a href="{{ route('artworks.index') }}" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-red-600 transition underline">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
                {{-- ========================================== --}}

                {{-- KONTROL TOMBOL UPLOAD --}}
                <div class="mb-10">
                    @auth
                        @if (Auth::user()->role !== 'admin')
                            <a href="{{ route('artworks.create') }}" class="bg-black hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded inline-flex items-center transition duration-150">
                                <i class="fas fa-plus mr-2 text-sm"></i> Unggah Karya Baru
                            </a>
                        @elseif (Auth::user()->role === 'admin')
                            <p class="text-sm text-gray-600">Admin mengelola semua karya melalui halaman Moderasi.</p>
                        @endif
                    @endauth
                </div>

                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-semibold text-lg text-gray-900">Daftar Karya Anda</h3>
                    @if(request('search'))
                        <p class="text-sm text-gray-500">Menampilkan hasil untuk: <span class="font-bold text-black">"{{ request('search') }}"</span></p>
                    @endif
                </div>

                @if ($artworks->isEmpty())
                    <div class="text-center py-20 border-2 border-dashed border-gray-100 rounded-2xl">
                        <p class="text-gray-400">Tidak ada karya yang ditemukan.</p>
                        @if(request('search') || request('category'))
                            <a href="{{ route('artworks.index') }}" class="text-black font-bold text-sm underline mt-2 inline-block">Lihat semua karya</a>
                        @endif
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8 mt-4">
                        @foreach ($artworks as $artwork)
                            <div class="bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition duration-500">

                                {{-- Gambar Karya --}}
                                <div class="w-full h-48 overflow-hidden relative group">
                                    <img src="{{ asset('storage/' . $artwork->image_path) }}" alt="{{ $artwork->title }}"
                                         class="w-full h-full object-cover transition duration-700 ease-in-out grayscale group-hover:grayscale-0 group-hover:scale-110">

                                    {{-- Overlay Link --}}
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition duration-300 flex items-center justify-center">
                                        <a href="{{ route('profile.show', Auth::id()) }}" class="opacity-0 group-hover:opacity-100 bg-white text-black text-xs font-bold py-2 px-4 rounded-full shadow-2xl transform translate-y-4 group-hover:translate-y-0 transition duration-300">
                                            Preview di Profil
                                        </a>
                                    </div>
                                </div>

                                <div class="p-4">
                                    <h3 class="font-bold text-lg truncate text-gray-900">{{ $artwork->title }}</h3>
                                    <p class="text-xs font-medium text-gray-400 mb-3 tracking-wider">{{ strtoupper($artwork->category->name ?? 'Umum') }}</p>

                                    {{-- Status Persetujuan --}}
                                    <div class="flex items-center justify-between">
                                        <span class="text-[10px] uppercase tracking-tighter font-bold rounded-full px-3 py-1
                                            {{ $artwork->is_approved ? 'bg-green-50 text-green-600' : 'bg-orange-50 text-orange-600' }}">
                                            {{ $artwork->is_approved ? 'Published' : 'Pending' }}
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between mt-4 border-t border-gray-50 pt-3">
                                        {{-- KONTROL EDIT/HAPUS --}}
                                        @if (Auth::user()->role !== 'admin' && $artwork->user_id === Auth::id())
                                            <div class="flex gap-4 text-xs font-bold uppercase tracking-widest">
                                                <a href="{{ route('artworks.edit', $artwork) }}" class="text-gray-400 hover:text-black transition">Edit</a>

                                                <form action="{{ route('artworks.destroy', $artwork) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus karya ini?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-300 hover:text-red-600 transition">Hapus</button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>