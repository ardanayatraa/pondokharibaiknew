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

                        <div>
                            <x-label for="icon" value="Icon" />
                            <select id="icon" name="icon"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="fa-check-circle"
                                    {{ old('icon') == 'fa-check-circle' ? 'selected' : '' }}>Default (Check Circle)
                                </option>

                                <optgroup label="Bedroom/Living">
                                    <option value="fa-bed" {{ old('icon') == 'fa-bed' ? 'selected' : '' }}>Bed</option>
                                    <option value="fa-couch" {{ old('icon') == 'fa-couch' ? 'selected' : '' }}>
                                        Couch/Sofa</option>
                                </optgroup>

                                <optgroup label="Kitchen">
                                    <option value="fa-kitchen-set"
                                        {{ old('icon') == 'fa-kitchen-set' ? 'selected' : '' }}>Kitchen Set</option>
                                    <option value="fa-refrigerator"
                                        {{ old('icon') == 'fa-refrigerator' ? 'selected' : '' }}>Refrigerator</option>
                                    <option value="fa-microwave" {{ old('icon') == 'fa-microwave' ? 'selected' : '' }}>
                                        Microwave</option>
                                    <option value="fa-fire" {{ old('icon') == 'fa-fire' ? 'selected' : '' }}>Stove/Fire
                                    </option>
                                    <option value="fa-mug-hot" {{ old('icon') == 'fa-mug-hot' ? 'selected' : '' }}>
                                        Coffee</option>
                                </optgroup>

                                <optgroup label="Bathroom">
                                    <option value="fa-bath" {{ old('icon') == 'fa-bath' ? 'selected' : '' }}>Bath
                                    </option>
                                    <option value="fa-shower" {{ old('icon') == 'fa-shower' ? 'selected' : '' }}>Shower
                                    </option>
                                    <option value="fa-toilet" {{ old('icon') == 'fa-toilet' ? 'selected' : '' }}>Toilet
                                    </option>
                                </optgroup>

                                <optgroup label="Entertainment">
                                    <option value="fa-tv" {{ old('icon') == 'fa-tv' ? 'selected' : '' }}>TV</option>
                                    <option value="fa-wifi" {{ old('icon') == 'fa-wifi' ? 'selected' : '' }}>WiFi
                                    </option>
                                    <option value="fa-gamepad" {{ old('icon') == 'fa-gamepad' ? 'selected' : '' }}>Game
                                    </option>
                                </optgroup>

                                <optgroup label="Outdoor">
                                    <option value="fa-swimming-pool"
                                        {{ old('icon') == 'fa-swimming-pool' ? 'selected' : '' }}>Swimming Pool
                                    </option>
                                    <option value="fa-leaf" {{ old('icon') == 'fa-leaf' ? 'selected' : '' }}>Garden
                                    </option>
                                    <option value="fa-door-open" {{ old('icon') == 'fa-door-open' ? 'selected' : '' }}>
                                        Balcony</option>
                                    <option value="fa-mountain" {{ old('icon') == 'fa-mountain' ? 'selected' : '' }}>
                                        Terrace/Mountain View</option>
                                </optgroup>

                                <optgroup label="Services">
                                    <option value="fa-car" {{ old('icon') == 'fa-car' ? 'selected' : '' }}>Parking
                                    </option>
                                    <option value="fa-utensils" {{ old('icon') == 'fa-utensils' ? 'selected' : '' }}>
                                        Restaurant/Food</option>
                                    <option value="fa-broom" {{ old('icon') == 'fa-broom' ? 'selected' : '' }}>Cleaning
                                    </option>
                                </optgroup>

                                <optgroup label="Amenities">
                                    <option value="fa-snowflake" {{ old('icon') == 'fa-snowflake' ? 'selected' : '' }}>
                                        AC</option>
                                    <option value="fa-temperature-high"
                                        {{ old('icon') == 'fa-temperature-high' ? 'selected' : '' }}>Heating</option>
                                    <option value="fa-elevator" {{ old('icon') == 'fa-elevator' ? 'selected' : '' }}>
                                        Elevator</option>
                                    <option value="fa-shield-alt"
                                        {{ old('icon') == 'fa-shield-alt' ? 'selected' : '' }}>Security</option>
                                </optgroup>

                                <optgroup label="Accessibility">
                                    <option value="fa-wheelchair"
                                        {{ old('icon') == 'fa-wheelchair' ? 'selected' : '' }}>Wheelchair Access
                                    </option>
                                </optgroup>
                            </select>
                            <div class="mt-2">
                                <span class="text-sm text-gray-600">Preview: <i
                                        class="fas {{ old('icon', 'fa-check-circle') }} text-indigo-500"></i></span>
                            </div>
                            @error('icon')
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
