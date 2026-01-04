<x-app-layout>
    <x-slot name="header">
        <div class="py-6">
            <p class="text-sm tracking-widest text-gray-500 font-medium uppercase">PENGATURAN AKUN</p>
            <h1 class="text-4xl font-extrabold text-gray-900 mt-2">Edit Profil</h1>
        </div>
    </x-slot>

    <div class="pb-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Notifikasi Sukses --}}
            @if (session('success'))
                <div class="bg-black text-white px-6 py-4 rounded-lg shadow-lg mb-6 flex justify-between items-center">
                    <span class="text-sm font-bold tracking-wide">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Bagian 1: Informasi Dasar & Detail Portofolio (Digabung agar tidak bentrok validasi) --}}
            <div class="p-6 sm:p-10 bg-white border border-gray-200 shadow-sm rounded-lg">
                <div class="max-w-2xl">
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-900">Informasi Profil & Portofolio</h3>
                        <p class="text-sm text-gray-600 mt-1">Perbarui identitas dasar dan detail seniman Anda dalam satu langkah mudah.</p>
                    </div>

                    {{-- Pastikan file partial di bawah sudah berisi input Bio, Foto, Nama, dan Email --}}
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Bagian 2: Keamanan Akun (Kata Sandi) --}}
            <div class="p-6 sm:p-10 bg-white border border-gray-200 shadow-sm rounded-lg">
                <div class="max-w-2xl">
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Keamanan Akun</h3>
                        <p class="text-sm text-gray-600 mt-1">Gunakan kata sandi yang kuat untuk melindungi karya dan data Anda.</p>
                    </div>

                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Bagian 3: Area Berbahaya (Hapus Akun) --}}
            <div class="p-6 sm:p-10 bg-white border border-red-100 shadow-sm rounded-lg">
                <div class="max-w-2xl">
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-red-600">Hapus Akun</h3>
                        <p class="text-sm text-gray-600 mt-1">Tindakan ini permanen. Semua koleksi karya seni Anda akan ikut terhapus.</p>
                    </div>

                    @include('profile.partials.delete-user-form')
                </div>
            </div>

            {{-- Navigasi Kembali --}}
            <div class="flex justify-start">
                <a href="{{ route('profile.show', Auth::id()) }}" class="text-sm font-bold text-gray-400 hover:text-black transition duration-150 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Profil
                </a>
            </div>

        </div>
    </div>
</x-app-layout>