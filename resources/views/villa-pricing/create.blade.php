<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Villa Pricing') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Tambah Villa Pricing</h3>
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

                    <form action="{{ route('villa-pricing.store') }}" method="POST">
                        @csrf

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
                                            {{ old('villa_id') == $villa->id_villa ? 'selected' : '' }}>
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
                                    required onchange="handleSeasonChange()">
                                    <option value="">Pilih Season</option>
                                    @foreach ($seasons as $season)
                                        <option value="{{ $season->id_season }}"
                                            data-repeat-weekly="{{ $season->repeat_weekly ? '1' : '0' }}"
                                            data-days-of-week="{{ json_encode($season->days_of_week) }}"
                                            data-periode="{{ $season->periode_label }}"
                                            {{ old('season_id') == $season->id_season ? 'selected' : '' }}>
                                            {{ $season->nama_season }} ({{ $season->periode_label }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Season Info Display -->
                        <div id="season-info" class="mb-6 hidden">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <h4 class="text-md font-semibold text-blue-800 mb-2">Informasi Season</h4>
                                <div id="season-details" class="text-sm text-blue-700">
                                    <!-- Season details will be populated by JavaScript -->
                                </div>
                            </div>
                        </div>

                        <!-- Daily Pricing Section -->
                        <div class="mb-6">
                            <h4 class="text-md font-semibold text-gray-800 mb-4">
                                Harga Per Hari
                                <span id="pricing-note" class="text-sm font-normal text-gray-600"></span>
                            </h4>

                            <!-- Weekly Pricing (for repeat_weekly = true) -->
                            <div id="weekly-pricing" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div class="pricing-day" data-day="0">
                                    <label for="sunday_pricing" class="block text-sm font-medium text-gray-700 mb-2">
                                        <span class="day-name">Minggu</span>
                                        <span class="day-status text-xs"></span>
                                    </label>
                                    <input type="number" name="sunday_pricing" id="sunday_pricing"
                                        value="{{ old('sunday_pricing') }}" min="0" step="1000"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="0">
                                </div>

                                <div class="pricing-day" data-day="1">
                                    <label for="monday_pricing" class="block text-sm font-medium text-gray-700 mb-2">
                                        <span class="day-name">Senin</span>
                                        <span class="day-status text-xs"></span>
                                    </label>
                                    <input type="number" name="monday_pricing" id="monday_pricing"
                                        value="{{ old('monday_pricing') }}" min="0" step="1000"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="0">
                                </div>

                                <div class="pricing-day" data-day="2">
                                    <label for="tuesday_pricing" class="block text-sm font-medium text-gray-700 mb-2">
                                        <span class="day-name">Selasa</span>
                                        <span class="day-status text-xs"></span>
                                    </label>
                                    <input type="number" name="tuesday_pricing" id="tuesday_pricing"
                                        value="{{ old('tuesday_pricing') }}" min="0" step="1000"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="0">
                                </div>

                                <div class="pricing-day" data-day="3">
                                    <label for="wednesday_pricing" class="block text-sm font-medium text-gray-700 mb-2">
                                        <span class="day-name">Rabu</span>
                                        <span class="day-status text-xs"></span>
                                    </label>
                                    <input type="number" name="wednesday_pricing" id="wednesday_pricing"
                                        value="{{ old('wednesday_pricing') }}" min="0" step="1000"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="0">
                                </div>

                                <div class="pricing-day" data-day="4">
                                    <label for="thursday_pricing"
                                        class="block text-sm font-medium text-gray-700 mb-2">
                                        <span class="day-name">Kamis</span>
                                        <span class="day-status text-xs"></span>
                                    </label>
                                    <input type="number" name="thursday_pricing" id="thursday_pricing"
                                        value="{{ old('thursday_pricing') }}" min="0" step="1000"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="0">
                                </div>

                                <div class="pricing-day" data-day="5">
                                    <label for="friday_pricing" class="block text-sm font-medium text-gray-700 mb-2">
                                        <span class="day-name">Jumat</span>
                                        <span class="day-status text-xs"></span>
                                    </label>
                                    <input type="number" name="friday_pricing" id="friday_pricing"
                                        value="{{ old('friday_pricing') }}" min="0" step="1000"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="0">
                                </div>

                                <div class="pricing-day" data-day="6">
                                    <label for="saturday_pricing"
                                        class="block text-sm font-medium text-gray-700 mb-2">
                                        <span class="day-name">Sabtu</span>
                                        <span class="day-status text-xs"></span>
                                    </label>
                                    <input type="number" name="saturday_pricing" id="saturday_pricing"
                                        value="{{ old('saturday_pricing') }}" min="0" step="1000"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="0">
                                </div>
                            </div>

                            <!-- Range Date Pricing (for repeat_weekly = false) -->
                            <div id="range-pricing" class="hidden">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-sm text-gray-600 mb-2">
                                        <i class="fas fa-info-circle"></i>
                                        Season ini menggunakan rentang tanggal tertentu. Anda tetap bisa mengatur harga
                                        per hari yang akan diterapkan pada rentang tanggal tersebut.
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        Rentang tanggal akan diambil dari pengaturan season yang dipilih.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Special Price -->
                        <div class="mb-6">
                            <h4 class="text-md font-semibold text-gray-800 mb-4">Special Price</h4>

                            <div class="mb-4">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="use_special_price" id="use_special_price"
                                        value="1" {{ old('use_special_price') ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">Gunakan Special Price</span>
                                </label>
                            </div>

                            <div id="special-price-section" class="grid grid-cols-1 md:grid-cols-2 gap-4"
                                style="display: none;">
                                <div>
                                    <label for="special_price"
                                        class="block text-sm font-medium text-gray-700 mb-2">Special Price</label>
                                    <input type="number" name="special_price" id="special_price"
                                        value="{{ old('special_price') }}" min="0" step="1000"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="0">
                                </div>

                                <div>
                                    <label for="special_price_description"
                                        class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Special
                                        Price</label>
                                    <input type="text" name="special_price_description"
                                        id="special_price_description" value="{{ old('special_price_description') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Contoh: Weekend Special">
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('villa-pricing.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function handleSeasonChange() {
            const seasonSelect = document.getElementById('season_id');
            const selectedOption = seasonSelect.options[seasonSelect.selectedIndex];
            const seasonInfo = document.getElementById('season-info');
            const seasonDetails = document.getElementById('season-details');
            const weeklyPricing = document.getElementById('weekly-pricing');
            const rangePricing = document.getElementById('range-pricing');
            const pricingNote = document.getElementById('pricing-note');

            if (selectedOption.value === '') {
                seasonInfo.classList.add('hidden');
                resetPricingDisplay();
                return;
            }

            const isRepeatWeekly = selectedOption.dataset.repeatWeekly === '1';
            const daysOfWeek = JSON.parse(selectedOption.dataset.daysOfWeek || '[]');
            const periode = selectedOption.dataset.periode;

            // Show season info
            seasonInfo.classList.remove('hidden');

            if (isRepeatWeekly) {
                seasonDetails.innerHTML = `
                    <div class="flex items-center space-x-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-repeat mr-1"></i> Weekly Repeat
                        </span>
                        <span class="text-sm">Berlaku untuk hari: ${getDayNames(daysOfWeek).join(', ')}</span>
                    </div>
                `;

                weeklyPricing.classList.remove('hidden');
                rangePricing.classList.add('hidden');
                pricingNote.textContent = '(Pricing akan diterapkan berulang setiap minggu)';

                updateDayAvailability(daysOfWeek);
            } else {
                seasonDetails.innerHTML = `
                    <div class="flex items-center space-x-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <i class="fas fa-calendar-alt mr-1"></i> Date Range
                        </span>
                        <span class="text-sm">Periode: ${periode}</span>
                    </div>
                `;

                weeklyPricing.classList.remove('hidden');
                rangePricing.classList.remove('hidden');
                pricingNote.textContent = '(Pricing akan diterapkan pada rentang tanggal tertentu)';

                // Enable all days for range pricing
                enableAllDays();
            }
        }

        function updateDayAvailability(activeDays) {
            const pricingDays = document.querySelectorAll('.pricing-day');

            pricingDays.forEach(dayElement => {
                const dayNumber = parseInt(dayElement.dataset.day);
                const input = dayElement.querySelector('input');
                const statusElement = dayElement.querySelector('.day-status');

                if (activeDays.includes(dayNumber)) {
                    dayElement.classList.remove('opacity-50');
                    input.disabled = false;
                    input.classList.remove('bg-gray-100');
                    statusElement.innerHTML = '<span class="text-green-600">(✓ Aktif)</span>';
                } else {
                    dayElement.classList.add('opacity-50');
                    input.disabled = true;
                    input.value = '';
                    input.classList.add('bg-gray-100');
                    statusElement.innerHTML = '<span class="text-gray-400">(Tidak aktif)</span>';
                }
            });
        }

        function enableAllDays() {
            const pricingDays = document.querySelectorAll('.pricing-day');

            pricingDays.forEach(dayElement => {
                const input = dayElement.querySelector('input');
                const statusElement = dayElement.querySelector('.day-status');

                dayElement.classList.remove('opacity-50');
                input.disabled = false;
                input.classList.remove('bg-gray-100');
                statusElement.innerHTML = '<span class="text-blue-600">(Tersedia)</span>';
            });
        }

        function resetPricingDisplay() {
            const pricingDays = document.querySelectorAll('.pricing-day');
            const pricingNote = document.getElementById('pricing-note');

            pricingDays.forEach(dayElement => {
                const input = dayElement.querySelector('input');
                const statusElement = dayElement.querySelector('.day-status');

                dayElement.classList.remove('opacity-50');
                input.disabled = false;
                input.classList.remove('bg-gray-100');
                statusElement.innerHTML = '';
            });

            pricingNote.textContent = '';
            document.getElementById('range-pricing').classList.add('hidden');
        }

        function getDayNames(dayNumbers) {
            const dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            return dayNumbers.map(num => dayNames[num] || '');
        }

        // Toggle special price section
        document.getElementById('use_special_price').addEventListener('change', function() {
            const section = document.getElementById('special-price-section');
            if (this.checked) {
                section.style.display = 'grid';
            } else {
                section.style.display = 'none';
            }
        });

        // Initialize special price section visibility
        if (document.getElementById('use_special_price').checked) {
            document.getElementById('special-price-section').style.display = 'grid';
        }

        // Initialize on page load if season is already selected
        if (document.getElementById('season_id').value) {
            handleSeasonChange();
        }
    </script>
</x-app-layout>
