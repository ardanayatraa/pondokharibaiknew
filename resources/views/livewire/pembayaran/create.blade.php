<div>
    <x-button wire:click="$set('open', true)" class="bg-green-600 hover:bg-green-700">Tambah Pembayaran</x-button>

    <x-dialog-modal wire:model="open">
        <x-slot name="title">Tambah Pembayaran</x-slot>

        <x-slot name="content">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-label value="Tamu (Guest)" />
                    <select wire:model.defer="guest_id" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Pilih --</option>
                        @foreach ($guests as $guest)
                            <option value="{{ $guest->id_guest }}">{{ $guest->full_name }}</option>
                        @endforeach
                    </select>
                    @error('guest_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label value="Reservasi" />
                    <select wire:model.defer="reservation_id" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Pilih --</option>
                        @foreach ($reservasis as $r)
                            <option value="{{ $r->id_reservation }}">ID #{{ $r->id_reservation }}</option>
                        @endforeach
                    </select>
                    @error('reservation_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label value="Jumlah (Rp)" />
                    <x-input wire:model.defer="amount" type="number" class="w-full" />
                    @error('amount')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label value="Tanggal Bayar" />
                    <x-input wire:model.defer="payment_date" type="date" class="w-full" />
                    @error('payment_date')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label value="Snap Token" />
                    <x-input wire:model.defer="snap_token" class="w-full" />
                    @error('snap_token')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label value="Notifikasi" />
                    <x-input wire:model.defer="notifikasi" class="w-full" />
                    @error('notifikasi')
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
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="store" class="bg-blue-600 hover:bg-blue-700 text-white">Simpan</x-button>
            <x-button wire:click="$set('open', false)" class="bg-gray-500 hover:bg-gray-600 text-white">Batal</x-button>
        </x-slot>
    </x-dialog-modal>
</div>
