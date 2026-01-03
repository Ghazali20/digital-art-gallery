<x-app-layout>
    <x-slot name="header">
        {{-- Header Kustom Monokrom --}}
        <div class="py-6">
            <p class="text-sm tracking-widest text-gray-500 font-medium uppercase">PENGATURAN AKUN</p>
            <h1 class="text-4xl font-extrabold text-gray-900 mt-2">Edit Profil</h1>
        </div>
    </x-slot>

    <div class="pb-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Bagian 1: Informasi Profil (Nama & Email) --}}
            <div class="p-6 sm:p-10 bg-white border border-gray-200 shadow-sm rounded-lg">
                <div class="max-w-2xl">
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Informasi Pribadi</h3>
                        <p class="text-sm text-gray-600 mt-1">Perbarui nama akun dan alamat email Anda. Perubahan nama tidak akan menghilangkan status peran (role) Anda saat ini.</p>
                    </div>

                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Bagian 2: Kata Sandi --}}
            <div class="p-6 sm:p-10 bg-white border border-gray-200 shadow-sm rounded-lg">
                <div class="max-w-2xl">
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Keamanan Akun</h3>
                        <p class="text-sm text-gray-600 mt-1">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk menjaga keamanan.</p>
                    </div>

                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Bagian 3: Hapus Akun --}}
            <div class="p-6 sm:p-10 bg-white border border-red-100 shadow-sm rounded-lg">
                <div class="max-w-2xl">
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-red-600">Hapus Akun</h3>
                        <p class="text-sm text-gray-600 mt-1">Setelah akun Anda dihapus, semua sumber daya dan data yang terkait akan dihapus secara permanen.</p>
                    </div>

                    @include('profile.partials.delete-user-form')
                </div>
            </div>

            {{-- Navigasi Kembali --}}
            <div class="flex justify-start">
                <a href="{{ route('profile.show', Auth::id()) }}" class="text-sm font-bold text-gray-500 hover:text-black transition duration-150 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Profil
                </a>
            </div>

        </div>
    </div>
</x-app-layout>