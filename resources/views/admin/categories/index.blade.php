<x-app-layout>
    <x-slot name="header">
        {{-- Header default dihapus untuk memberi ruang bagi header kustom yang lebih besar --}}
    </x-slot>

    <div class="pt-12 pb-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-6">

                {{-- === HEADER KUSTOM (Manajemen Kategori) === --}}
                <div class="mb-10">
                    <h1 class="text-3xl font-extrabold text-gray-900 mt-2 mb-4">
                        Manajemen Kategori
                    </h1>
                </div>
                {{-- ======================================= --}}

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                {{-- Tombol Tambah Kategori Baru (Gaya Monokrom Hitam) --}}
                <a href="{{ route('admin.categories.create') }}" class="bg-black hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded mb-6 inline-flex items-center transition duration-150">
                    + Tambah Kategori Baru
                </a>

                {{-- Tabel Kategori (Gaya Monokrom) --}}
                <div class="overflow-x-auto mt-6 border rounded-lg shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Slug</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($categories as $category)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $category->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $category->slug }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-4">
                                    {{-- Tautan Edit dan Hapus disesuaikan ke monokrom/aksi --}}
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="text-gray-700 hover:text-black font-semibold">Edit</a>

                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>