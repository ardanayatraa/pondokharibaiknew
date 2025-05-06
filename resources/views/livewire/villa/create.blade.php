<div>
    <x-button wire:click="$set('open', true)" class="bg-green-600 hover:bg-green-700">
        Tambah Villa
    </x-button>

    <x-dialog-modal wire:model="open">
        <x-slot name="title">Tambah Villa</x-slot>

        <x-slot name="content">
            <div class="flex flex-col gap-4">

                {{-- FASILITAS --}}
                <div>
                    <x-label value="Fasilitas (boleh lebih dari satu)" />
                    @if ($facilities->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
                            @foreach ($facilities as $facility)
                                <label class="flex items-center gap-2 text-sm p-2 rounded hover:bg-gray-100">
                                    <input type="checkbox" wire:model.defer="facility_id"
                                        value="{{ $facility->id_facility }}"
                                        class="text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                    <span>{{ $facility->name_facility }}</span>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <div class="mt-2 p-3 text-sm bg-yellow-50 border border-yellow-200 text-yellow-700 rounded">
                            Silakan atur fasilitas terlebih dahulu.
                        </div>
                    @endif
                    @error('facility_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- HARGA --}}
                <div>
                    <x-label for="villa_pricing_id" value="Harga Villa" />
                    <select wire:model.defer="villa_pricing_id" id="villa_pricing_id"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500">
                        <option value="">-- Pilih Harga --</option>
                        @foreach ($pricings as $pricing)
                            <option value="{{ $pricing->id_villa_pricing }}">
                                ID #{{ $pricing->id_villa_pricing }} ({{ $pricing->season->name ?? 'Tanpa Musim' }})
                            </option>
                        @endforeach
                    </select>
                    @error('villa_pricing_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- KETERSEDIAAN --}}
                <div>
                    <x-label for="cek_ketersediaan_id" value="Cek Ketersediaan (Opsional)" />
                    <select wire:model.defer="cek_ketersediaan_id" id="cek_ketersediaan_id"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500">
                        <option value="">-- Kosongkan Jika Tidak Perlu --</option>
                        @foreach ($ketersediaanList as $item)
                            <option value="{{ $item->id_cek_ketersediaan }}">
                                ID #{{ $item->id_cek_ketersediaan }}: {{ $item->start_date }} - {{ $item->end_date }}
                            </option>
                        @endforeach
                    </select>
                    @error('cek_ketersediaan_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- NAMA --}}
                <div>
                    <x-label for="name" value="Nama Villa" />
                    <x-input wire:model.defer="name" id="name" class="w-full" />
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- DESKRIPSI --}}
                <div>
                    <x-label for="description" value="Deskripsi" />
                    <textarea wire:model.defer="description" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500"></textarea>
                    @error('description')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="store" class="bg-blue-600 hover:bg-blue-700">Simpan</x-button>
            <x-button wire:click="$set('open', false)" class="bg-gray-500 hover:bg-gray-600">Batal</x-button>
        </x-slot>
    </x-dialog-modal>
</div>
