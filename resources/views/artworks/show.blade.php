<x-app-layout>
    <div class="pt-20 pb-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-6">

                {{-- === BREADCRUMB MINIMALIS === --}}
                <div class="mb-8 text-sm text-gray-500">
                    @guest
                        <a href="{{ url('/') }}" class="hover:underline">Beranda</a>
                    @else
                        <a href="{{ route('gallery.terpilih') }}" class="hover:underline">Galeri Terpilih</a>
                    @endguest
                    &rarr;
                    <span class="font-semibold text-gray-800">{{ $artwork->title }}</span>
                </div>

                <div class="flex flex-col md:flex-row gap-12">

                    {{-- 1. BAGIAN KIRI: TAMPILAN KARYA --}}
                    <div class="md:w-3/5 w-full">
                        <div class="w-full h-auto overflow-hidden shadow-xl border border-gray-100">
                            <img src="{{ asset('storage/' . $artwork->image_path) }}"
                                 alt="{{ $artwork->title }}"
                                 class="w-full h-full object-cover transition duration-500 ease-in-out
                                        grayscale hover:grayscale-0">
                        </div>

                        {{-- Metadata Bawah (Mobile/Tablet Only) --}}
                        <div class="mt-4 md:hidden">
                            <h1 class="text-4xl font-extrabold text-gray-900 mb-2">{{ $artwork->title }}</h1>
                            <p class="text-lg text-gray-700">Oleh: <span class="font-semibold">{{ $artwork->user->name ?? 'Anonim' }}</span>, {{ $artwork->created_at->year }}</p>
                            <p class="text-sm text-gray-500 mb-4">Kategori: {{ $artwork->category->name ?? 'Tidak ada' }}</p>

                            {{-- Like Button dan Counter (DIHAPUS TOTAL) --}}

                            <hr class="my-6 border-gray-100">

                            <h3 class="text-xl font-bold text-gray-900 mb-3">Deskripsi Karya</h3>
                            <p class="text-gray-700 whitespace-pre-line">{{ $artwork->description }}</p>

                        </div>
                    </div>

                    {{-- 2. BAGIAN KANAN: DETAIL & DESKRIPSI --}}
                    <div class="md:w-2/5 w-full">

                        {{-- Metadata Atas (Desktop Only) --}}
                        <div class="hidden md:block sticky top-20">
                            <h1 class="text-6xl font-extrabold text-gray-900 mb-4">{{ $artwork->title }}</h1>
                            <p class="text-xl text-gray-700">Oleh: <span class="font-bold">{{ $artwork->user->name ?? 'Anonim' }}</span>, {{ $artwork->created_at->year }}</p>
                            <p class="text-md text-gray-500 mb-6">Kategori: {{ $artwork->category->name ?? 'Tidak ada' }}</p>

                            {{-- Like Button dan Counter (DIHAPUS TOTAL) --}}

                            <hr class="my-6 border-gray-100">

                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Deskripsi Karya</h3>
                            <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $artwork->description }}</p>

                            {{-- Placeholder untuk Komentar atau Aksi Lain --}}
                            <div class="mt-10">
                                @guest
                                    <a href="{{ url('/') }}" class="text-black hover:text-gray-700 font-semibold underline inline-flex items-center transition duration-150">
                                        Kembali ke Beranda &rarr;
                                    </a>
                                @else
                                    <a href="{{ route('gallery.terpilih') }}" class="text-black hover:text-gray-700 font-semibold underline inline-flex items-center transition duration-150">
                                        Kembali ke Galeri Terpilih &rarr;
                                    </a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- SCRIPT JIKA MENGGUNAKAN FUNGSI LIKE ASYNC (DIHAPUS TOTAL) --}}
    {{-- @auth @push('scripts') ... @endpush @endauth --}}
</x-app-layout>