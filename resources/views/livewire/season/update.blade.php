<div>

    <x-dialog-modal wire:model="open">
        <x-slot name="title">Tambah Season</x-slot>

        <x-slot name="content">
            <div class="flex flex-col gap-4">
                <div>
                    <x-label value="Nama Season" />
                    <x-input wire:model.defer="nama_season" class="w-full" />
                    @error('nama_season')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label value="Tanggal Mulai" />
                    <x-input type="date" wire:model.defer="tgl_mulai_season" class="w-full" />
                    @error('tgl_mulai_season')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label value="Tanggal Akhir" />
                    <x-input type="date" wire:model.defer="tgl_akhir_season" class="w-full" />
                    @error('tgl_akhir_season')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="update" class="bg-blue-600 hover:bg-blue-700">Simpan</x-button>
            <x-button wire:click="$set('open', false)" class="bg-gray-500 hover:bg-gray-600">Batal</x-button>
        </x-slot>
    </x-dialog-modal>
</div>
