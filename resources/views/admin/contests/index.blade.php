<x-app-layout>
    <x-slot name="header">
        {{-- Header default dihapus untuk memberi ruang bagi header kustom yang lebih besar --}}
    </x-slot>

    <div class="pt-12 pb-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-6">

                {{-- === HEADER KUSTOM (Manajemen Kontes) === --}}
                <div class="mb-10">
                    <h1 class="text-3xl font-extrabold text-gray-900 mt-2 mb-4">
                        Manajemen Kontes
                    </h1>
                </div>
                {{-- ======================================= --}}

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Tombol Buat Kontes Baru (Gaya Monokrom Hitam) --}}
                <a href="{{ route('admin.contests.create') }}" class="bg-black hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded mb-6 inline-flex items-center transition duration-150">
                    + Buat Kontes Baru
                </a>

                @if ($contests->isEmpty())
                    <p class="mt-4 text-gray-600">Belum ada kontes yang dibuat.</p>
                @else
                    <div class="overflow-x-auto mt-6 border rounded-lg shadow-sm">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50"> {{-- Latar belakang kepala tabel diubah --}}
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Judul</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Mulai</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Selesai</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status Aktif</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status Timeline</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($contests as $contest)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $contest->title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ \Carbon\Carbon::parse($contest->start_date)->format('d M Y H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ \Carbon\Carbon::parse($contest->end_date)->format('d M Y H:i') }}</td>

                                        {{-- Status Aktif (Kontrol Manual Admin) --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $contest->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $contest->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        </td>

                                        {{-- Status Timeline (Otomatis berdasarkan Tanggal) --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                if (\Carbon\Carbon::parse($contest->end_date)->lessThanOrEqualTo(now())) {
                                                    $statusClass = 'bg-gray-100 text-gray-800';
                                                    $statusText = 'Berakhir';
                                                } elseif (\Carbon\Carbon::parse($contest->start_date)->greaterThan(now())) {
                                                    $statusClass = 'bg-yellow-100 text-yellow-800';
                                                    $statusText = 'Akan Datang';
                                                } else {
                                                    $statusClass = 'bg-black text-white'; // Kontes Berlangsung, gunakan warna Aksi Hitam
                                                    $statusText = 'Berlangsung';
                                                }
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                                {{ $statusText }}
                                            </span>
                                        </td>

                                        {{-- Aksi (Edit/Hapus) --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex space-x-4">
                                            <a href="{{ route('admin.contests.edit', $contest) }}" class="text-gray-700 hover:text-black font-semibold">Edit</a>

                                            <form action="{{ route('admin.contests.destroy', $contest) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kontes ini?');">
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
                    <div class="mt-4">
                        {{ $contests->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>