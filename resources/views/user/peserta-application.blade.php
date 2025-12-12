<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Formulir Pendaftaran Peserta') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-2xl font-bold mb-4 text-indigo-700">Tingkatkan Akun Anda Menjadi Peserta</h3>

                    <p class="mb-4 text-gray-700">
                        Dengan menjadi Peserta, Anda dapat mengunggah karya seni Anda ke Galeri Pribadi dan berpartisipasi dalam Kontes Seni yang diselenggarakan.
                    </p>
                    <p class="mb-6 font-semibold text-red-600">
                        *Tindakan ini tidak dapat dibatalkan.*
                    </p>

                    {{-- Form yang mengarah ke route POST upgrade --}}
                    <form method="POST" action="{{ route('user.upgrade') }}">
                        @csrf

                        <div class="bg-gray-50 p-4 rounded-md border mb-6">
                            <label class="block text-gray-700 font-bold mb-2">
                                Detail Akun Anda
                            </label>
                            <div class="text-sm text-gray-600">
                                <p>Nama: {{ Auth::user()->name }}</p>
                                <p>Email: {{ Auth::user()->email }}</p>
                                <p>Peran Saat Ini: {{ ucfirst(Auth::user()->role) }}</p>
                            </div>
                        </div>

                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md shadow-md">
                            Konfirmasi & Daftar sebagai Peserta
                        </button>

                        <a href="{{ route('dashboard') }}" class="ml-4 text-gray-600 hover:text-gray-900">Batal</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>