<div>

    <x-dialog-modal wire:model="open">
        <x-slot name="title">Tambah Guest</x-slot>

        <x-slot name="content">
            <div class="flex flex-col gap-4">
                <div>
                    <x-label value="Username" />
                    <x-input wire:model.defer="username" class="w-full" />
                    @error('username')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label value="Password" />
                    <x-input type="password" wire:model.defer="password" class="w-full" />
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label value="Email" />
                    <x-input wire:model.defer="email" type="email" class="w-full" />
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label value="Nama Lengkap" />
                    <x-input wire:model.defer="full_name" class="w-full" />
                    @error('full_name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label value="Alamat" />
                    <x-input wire:model.defer="address" class="w-full" />
                    @error('address')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label value="No. Telepon" />
                    <x-input wire:model.defer="phone_number" class="w-full" />
                    @error('phone_number')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label value="No. KTP" />
                    <x-input wire:model.defer="id_card_number" class="w-full" />
                    @error('id_card_number')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label value="No. Passport" />
                    <x-input wire:model.defer="passport_number" class="w-full" />
                    @error('passport_number')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label value="Tanggal Lahir" />
                    <x-input type="date" wire:model.defer="birthdate" class="w-full" />
                    @error('birthdate')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-label value="Jenis Kelamin" />
                    <select wire:model.defer="gender" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Pilih --</option>
                        <option value="male">Laki-laki</option>
                        <option value="female">Perempuan</option>
                    </select>
                    @error('gender')
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
