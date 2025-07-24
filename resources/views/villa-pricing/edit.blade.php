<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Villa Pricing') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Edit Villa Pricing</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('villa-pricing.show', $villaPricing->id_villa_pricing) }}"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-eye"></i> View
                            </a>
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

                    <!-- Current Data Display -->
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                        <h4 class="text-md font-semibold text-gray-800 mb-3">Data Saat Ini</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <span class="font-medium text-gray-600">ID:</span>
                                <span class="text-gray-900">{{ $villaPricing->id_villa_pricing }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-600">Villa:</span>
                                <span class="text-gray-900">{{ $villaPricing->villa->name ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-600">Season:</span>
                                <span class="text-gray-900">{{ $villaPricing->season->nama_season ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('villa-pricing.update', $villaPricing->id_villa_pricing) }}" method="POST">
                        @csrf
                        @method('PUT')

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
                                            {{ old('villa_id', $villaPricing->villa_id) == $villa->id_villa ? 'selected' : '' }}>
                                            {{ $villa->name }}
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
                                            {{ old('season_id', $villaPricing->season_id) == $season->id_season ? 'selected' : '' }}>
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
                                            value="{{ old('sunday_pricing', $villaPricing->sunday_pricing) }}"
                                            min="0" step="1000"
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
                                            value="{{ old('monday_pricing', $villaPricing->monday_pricing) }}"
                                            min="0" step="1000"
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
                                            value="{{ old('tuesday_pricing', $villaPricing->tuesday_pricing) }}"
                                            min="0" step="1000"
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
                                            value="{{ old('wednesday_pricing', $villaPricing->wednesday_pricing) }}"
                                            min="0" step="1000"
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
                                            value="{{ old('thursday_pricing', $villaPricing->thursday_pricing) }}"
                                            min="0" step="1000"
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
                                            value="{{ old('friday_pricing', $villaPricing->friday_pricing) }}"
                                            min="0" step="1000"
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
                                            value="{{ old('saturday_pricing', $villaPricing->saturday_pricing) }}"
                                            min="0" step="1000"
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

                        <!-- Submit Button -->
                        <div class="flex justify-between items-center pt-6 border-t">
                            <div class="flex space-x-3">
                                <a href="{{ route('villa-pricing.index') }}"
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    <i class="fas fa-times mr-1"></i>Batal
                                </a>
                                <a href="{{ route('villa-pricing.show', $villaPricing->id_villa_pricing) }}"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    <i class="fas fa-eye mr-1"></i>View Detail
                                </a>
                            </div>
                            <button type="submit"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-6 rounded">
                                <i class="fas fa-save mr-2"></i>Update Pricing
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

            // Show season info
            seasonInfo.classList.remove('hidden');

            if (isRepeatWeekly) {
                seasonDetails.innerHTML = `
                    <div class="flex items-center space-x-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-repeat mr-1"></i> Weekly Repeat
                        </span>
                        <span class="text-sm">Berlaku untuk hari: <strong>${getDayNames(daysOfWeek).join(', ')}</strong></span>
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
                    </div>
                `;

                weeklyPricing.classList.remove('hidden');
                rangePricing.classList.remove('hidden');
                pricingNote.innerHTML =
                    '<i class="fas fa-calendar mr-1"></i>(Pricing akan diterapkan pada rentang tanggal tertentu)';

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
                    input.classList.remove('bg-gray-100', 'cursor-not-allowed');
                    statusElement.innerHTML =
                        '<span class="text-green-600 font-medium"><i class="fas fa-check-circle mr-1"></i>Aktif dalam season</span>';
                } else {
                    dayElement.classList.add('opacity-50');
                    input.disabled = true;
                    input.classList.add('bg-gray-100', 'cursor-not-allowed');
                    statusElement.innerHTML =
                        '<span class="text-gray-400"><i class="fas fa-times-circle mr-1"></i>Tidak aktif dalam season ini</span>';
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

        // Quick Actions Functions - Removed per user request

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

        // Initialize on page load since season is already selected
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('season_id').value) {
                handleSeasonChange();
            }
        });

        // Format input on typing
        document.querySelectorAll('input[type="number"]').forEach(input => {
            input.addEventListener('input', function() {
                if (this.value) {
                    // Optional: You can add number formatting here
                    // For now, just ensure it's a valid number
                    if (this.value < 0) {
                        this.value = 0;
                    }
                }
            });
        });

        // Auto-save draft functionality (optional)
        let saveTimeout;

        function autoSaveDraft() {
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(() => {
                const formData = new FormData(document.querySelector('form'));
                const draftData = {};

                for (let [key, value] of formData.entries()) {
                    if (value) {
                        draftData[key] = value;
                    }
                }

                localStorage.setItem('villa_pricing_draft_{{ $villaPricing->id_villa_pricing }}', JSON.stringify(
                    draftData));

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
            input.addEventListener('change', autoSaveDraft);
        });

        // Load draft on page load
        document.addEventListener('DOMContentLoaded', function() {
            const savedDraft = localStorage.getItem('villa_pricing_draft_{{ $villaPricing->id_villa_pricing }}');
            if (savedDraft) {
                try {
                    const draftData = JSON.parse(savedDraft);

                    // Only restore if user confirms
                    if (confirm('Ditemukan draft yang belum disimpan. Restore draft?')) {
                        Object.keys(draftData).forEach(key => {
                            const input = document.querySelector(`[name="${key}"]`);
                            if (input && draftData[key]) {
                                input.value = draftData[key];
                            }
                        });
                        showToast('Draft berhasil di-restore!', 'info');
                    }
                } catch (e) {
                    console.log('Error loading draft:', e);
                }
            }
        });

        // Clear draft on successful submit
        document.querySelector('form').addEventListener('submit', function() {
            localStorage.removeItem('villa_pricing_draft_{{ $villaPricing->id_villa_pricing }}');
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + S to save
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                document.querySelector('form').submit();
            }

            // Esc to cancel
            if (e.key === 'Escape') {
                if (confirm('Apakah Anda yakin ingin membatalkan perubahan?')) {
                    window.location.href = '{{ route('villa-pricing.index') }}';
                }
            }
        });

        // Add visual feedback for form validation
        document.querySelector('form').addEventListener('submit', function(e) {
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
            });

            // Format display on blur
            input.addEventListener('blur', function() {
                if (this.value) {
                    const value = parseInt(this.value);
                    if (!isNaN(value)) {
                        // Optional: Add thousand separators in placeholder or tooltip
                        this.title = `Rp ${value.toLocaleString('id-ID')}`;
                    }
                }
            });
        });
    </script>
</x-app-layout>
