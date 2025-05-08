{{-- resources/views/season/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-sm text-gray-800">Edit Season</h2>
    </x-slot>

    <div class="py-2">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="w-full mb-4 bg-white dark:bg-gray-900 py-4  px-6">
                <h2 class="text-sm font-bold">
                    Edit Season
                </h2>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6">
                <form action="{{ route('season.update', $season) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="space-y-6">
                        <div>
                            <x-label for="nama_season" value="Nama Season" />
                            <x-input id="nama_season" name="nama_season" type="text" class="mt-1 block w-full"
                                :value="old('nama_season', $season->nama_season)" required autofocus />
                            @error('nama_season')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <x-label for="tgl_mulai_season" value="Tanggal Mulai" />
                            <x-input id="tgl_mulai_season" name="tgl_mulai_season" type="date"
                                class="mt-1 block w-full" :value="old('tgl_mulai_season', $season->tgl_mulai_season)" required />
                            @error('tgl_mulai_season')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <x-label for="tgl_akhir_season" value="Tanggal Akhir" />
                            <x-input id="tgl_akhir_season" name="tgl_akhir_season" type="date"
                                class="mt-1 block w-full" :value="old('tgl_akhir_season', $season->tgl_akhir_season)" required />
                            @error('tgl_akhir_season')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-4">
                        <a href="{{ route('season.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100">
                            Batal
                        </a>
                        <x-button>
                            Update
                        </x-button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
