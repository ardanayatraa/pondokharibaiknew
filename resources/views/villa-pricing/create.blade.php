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
                        <div class="flex space-x-2">
                            <a href="{{ route('villa-pricing.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
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

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Quick Info -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-lightbulb text-blue-400 text-lg"></i>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-md font-semibold text-blue-800">Tips Pengisian Pricing</h4>
                                <div class="text-sm text-blue-700 mt-1">
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>Pilih Villa dan Season terlebih dahulu untuk melihat hari yang berlaku</li>
                                        <li>Gunakan Quick Actions untuk mempercepat pengisian harga</li>
                                        <li>Harga dalam format Rupiah tanpa titik atau koma</li>
                                        <li>Sistem akan otomatis menyimpan draft setiap 2 detik</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('villa-pricing.store') }}" method="POST" id="pricing-form">
                        @csrf

                        <!-- Villa & Season Selection -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="villa_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Villa <span class="text-red-500">*</span>
                                </label>
                                <select name="villa_id" id="villa_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                    <option value="">Pilih Villa</option>
                                    @foreach ($villas as $villa)
                                        <option value="{{ $villa->id_villa }}"
                                            {{ old('villa_id') == $villa->id_villa ? 'selected' : '' }}>
                                            {{ $villa->name }}
                                            @if ($villa->capacity)
                                                (Kapasitas: {{ $villa->capacity }} orang)
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('villa_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="season_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Season <span class="text-red-500">*</span>
                                </label>
                                <select name="season_id" id="season_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    required onchange="handleSeasonChange()">
                                    <option value="">Pilih Season</option>
                                    @foreach ($seasons as $season)
                                        <option value="{{ $season->id_season }}"
                                            data-repeat-weekly="{{ $season->repeat_weekly ? '1' : '0' }}"
                                            data-days-of-week="{{ json_encode($season->days_of_week ?? []) }}"
                                            data-periode="{{ $season->periode_label ?? '' }}"
                                            data-priority="{{ $season->priority ?? 0 }}"
                                            {{ old('season_id') == $season->id_season ? 'selected' : '' }}>
                                            {{ $season->nama_season }} ({{ $season->periode_label ?? 'No period' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('season_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Season Info Display -->
                        <div id="season-info" class="mb-6 hidden">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <h4 class="text-md font-semibold text-blue-800 mb-2">
                                    <i class="fas fa-info-circle mr-2"></i>Informasi Season
                                </h4>
                                <div id="season-details" class="text-sm text-blue-700">
                                    <!-- Season details will be populated by JavaScript -->
                                </div>
                            </div>
                        </div>

                        <!-- Duplicate Check Warning -->
                        <div id="duplicate-warning" class="mb-6 hidden">
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-md font-semibold text-yellow-800">Peringatan</h4>
                                        <p class="text-sm text-yellow-700 mt-1">
                                            Kombinasi Villa dan Season ini mungkin sudah ada. Pastikan untuk mengecek
                                            data yang sudah ada.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Daily Pricing Section -->
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-md font-semibold text-gray-800">
                                    Harga Per Hari
                                    <span id="pricing-note" class="text-sm font-normal text-gray-600"></span>
                                </h4>
                                <div class="text-sm text-gray-500">
                                    <i class="fas fa-calculator mr-1"></i>
                                    Format: Rupiah (tanpa titik/koma)
                                </div>
                            </div>

                            <!-- Weekly Pricing Grid -->
                            <div id="weekly-pricing" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <!-- Sunday -->
                                <div class="pricing-day" data-day="0">
                                    <label for="sunday_pricing" class="block text-sm font-medium text-gray-700 mb-2">
                                        <span class="day-name flex items-center">
                                            <i class="fas fa-sun text-yellow-500 mr-2"></i>Minggu
                                        </span>
                                        <span class="day-status text-xs block mt-1"></span>
                                    </label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                                        <input type="number" name="sunday_pricing" id="sunday_pricing"
                                            value="{{ old('sunday_pricing') }}" min="0" step="1000"
                                            class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="0">
                                    </div>
                                    @error('sunday_pricing')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Monday -->
                                <div class="pricing-day" data-day="1">
                                    <label for="monday_pricing" class="block text-sm font-medium text-gray-700 mb-2">
                                        <span class="day-name flex items-center">
                                            <i class="fas fa-briefcase text-blue-500 mr-2"></i>Senin
                                        </span>
                                        <span class="day-status text-xs block mt-1"></span>
                                    </label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                                        <input type="number" name="monday_pricing" id="monday_pricing"
                                            value="{{ old('monday_pricing') }}" min="0" step="1000"
                                            class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="0">
                                    </div>
                                    @error('monday_pricing')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tuesday -->
                                <div class="pricing-day" data-day="2">
                                    <label for="tuesday_pricing" class="block text-sm font-medium text-gray-700 mb-2">
                                        <span class="day-name flex items-center">
                                            <i class="fas fa-briefcase text-blue-500 mr-2"></i>Selasa
                                        </span>
                                        <span class="day-status text-xs block mt-1"></span>
                                    </label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                                        <input type="number" name="tuesday_pricing" id="tuesday_pricing"
                                            value="{{ old('tuesday_pricing') }}" min="0" step="1000"
                                            class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="0">
                                    </div>
                                    @error('tuesday_pricing')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Wednesday -->
                                <div class="pricing-day" data-day="3">
                                    <label for="wednesday_pricing"
                                        class="block text-sm font-medium text-gray-700 mb-2">
                                        <span class="day-name flex items-center">
                                            <i class="fas fa-briefcase text-blue-500 mr-2"></i>Rabu
                                        </span>
                                        <span class="day-status text-xs block mt-1"></span>
                                    </label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                                        <input type="number" name="wednesday_pricing" id="wednesday_pricing"
                                            value="{{ old('wednesday_pricing') }}" min="0" step="1000"
                                            class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="0">
                                    </div>
                                    @error('wednesday_pricing')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Thursday -->
                                <div class="pricing-day" data-day="4">
                                    <label for="thursday_pricing"
                                        class="block text-sm font-medium text-gray-700 mb-2">
                                        <span class="day-name flex items-center">
                                            <i class="fas fa-briefcase text-blue-500 mr-2"></i>Kamis
                                        </span>
                                        <span class="day-status text-xs block mt-1"></span>
                                    </label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                                        <input type="number" name="thursday_pricing" id="thursday_pricing"
                                            value="{{ old('thursday_pricing') }}" min="0" step="1000"
                                            class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="0">
                                    </div>
                                    @error('thursday_pricing')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Friday -->
                                <div class="pricing-day" data-day="5">
                                    <label for="friday_pricing" class="block text-sm font-medium text-gray-700 mb-2">
                                        <span class="day-name flex items-center">
                                            <i class="fas fa-briefcase text-blue-500 mr-2"></i>Jumat
                                        </span>
                                        <span class="day-status text-xs block mt-1"></span>
                                    </label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                                        <input type="number" name="friday_pricing" id="friday_pricing"
                                            value="{{ old('friday_pricing') }}" min="0" step="1000"
                                            class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="0">
                                    </div>
                                    @error('friday_pricing')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Saturday -->
                                <div class="pricing-day" data-day="6">
                                    <label for="saturday_pricing"
                                        class="block text-sm font-medium text-gray-700 mb-2">
                                        <span class="day-name flex items-center">
                                            <i class="fas fa-calendar-weekend text-purple-500 mr-2"></i>Sabtu
                                        </span>
                                        <span class="day-status text-xs block mt-1"></span>
                                    </label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                                        <input type="number" name="saturday_pricing" id="saturday_pricing"
                                            value="{{ old('saturday_pricing') }}" min="0" step="1000"
                                            class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="0">
                                    </div>
                                    @error('saturday_pricing')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Range Date Pricing Info -->
                            <div id="range-pricing" class="hidden mt-4">
                                <div class="bg-gray-50 border-l-4 border-blue-400 p-4 rounded">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-info-circle text-blue-400"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-gray-600">
                                                Season ini menggunakan rentang tanggal tertentu. Harga per hari di atas
                                                akan diterapkan pada rentang tanggal yang telah ditentukan di season.
                                            </p>
                                            <p class="text-sm text-gray-500 mt-1">
                                                <i class="fas fa-cog mr-1"></i>
                                                Rentang tanggal dikelola di pengaturan season.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Price Summary -->
                        <div id="price-summary" class="mb-6 hidden">
                            <h4 class="text-md font-semibold text-gray-800 mb-3">Ringkasan Harga</h4>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                    <div>
                                        <span class="font-medium text-gray-600">Total Hari Diisi:</span>
                                        <span id="filled-days" class="text-gray-900 font-semibold">0</span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-600">Harga Tertinggi:</span>
                                        <span id="highest-price" class="text-gray-900 font-semibold">-</span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-600">Harga Terendah:</span>
                                        <span id="lowest-price" class="text-gray-900 font-semibold">-</span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-600">Rata-rata:</span>
                                        <span id="average-price" class="text-gray-900 font-semibold">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-between items-center pt-6 border-t">
                            <div class="flex space-x-3">
                                <a href="{{ route('villa-pricing.index') }}"
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    <i class="fas fa-times mr-1"></i>Batal
                                </a>
                                <button type="button" onclick="resetForm()"
                                    class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                    <i class="fas fa-undo mr-1"></i>Reset Form
                                </button>
                            </div>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded">
                                <i class="fas fa-save mr-2"></i>Simpan Pricing
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
            const periode = selectedOption.dataset.periode || '';
            const priority = selectedOption.dataset.priority || 0;

            // Show season info
            seasonInfo.classList.remove('hidden');

            if (isRepeatWeekly) {
                seasonDetails.innerHTML = `
                    <div class="flex items-center space-x-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-repeat mr-1"></i> Weekly Repeat
                        </span>
                        <span class="text-sm">Berlaku untuk hari: <strong>${getDayNames(daysOfWeek).join(', ')}</strong></span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Priority: ${priority}
                        </span>
                    </div>
                `;

                weeklyPricing.classList.remove('hidden');
                rangePricing.classList.add('hidden');
                pricingNote.innerHTML =
                    '<i class="fas fa-repeat mr-1"></i>(Pricing akan diterapkan berulang setiap minggu)';

                updateDayAvailability(daysOfWeek);
            } else {
                seasonDetails.innerHTML = `
                    <div class="flex items-center space-x-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <i class="fas fa-calendar-alt mr-1"></i> Date Range
                        </span>
                        <span class="text-sm">Periode: <strong>${periode}</strong></span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Priority: ${priority}
                        </span>
                    </div>
                `;

                weeklyPricing.classList.remove('hidden');
                rangePricing.classList.remove('hidden');
                pricingNote.innerHTML =
                    '<i class="fas fa-calendar mr-1"></i>(Pricing akan diterapkan pada rentang tanggal tertentu)';

                // Enable all days for range pricing
                enableAllDays();
            }

            // Check for potential duplicates
            checkDuplicates();
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
                    input.classList.remove('bg-gray-100', 'cursor-not-allowed');
                    statusElement.innerHTML =
                        '<span class="text-green-600 font-medium"><i class="fas fa-check-circle mr-1"></i>Aktif dalam season</span>';
                } else {
                    dayElement.classList.add('opacity-50');
                    input.disabled = true;
                    input.value = '';
                    input.classList.add('bg-gray-100', 'cursor-not-allowed');
                    statusElement.innerHTML =
                        '<span class="text-gray-400"><i class="fas fa-times-circle mr-1"></i>Tidak aktif dalam season</span>';
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
                input.classList.remove('bg-gray-100', 'cursor-not-allowed');
                statusElement.innerHTML =
                    '<span class="text-blue-600"><i class="fas fa-check mr-1"></i>Tersedia untuk pricing</span>';
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
                input.classList.remove('bg-gray-100', 'cursor-not-allowed');
                statusElement.innerHTML = '';
            });

            pricingNote.innerHTML = '';
            document.getElementById('range-pricing').classList.add('hidden');
        }

        function getDayNames(dayNumbers) {
            const dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            return dayNumbers.map(num => dayNames[num] || '');
        }

        function checkDuplicates() {
            const villaId = document.getElementById('villa_id').value;
            const seasonId = document.getElementById('season_id').value;
            const warningDiv = document.getElementById('duplicate-warning');

            if (villaId && seasonId) {
                // Show warning for now, you can implement AJAX check to backend
                warningDiv.classList.remove('hidden');
            } else {
                warningDiv.classList.add('hidden');
            }
        }

        // Quick Actions Functions
        function copyWeekdayPrice() {
            const mondayPrice = document.getElementById('monday_pricing').value;
            if (mondayPrice) {
                ['tuesday_pricing', 'wednesday_pricing', 'thursday_pricing', 'friday_pricing'].forEach(id => {
                    const input = document.getElementById(id);
                    if (!input.disabled) {
                        input.value = mondayPrice;
                    }
                });
                updatePriceSummary();
                showToast('Harga Senin berhasil disalin ke hari kerja lainnya!', 'success');
            } else {
                showToast('Isi harga Senin terlebih dahulu!', 'warning');
            }
        }

        function copyWeekendPrice() {
            const saturdayPrice = document.getElementById('saturday_pricing').value;
            if (saturdayPrice) {
                const sundayInput = document.getElementById('sunday_pricing');
                if (!sundayInput.disabled) {
                    sundayInput.value = saturdayPrice;
                    updatePriceSummary();
                    showToast('Harga Sabtu berhasil disalin ke Minggu!', 'success');
                }
            } else {
                showToast('Isi harga Sabtu terlebih dahulu!', 'warning');
            }
        }

        function fillSamplePrices() {
            if (confirm('Apakah Anda ingin mengisi dengan contoh harga? (Weekday: 500k, Weekend: 750k)')) {
                const weekdayPrice = 500000;
                const weekendPrice = 750000;

                // Weekdays
                ['monday_pricing', 'tuesday_pricing', 'wednesday_pricing', 'thursday_pricing', 'friday_pricing'].forEach(
                    id => {
                        const input = document.getElementById(id);
                        if (!input.disabled) {
                            input.value = weekdayPrice;
                        }
                    });

                // Weekends
                ['saturday_pricing', 'sunday_pricing'].forEach(id => {
                    const input = document.getElementById(id);
                    if (!input.disabled) {
                        input.value = weekendPrice;
                    }
                });

                updatePriceSummary();
                showToast('Contoh harga berhasil diisi!', 'success');
            }
        }

        function clearAllPrices() {
            if (confirm('Apakah Anda yakin ingin menghapus semua harga?')) {
                ['sunday_pricing', 'monday_pricing', 'tuesday_pricing', 'wednesday_pricing', 'thursday_pricing',
                    'friday_pricing', 'saturday_pricing'
                ].forEach(id => {
                    const input = document.getElementById(id);
                    if (!input.disabled) {
                        input.value = '';
                    }
                });
                updatePriceSummary();
                showToast('Semua harga berhasil dihapus!', 'info');
            }
        }

        function resetForm() {
            if (confirm('Apakah Anda yakin ingin mereset seluruh form?')) {
                document.getElementById('pricing-form').reset();
                document.getElementById('season-info').classList.add('hidden');
                document.getElementById('duplicate-warning').classList.add('hidden');
                document.getElementById('price-summary').classList.add('hidden');
                resetPricingDisplay();
                localStorage.removeItem('villa_pricing_draft_new');
                showToast('Form berhasil direset!', 'info');
            }
        }

        function updatePriceSummary() {
            const inputs = ['sunday_pricing', 'monday_pricing', 'tuesday_pricing', 'wednesday_pricing', 'thursday_pricing',
                'friday_pricing', 'saturday_pricing'
            ];
            const prices = [];
            let filledCount = 0;

            inputs.forEach(id => {
                const input = document.getElementById(id);
                if (input.value && !input.disabled) {
                    const price = parseInt(input.value);
                    if (!isNaN(price) && price > 0) {
                        prices.push(price);
                        filledCount++;
                    }
                }
            });

            const summaryDiv = document.getElementById('price-summary');
            const filledDaysSpan = document.getElementById('filled-days');
            const highestPriceSpan = document.getElementById('highest-price');
            const lowestPriceSpan = document.getElementById('lowest-price');
            const averagePriceSpan = document.getElementById('average-price');

            if (filledCount > 0) {
                summaryDiv.classList.remove('hidden');
                filledDaysSpan.textContent = filledCount;

                const highest = Math.max(...prices);
                const lowest = Math.min(...prices);
                const average = Math.round(prices.reduce((a, b) => a + b, 0) / prices.length);

                highestPriceSpan.textContent = 'Rp ' + highest.toLocaleString('id-ID');
                lowestPriceSpan.textContent = 'Rp ' + lowest.toLocaleString('id-ID');
                averagePriceSpan.textContent = 'Rp ' + average.toLocaleString('id-ID');
            } else {
                summaryDiv.classList.add('hidden');
            }
        }

        function showToast(message, type = 'info') {
            // Simple toast notification
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 px-4 py-3 rounded shadow-lg text-white z-50 ${
                type === 'success' ? 'bg-green-500' :
                type === 'warning' ? 'bg-yellow-500' :
                type === 'error' ? 'bg-red-500' : 'bg-blue-500'
            }`;
            toast.innerHTML =
                `<i class="fas fa-${type === 'success' ? 'check' : type === 'warning' ? 'exclamation-triangle' : type === 'error' ? 'times' : 'info-circle'} mr-2"></i>${message}`;

            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

        // Initialize on page load if season is already selected
        if (document.getElementById('season_id').value) {
            handleSeasonChange();
        }

        // Auto-save draft functionality
        let saveTimeout;

        function autoSaveDraft() {
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(() => {
                const formData = new FormData(document.getElementById('pricing-form'));
                const draftData = {};

                for (let [key, value] of formData.entries()) {
                    if (value) {
                        draftData[key] = value;
                    }
                }

                localStorage.setItem('villa_pricing_draft_new', JSON.stringify(draftData));

                // Show subtle save indicator
                const saveIndicator = document.createElement('div');
                saveIndicator.className = 'fixed bottom-4 right-4 bg-gray-800 text-white px-3 py-1 rounded text-sm';
                saveIndicator.innerHTML = '<i class="fas fa-save mr-1"></i>Draft saved';
                document.body.appendChild(saveIndicator);

                setTimeout(() => {
                    saveIndicator.remove();
                }, 2000);
            }, 2000);
        }

        // Attach auto-save to form inputs
        document.querySelectorAll('input, select').forEach(input => {
            input.addEventListener('change', () => {
                autoSaveDraft();
                updatePriceSummary();

                // Check duplicates when villa or season changes
                if (input.id === 'villa_id' || input.id === 'season_id') {
                    checkDuplicates();
                }
            });
        });

        // Load draft on page load
        document.addEventListener('DOMContentLoaded', function() {
            const savedDraft = localStorage.getItem('villa_pricing_draft_new');
            if (savedDraft) {
                try {
                    const draftData = JSON.parse(savedDraft);

                    // Only restore if user confirms
                    if (confirm('Ditemukan draft yang belum disimpan. Restore draft?')) {
                        Object.keys(draftData).forEach(key => {
                            const input = document.querySelector(`[name="${key}"]`);
                            if (input && draftData[key]) {
                                input.value = draftData[key];

                                // Trigger change event for season/villa
                                if (key === 'season_id' || key === 'villa_id') {
                                    input.dispatchEvent(new Event('change'));
                                }
                            }
                        });
                        updatePriceSummary();
                        showToast('Draft berhasil di-restore!', 'info');
                    }
                } catch (e) {
                    console.log('Error loading draft:', e);
                }
            }
        });

        // Clear draft on successful submit
        document.getElementById('pricing-form').addEventListener('submit', function() {
            localStorage.removeItem('villa_pricing_draft_new');
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + S to save
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                document.getElementById('pricing-form').submit();
            }

            // Esc to cancel
            if (e.key === 'Escape') {
                if (confirm('Apakah Anda yakin ingin membatalkan dan kembali?')) {
                    window.location.href = '{{ route('villa-pricing.index') }}';
                }
            }
        });

        // Add visual feedback for form validation
        document.getElementById('pricing-form').addEventListener('submit', function(e) {
            const requiredInputs = document.querySelectorAll('input[required], select[required]');
            let hasError = false;

            requiredInputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('border-red-500');
                    hasError = true;
                } else {
                    input.classList.remove('border-red-500');
                }
            });

            // Check if at least one price is filled
            const priceInputs = ['sunday_pricing', 'monday_pricing', 'tuesday_pricing', 'wednesday_pricing',
                'thursday_pricing', 'friday_pricing', 'saturday_pricing'
            ];
            const hasPrice = priceInputs.some(id => {
                const input = document.getElementById(id);
                return input.value && !input.disabled && parseInt(input.value) > 0;
            });

            if (!hasPrice) {
                showToast('Minimal isi satu harga untuk hari yang aktif!', 'error');
                hasError = true;
            }

            if (hasError) {
                e.preventDefault();
                showToast('Mohon lengkapi semua field yang wajib diisi!', 'error');

                // Scroll to first error
                const firstError = document.querySelector('.border-red-500');
                if (firstError) {
                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    firstError.focus();
                }
            }
        });

        // Enhanced form interaction
        document.querySelectorAll('input[type="number"]').forEach(input => {
            // Add focus effects
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-blue-500', 'ring-opacity-50');
            });

            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-blue-500', 'ring-opacity-50');
                updatePriceSummary();
            });

            // Format display on blur
            input.addEventListener('blur', function() {
                if (this.value) {
                    const value = parseInt(this.value);
                    if (!isNaN(value)) {
                        // Add thousand separators in title
                        this.title = `Rp ${value.toLocaleString('id-ID')}`;
                    }
                }
            });

            // Prevent negative values
            input.addEventListener('input', function() {
                if (this.value < 0) {
                    this.value = 0;
                }
            });
        });

        // Initial price summary update
        updatePriceSummary();
    </script>
</x-app-layout>
