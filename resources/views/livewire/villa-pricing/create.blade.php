<div>
    <x-button wire:click="$set('open', true)" class="bg-green-600 hover:bg-green-700">Tambah Harga Villa</x-button>

    <x-dialog-modal wire:model="open">
        <x-slot name="title">Tambah Harga Villa</x-slot>

        <x-slot name="content">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-label value="Villa" />
                    <select wire:model="villa_id" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Pilih Villa --</option>
                        @foreach ($villas as $villa)
                            <option value="{{ $villa->id_villa }}">{{ $villa->name }}</option>
                        @endforeach
                    </select>
                    @error('villa_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label value="Season" />
                    <select wire:model="season_id" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Pilih Season --</option>
                        @foreach ($seasons as $season)
                            <option value="{{ $season->id_season }}">{{ $season->nama_season }}</option>
                        @endforeach
                    </select>
                    @error('season_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                @foreach (['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'] as $day)
                    <div>
                        <x-label value="Harga {{ ucfirst($day) }}" />
                        <x-input wire:model.defer="{{ $day . '_pricing' }}" type="number" class="w-full" />
                        @error($day . '_pricing')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                @endforeach
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="store" class="bg-blue-600 hover:bg-blue-700 text-white">Simpan</x-button>
            <x-button wire:click="$set('open', false)" class="bg-gray-500 hover:bg-gray-600 text-white">Batal</x-button>
        </x-slot>
    </x-dialog-modal>
</div>
