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

                {{-- === HEADER KUSTOM (Sesuai Konsep Desain) === --}}
                <div class="mb-12">
                    <p class="text-sm tracking-widest text-gray-500 font-medium uppercase">GALERI PRIBADI</p>
                    <h1 class="text-6xl font-extrabold text-gray-900 mt-2 mb-4">
                        Karya Seni Saya
                    </h1>
                    <p class="text-lg text-gray-700 max-w-3xl mb-8">
                        Kelola koleksi karya seni pribadi Anda. Upload, edit, dan bagikan karya terbaik Anda kepada komunitas seniman dan pecinta seni di platform kami.
                    </p>
                </div>
                {{-- ============================================= --}}

                {{-- KONTROL TOMBOL UPLOAD: Tampilkan untuk User dan Peserta --}}
                <div class="mb-10">
                    @auth
                        @if (Auth::user()->role !== 'admin')
                            {{-- Tombol Upload (Gaya Monokrom Hitam) --}}
                            <a href="{{ route('artworks.create') }}" class="bg-black hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded inline-flex items-center transition duration-150">
                                <i class="fas fa-plus mr-2 text-sm"></i> Unggah Karya Baru
                            </a>
                        @elseif (Auth::user()->role === 'admin')
                            <p class="text-sm text-gray-600">Admin mengelola semua karya melalui halaman Moderasi.</p>
                        @endif
                    @endauth
                </div>

                <h3 class="font-semibold text-lg mb-6 text-gray-900">Daftar Karya Anda</h3>

                @if ($artworks->isEmpty())
                    <p class="mt-4 text-gray-600">Anda belum mengunggah karya seni apapun.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8 mt-4">
                        @foreach ($artworks as $artwork)
                            <div class="bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition duration-300">

                                {{-- Gambar Karya - DENGAN EFEK HOVER WARNA --}}
                                <div class="w-full h-48 overflow-hidden">
                                    <img src="{{ asset('storage/' . $artwork->image_path) }}" alt="{{ $artwork->title }}"
                                         class="w-full h-full object-cover transition duration-500 ease-in-out grayscale hover:grayscale-0">
                                </div>

                                <div class="p-4">
                                    <h3 class="font-bold text-lg truncate text-gray-900">{{ $artwork->title }}</h3>
                                    <p class="text-sm text-gray-500 mb-3">{{ $artwork->category->name ?? 'Tanpa Kategori' }}</p>

                                    {{-- Status Persetujuan --}}
                                    <span class="text-xs font-semibold mt-1 inline-block rounded px-2 py-0.5
                                        {{ $artwork->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $artwork->is_approved ? 'Disetujui' : 'Menunggu Moderasi' }}
                                    </span>

                                    <div class="flex items-center justify-between mt-4 border-t pt-3">

                                        {{-- KONTROL EDIT/HAPUS --}}
                                        @if (Auth::user()->role !== 'admin' && $artwork->user_id === Auth::id())
                                            <div class="space-x-3 text-sm">
                                                {{-- Tautan Edit dan Hapus disesuaikan ke monokrom/aksi --}}
                                                <a href="{{ route('artworks.edit', $artwork) }}" class="text-gray-700 hover:text-black font-semibold">Edit</a>

                                                <form action="{{ route('artworks.destroy', $artwork) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus karya ini?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Hapus</button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-400">Tersedia</span>
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