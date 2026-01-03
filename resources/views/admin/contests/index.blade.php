<x-app-layout>
    <div class="pt-12 pb-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm rounded-lg">
                <div class="mb-10"><h1 class="text-3xl font-extrabold text-gray-900 mt-2 mb-4">Manajemen Kontes</h1></div>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
                @endif

                <a href="{{ route('admin.contests.create') }}" class="bg-black hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded mb-6 inline-flex items-center">+ Buat Kontes Baru</a>

                <div class="overflow-x-auto mt-6 border rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Judul</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Mulai</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Selesai</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Status Aktif</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Status Timeline</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($contests as $contest)
                                @php
                                    $isPast = \Carbon\Carbon::parse($contest->end_date)->isPast();
                                    // SINKRONISASI: Hanya tampil hijau jika dicentang DAN belum berakhir
                                    $isActuallyActive = ($contest->is_active && !$isPast);
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $contest->title }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($contest->start_date)->format('d M Y H:i') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($contest->end_date)->format('d M Y H:i') }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 inline-flex text-xs font-semibold rounded-full {{ $isActuallyActive ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $isActuallyActive ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            if ($isPast) { $tlClass = 'bg-gray-100 text-gray-800'; $tlText = 'Berakhir'; }
                                            elseif (\Carbon\Carbon::parse($contest->start_date)->isFuture()) { $tlClass = 'bg-yellow-100 text-yellow-800'; $tlText = 'Akan Datang'; }
                                            else { $tlClass = 'bg-black text-white'; $tlText = 'Berlangsung'; }
                                        @endphp
                                        <span class="px-2 inline-flex text-xs font-semibold rounded-full {{ $tlClass }}">{{ $tlText }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium flex space-x-4">
                                        <a href="{{ route('admin.contests.edit', $contest) }}" class="text-gray-700 hover:text-black font-semibold">Edit</a>
                                        <form action="{{ route('admin.contests.destroy', $contest) }}" method="POST" onsubmit="return confirm('Hapus?');">
                                            @csrf @method('DELETE')
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