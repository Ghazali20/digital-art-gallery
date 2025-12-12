<x-app-layout>
    <x-slot name="header">
        {{-- Header tidak banyak diubah, tetap clean --}}
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $contest->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Notifikasi (Warna tetap untuk fungsionalitas) --}}
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

                {{-- Bagian Detail Kontes --}}
                <div class="mb-8 pb-6">
                    <h3 class="text-4xl font-extrabold text-gray-900 mb-4">{{ $contest->title }}</h3>
                    <p class="text-gray-600 mb-6 text-lg">{{ $contest->description }}</p>

                    <div class="flex flex-wrap space-x-6 text-sm text-gray-700 border-l-4 pl-4">
                        <div>
                            <span class="font-semibold text-gray-900">Mulai:</span>
                            {{ \Carbon\Carbon::parse($contest->start_date)->format('d M Y, H:i') }}
                        </div>
                        <div>
                            <span class="font-semibold text-gray-900">Berakhir:</span>
                            {{ \Carbon\Carbon::parse($contest->end_date)->format('d M Y, H:i') }}
                        </div>
                        <div>
                            <span class="font-semibold text-gray-900">Entri Total:</span>
                            {{ $entries->count() }}
                        </div>
                    </div>
                </div>

                {{-- Tombol Pendaftaran/Submission (Gaya Tombol Monokrom) --}}
                <div class="mb-8">
                    @auth
                        @if (Auth::user()->role === 'peserta')
                            @if ($contest->end_date > now())
                                {{-- Tombol Hitam/Putih (Sesuai Konsep Desain) --}}
                                <a href="{{ route('contests.createEntry', $contest) }}"
                                   class="bg-black hover:bg-gray-800 text-white font-semibold py-3 px-6 rounded inline-block transition duration-150">
                                    + Daftarkan Karya Anda
                                </a>
                            @else
                                <p class="text-sm text-gray-500">Pendaftaran telah ditutup.</p>
                            @endif
                        @elseif (Auth::user()->role === 'user')
                            <p class="text-sm text-gray-700">Anda adalah User standar. Untuk ikut kontes dan mendaftarkan karya, Anda perlu meng-upgrade akun menjadi **Peserta**.</p>
                        @elseif (Auth::user()->role === 'admin')
                            <p class="text-sm text-gray-700">Administrator tidak diizinkan berpartisipasi atau mendaftarkan karya.</p>
                        @endif
                    @else
                        <p class="text-sm text-gray-700">Silakan <a href="{{ route('login') }}" class="font-bold underline text-black hover:text-gray-700">Login</a> untuk melihat opsi pendaftaran atau memberikan suara.</p>
                    @endauth
                </div>


                {{-- Leaderboard dan Voting --}}
                <h3 class="text-3xl font-bold mt-12 mb-6 text-gray-900">Daftar Karya Kontes</h3>

                @if ($entries->isEmpty())
                    <p class="text-gray-500">Belum ada karya yang terdaftar dalam kontes ini.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                        @foreach ($entries as $index => $entry)
                            @php
                                // Tentukan styling untuk 3 Peringkat Teratas
                                $rankStyle = '';
                                if ($index === 0) {
                                    $rankStyle = 'border-l-4 border-yellow-500 shadow-xl'; // Peringkat 1
                                } elseif ($index === 1) {
                                    $rankStyle = 'border-l-4 border-gray-400 shadow-lg'; // Peringkat 2
                                } elseif ($index === 2) {
                                    $rankStyle = 'border-l-4 border-amber-600 shadow-md'; // Peringkat 3
                                }
                            @endphp

                            <div class="bg-white border p-4 rounded-lg shadow-sm flex flex-col transition duration-300 hover:shadow-xl {{ $rankStyle }}">

                                {{-- Peringkat (Diambil dari index array, tambahkan 1) --}}
                                <div class="text-lg font-extrabold text-gray-900 mb-2">
                                    Peringkat: <span class="{{ $index < 3 ? 'text-4xl' : 'text-xl' }}">{{ $index + 1 }}</span>
                                </div>

                                {{-- Gambar Karya - DENGAN EFEK HOVER WARNA --}}
                                <div class="w-full h-48 overflow-hidden rounded-md mb-3 border">
                                    <img src="{{ asset('storage/' . $entry->artwork->image_path) }}"
                                         alt="{{ $entry->artwork->title }}"
                                         class="w-full h-full object-cover transition duration-500 ease-in-out
                                                grayscale hover:grayscale-0">
                                </div>

                                {{-- Detail Karya --}}
                                <h4 class="text-xl font-bold text-gray-900 truncate">{{ $entry->artwork->title }}</h4>
                                <p class="text-sm text-gray-500 mb-3">Oleh: {{ $entry->artwork->user->name }}</p>

                                {{-- Status Voting --}}
                                <div class="mt-auto pt-3 border-t">
                                    <p class="text-lg font-bold mb-2">
                                        Total Suara: <span class="text-black">{{ $entry->votes_count }}</span>
                                    </p>

                                    @auth
                                        {{-- LOGIC VOTING: HANYA untuk User dan Peserta --}}
                                        @if (Auth::user()->role === 'user' || Auth::user()->role === 'peserta')

                                            @if (!$hasVoted && $contest->end_date > now() && $contest->start_date <= now())
                                                {{-- Form Voting - Tombol Hitam/Putih --}}
                                                <form action="{{ route('contests.vote', $entry) }}" method="POST" class="mt-2">
                                                    @csrf
                                                    <button type="submit" class="bg-black hover:bg-gray-700 text-white py-2 px-4 rounded text-sm transition duration-150 font-semibold w-full">
                                                        Berikan Suara Saya!
                                                    </button>
                                                </form>
                                            @elseif ($hasVoted)
                                                <p class="text-sm text-green-600 font-semibold mt-2">
                                                    Anda sudah memberikan suara.
                                                </p>
                                            @elseif ($contest->end_date < now())
                                                <p class="text-sm text-red-600 mt-2">Voting telah ditutup.</p>
                                            @elseif ($contest->start_date > now())
                                                <p class="text-sm text-gray-500 mt-2">Voting belum dimulai.</p>
                                            @endif

                                        @elseif (Auth::user()->role === 'admin')
                                            <p class="text-sm text-gray-500 mt-2">Administrator tidak dapat memberikan suara.</p>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>