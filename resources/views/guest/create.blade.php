<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-sm text-gray-800">Tambah Guest</h2>
    </x-slot>

    <div class="py-2">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="w-full mb-4 bg-white dark:bg-gray-900 py-4  px-6">
                <h2 class="text-sm font-bold">
                    Tambah Guest
                </h2>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6">
                <form action="{{ route('guest.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <x-label for="username" value="Username" />
                            <x-input id="username" name="username" type="text" class="mt-1 block w-full"
                                :value="old('username')" required autofocus />
                            @error('username')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <x-label for="email" value="Email" />
                            <x-input id="email" name="email" type="email" class="mt-1 block w-full"
                                :value="old('email')" required />
                            @error('email')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <x-label for="password" value="Password" />
                            <x-input id="password" name="password" type="password" class="mt-1 block w-full"
                                required />
                            @error('password')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="password_confirmation" value="Konfirmasi Password" />
                            <x-input id="password_confirmation" name="password_confirmation" type="password"
                                class="mt-1 block w-full" required />
                        </div>
                        <div>
                            <x-label for="full_name" value="Nama Lengkap" />
                            <x-input id="full_name" name="full_name" type="text" class="mt-1 block w-full"
                                :value="old('full_name')" required />
                            @error('full_name')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="md:col-span-3">
                            <x-label for="address" value="Alamat" />
                            <textarea id="address" name="address" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="2">{{ old('address') }}</textarea>
                            @error('address')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="phone_number" value="Nomor Telepon" />
                            <x-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full"
                                :value="old('phone_number')" />
                            @error('phone_number')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <x-label for="id_card_number" value="No. KTP" />
                            <x-input id="id_card_number" name="id_card_number" type="text" class="mt-1 block w-full"
                                :value="old('id_card_number')" />
                            @error('id_card_number')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <x-label for="passport_number" value="No. Passport" />
                            <x-input id="passport_number" name="passport_number" type="text"
                                class="mt-1 block w-full" :value="old('passport_number')" />
                            @error('passport_number')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="birthdate" value="Tanggal Lahir" />
                            <x-input id="birthdate" name="birthdate" type="date" class="mt-1 block w-full"
                                :value="old('birthdate')" />
                            @error('birthdate')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="gender" value="Jenis Kelamin" />
                            <select id="gender" name="gender"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">-- Pilih --</option>
                                <option value="male" @selected(old('gender') == 'male')>Laki-laki</option>
                                <option value="female" @selected(old('gender') == 'female')>Perempuan</option>
                            </select>
                            @error('gender')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-4">
                        <a href="{{ route('guest.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100">
                            Batal
                        </a>
                        <x-button>
                            Simpan
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
