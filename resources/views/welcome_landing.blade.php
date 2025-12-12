<x-app-layout>

    {{-- HERO SECTION - Memaksa tinggi layar penuh (min-h-screen) dan menengahkan konten --}}
    <div class="min-h-screen flex flex-col items-center justify-center text-center pt-32 pb-32">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <p class="text-sm tracking-widest text-gray-500 font-medium uppercase mb-4">
                GALERI SENI MONOKROM
            </p>

            {{-- JUDUL UTAMA (BOLD TYPOGRAPHY: ukuran font sangat besar) --}}
            <h1 class="text-7xl sm:text-8xl md:text-9xl font-extrabold text-gray-900 leading-none mb-8">
                Mentality.
            </h1>

            <p class="text-xl text-gray-700 mb-12 max-w-2xl mx-auto">
                Jelajahi, pamerkan, dan ikuti kontes karya seni dengan fokus eksklusif pada estetika hitam, putih, dan abu-abu yang elegan.
            </p>

            {{-- Tombol CTA (Call to Action) --}}
            <div class="flex justify-center space-x-6">
                {{-- Tombol Daftar (Primary CTA) --}}
                <a href="{{ route('register') }}"
                   class="bg-black hover:bg-gray-700 text-white font-semibold py-3 px-8 rounded-lg text-lg tracking-wide transition duration-150 shadow-lg">
                    Daftar Sekarang &rarr;
                </a>

                {{-- Tombol Masuk/Jelajahi (Secondary CTA) --}}
                <a href="{{ route('login') }}"
                   class="text-gray-900 hover:text-black font-semibold py-3 px-8 rounded-lg text-lg tracking-wide border border-gray-300 hover:border-black transition duration-150">
                    Masuk
                </a>
            </div>

            <div class="mt-20">
                <p class="text-md text-gray-500">
                    Atau langsung jelajahi:
                    <a href="{{ route('gallery.terpilih') }}" class="text-gray-700 hover:text-black font-medium underline transition duration-150">Galeri Terpilih</a>
                </p>
            </div>

        </div>
    </div>
</x-app-layout>