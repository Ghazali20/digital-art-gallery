<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Moderasi & Kurasi Galeri') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b-4 border-black">

                @if (session('success'))
                    <div class="bg-black text-white px-4 py-3 rounded relative mb-4 font-bold text-sm" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-600 text-white px-4 py-3 rounded relative mb-4 font-bold text-sm" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Alert Error Validasi (Penting untuk Alasan Penolakan) --}}
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-xs font-bold">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if ($artworks->isEmpty())
                    <p class="mt-4 text-gray-600 italic text-center py-10">Belum ada karya seni yang diunggah ke sistem.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Karya</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Detail & Seniman</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Status</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-widest">Pilihan Galeri</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-widest">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach ($artworks as $artwork)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($artwork->image_path)
                                                <img src="{{ asset('storage/' . $artwork->image_path) }}" alt="{{ $artwork->title }}" class="w-20 h-20 object-cover rounded-lg border border-gray-200 shadow-sm">
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-extrabold text-gray-900">{{ $artwork->title }}</div>
                                            <div class="text-xs text-gray-500 uppercase font-medium mt-1">{{ $artwork->category->name ?? 'Umum' }}</div>
                                            <div class="text-xs text-black font-bold mt-2">Oleh: {{ $artwork->user->name ?? 'User Dihapus' }}</div>
                                            <div class="text-[10px] text-gray-400 mt-1 italic uppercase tracking-tighter">{{ $artwork->created_at->format('d M Y, H:i') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($artwork->is_approved)
                                                <span class="px-3 py-1 text-[10px] font-bold leading-5 rounded-full bg-green-100 text-green-800 uppercase tracking-wider">Approved</span>
                                            @else
                                                <span class="px-3 py-1 text-[10px] font-bold leading-5 rounded-full bg-yellow-100 text-yellow-800 uppercase tracking-wider">Pending</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <form action="{{ route('admin.moderation.toggleSelect', $artwork) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="transition duration-200 {{ $artwork->is_selected ? 'text-yellow-500 scale-125' : 'text-gray-300 hover:text-yellow-400' }}"
                                                        title="{{ $artwork->is_selected ? 'Hapus dari Pilihan' : 'Jadikan Karya Pilihan' }}">
                                                    <svg class="w-8 h-8 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                </button>
                                            </form>
                                            @if($artwork->is_selected)
                                                <span class="text-[9px] font-bold text-yellow-600 uppercase tracking-widest">Terpilih</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <div class="flex justify-end items-center space-x-3">
                                                {{-- Tombol Approve --}}
                                                @if(!$artwork->is_approved)
                                                    <form action="{{ route('admin.moderation.approve', $artwork) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                                class="bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded text-[10px] uppercase tracking-widest transition"
                                                                onclick="return confirm('Setujui karya ini? Notifikasi akan dikirim ke seniman.');">
                                                            Approve
                                                        </button>
                                                    </form>
                                                @endif

                                                {{-- Form Reject dengan Input Alasan --}}
                                                <form action="{{ route('admin.moderation.reject', $artwork) }}" method="POST" class="flex items-center space-x-2">
                                                    @csrf
                                                    @method('DELETE')

                                                    <input type="text"
                                                           name="reason"
                                                           placeholder="Alasan tolak..."
                                                           required
                                                           class="text-[10px] border-gray-300 rounded px-2 py-1 focus:ring-black focus:border-black w-32 tracking-tighter">

                                                    <button type="submit"
                                                            class="bg-white border border-red-600 text-red-600 hover:bg-red-600 hover:text-white font-bold py-2 px-3 rounded text-[10px] uppercase tracking-widest transition"
                                                            onclick="return confirm('Tolak dan hapus permanen karya ini? Alasan akan dikirim ke seniman.');">
                                                        Reject
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8">
                        {{ $artworks->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>