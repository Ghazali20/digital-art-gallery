<x-app-layout>
    <div class="pt-20 pb-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-6">

                {{-- === HEADER KUSTOM: Galeri Terpilih === --}}
                <div class="mb-12">
                    <p class="text-sm tracking-widest text-gray-500 font-medium uppercase">KARYA PILIHAN</p>
                    <h1 class="text-6xl font-extrabold text-gray-900 mt-2 mb-4">
                        Galeri Terpilih
                    </h1>
                    <p class="text-lg text-gray-700 max-w-3xl">
                        Koleksi *curated* dari karya-karya terbaik yang menunjukkan inovasi dan kedalaman emosional, dipilih langsung oleh tim kurator Galeri Seni Mentality.
                    </p>
                </div>
                {{-- ======================================= --}}

                {{-- === GALERI GRID MINIMALIS === --}}
                @if ($selectedArtworks->isEmpty())
                    <p class="text-center text-gray-500">Belum ada karya terpilih yang dapat ditampilkan.</p>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

                        @foreach ($selectedArtworks as $artwork)
                            <div class="bg-white group">

                                {{-- Gambar Karya (Grayscale on Hover) --}}
                                <div class="w-full h-64 overflow-hidden mb-3">
                                    <a href="{{ route('artworks.show', $artwork) }}">
                                        <img src="{{ asset('storage/' . $artwork->image_path) }}"
                                            alt="{{ $artwork->title }}"
                                            class="w-full h-full object-cover shadow-sm transition duration-500 ease-in-out
                                                   grayscale hover:grayscale-0">
                                    </a>
                                </div>

                                {{-- Detail Karya --}}
                                <div class="p-0">
                                    <h4 class="font-semibold text-lg text-gray-900 truncate">{{ $artwork->title }}</h4>
                                    <p class="text-sm text-gray-600 mb-2">{{ $artwork->user->name ?? 'Anonim' }}, {{ $artwork->created_at->year }}</p>

                                    {{-- Link Detail (Menggantikan Jumlah Like) --}}
                                    <div class="flex justify-end items-center mt-2">
                                        {{-- Catatan: Jumlah like dihapus dari sini --}}

                                        <a href="{{ route('artworks.show', $artwork) }}"
                                           class="text-xs text-black hover:text-gray-700 font-medium underline opacity-0 group-hover:opacity-100 transition duration-300">
                                            Lihat Karya &rarr;
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                {{-- ========================================================== --}}

                <div class="mt-16 text-center">
                    <a href="{{ route('dashboard') }}" class="text-black hover:text-gray-700 font-semibold underline inline-flex items-center transition duration-150">
                        Lihat Semua Karya &rarr;
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>