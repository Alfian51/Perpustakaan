<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pengembalian / Edit Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                        Buku: <strong>{{ $peminjaman->buku->judul ?? '-' }}</strong><br>
                        Anggota: <strong>{{ $peminjaman->anggota->nama ?? '-' }}</strong><br>
                        Tgl Pinjam: <strong>{{ $peminjaman->tanggal_pinjam }}</strong>
                    </div>

                    <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="status" value="Status" />
                            <select id="status" name="status" required
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm">
                                <option value="dipinjam" {{ old('status', $peminjaman->status) === 'dipinjam' ? 'selected' : '' }}>dipinjam</option>
                                <option value="kembali" {{ old('status', $peminjaman->status) === 'kembali' ? 'selected' : '' }}>kembali</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="tanggal_kembali" value="Tanggal Kembali" />
                            <x-text-input id="tanggal_kembali" name="tanggal_kembali" type="date" class="mt-1 block w-full" :value="old('tanggal_kembali', $peminjaman->tanggal_kembali)" />
                            <x-input-error :messages="$errors->get('tanggal_kembali')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
                            <a href="{{ route('peminjaman.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 underline">
                                Kembali
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
