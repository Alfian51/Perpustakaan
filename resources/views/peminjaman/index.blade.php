<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <a href="{{ route('peminjaman.create') }}"
                           class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            + Tambah Peminjaman
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 border">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">No</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Buku</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Anggota</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Tgl Pinjam</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Tgl Kembali</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($peminjaman as $item)
                                    <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2">{{ $item->buku->judul ?? '-' }}</td>
                                        <td class="px-4 py-2">{{ $item->anggota->nama ?? '-' }}</td>
                                        <td class="px-4 py-2">{{ $item->tanggal_pinjam }}</td>
                                        <td class="px-4 py-2">{{ $item->tanggal_kembali ?? '-' }}</td>
                                        <td class="px-4 py-2">
                                            @if ($item->status === 'dipinjam')
                                                <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">dipinjam</span>
                                            @else
                                                <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">kembali</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            @if ($item->status === 'dipinjam')
                                                <form action="{{ route('peminjaman.kembalikan', $item->id) }}"
                                                      method="POST" class="inline"
                                                      onsubmit="return confirm('Tandai buku ini sudah dikembalikan?')">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit"
                                                            class="bg-green-500 hover:bg-green-700 text-white text-sm font-bold py-1 px-3 rounded mr-1">
                                                        Kembalikan
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('peminjaman.edit', $item->id) }}"
                                               class="inline-block bg-yellow-500 hover:bg-yellow-700 text-white text-sm font-bold py-1 px-3 rounded mr-1">
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-4 text-center text-gray-500">
                                            Data peminjaman tidak ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
