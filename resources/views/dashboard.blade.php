<x-app-layout>
    <x-slot name="header">
        {{-- Header default dihapus --}}
    </x-slot>

    <div class="pt-12 pb-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-6">

                {{-- Notifikasi Sukses --}}
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- === HEADER KUSTOM (Selamat Datang - Gaya Figma) === --}}
                <div class="mb-10">
                    <p class="text-sm tracking-widest text-gray-500 font-medium uppercase mb-2">STATUS AKUN</p>
                    <h1 class="text-5xl font-extrabold text-gray-900">
                        Selamat Datang, {{ strtok(Auth::user()->name, ' ') }}
                    </h1>
                </div>
                {{-- ======================================= --}}

                {{-- === KARTU STATUS BERDASARKAN ROLE (Gaya Monokrom) === --}}
                <div class="p-6 border rounded-lg mb-10 shadow-sm">

                    @if (Auth::user()->role === 'admin')
                        <p class="text-lg font-semibold text-red-700">Administrator</p>
                        <p class="text-sm text-gray-600">Anda memiliki akses penuh ke sistem manajemen kontes dan moderasi karya.</p>
                        <a href="{{ route('admin.contests.index') }}" class="mt-3 inline-block bg-black hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded text-sm transition duration-150">Kelola Kontes</a>

                    @elseif (Auth::user()->role === 'peserta')
                        <p class="text-lg font-semibold text-green-700">Peserta Aktif</p>
                        <p class="text-sm text-gray-600">Anda dapat mengunggah karya, mendaftar kontes, dan memberikan suara.</p>
                        <a href="{{ route('artworks.index') }}" class="mt-3 inline-block text-black hover:text-gray-700 underline font-semibold text-sm">Lihat Karya Saya &rarr;</a>

                    @elseif (Auth::user()->role === 'user')
                        <p class="text-lg font-semibold text-gray-700">Anda saat ini terdaftar sebagai **User Standar**.</p>
                        <p class="text-sm text-gray-600 mb-4">Untuk dapat mendaftarkan diri ke kontes, Anda harus menjadi **Peserta**.</p>
                        <a href="{{ route('user.peserta.create') }}" class="bg-black hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-md shadow-md inline-block transition duration-150">
                            Daftar Sebagai Peserta
                        </a>
                    @endif
                </div>
                {{-- =============================================== --}}

                <hr class="my-10 border-gray-200">

                {{-- === BLOK STATISTIK (MENGGUNAKAN DATA REAL-TIME) === --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-10">

                    {{-- 1. Kompetisi Aktif --}}
                    <div>
                        <div class="text-4xl font-extrabold text-gray-900">{{ number_format($activeContestsCount ?? 0) }}</div>
                        <div class="text-sm text-gray-500 uppercase tracking-wider mt-1">Kompetisi Aktif</div>
                    </div>

                    {{-- 2. Total Karya --}}
                    <div>
                        <div class="text-4xl font-extrabold text-gray-900">{{ number_format($totalArtworksCount ?? 0) }}</div>
                        <div class="text-sm text-gray-500 uppercase tracking-wider mt-1">Total Karya</div>
                    </div>

                    {{-- 3. Seniman Aktif --}}
                    <div>
                        <div class="text-4xl font-extrabold text-gray-900">{{ number_format($activeArtistsCount ?? 0) }}</div>
                        <div class="text-sm text-gray-500 uppercase tracking-wider mt-1">Seniman Aktif</div>
                    </div>

                    {{-- 4. Pengunjung --}}
                    <div>
                        <div class="text-4xl font-extrabold text-gray-900">{{ $formattedTotalVisitors ?? '0' }}</div>
                        <div class="text-sm text-gray-500 uppercase tracking-wider mt-1">Pengunjung</div>
                    </div>

                </div>
                {{-- =============================================== --}}

                <hr class="my-10 border-gray-200">

                {{-- === SEPUTAR EDUKASI SENI === --}}
                <h2 class="text-2xl font-bold text-gray-800 mb-4">💡 Seni & Edukasi</h2>
                <div class="bg-gray-100 p-4 rounded-lg shadow-sm">
                    <p class="mb-3 text-sm text-gray-700">
                        Tahukah Anda? Seni bukan sekadar keindahan visual. Seni adalah media ekspresi yang kuat.
                        Setiap warna yang Anda pilih dan setiap sapuan kuas Anda dapat mencerminkan kondisi mental,
                        sebuah konsep yang dikenal sebagai **Art Therapy**. Dengan memahami psikologi warna, kita bisa menggunakan palet kita tidak hanya untuk membuat karya,
                        tapi juga untuk memproses emosi yang kompleks. Teruslah berkarya!
                    </p>
                </div>
                {{-- =============================== --}}

                {{-- === GALERI GLOBAL KARYA YANG DISETUJUI === --}}
                @if (isset($globalApprovedArtworks) && $globalApprovedArtworks->isNotEmpty())
                    <hr class="my-10 border-gray-200">

                    <h2 class="text-3xl font-bold text-gray-900 mb-4">🌟 Galeri Karya Pilihan (Semua User)</h2>
                    <p class="text-md text-gray-600 mb-6">Lihat karya-karya terbaru yang telah disetujui oleh Admin dan ditampilkan di Galeri Utama.</p>

                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($globalApprovedArtworks as $artwork)
                            <div class="bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition duration-300">
                                <div class="w-full h-40 overflow-hidden">
                                    <a href="{{ route('artworks.show', $artwork) }}">
                                        <img src="{{ asset('storage/' . $artwork->image_path) }}" alt="{{ $artwork->title }}"
                                            class="w-full h-full object-cover transition duration-500 ease-in-out grayscale hover:grayscale-0">
                                    </a>
                                </div>
                                <div class="p-3 flex justify-between items-center">
                                    <div>
                                        <h4 class="font-semibold text-sm truncate text-gray-900">
                                            <a href="{{ route('artworks.show', $artwork) }}" class="hover:text-gray-700">{{ $artwork->title }}</a>
                                        </h4>
                                        <p class="text-xs text-gray-500">Oleh: {{ $artwork->user->name }}</p>
                                    </div>
                                    {{-- BLOK LIKE DIHAPUS TOTAL DI SINI --}}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                {{-- ============================================= --}}
            </div>
        </div>
    </div>
</x-app-layout>