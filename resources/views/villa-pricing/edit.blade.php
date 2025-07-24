<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Villa Pricing') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Edit Villa Pricing</h3>
                        <a href="{{ route('villa-pricing.index') }}"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                            <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('villa-pricing.update', $villaPricing->id_villa_pricing) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Villa & Season Selection -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="villa_id" class="block text-sm font-medium text-gray-700 mb-2">Villa <span
                                        class="text-red-500">*</span></label>
                                <select name="villa_id" id="villa_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                    <option value="">Pilih Villa</option>
                                    @foreach ($villas as $villa)
                                        <option value="{{ $villa->id_villa }}"
                                            {{ old('villa_id', $villaPricing->villa_id) == $villa->id_villa ? 'selected' : '' }}>
                                            {{ $villa->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="season_id" class="block text-sm font-medium text-gray-700 mb-2">Season <span
                                        class="text-red-500">*</span></label>
                                <select name="season_id" id="season_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                    <option value="">Pilih Season</option>
                                    @foreach ($seasons as $season)
                                        <option value="{{ $season->id_season }}"
                                            {{ old('season_id', $villaPricing->season_id) == $season->id_season ? 'selected' : '' }}>
                                            {{ $season->nama_season }} ({{ $season->periode_label }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Daily Pricing -->
                        <div class="mb-6">
                            <h4 class="text-md font-semibold text-gray-800 mb-4">Harga Per Hari</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div>
                                    <label for="sunday_pricing"
                                        class="block text-sm font-medium text-gray-700 mb-2">Minggu</label>
                                    <input type="number" name="sunday_pricing" id="sunday_pricing"
                                        value="{{ old('sunday_pricing', $villaPricing->sunday_pricing) }}"
                                        min="0" step="1000"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="0">
                                </div>

                                <div>
                                    <label for="monday_pricing"
                                        class="block text-sm font-medium text-gray-700 mb-2">Senin</label>
                                    <input type="number" name="monday_pricing" id="monday_pricing"
                                        value="{{ old('monday_pricing', $villaPricing->monday_pricing) }}"
                                        min="0" step="1000"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="0">
                                </div>

                                <div>
                                    <label for="tuesday_pricing"
                                        class="block text-sm font-medium text-gray-700 mb-2">Selasa</label>
                                    <input type="number" name="tuesday_pricing" id="tuesday_pricing"
                                        value="{{ old('tuesday_pricing', $villaPricing->tuesday_pricing) }}"
                                        min="0" step="1000"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="0">
                                </div>

                                <div>
                                    <label for="wednesday_pricing"
                                        class="block text-sm font-medium text-gray-700 mb-2">Rabu</label>
                                    <input type="number" name="wednesday_pricing" id="wednesday_pricing"
                                        value="{{ old('wednesday_pricing', $villaPricing->wednesday_pricing) }}"
                                        min="0" step="1000"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="0">
                                </div>

                                <div>
                                    <label for="thursday_pricing"
                                        class="block text-sm font-medium text-gray-700 mb-2">Kamis</label>
                                    <input type="number" name="thursday_pricing" id="thursday_pricing"
                                        value="{{ old('thursday_pricing', $villaPricing->thursday_pricing) }}"
                                        min="0" step="1000"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="0">
                                </div>

                                <div>
                                    <label for="friday_pricing"
                                        class="block text-sm font-medium text-gray-700 mb-2">Jumat</label>
                                    <input type="number" name="friday_pricing" id="friday_pricing"
                                        value="{{ old('friday_pricing', $villaPricing->friday_pricing) }}"
                                        min="0" step="1000"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="0">
                                </div>

                                <div>
                                    <label for="saturday_pricing"
                                        class="block text-sm font-medium text-gray-700 mb-2">Sabtu</label>
                                    <input type="number" name="saturday_pricing" id="saturday_pricing"
                                        value="{{ old('saturday_pricing', $villaPricing->saturday_pricing) }}"
                                        min="0" step="1000"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="0">
                                </div>
                            </div>
                        </div>

                        <!-- Special Price -->
                        <div class="mb-6">
                            <h4 class="text-md font-semibold text-gray-800 mb-4">Special Price</h4>

                            <div class="mb-4">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="use_special_price" id="use_special_price"
                                        value="1"
                                        {{ old('use_special_price', $villaPricing->use_special_price) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">Gunakan Special Price</span>
                                </label>
                            </div>

                            <div id="special-price-section" class="grid grid-cols-1 md:grid-cols-2 gap-4"
                                style="display: {{ old('use_special_price', $villaPricing->use_special_price) ? 'grid' : 'none' }};">
                                <div>
                                    <label for="special_price"
                                        class="block text-sm font-medium text-gray-700 mb-2">Special Price</label>
                                    <input type="number" name="special_price" id="special_price"
                                        value="{{ old('special_price', $villaPricing->special_price) }}"
                                        min="0" step="1000"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="0">
                                </div>

                                <div>
                                    <label for="special_price_description"
                                        class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Special
                                        Price</label>
                                    <input type="text" name="special_price_description"
                                        id="special_price_description"
                                        value="{{ old('special_price_description', $villaPricing->special_price_description) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Contoh: Weekend Special">
                                </div>
                            </div>
                        </div>

                        <!-- Range Date Price -->
                        <div class="mb-6">
                            <h4 class="text-md font-semibold text-gray-800 mb-4">Range Date Price</h4>
                            <div id="range-date-container">
                                @php
                                    $rangeDatePrices = old('range_date_price', $villaPricing->range_date_price ?? []);
                                    if (empty($rangeDatePrices)) {
                                        $rangeDatePrices = [['start_date' => '', 'end_date' => '', 'price' => '']];
                                    }
                                @endphp

                                @foreach ($rangeDatePrices as $index => $rangeDatePrice)
                                    <div class="range-date-item grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal
                                                Mulai</label>
                                            <input type="date"
                                                name="range_date_price[{{ $index }}][start_date]"
                                                value="{{ $rangeDatePrice['start_date'] ?? '' }}"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal
                                                Akhir</label>
                                            <input type="date"
                                                name="range_date_price[{{ $index }}][end_date]"
                                                value="{{ $rangeDatePrice['end_date'] ?? '' }}"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Harga</label>
                                            <input type="number" name="range_date_price[{{ $index }}][price]"
                                                value="{{ $rangeDatePrice['price'] ?? '' }}" min="0"
                                                step="1000"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                placeholder="0">
                                        </div>
                                        <div class="flex items-end">
                                            <button type="button" onclick="removeRangeDateItem(this)"
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded w-full">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" onclick="addRangeDateItem()"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-plus"></i> Tambah Range Date
                            </button>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('villa-pricing.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-save"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle special price section
        document.getElementById('use_special_price').addEventListener('change', function() {
            const section = document.getElementById('special-price-section');
            if (this.checked) {
                section.style.display = 'grid';
            } else {
                section.style.display = 'none';
            }
        });

        let rangeDateIndex = {{ count($rangeDatePrices) }};

        function addRangeDateItem() {
            const container = document.getElementById('range-date-container');
            const newItem = document.createElement('div');
            newItem.className = 'range-date-item grid grid-cols-1 md:grid-cols-4 gap-4 mb-4';
            newItem.innerHTML = `
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                    <input type="date" name="range_date_price[${rangeDateIndex}][start_date]"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
                    <input type="date" name="range_date_price[${rangeDateIndex}][end_date]"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Harga</label>
                    <input type="number" name="range_date_price[${rangeDateIndex}][price]"
                           min="0" step="1000"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           placeholder="0">
                </div>
                <div class="flex items-end">
                    <button type="button" onclick="removeRangeDateItem(this)"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded w-full">
                        Hapus
                    </button>
                </div>
            `;
            container.appendChild(newItem);
            rangeDateIndex++;
        }

        function removeRangeDateItem(button) {
            const container = document.getElementById('range-date-container');
            if (container.children.length > 1) {
                button.closest('.range-date-item').remove();
            }
        }
    </script>
</x-app-layout>
