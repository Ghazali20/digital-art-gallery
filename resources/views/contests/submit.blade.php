<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftarkan Karya untuk Kontes: ') . $contest->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <h3 class="text-lg font-semibold mb-4">Pilih Karya Seni Anda</h3>

                {{-- Status Error/Success --}}
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                {{-- Validasi Error Form --}}
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        Terdapat kesalahan pada input Anda. Pastikan Anda memilih karya yang valid.
                    </div>
                @endif

                @if ($availableArtworks->isEmpty())
                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4">
                        <p>Anda tidak memiliki karya seni yang memenuhi syarat (sudah disetujui dan belum terdaftar di kontes ini).</p>
                        <p class="mt-2 text-sm">Silakan <a href="{{ route('artworks.create') }}" class="font-bold underline">unggah karya baru</a> dan tunggu persetujuan Admin.</p>
                    </div>
                @else
                    <form action="{{ route('contests.storeEntry', $contest) }}" method="POST">
                        @csrf

                        <div class="mb-6">
                            <label for="artwork_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Karya Seni yang Akan Didaftarkan:</label>

                            <select name="artwork_id" id="artwork_id"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('artwork_id') border-red-500 @enderror" required>
                                <option value="">-- Pilih Karya --</option>
                                @foreach ($availableArtworks as $artwork)
                                    <option value="{{ $artwork->id }}" {{ old('artwork_id') == $artwork->id ? 'selected' : '' }}>
                                        {{ $artwork->title }} ({{ Str::limit($artwork->description, 30) }})
                                    </option>
                                @endforeach
                            </select>

                            @error('artwork_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('contests.show', $contest) }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Daftarkan Karya
                            </button>
                        </div>
                    </form>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>