<x-app-layout>
    <div class="pt-20 pb-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-6">

                {{-- === HEADER KUSTOM: Galeri Terpilih === --}}
                <div class="mb-16 border-l-8 border-black pl-8">
                    <p class="text-sm tracking-[0.3em] text-gray-500 font-bold uppercase">CURATED COLLECTION</p>
                    <h1 class="text-7xl font-black text-gray-900 mt-2 mb-4 tracking-tighter">
                        Galeri Terpilih
                    </h1>
                    <p class="text-xl text-gray-600 max-w-2xl leading-relaxed">
                        Koleksi eksklusif karya seni yang telah melalui proses kurasi ketat, dipilih berdasarkan orisinalitas, teknik, dan visi artistik yang luar biasa.
                    </p>
                </div>
                {{-- ======================================= --}}

                {{-- === GALERI GRID MINIMALIS === --}}
                @if ($selectedArtworks->isEmpty())
                    <div class="py-20 text-center border-2 border-dashed border-gray-100 rounded-3xl">
                        <p class="text-gray-400 italic">Belum ada karya pilihan kurator untuk saat ini.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">

                        @foreach ($selectedArtworks as $artwork)
                            <div class="group relative bg-white transition duration-500">

                                {{-- Gambar Karya (Hover Effect) --}}
                                <div class="relative w-full aspect-[4/5] overflow-hidden mb-4 bg-gray-50">
                                    <a href="{{ route('artworks.show', $artwork) }}">
                                        <img src="{{ asset('storage/' . $artwork->image_path) }}"
                                            alt="{{ $artwork->title }}"
                                            class="w-full h-full object-cover transition duration-700 ease-in-out
                                                   grayscale group-hover:grayscale-0 group-hover:scale-105">
                                    </a>

                                    {{-- Badge Kategori --}}
                                    <div class="absolute top-4 left-4">
                                        <span class="bg-black text-white text-[10px] font-bold px-3 py-1 uppercase tracking-widest shadow-lg">
                                            {{ $artwork->category->name ?? 'Art' }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Detail Karya --}}
                                <div class="space-y-1">
                                    <h4 class="font-black text-2xl text-gray-900 tracking-tight leading-none group-hover:underline decoration-2">
                                        <a href="{{ route('artworks.show', $artwork) }}">{{ $artwork->title }}</a>
                                    </h4>

                                    <div class="flex justify-between items-end pt-2">
                                        <div>
                                            <p class="text-sm font-bold text-gray-800 uppercase tracking-tighter">
                                                {{ $artwork->user->name ?? 'Anonim' }}
                                            </p>
                                            <p class="text-xs text-gray-400 font-medium">
                                                Dibuat pada {{ $artwork->created_at->format('M Y') }}
                                            </p>
                                        </div>

                                        <a href="{{ route('artworks.show', $artwork) }}"
                                           class="inline-flex items-center text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 group-hover:text-black transition duration-300">
                                            Eksplorasi &rarr;
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                {{-- ========================================================== --}}

                {{-- Footer Navigasi --}}
                <div class="mt-24 pt-8 border-t border-gray-100 flex flex-col items-center">
                    <p class="text-gray-400 text-sm mb-6 uppercase tracking-widest font-medium">Ingin melihat lebih banyak?</p>
                    <a href="{{ route('dashboard') }}" class="px-10 py-4 bg-black text-white text-xs font-bold uppercase tracking-[0.3em] hover:bg-gray-800 transition duration-300 shadow-xl">
                        Kembali ke Galeri Publik
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>