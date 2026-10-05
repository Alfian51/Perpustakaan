<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form action="{{ route('peminjaman.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="buku_id" value="Buku" />
                            <select id="buku_id" name="buku_id" required
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm">
                                <option value="">-- Pilih Buku --</option>
                                @foreach ($buku as $item)
                                    <option value="{{ $item->id }}" {{ old('buku_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->judul }} (stok: {{ $item->stok }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('buku_id')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="anggota_id" value="Anggota" />
                            <select id="anggota_id" name="anggota_id" required
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm">
                                <option value="">-- Pilih Anggota --</option>
                                @foreach ($anggota as $item)
                                    <option value="{{ $item->id }}" {{ old('anggota_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama }} ({{ $item->nis }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('anggota_id')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="tanggal_pinjam" value="Tanggal Pinjam" />
                            <x-text-input id="tanggal_pinjam" name="tanggal_pinjam" type="date" class="mt-1 block w-full" :value="old('tanggal_pinjam', date('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('tanggal_pinjam')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="tanggal_kembali" value="Tanggal Rencana Kembali (opsional)" />
                            <x-text-input id="tanggal_kembali" name="tanggal_kembali" type="date" class="mt-1 block w-full" :value="old('tanggal_kembali')" />
                            <x-input-error :messages="$errors->get('tanggal_kembali')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan Peminjaman') }}</x-primary-button>
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
