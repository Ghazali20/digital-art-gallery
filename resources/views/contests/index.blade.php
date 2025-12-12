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
                    <p class="text-sm tracking-widest text-gray-500 font-medium uppercase">KOMPETISI SENI</p>
                    <h1 class="text-6xl font-extrabold text-gray-900 mt-2 mb-4">
                        Kompetisi Aktif
                    </h1>
                    <p class="text-lg text-gray-700 max-w-3xl">
                        Ikuti kompetisi seni yang sedang berlangsung dan tunjukkan bakat Anda kepada komunitas seniman Indonesia. Karya terpilih akan dipamerkan di galeri utama dan mendapatkan pengakuan profesional.
                    </p>
                </div>
                {{-- ============================================= --}}

                @if ($contests->isEmpty())
                    <div class="p-8 bg-gray-50 rounded-lg border">
                        <p class="text-gray-600 text-lg">Saat ini, belum ada kompetisi aktif yang tersedia. Tunggu pengumuman selanjutnya!</p>
                    </div>
                @else
                    {{-- Daftar Kontes dengan Layout 2 Kolom --}}
                    <div class="space-y-12">
                        @foreach ($contests as $contest)

                            @php
                                // Tentukan apakah kontes sudah berjalan
                                $isOngoing = $contest->start_date <= now();
                                $statusText = $isOngoing ? 'Berlangsung' : 'Akan Datang';
                            @endphp

                            <div class="flex flex-col lg:flex-row bg-white border rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition duration-300">

                                {{-- Kolom Kiri: Gambar Thumbnail --}}
                                <div class="w-full lg:w-2/5 bg-gray-200 overflow-hidden relative">
                                    {{-- Placeholder Gambar Kontes. Gunakan gambar monokrom sebagai default --}}
                                    <div class="h-64 lg:h-full flex items-center justify-center text-gray-500 text-sm">
                                        {{-- Placeholder gambar dengan class grayscale --}}
                                        <img src="https://picsum.photos/600/400?random={{ $contest->id }}" alt="Thumbnail Kontes"
                                             class="w-full h-full object-cover transition duration-300 ease-in-out grayscale hover:grayscale-0">

                                        {{-- Label Status --}}
                                        <span class="absolute top-4 left-4 bg-black text-white text-xs font-semibold py-1 px-3 rounded-full
                                            {{ $isOngoing ? 'bg-black' : 'bg-gray-700' }}">
                                            {{ $statusText }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Kolom Kanan: Detail Kontes --}}
                                <div class="w-full lg:w-3/5 p-8 flex flex-col justify-between">
                                    <div>
                                        <h2 class="text-3xl font-bold text-gray-900 mb-3">{{ $contest->title }}</h2>
                                        <p class="text-gray-700 mb-6">{{ Str::limit($contest->description, 200) }}</p>

                                        {{-- Periode & Statistik --}}
                                        <div class="space-y-3 text-sm text-gray-700">
                                            <div class="flex items-center space-x-2">
                                                <i class="fas fa-calendar-alt text-black"></i>
                                                <span>Periode Kompetisi:
                                                    <span class="font-semibold">{{ \Carbon\Carbon::parse($contest->start_date)->format('d M Y') }} – {{ \Carbon\Carbon::parse($contest->end_date)->format('d M Y') }}</span>
                                                </span>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <i class="fas fa-users text-black"></i>
                                                <span>Entri Terdaftar:
                                                    <span class="font-semibold">{{ $contest->entries->count() }} Seniman</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Tombol Aksi (Gaya Monokrom Hitam) --}}
                                    <div class="mt-6">
                                        <a href="{{ route('contests.show', $contest) }}"
                                           class="bg-black hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded inline-flex items-center transition duration-150">
                                            Lihat Detail Kompetisi <i class="fas fa-arrow-right ml-2 text-sm"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>

                    {{-- Pagination Links --}}
                    <div class="mt-12">
                        {{ $contests->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>