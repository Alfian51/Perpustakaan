<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form action="{{ route('buku.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="kode_buku" value="Kode Buku" />
                            <x-text-input id="kode_buku" name="kode_buku" type="text" class="mt-1 block w-full" :value="old('kode_buku')" />
                            <x-input-error :messages="$errors->get('kode_buku')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="judul" value="Judul" />
                            <x-text-input id="judul" name="judul" type="text" class="mt-1 block w-full" :value="old('judul')" />
                            <x-input-error :messages="$errors->get('judul')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="pengarang" value="Pengarang" />
                            <x-text-input id="pengarang" name="pengarang" type="text" class="mt-1 block w-full" :value="old('pengarang')" />
                            <x-input-error :messages="$errors->get('pengarang')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="penerbit" value="Penerbit" />
                            <x-text-input id="penerbit" name="penerbit" type="text" class="mt-1 block w-full" :value="old('penerbit')" />
                            <x-input-error :messages="$errors->get('penerbit')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="tahun_terbit" value="Tahun Terbit" />
                            <x-text-input id="tahun_terbit" name="tahun_terbit" type="number" class="mt-1 block w-full" :value="old('tahun_terbit')" />
                            <x-input-error :messages="$errors->get('tahun_terbit')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="stok" value="Stok" />
                            <x-text-input id="stok" name="stok" type="number" class="mt-1 block w-full" :value="old('stok')" />
                            <x-input-error :messages="$errors->get('stok')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                            <a href="{{ route('buku.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 underline">
                                Kembali
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
