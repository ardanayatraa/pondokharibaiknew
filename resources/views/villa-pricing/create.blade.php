<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Villa Pricing') }}
            </h2>
            <a href="{{ route('villa-pricing.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                There were {{ count($errors) }} errors with your submission
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('villa-pricing.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Basic Information Card --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-medium text-gray-900">Basic Information</h3>
                        <p class="mt-1 text-sm text-gray-600">Select the villa and season for this pricing
                            configuration.</p>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="villa_id" class="block text-sm font-medium text-gray-900 mb-2">
                                    Villa <span class="text-red-500">*</span>
                                </label>
                                <select name="villa_id" id="villa_id" required
                                    class="block w-full rounded-md border-0 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    <option value="">Choose a villa...</option>
                                    @foreach ($villas as $villa)
                                        <option value="{{ $villa->id_villa }}"
                                            {{ old('villa_id') == $villa->id_villa ? 'selected' : '' }}>
                                            {{ $villa->nama_villa }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="mt-1 text-xs text-gray-500">Select the villa for which you want to set
                                    pricing.</p>
                            </div>

                            <div>
                                <label for="season_id" class="block text-sm font-medium text-gray-900 mb-2">
                                    Season <span class="text-red-500">*</span>
                                </label>
                                <select name="season_id" id="season_id" required
                                    class="block w-full rounded-md border-0 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    <option value="">Choose a season...</option>
                                    @foreach ($seasons as $season)
                                        <option value="{{ $season->id_season }}"
                                            {{ old('season_id') == $season->id_season ? 'selected' : '' }}>
                                            {{ $season->nama_season }}
                                            @if ($season->periode_label !== '-')
                                                - {{ $season->periode_label }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                <p class="mt-1 text-xs text-gray-500">Select the season period for this pricing.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Daily Pricing Card --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-medium text-gray-900">Daily Pricing</h3>
                        <p class="mt-1 text-sm text-gray-600">Set the base price for each day of the week.</p>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
                            @php
                                $days = [
                                    'sunday' => ['label' => 'Sunday', 'short' => 'Sun'],
                                    'monday' => ['label' => 'Monday', 'short' => 'Mon'],
                                    'tuesday' => ['label' => 'Tuesday', 'short' => 'Tue'],
                                    'wednesday' => ['label' => 'Wednesday', 'short' => 'Wed'],
                                    'thursday' => ['label' => 'Thursday', 'short' => 'Thu'],
                                    'friday' => ['label' => 'Friday', 'short' => 'Fri'],
                                    'saturday' => ['label' => 'Saturday', 'short' => 'Sat'],
                                ];
                            @endphp

                            @foreach ($days as $day => $info)
                                <div class="text-center">
                                    <label for="{{ $day }}_pricing"
                                        class="block text-sm font-medium text-gray-900 mb-2">
                                        <span class="hidden md:block">{{ $info['label'] }}</span>
                                        <span class="md:hidden">{{ $info['short'] }}</span>
                                    </label>
                                    <div class="relative">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-gray-500 sm:text-sm">Rp</span>
                                        </div>
                                        <input type="number" name="{{ $day }}_pricing"
                                            id="{{ $day }}_pricing" min="0" step="1000"
                                            value="{{ old($day . '_pricing') }}"
                                            class="block w-full rounded-md border-0 py-2 pl-12 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                            placeholder="0">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 p-3 bg-blue-50 rounded-md">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        <strong>Tip:</strong> Leave empty (0) for days when the villa is not available.
                                        You can use increments of 1000 for easier input.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Global Special Price Card --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-medium text-gray-900">Global Special Price</h3>
                        <p class="mt-1 text-sm text-gray-600">Override daily pricing with a fixed special price
                            (optional).</p>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" name="use_special_price" id="use_special_price"
                                        value="1" {{ old('use_special_price') ? 'checked' : '' }}
                                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                </div>
                                <div class="ml-3">
                                    <label for="use_special_price" class="text-sm font-medium text-gray-900">
                                        Enable Global Special Price
                                    </label>
                                    <p class="text-sm text-gray-500">
                                        When enabled, this price will override the daily pricing for all days.
                                    </p>
                                </div>
                            </div>

                            <div id="special-price-fields" class="grid grid-cols-1 md:grid-cols-2 gap-4"
                                style="display: {{ old('use_special_price') ? 'grid' : 'none' }};">
                                <div>
                                    <label for="special_price"
                                        class="block text-sm font-medium text-gray-900 mb-2">Special Price</label>
                                    <div class="relative">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-gray-500 sm:text-sm">Rp</span>
                                        </div>
                                        <input type="number" name="special_price" id="special_price" min="0"
                                            step="1000" value="{{ old('special_price') }}"
                                            class="block w-full rounded-md border-0 py-2 pl-12 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                            placeholder="0">
                                    </div>
                                </div>
                                <div>
                                    <label for="special_price_description"
                                        class="block text-sm font-medium text-gray-900 mb-2">Description</label>
                                    <input type="text" name="special_price_description"
                                        id="special_price_description" value="{{ old('special_price_description') }}"
                                        class="block w-full rounded-md border-0 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                        placeholder="e.g., Holiday Special, Promotion Price">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Range Date Prices Card --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Range Date Prices</h3>
                                <p class="mt-1 text-sm text-gray-600">Set specific prices for date ranges (optional).
                                </p>
                            </div>
                            <button type="button" id="add-range-date-price"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Range
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <div id="range-date-prices-container" class="space-y-4">
                            <div class="text-center py-8 text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="mt-2 text-sm">No range date prices added yet. Click "Add Range" to add
                                    specific pricing for date ranges.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Special Price Ranges Card --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Special Price Ranges</h3>
                                <p class="mt-1 text-sm text-gray-600">Set high-priority special prices for specific
                                    date ranges (optional).</p>
                            </div>
                            <button type="button" id="add-special-price-range"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Special Range
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <div id="special-price-ranges-container" class="space-y-4">
                            <div class="text-center py-8 text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                                <p class="mt-2 text-sm">No special price ranges added yet. Click "Add Special Range" to
                                    add priority pricing for special periods.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pricing Priority Info --}}
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-amber-800">Pricing Priority System</h3>
                            <div class="mt-2 text-sm text-amber-700">
                                <p class="mb-2">The system uses the following priority order when determining prices:
                                </p>
                                <ol class="list-decimal list-inside space-y-1">
                                    <li><strong>Special Price Ranges</strong> - Highest priority for specific dates</li>
                                    <li><strong>Range Date Prices</strong> - Medium priority for date ranges</li>
                                    <li><strong>Global Special Price</strong> - Override all daily pricing</li>
                                    <li><strong>Daily Pricing</strong> - Base price for each day of the week</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Submit Actions --}}
                <div class="flex items-center justify-end space-x-4 pt-6">
                    <a href="{{ route('villa-pricing.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Create Villa Pricing
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- JavaScript --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle special price fields
            const useSpecialPrice = document.getElementById('use_special_price');
            const specialPriceFields = document.getElementById('special-price-fields');

            useSpecialPrice.addEventListener('change', function() {
                specialPriceFields.style.display = this.checked ? 'grid' : 'none';
            });

            // Range Date Prices Management
            let rangeDatePriceIndex = 0;
            const addRangeDatePrice = document.getElementById('add-range-date-price');
            const rangeDatePricesContainer = document.getElementById('range-date-prices-container');

            addRangeDatePrice.addEventListener('click', function() {
                if (rangeDatePriceIndex === 0) {
                    rangeDatePricesContainer.innerHTML = '';
                }

                const rangeHtml = `
                    <div class="range-date-price-item bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-md font-medium text-blue-900">Range Date Price #${rangeDatePriceIndex + 1}</h4>
                            <button type="button" class="remove-range-date-price inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Remove
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-1">Start Date</label>
                                <input type="date" name="range_date_prices[${rangeDatePriceIndex}][start_date]"
                                       class="block w-full rounded-md border-0 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-1">End Date</label>
                                <input type="date" name="range_date_prices[${rangeDatePriceIndex}][end_date]"
                                       class="block w-full rounded-md border-0 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-1">Price</label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" name="range_date_prices[${rangeDatePriceIndex}][price]" min="0" step="1000"
                                           class="block w-full rounded-md border-0 py-2 pl-12 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                           placeholder="0" required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-1">Description</label>
                                <input type="text" name="range_date_prices[${rangeDatePriceIndex}][description]"
                                       class="block w-full rounded-md border-0 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                       placeholder="e.g., Weekend Rate, Peak Season">
                            </div>
                        </div>
                    </div>
                `;

                rangeDatePricesContainer.insertAdjacentHTML('beforeend', rangeHtml);
                rangeDatePriceIndex++;
            });

            // Remove range date price
            rangeDatePricesContainer.addEventListener('click', function(e) {
                if (e.target.closest('.remove-range-date-price')) {
                    const item = e.target.closest('.range-date-price-item');
                    item.remove();

                    // If no items left, show empty state
                    if (rangeDatePricesContainer.children.length === 0) {
                        rangeDatePricesContainer.innerHTML = `
                            <div class="text-center py-8 text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="mt-2 text-sm">No range date prices added yet. Click "Add Range" to add specific pricing for date ranges.</p>
                            </div>
                        `;
                        rangeDatePriceIndex = 0;
                    }
                }
            });

            // Special Price Ranges Management
            let specialPriceRangeIndex = 0;
            const addSpecialPriceRange = document.getElementById('add-special-price-range');
            const specialPriceRangesContainer = document.getElementById('special-price-ranges-container');

            addSpecialPriceRange.addEventListener('click', function() {
                if (specialPriceRangeIndex === 0) {
                    specialPriceRangesContainer.innerHTML = '';
                }

                const rangeHtml = `
                    <div class="special-price-range-item bg-purple-50 border border-purple-200 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-md font-medium text-purple-900">Special Price Range #${specialPriceRangeIndex + 1}</h4>
                            <button type="button" class="remove-special-price-range inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Remove
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-1">Start Date</label>
                                <input type="date" name="special_price_ranges[${specialPriceRangeIndex}][start_date]"
                                       class="block w-full rounded-md border-0 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-purple-600 sm:text-sm sm:leading-6" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-1">End Date</label>
                                <input type="date" name="special_price_ranges[${specialPriceRangeIndex}][end_date]"
                                       class="block w-full rounded-md border-0 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-purple-600 sm:text-sm sm:leading-6" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-1">Price</label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" name="special_price_ranges[${specialPriceRangeIndex}][price]" min="0" step="1000"
                                           class="block w-full rounded-md border-0 py-2 pl-12 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-purple-600 sm:text-sm sm:leading-6"
                                           placeholder="0" required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-1">Description</label>
                                <input type="text" name="special_price_ranges[${specialPriceRangeIndex}][description]"
                                       class="block w-full rounded-md border-0 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-purple-600 sm:text-sm sm:leading-6"
                                       placeholder="e.g., Holiday Premium, New Year Special">
                            </div>
                        </div>
                    </div>
                `;

                specialPriceRangesContainer.insertAdjacentHTML('beforeend', rangeHtml);
                specialPriceRangeIndex++;
            });

            // Remove special price range
            specialPriceRangesContainer.addEventListener('click', function(e) {
                if (e.target.closest('.remove-special-price-range')) {
                    const item = e.target.closest('.special-price-range-item');
                    item.remove();

                    // If no items left, show empty state
                    if (specialPriceRangesContainer.children.length === 0) {
                        specialPriceRangesContainer.innerHTML = `
                            <div class="text-center py-8 text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                                <p class="mt-2 text-sm">No special price ranges added yet. Click "Add Special Range" to add priority pricing for special periods.</p>
                            </div>
                        `;
                        specialPriceRangeIndex = 0;
                    }
                }
            });
        });
    </script>
</x-app-layout>
