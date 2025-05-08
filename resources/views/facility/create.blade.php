<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-sm text-gray-800">Tambah Facility</h2>
    </x-slot>

    <div class="py-2">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="w-full mb-4 bg-white dark:bg-gray-900 py-4  px-6">
                <h2 class="text-sm font-bold">
                    Tambah Facility
                </h2>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6">
                <form action="{{ route('facility.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <x-label for="name_facility" value="Nama Facility" />
                            <x-input id="name_facility" name="name_facility" type="text" class="mt-1 block w-full"
                                :value="old('name_facility')" required autofocus />
                            @error('name_facility')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="description" value="Deskripsi" />
                            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="facility_type" value="Tipe Facility" />
                            <select id="facility_type" name="facility_type"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>
                                <option value="" disabled {{ old('facility_type') ? '' : 'selected' }}>Pilih tipe
                                    fasilitas</option>
                                <option value="amenities" {{ old('facility_type') == 'amenities' ? 'selected' : '' }}>
                                    Amenities</option>
                                <option value="non_amenities"
                                    {{ old('facility_type') == 'non_amenities' ? 'selected' : '' }}>Non Amenities
                                </option>
                            </select>
                            @error('facility_type')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="mt-6 flex justify-end space-x-4">
                        <a href="{{ route('facility.index') }}"
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
