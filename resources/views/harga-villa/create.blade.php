<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-sm text-gray-800">Tambah Harga Villa</h2>
    </x-slot>

    <div class="py-2">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="w-full mb-4 bg-white dark:bg-gray-900 py-4 px-6">
                <h2 class="text-sm font-bold">Tambah Harga Villa</h2>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-6">
                <form action="{{ route('harga-villa.store') }}" method="POST" id="villa-pricing-form">
                    @csrf

                    <!-- Basic Information -->
                    <div class="space-y-6">
                        <!-- Villa Selection -->
                        <div>
                            <x-label for="villa_id" value="Villa" />
                            <select id="villa_id" name="villa_id" required
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">-- Pilih Villa --</option>
                                @foreach ($villas as $villa)
                                    <option value="{{ $villa->id_villa }}"
                                        {{ old('villa_id') == $villa->id_villa ? 'selected' : '' }}>
                                        {{ $villa->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('villa_id')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Season Selection -->
                        <div>
                            <x-label for="season_id" value="Season" />
                            <select id="season_id" name="season_id" required
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">-- Pilih Season --</option>
                                @foreach ($seasons as $season)
                                    <option value="{{ $season->id_season }}"
                                        data-repeat-weekly="{{ $season->repeat_weekly ? 'true' : 'false' }}"
                                        data-days="{{ json_encode($season->days_of_week) }}"
                                        {{ old('season_id') == $season->id_season ? 'selected' : '' }}>
                                        {{ $season->nama_season }} ({{ $season->periode_label }})
                                    </option>
                                @endforeach
                            </select>
                            @error('season_id')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Season Info Display -->
                        <div id="season-info" class="hidden bg-blue-50 border border-blue-200 rounded-md p-4">
                            <h4 class="font-medium text-blue-900 mb-2">Informasi Season:</h4>
                            <div id="season-details" class="text-sm text-blue-800"></div>
                        </div>
                    </div>

                    <!-- Daily Pricing Section -->
                    <div id="daily-pricing-section" class="mt-8 hidden">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Harga Per Hari</h3>

                        <!-- Bulk Price Setting -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-2 mb-3">
                                <input type="checkbox" id="use_bulk_price"
                                    class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                <label for="use_bulk_price" class="font-medium text-gray-700">
                                    Gunakan Harga yang Sama untuk Semua Hari
                                </label>
                            </div>
                            <div id="bulk-price-input" class="hidden">
                                <x-input id="bulk_price" type="number" min="0" step="1000"
                                    class="mt-1 block w-full max-w-md border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Masukkan harga untuk semua hari" />
                                <p class="text-sm text-gray-500 mt-1">Harga akan diterapkan ke semua hari yang tersedia
                                </p>
                            </div>
                        </div>

                        <!-- Individual Day Pricing -->
                        <div id="day-pricing-fields" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Day pricing fields will be generated by JavaScript -->
                        </div>
                    </div>

                    <!-- Global Special Price Section -->
                    <div class="mt-8 border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Special Price Global</h3>
                        <p class="text-sm text-gray-600 mb-4">
                            Special price yang berlaku untuk semua hari dalam season (menggantikan harga per hari)
                        </p>

                        <div class="flex items-center space-x-2 mb-4">
                            <input type="checkbox" id="use_special_price" name="use_special_price" value="1"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded"
                                {{ old('use_special_price') ? 'checked' : '' }}>
                            <label for="use_special_price" class="font-medium text-gray-700">
                                Aktifkan Special Price Global
                            </label>
                        </div>

                        <div id="special-price-fields" class="hidden space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-label for="special_price" value="Special Price" />
                                    <x-input id="special_price" name="special_price" type="number" min="0"
                                        step="1000"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        value="{{ old('special_price') }}" placeholder="Contoh: 500000" />
                                    @error('special_price')
                                        <span class="text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <x-label for="special_price_description" value="Deskripsi" />
                                    <x-input id="special_price_description" name="special_price_description"
                                        type="text"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        value="{{ old('special_price_description') }}"
                                        placeholder="Contoh: Promo Akhir Tahun" />
                                    @error('special_price_description')
                                        <span class="text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Range Date Price Section -->
                    <div class="mt-8 border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Override Harga Periode Tertentu</h3>
                        <p class="text-sm text-gray-600 mb-4">
                            Override harga reguler atau special price untuk tanggal/periode tertentu
                        </p>

                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <x-label for="range_start_date" value="Tanggal Mulai" />
                                    <x-input id="range_start_date" type="date"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                </div>
                                <div>
                                    <x-label for="range_end_date" value="Tanggal Selesai" />
                                    <x-input id="range_end_date" type="date"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                </div>
                                <div>
                                    <x-label for="range_price" value="Harga Override" />
                                    <x-input id="range_price" type="number" min="0" step="1000"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        placeholder="Contoh: 750000" />
                                </div>
                                <div class="flex items-end">
                                    <button type="button" id="add-range-price"
                                        class="w-full px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Tambah
                                    </button>
                                </div>
                            </div>

                            <!-- Range Price List -->
                            <div id="range-price-list" class="hidden space-y-2">
                                <h4 class="font-medium text-gray-700">Range Price yang Ditambahkan:</h4>
                                <div id="range-price-items" class="space-y-2"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Special Price Range Section -->
                    <div class="mt-8 border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Special Price Tanggal Tertentu</h3>
                        <p class="text-sm text-gray-600 mb-4">
                            Special price untuk tanggal/periode tertentu (prioritas tertinggi)
                        </p>

                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <x-label for="special_start_date" value="Tanggal Mulai" />
                                    <x-input id="special_start_date" type="date"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                </div>
                                <div>
                                    <x-label for="special_end_date" value="Tanggal Selesai" />
                                    <x-input id="special_end_date" type="date"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                </div>
                                <div>
                                    <x-label for="special_range_price" value="Special Price" />
                                    <x-input id="special_range_price" type="number" min="0" step="1000"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        placeholder="Contoh: 900000" />
                                </div>
                                <div class="flex items-end">
                                    <button type="button" id="add-special-range"
                                        class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        Tambah
                                    </button>
                                </div>
                            </div>

                            <!-- Special Range List -->
                            <div id="special-range-list" class="hidden space-y-2">
                                <h4 class="font-medium text-gray-700">Special Price Range yang Ditambahkan:</h4>
                                <div id="special-range-items" class="space-y-2"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing Priority Info -->
                    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-md p-4">
                        <h4 class="font-medium text-blue-900 mb-2">Prioritas Penggunaan Harga:</h4>
                        <ol class="list-decimal list-inside text-sm text-blue-800 space-y-1">
                            <li><strong>Special Price Tanggal Tertentu</strong> - Prioritas tertinggi</li>
                            <li><strong>Override Harga Periode Tertentu</strong> - Prioritas kedua</li>
                            <li><strong>Special Price Global</strong> - Prioritas ketiga</li>
                            <li><strong>Harga per Hari</strong> - Prioritas default</li>
                        </ol>
                    </div>

                    <!-- Form Actions -->
                    <div class="mt-8 flex justify-end space-x-4">
                        <a href="{{ route('harga-villa.index') }}"
                            class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const PricingManager = {
                // Configuration
                dayNames: ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'],
                dayLabels: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],

                // DOM Elements
                seasonSelect: document.getElementById('season_id'),
                seasonInfo: document.getElementById('season-info'),
                seasonDetails: document.getElementById('season-details'),
                dailyPricingSection: document.getElementById('daily-pricing-section'),
                dayPricingFields: document.getElementById('day-pricing-fields'),
                useBulkPrice: document.getElementById('use_bulk_price'),
                bulkPriceInput: document.getElementById('bulk-price-input'),
                bulkPrice: document.getElementById('bulk_price'),
                useSpecialPrice: document.getElementById('use_special_price'),
                specialPriceFields: document.getElementById('special-price-fields'),

                // Range pricing elements
                addRangePrice: document.getElementById('add-range-price'),
                rangePriceList: document.getElementById('range-price-list'),
                rangePriceItems: document.getElementById('range-price-items'),
                addSpecialRange: document.getElementById('add-special-range'),
                specialRangeList: document.getElementById('special-range-list'),
                specialRangeItems: document.getElementById('special-range-items'),

                // Data storage
                rangePrices: [],
                specialRanges: [],
                currentSeason: null,

                init() {
                    this.bindEvents();
                    this.restoreFormState();
                },

                bindEvents() {
                    // Season selection
                    this.seasonSelect.addEventListener('change', () => this.handleSeasonChange());

                    // Bulk pricing
                    this.useBulkPrice.addEventListener('change', () => this.handleBulkPriceToggle());
                    this.bulkPrice.addEventListener('input', () => this.handleBulkPriceInput());

                    // Special price
                    this.useSpecialPrice.addEventListener('change', () => this.handleSpecialPriceToggle());

                    // Range pricing
                    this.addRangePrice.addEventListener('click', () => this.handleAddRangePrice());
                    this.addSpecialRange.addEventListener('click', () => this.handleAddSpecialRange());
                },

                handleSeasonChange() {
                    const selectedOption = this.seasonSelect.selectedOptions[0];
                    if (!selectedOption || !selectedOption.value) {
                        this.hideAllSections();
                        return;
                    }

                    const seasonData = {
                        id: selectedOption.value,
                        name: selectedOption.textContent.split(' (')[0],
                        repeatWeekly: selectedOption.dataset.repeatWeekly === 'true',
                        daysOfWeek: JSON.parse(selectedOption.dataset.days || '[]')
                    };

                    this.currentSeason = seasonData;
                    this.showSeasonInfo(seasonData);
                    this.generateDayPricingFields(seasonData);
                },

                showSeasonInfo(seasonData) {
                    let infoHtml =
                        `<strong>Tipe Season:</strong> ${seasonData.repeatWeekly ? 'Weekly (Berulang Mingguan)' : 'Date Range (Rentang Tanggal)'}<br>`;

                    if (seasonData.repeatWeekly) {
                        const dayLabels = seasonData.daysOfWeek.map(dayIndex => this.dayLabels[dayIndex]);
                        infoHtml += `<strong>Hari Tersedia:</strong> ${dayLabels.join(', ')}`;
                    } else {
                        infoHtml += `<strong>Mode:</strong> Rentang tanggal (semua hari dalam periode season)`;
                    }

                    this.seasonDetails.innerHTML = infoHtml;
                    this.seasonInfo.classList.remove('hidden');
                    this.dailyPricingSection.classList.remove('hidden');
                },

                generateDayPricingFields(seasonData) {
                    this.dayPricingFields.innerHTML = '';

                    if (seasonData.repeatWeekly) {
                        // Generate fields for specific days of week
                        seasonData.daysOfWeek.forEach(dayIndex => {
                            this.createDayPricingField(dayIndex);
                        });
                    } else {
                        // For date range seasons, show info that daily pricing applies to all days
                        const infoDiv = document.createElement('div');
                        infoDiv.className =
                        'col-span-full bg-yellow-50 border border-yellow-200 rounded-md p-4';
                        infoDiv.innerHTML = `
                            <div class="text-sm text-yellow-800">
                                <strong>Catatan:</strong> Untuk season dengan rentang tanggal, harga per hari akan berlaku untuk semua hari dalam periode season.
                                Anda dapat menggunakan "Override Harga Periode Tertentu" atau "Special Price" untuk mengatur harga khusus.
                            </div>
                        `;
                        this.dayPricingFields.appendChild(infoDiv);

                        // Create basic daily pricing fields for reference
                        for (let i = 0; i < 7; i++) {
                            this.createDayPricingField(i);
                        }
                    }
                },

                createDayPricingField(dayIndex) {
                    const dayName = this.dayNames[dayIndex];
                    const dayLabel = this.dayLabels[dayIndex];

                    const fieldDiv = document.createElement('div');
                    fieldDiv.className = 'pricing-field';
                    fieldDiv.dataset.day = dayName;

                    const oldValue = this.getOldValue(`${dayName}_pricing`);

                    fieldDiv.innerHTML = `
                        <label for="${dayName}_pricing" class="block text-sm font-medium text-gray-700 mb-1">
                            ${dayLabel}
                        </label>
                        <input type="number"
                               id="${dayName}_pricing"
                               name="${dayName}_pricing"
                               min="0"
                               step="1000"
                               value="${oldValue}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                               placeholder="Kosongkan jika tidak ada">
                        ${this.getErrorMessage(`${dayName}_pricing`)}
                    `;

                    this.dayPricingFields.appendChild(fieldDiv);
                },

                handleBulkPriceToggle() {
                    if (this.useBulkPrice.checked) {
                        this.bulkPriceInput.classList.remove('hidden');
                        this.bulkPrice.focus();
                    } else {
                        this.bulkPriceInput.classList.add('hidden');
                        this.bulkPrice.value = '';
                    }
                },

                handleBulkPriceInput() {
                    const bulkValue = this.bulkPrice.value;
                    const pricingInputs = this.dayPricingFields.querySelectorAll('input[type="number"]');

                    pricingInputs.forEach(input => {
                        input.value = bulkValue;
                    });
                },

                handleSpecialPriceToggle() {
                    if (this.useSpecialPrice.checked) {
                        this.specialPriceFields.classList.remove('hidden');
                    } else {
                        this.specialPriceFields.classList.add('hidden');
                        document.getElementById('special_price').value = '';
                        document.getElementById('special_price_description').value = '';
                    }
                },

                handleAddRangePrice() {
                    const startDate = document.getElementById('range_start_date').value;
                    const endDate = document.getElementById('range_end_date').value;
                    const price = document.getElementById('range_price').value;

                    if (!this.validateRangeInput(startDate, endDate, price)) {
                        return;
                    }

                    const rangeData = {
                        start_date: startDate,
                        end_date: endDate,
                        price: parseInt(price),
                        description: 'Harga khusus untuk periode tertentu'
                    };

                    this.rangePrices.push(rangeData);
                    this.renderRangePriceItem(rangeData, this.rangePrices.length - 1);
                    this.addHiddenInput('range_date_prices[]', JSON.stringify(rangeData));
                    this.clearRangeInputs();
                    this.showRangePriceList();
                },

                handleAddSpecialRange() {
                    const startDate = document.getElementById('special_start_date').value;
                    const endDate = document.getElementById('special_end_date').value;
                    const price = document.getElementById('special_range_price').value;

                    if (!this.validateRangeInput(startDate, endDate, price)) {
                        return;
                    }

                    const rangeData = {
                        start_date: startDate,
                        end_date: endDate,
                        price: parseInt(price),
                        description: 'Special price untuk tanggal tertentu'
                    };

                    this.specialRanges.push(rangeData);
                    this.renderSpecialRangeItem(rangeData, this.specialRanges.length - 1);
                    this.addHiddenInput('special_price_ranges[]', JSON.stringify(rangeData));
                    this.clearSpecialInputs();
                    this.showSpecialRangeList();
                },

                validateRangeInput(startDate, endDate, price) {
                    if (!startDate || !endDate || !price) {
                        alert('Semua field harus diisi!');
                        return false;
                    }

                    if (new Date(startDate) > new Date(endDate)) {
                        alert('Tanggal mulai tidak boleh lebih dari tanggal selesai!');
                        return false;
                    }

                    if (parseInt(price) <= 0) {
                        alert('Harga harus lebih dari 0!');
                        return false;
                    }

                    return true;
                },

                renderRangePriceItem(rangeData, index) {
                    const itemDiv = document.createElement('div');
                    itemDiv.className =
                        'bg-gray-50 p-3 rounded-lg border border-gray-200 flex justify-between items-center';
                    itemDiv.innerHTML = `
                        <div>
                            <p class="font-medium text-gray-900">${this.formatDate(rangeData.start_date)} - ${this.formatDate(rangeData.end_date)}</p>
                            <p class="text-sm text-gray-600">${rangeData.description}</p>
                            <p class="text-sm font-semibold text-green-600">${this.formatCurrency(rangeData.price)}</p>
                        </div>
                        <button type="button" onclick="PricingManager.removeRangePrice(${index})"
                                class="text-red-600 hover:text-red-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    `;
                    this.rangePriceItems.appendChild(itemDiv);
                },

                renderSpecialRangeItem(rangeData, index) {
                    const itemDiv = document.createElement('div');
                    itemDiv.className =
                        'bg-green-50 p-3 rounded-lg border border-green-200 flex justify-between items-center';
                    itemDiv.innerHTML = `
                        <div>
                            <p class="font-medium text-gray-900">${this.formatDate(rangeData.start_date)} - ${this.formatDate(rangeData.end_date)}</p>
                            <p class="text-sm text-gray-600">${rangeData.description}</p>
                            <p class="text-sm font-semibold text-green-600">${this.formatCurrency(rangeData.price)}</p>
                        </div>
                        <button type="button" onclick="PricingManager.removeSpecialRange(${index})"
                                class="text-red-600 hover:text-red-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    `;
                    this.specialRangeItems.appendChild(itemDiv);
                },

                removeRangePrice(index) {
                    this.rangePrices.splice(index, 1);
                    this.refreshRangePriceList();
                    this.updateHiddenInputs('range_date_prices[]', this.rangePrices);
                },

                removeSpecialRange(index) {
                    this.specialRanges.splice(index, 1);
                    this.refreshSpecialRangeList();
                    this.updateHiddenInputs('special_price_ranges[]', this.specialRanges);
                },

                refreshRangePriceList() {
                    this.rangePriceItems.innerHTML = '';
                    this.rangePrices.forEach((range, index) => {
                        this.renderRangePriceItem(range, index);
                    });

                    if (this.rangePrices.length === 0) {
                        this.rangePriceList.classList.add('hidden');
                    }
                },

                refreshSpecialRangeList() {
                    this.specialRangeItems.innerHTML = '';
                    this.specialRanges.forEach((range, index) => {
                        this.renderSpecialRangeItem(range, index);
                    });

                    if (this.specialRanges.length === 0) {
                        this.specialRangeList.classList.add('hidden');
                    }
                },

                addHiddenInput(name, value) {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = name;
                    hiddenInput.value = value;
                    document.getElementById('villa-pricing-form').appendChild(hiddenInput);
                },

                updateHiddenInputs(name, dataArray) {
                    // Remove existing hidden inputs
                    const existingInputs = document.querySelectorAll(`input[name="${name}"]`);
                    existingInputs.forEach(input => input.remove());

                    // Add new hidden inputs
                    dataArray.forEach(data => {
                        this.addHiddenInput(name, JSON.stringify(data));
                    });
                },

                clearRangeInputs() {
                    document.getElementById('range_start_date').value = '';
                    document.getElementById('range_end_date').value = '';
                    document.getElementById('range_price').value = '';
                },

                clearSpecialInputs() {
                    document.getElementById('special_start_date').value = '';
                    document.getElementById('special_end_date').value = '';
                    document.getElementById('special_range_price').value = '';
                },

                showRangePriceList() {
                    this.rangePriceList.classList.remove('hidden');
                },

                showSpecialRangeList() {
                    this.specialRangeList.classList.remove('hidden');
                },

                hideAllSections() {
                    this.seasonInfo.classList.add('hidden');
                    this.dailyPricingSection.classList.add('hidden');
                    this.currentSeason = null;
                },

                formatDate(dateString) {
                    const date = new Date(dateString);
                    return date.toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric'
                    });
                },

                formatCurrency(amount) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(amount);
                },

                getOldValue(fieldName) {
                    @if (old())
                        const oldValues = @json(old());
                        return oldValues['{{ $fieldName }}'] || '';
                    @else
                        return '';
                    @endif
                },

                getErrorMessage(fieldName) {
                    @if ($errors->any())
                        const errors = @json($errors->getMessages());
                        if (errors[fieldName]) {
                            return `<span class="text-sm text-red-600">${errors[fieldName][0]}</span>`;
                        }
                    @endif
                    return '';
                },

                restoreFormState() {
                    // Restore special price state
                    if (this.useSpecialPrice.checked) {
                        this.specialPriceFields.classList.remove('hidden');
                    }

                    // Trigger season change if there's an old value
                    @if (old('season_id'))
                        this.seasonSelect.value = '{{ old('season_id') }}';
                        this.handleSeasonChange();
                    @endif
                }
            };

            // Initialize the pricing manager
            PricingManager.init();

            // Make it globally accessible for button onclick handlers
            window.PricingManager = PricingManager;
        });
    </script>
</x-app-layout>
