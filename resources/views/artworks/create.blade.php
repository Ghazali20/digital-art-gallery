<x-app-layout>
    <x-slot name="header">
        {{-- Header default dihapus --}}
    </x-slot>

    <div class="pt-12 pb-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- === HEADER KUSTOM === --}}
            <div class="mb-12">
                <p class="text-sm tracking-widest text-gray-500 font-medium uppercase">GALERI PRIBADI</p>
                <h1 class="text-6xl font-extrabold text-gray-900 mt-2 mb-4">
                    Unggah Karya Baru
                </h1>
            </div>
            {{-- ======================= --}}

            {{-- Grid Utama: Panduan (kiri) vs. Form (kanan) --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                {{-- Kolom Kiri: Panduan Upload & Tips (Sesuai Konsep Desain) --}}
                <div class="lg:col-span-1 space-y-10">

                    {{-- Panduan Upload --}}
                    <div>
                        <h2 class="text-xl font-bold mb-4 text-gray-900">Panduan Upload</h2>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li class="border-l-2 border-gray-900 pl-3">
                                <span class="font-semibold">Resolusi Tinggi:</span> Upload gambar dengan resolusi minimal 1920px untuk memastikan kualitas tampilan yang optimal.
                            </li>
                            <li class="border-l-2 border-gray-900 pl-3">
                                <span class="font-semibold">Pencahayaan:</span> Pastikan foto karya memiliki pencahayaan yang merata dan tidak *overexposed*.
                            </li>
                            <li class="border-l-2 border-gray-900 pl-3">
                                <span class="font-semibold">Format File:</span> Gunakan format JPG atau PNG untuk hasil terbaik.
                            </li>
                        </ul>
                    </div>

                    {{-- Tips Popularitas --}}
                    <div>
                        <h2 class="text-xl font-bold mb-4 text-gray-900">Tips Popularitas</h2>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li class="border-l-2 border-gray-500 pl-3">
                                <span class="font-semibold">Deskripsi Menarik:</span> Ceritakan proses kreatif, inspirasi, dan makna di balik karya Anda.
                            </li>
                            <li class="border-l-2 border-gray-500 pl-3">
                                <span class="font-semibold">Konsistensi:</span> Upload karya secara konsisten untuk membangun portfolio yang kuat.
                            </li>
                            <li class="border-l-2 border-gray-500 pl-3">
                                <span class="font-semibold">Ikuti Kompetisi:</span> Partisipasi aktif dalam kompetisi dapat meningkatkan eksposur.
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Kolom Kanan: Formulir Upload Karya --}}
                <div class="lg:col-span-2 bg-white border p-8 rounded-lg shadow-xl">

                    {{-- Notifikasi Error Umum --}}
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h3 class="text-2xl font-bold mb-6 text-gray-900">Isi Detail Karya</h3>

                    <form method="POST" action="{{ route('artworks.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="space-y-6">

                            {{-- Input Judul --}}
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Karya</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-black focus:ring-black @error('title') border-red-500 @enderror">
                                @error('title')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Input Kategori --}}
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                                <select name="category_id" id="category_id" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-black focus:ring-black @error('category_id') border-red-500 @enderror">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Input File Gambar --}}
                            <div>
                                <label for="image_file" class="block text-sm font-medium text-gray-700 mb-1">File Gambar (Max 2MB, JPG/PNG)</label>
                                <input type="file" name="image_file" id="image_file" required
                                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 @error('image_file') border-red-500 @enderror">
                                @error('image_file')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Input Deskripsi --}}
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi (Opsional)</label>
                                <textarea name="description" id="description" rows="4"
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-black focus:ring-black @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Tombol Submit (Gaya Monokrom Hitam) --}}
                        <div class="mt-8 flex justify-end">
                            <button type="submit" class="bg-black hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-md transition duration-150 shadow-md">
                                Unggah dan Ajukan Moderasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>