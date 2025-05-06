<x-dialog-modal wire:model="open">
    <x-slot name="title">Edit Reservasi</x-slot>

    <x-slot name="content">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-label value="Tamu (Guest)" />
                <select wire:model.defer="guest_id" class="w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">-- Pilih Guest --</option>
                    @foreach ($guests as $guest)
                        <option value="{{ $guest->id_guest }}">{{ $guest->full_name }}</option>
                    @endforeach
                </select>
                @error('guest_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-label value="Villa" />
                <select wire:model.defer="villa_id" class="w-full border-gray-300 rounded-md shadow-sm">
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
                <x-label value="Cek Ketersediaan (Opsional)" />
                <select wire:model.defer="cek_ketersediaan_id" class="w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">-- Pilih --</option>
                    @foreach ($ketersediaan as $item)
                        <option value="{{ $item->id_cek_ketersediaan }}">
                            {{ $item->start_date }} s.d. {{ $item->end_date }}
                        </option>
                    @endforeach
                </select>
                @error('cek_ketersediaan_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-label value="Harga (Villa Pricing)" />
                <select wire:model.defer="villa_pricing_id" class="w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">-- Pilih Harga --</option>
                    @foreach ($pricings as $pricing)
                        <option value="{{ $pricing->id_villa_pricing }}">ID #{{ $pricing->id_villa_pricing }}</option>
                    @endforeach
                </select>
                @error('villa_pricing_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-label value="Tanggal Mulai" />
                <x-input type="date" wire:model.defer="start_date" class="w-full" />
                @error('start_date')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-label value="Tanggal Akhir" />
                <x-input type="date" wire:model.defer="end_date" class="w-full" />
                @error('end_date')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-label value="Status" />
                <x-input wire:model.defer="status" class="w-full" />
                @error('status')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-label value="Total Bayar (Rp)" />
                <x-input wire:model.defer="total_amount" type="number" class="w-full" />
                @error('total_amount')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-button wire:click="update" class="bg-blue-600 hover:bg-blue-700 text-white">Update</x-button>
        <x-button wire:click="$set('open', false)" class="bg-gray-500 hover:bg-gray-600 text-white">Batal</x-button>
    </x-slot>
</x-dialog-modal>
