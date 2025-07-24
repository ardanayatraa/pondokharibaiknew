<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-sm text-gray-800">Edit Harga Villa</h2>
    </x-slot>

    <div class="py-2">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="w-full mb-4 bg-white dark:bg-gray-900 py-4 px-6">
                <h2 class="text-sm font-bold">
                    Edit Harga Villa
                </h2>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-6">
                <form action="{{ route('harga-villa.update', $pricing->id_villa_pricing) }}" method="POST"
                    id="form-edit-pricing">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        {{-- 1) Pilih Villa --}}
                        <div>
                            <x-label for="villa_id" value="Villa" />
                            <select id="villa_id" name="villa_id"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="" disabled
                                    {{ old('villa_id') ?? $pricing->villa_id ? '' : 'selected' }}>
                                    -- Pilih Villa --
                                </option>
                                @foreach ($villas as $villa)
                                    <option value="{{ $villa->id_villa }}"
                                        {{ (old('villa_id') ?? $pricing->villa_id) == $villa->id_villa ? 'selected' : '' }}>
                                        {{ $villa->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('villa_id')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- 2) Pilih Season --}}
                        <div>
                            <x-label for="season_id" value="Season" />
                            <select id="season_id" name="season_id"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="" disabled
                                    {{ old('season_id') ?? $pricing->season_id ? '' : 'selected' }}>
                                    -- Pilih Season --
                                </option>
                                @foreach ($seasons as $season)
                                    <option value="{{ $season->id_season }}"
                                        {{ (old('season_id') ?? $pricing->season_id) == $season->id_season ? 'selected' : '' }}>
                                        {{ $season->nama_season }} ({{ $season->periode_label }})
                                    </option>
                                @endforeach
                            </select>
                            @error('season_id')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- 3) Checkbox: Samakan Semua Hari --}}
                        <div id="container-samakan-semua" class="flex items-center space-x-2">
                            <input type="checkbox" id="samakan_semua"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded" />
                            <label for="samakan_semua" class="font-medium text-gray-700">
                                Samakan Harga ke Semua Hari
                            </label>
                        </div>

                        {{-- 6) Input harga tunggal (muncul jika "samakan semua" dicentang) --}}
                        <div id="container-harga-semua" class="mt-2" style="display: none;">
                            <x-label for="harga_semua" value="Harga Semua Hari" />
                            <x-input id="harga_semua" name="harga_semua" type="number" min="0"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Masukkan harga yang sama untuk semua hari" />
                            <span class="text-sm text-gray-500">
                                Nilai ini akan diterapkan ke semua hari sesuai season.
                            </span>
                        </div>

                        {{-- 5) Container tempat input harga per-hari --}}
                        <div id="container-pricing-fields"
                            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                            {{-- Render awal berdasarkan $pricing->season->days_of_week --}}
                            @php
                                $mappingNamaHari = [
                                    0 => 'sunday',
                                    1 => 'monday',
                                    2 => 'tuesday',
                                    3 => 'wednesday',
                                    4 => 'thursday',
                                    5 => 'friday',
                                    6 => 'saturday',
                                ];
                                $initialDays = $pricing->season->days_of_week ?? [];
                            @endphp

                            @foreach ($initialDays as $dayIndex)
                                @php
                                    $dayName = $mappingNamaHari[$dayIndex];
                                    $fieldValue = old($dayName . '_pricing', $pricing->{$dayName . '_pricing'});
                                @endphp
                                <div class="pricing-field" data-day="{{ $dayName }}">
                                    <x-label for="{{ $dayName }}_pricing" :value="ucfirst($dayName) . ' Pricing'" />
                                    <x-input id="{{ $dayName }}_pricing" name="{{ $dayName }}_pricing"
                                        type="number" min="0"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        :value="$fieldValue" placeholder="Kosongkan jika tidak ada" />
                                    @error($dayName . '_pricing')
                                        <span class="text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- 7) Range Date Price Override --}}
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Override Harga untuk Periode Tertentu
                        </h3>
                        <p class="text-sm text-gray-600 mb-4">
                            Gunakan untuk override harga reguler atau special price pada tanggal tertentu
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <x-label for="start_date" value="Tanggal Mulai" />
                                <x-input id="start_date" name="start_date" type="date"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    value="{{ old('start_date') }}" />
                                @error('start_date')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <x-label for="end_date" value="Tanggal Selesai" />
                                <x-input id="end_date" name="end_date" type="date"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    value="{{ old('end_date') }}" />
                                @error('end_date')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <x-label for="range_date_price_value" value="Harga Override" />
                                <x-input id="range_date_price_value" name="range_date_price_value" type="number"
                                    min="0"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Harga untuk periode ini" />
                                <span class="text-sm text-gray-500">Kosongkan jika tidak ingin override</span>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="button" id="btn-add-range-date-price"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Tambah Range Date Price
                            </button>
                        </div>
                    </div>

                    {{-- 8) Special Price untuk Range Date Tertentu --}}
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Special Price untuk Tanggal Tertentu
                        </h3>
                        <p class="text-sm text-gray-600 mb-4">
                            Gunakan untuk memberikan special price pada tanggal/periode tertentu (prioritas
                            tertinggi)
                        </p>

                        <div class="flex items-center space-x-2 mb-4">
                            <input type="checkbox" id="use_special_price_for_range" name="use_special_price_for_range"
                                value="1" class="h-4 w-4 text-indigo-600 border-gray-300 rounded"
                                {{ old('use_special_price_for_range', $pricing->special_price_range ? true : false) ? 'checked' : '' }} />
                            <label for="use_special_price_for_range" class="font-medium text-gray-700">
                                Aktifkan Special Price untuk Tanggal Tertentu
                            </label>
                        </div>

                        <div id="container-special-price-range"
                            style="{{ old('use_special_price_for_range', $pricing->special_price_range ? true : false) ? '' : 'display: none;' }}">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <x-label for="special_price_start_date" value="Tanggal Mulai Special Price" />
                                    <x-input id="special_price_start_date" name="special_price_start_date"
                                        type="date"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        value="{{ old('special_price_start_date') }}" />
                                    @error('special_price_start_date')
                                        <span class="text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <x-label for="special_price_end_date" value="Tanggal Selesai Special Price" />
                                    <x-input id="special_price_end_date" name="special_price_end_date" type="date"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        value="{{ old('special_price_end_date') }}" />
                                    @error('special_price_end_date')
                                        <span class="text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <x-label for="special_price_range" value="Harga Special" />
                                    <x-input id="special_price_range" name="special_price_range" type="number"
                                        min="0"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        value="{{ old('special_price_range') }}"
                                        placeholder="Masukkan harga special" />
                                    @error('special_price_range')
                                        <span class="text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end mt-4">
                            <button type="button" id="btn-add-special-price-range"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Tambah Special Price Range
                            </button>
                        </div>
                    </div>

                    {{-- 9) Informasi Prioritas Pricing --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                        <h4 class="font-medium text-blue-900 mb-2">Prioritas Penggunaan Harga:</h4>
                        <ol class="list-decimal list-inside text-sm text-blue-800 space-y-1">
                            <li><strong>Special Price untuk Tanggal Tertentu</strong> - Prioritas tertinggi</li>
                            <li><strong>Override Harga untuk Periode Tertentu</strong> - Prioritas kedua</li>
                            <li><strong>Special Price Global</strong> - Prioritas ketiga</li>
                            <li><strong>Harga per Hari</strong> - Prioritas terendah (default)</li>
                        </ol>
                    </div>

                    {{-- 10) Daftar Range Date Price yang Sudah Ada --}}
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Range Date Price yang Sudah Ada</h3>
                        <div id="existing-range-date-prices" class="space-y-4">
                            @if ($pricing->range_date_price)
                                @php
                                    $rangeDatePrices = isset($pricing->range_date_price['dates'])
                                        ? [$pricing->range_date_price]
                                        : $pricing->range_date_price;
                                @endphp
                                @foreach ($rangeDatePrices as $index => $range)
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="font-medium">{{ $range['start_date'] }} -
                                                    {{ $range['end_date'] }}</p>
                                                <p class="text-sm text-gray-600">
                                                    {{ $range['description'] ?? 'Harga khusus untuk periode tertentu' }}
                                                </p>
                                                <p class="text-sm font-semibold text-green-600">Rp
                                                    {{ number_format($range['price'], 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-gray-500 italic">Belum ada range date price yang ditambahkan</p>
                            @endif
                        </div>
                    </div>

                    {{-- 11) Daftar Special Price Range yang Sudah Ada --}}
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Special Price Range yang Sudah Ada</h3>
                        <div id="existing-special-price-ranges" class="space-y-4">
                            @if ($pricing->special_price_range)
                                @php
                                    $specialPriceRanges = isset($pricing->special_price_range['dates'])
                                        ? [$pricing->special_price_range]
                                        : $pricing->special_price_range;
                                @endphp
                                @foreach ($specialPriceRanges as $index => $range)
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="font-medium">{{ $range['start_date'] }} -
                                                    {{ $range['end_date'] }}</p>
                                                <p class="text-sm text-gray-600">
                                                    {{ $range['description'] ?? 'Special price untuk tanggal tertentu' }}
                                                </p>
                                                <p class="text-sm font-semibold text-green-600">Rp
                                                    {{ number_format($range['price'], 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-gray-500 italic">Belum ada special price range yang ditambahkan</p>
                            @endif
                        </div>
                    </div>

                    {{-- Tombol Simpan / Batal --}}
                    <div class="mt-6 flex justify-end space-x-4">
                        <a href="{{ route('harga-villa.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100">
                            Batal
                        </a>
                        <x-button>
                            Perbarui
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ---------------------------------------------
         SCRIPT: Generate/Render Input Harga Berdasarkan season_id + Prefill dari $pricing
        --------------------------------------------- --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dayMap = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

            // Kirim array { id: season_id, days: days_of_week } ke JS
            const seasons = @json(
                $seasons->map(fn($s) => [
                        'id' => $s->id_season,
                        'days' => $s->days_of_week,
                    ]));

            // DOM Elements
            const selectSeason = document.getElementById('season_id');
            const containerFields = document.getElementById('container-pricing-fields');
            const checkboxSemua = document.getElementById('samakan_semua');
            const containerSamakan = document.getElementById('container-samakan-semua');
            const containerHargaAll = document.getElementById('container-harga-semua');
            const inputHargaAll = document.getElementById('harga_semua');

            // Hapus semua elemen child di container-pricing-fields
            function clearPricingFields() {
                while (containerFields.firstChild) {
                    containerFields.removeChild(containerFields.firstChild);
                }
            }

            // Cari days_of_week berdasarkan season_id
            function getDaysBySeasonId(seasonId) {
                const found = seasons.find(s => s.id === parseInt(seasonId));
                return found ? found.days : [];
            }

            // Render input harga per hari berdasarkan array daysArray
            function renderPricingFields(daysArray) {
                clearPricingFields();

                daysArray.forEach(dayIndex => {
                    const dayName = dayMap[dayIndex];
                    const labelText = dayName.charAt(0).toUpperCase() + dayName.slice(1) + ' Pricing';

                    const wrapper = document.createElement('div');
                    wrapper.classList.add('pricing-field');
                    wrapper.dataset.day = dayName;

                    // Label
                    const label = document.createElement('label');
                    label.setAttribute('for', `${dayName}_pricing`);
                    label.classList.add('block', 'text-sm', 'font-medium', 'text-gray-700');
                    label.textContent = labelText;

                    // Input
                    const input = document.createElement('input');
                    input.type = 'number';
                    input.min = '0';
                    input.id = `${dayName}_pricing`;
                    input.name = `${dayName}_pricing`;
                    input.placeholder = 'Kosongkan jika tidak ada';
                    input.classList.add(
                        'mt-1', 'block', 'w-full', 'border-gray-300',
                        'rounded-md', 'shadow-sm', 'focus:ring-indigo-500', 'focus:border-indigo-500'
                    );

                    // Prefill: jika old() ada (validasi gagal), else value awal sudah di-embed di blade
                    @foreach ($initialDays as $dayIndexLoop)
                        @php $dName = $mappingNamaHari[$dayIndexLoop]; @endphp
                        if (dayName === '{{ $dName }}') {
                            const oldVal = '{{ old("$dName" . '_pricing') }}';
                            if (oldVal !== '') {
                                input.value = oldVal;
                            } else {
                                input.value = '{{ $pricing->{$dName . '_pricing'} }}';
                            }
                        }
                    @endforeach

                    wrapper.appendChild(label);
                    wrapper.appendChild(input);
                    containerFields.appendChild(wrapper);
                });
            }


            // Event: season_id berubah
            selectSeason.addEventListener('change', function() {
                const selectedId = this.value;
                const daysArray = getDaysBySeasonId(selectedId);

                if (daysArray.length > 0) {
                    containerSamakan.style.display = 'flex';
                    checkboxSemua.checked = false;
                    containerHargaAll.style.display = 'none';
                    inputHargaAll.value = '';
                    renderPricingFields(daysArray);
                } else {
                    clearPricingFields();
                    containerSamakan.style.display = 'none';
                    containerHargaAll.style.display = 'none';
                }
            });

            // Event: checkbox "Samakan Semua Hari"
            checkboxSemua.addEventListener('change', function() {
                if (checkboxSemua.checked) {
                    containerHargaAll.style.display = 'block';
                    inputHargaAll.addEventListener('input', function() {
                        const valAll = inputHargaAll.value || '';
                        containerFields.querySelectorAll('input[type="number"]').forEach(el => {
                            el.value = valAll;
                        });
                    });
                } else {
                    containerHargaAll.style.display = 'none';
                    inputHargaAll.value = '';
                }
            });

            // Inisialisasi awal: langsung render fields sesuai $pricing->season
            (function initialRender() {
                const initialId = '{{ $pricing->season_id }}';
                const initialDays = getDaysBySeasonId(initialId);
                if (initialDays.length > 0) {
                    renderPricingFields(initialDays);
                }
            })();

            // Jika validasi gagal (ada old('season_id')), ulangi render
            @if (old('season_id'))
                selectSeason.value = '{{ old('season_id') }}';
                selectSeason.dispatchEvent(new Event('change'));
            @endif

            // Event: checkbox "Special Price Range"
            const checkboxSpecialPriceRange = document.getElementById('use_special_price_for_range');
            const containerSpecialPriceRange = document.getElementById('container-special-price-range');

            if (checkboxSpecialPriceRange) {
                checkboxSpecialPriceRange.addEventListener('change', function() {
                    if (checkboxSpecialPriceRange.checked) {
                        containerSpecialPriceRange.style.display = 'block';
                    } else {
                        containerSpecialPriceRange.style.display = 'none';
                        document.getElementById('special_price_start_date').value = '';
                        document.getElementById('special_price_end_date').value = '';
                        document.getElementById('special_price_range').value = '';
                    }
                });
            }

            // Event: Tambah Range Date Price
            const btnAddRangeDatePrice = document.getElementById('btn-add-range-date-price');
            const existingRangeDatePrices = document.getElementById('existing-range-date-prices');

            if (btnAddRangeDatePrice) {
                btnAddRangeDatePrice.addEventListener('click', function() {
                    const startDate = document.getElementById('start_date').value;
                    const endDate = document.getElementById('end_date').value;
                    const price = document.getElementById('range_date_price_value').value;
                    const villaId = document.getElementById('villa_id').value;
                    const pricingId = '{{ $pricing->id_villa_pricing }}';

                    // Validasi
                    if (!startDate || !endDate || !price) {
                        alert('Semua field harus diisi!');
                        return;
                    }

                    // Kirim data ke server menggunakan AJAX
                    fetch('{{ route('harga-villa.add-range-date-price') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                villa_pricing_id: pricingId,
                                villa_id: villaId,
                                start_date: startDate,
                                end_date: endDate,
                                price: price
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Tambahkan range date price baru ke daftar
                                const newItem = document.createElement('div');
                                newItem.classList.add('bg-gray-50', 'p-4', 'rounded-lg', 'border',
                                    'border-gray-200');

                                newItem.innerHTML = `
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="font-medium">${startDate} - ${endDate}</p>
                                        <p class="text-sm text-gray-600">Harga khusus untuk periode tertentu</p>
                                        <p class="text-sm font-semibold text-green-600">Rp ${parseInt(price).toLocaleString('id-ID')}</p>
                                    </div>
                                </div>
                            `;

                                // Hapus pesan "Belum ada range date price" jika ada
                                const emptyMessage = existingRangeDatePrices.querySelector(
                                    '.text-gray-500.italic');
                                if (emptyMessage) {
                                    emptyMessage.remove();
                                }

                                existingRangeDatePrices.appendChild(newItem);

                                // Reset form
                                document.getElementById('start_date').value = '';
                                document.getElementById('end_date').value = '';
                                document.getElementById('range_date_price_value').value = '';

                                alert('Range date price berhasil ditambahkan!');
                            } else {
                                alert('Gagal menambahkan range date price: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan saat menambahkan range date price');
                        });
                });
            }

            // Event: Tambah Special Price Range
            const btnAddSpecialPriceRange = document.getElementById('btn-add-special-price-range');
            const existingSpecialPriceRanges = document.getElementById('existing-special-price-ranges');

            if (btnAddSpecialPriceRange) {
                btnAddSpecialPriceRange.addEventListener('click', function() {
                    const startDate = document.getElementById('special_price_start_date').value;
                    const endDate = document.getElementById('special_price_end_date').value;
                    const price = document.getElementById('special_price_range').value;
                    const villaId = document.getElementById('villa_id').value;
                    const pricingId = '{{ $pricing->id_villa_pricing }}';

                    // Validasi
                    if (!startDate || !endDate || !price) {
                        alert('Semua field harus diisi!');
                        return;
                    }

                    // Kirim data ke server menggunakan AJAX
                    fetch('{{ route('harga-villa.add-special-price-range') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                villa_pricing_id: pricingId,
                                villa_id: villaId,
                                start_date: startDate,
                                end_date: endDate,
                                price: price
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Tambahkan special price range baru ke daftar
                                const newItem = document.createElement('div');
                                newItem.classList.add('bg-gray-50', 'p-4', 'rounded-lg', 'border',
                                    'border-gray-200');

                                newItem.innerHTML = `
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="font-medium">${startDate} - ${endDate}</p>
                                        <p class="text-sm text-gray-600">Special price untuk tanggal tertentu</p>
                                        <p class="text-sm font-semibold text-green-600">Rp ${parseInt(price).toLocaleString('id-ID')}</p>
                                    </div>
                                </div>
                            `;

                                // Hapus pesan "Belum ada special price range" jika ada
                                const emptyMessage = existingSpecialPriceRanges.querySelector(
                                    '.text-gray-500.italic');
                                if (emptyMessage) {
                                    emptyMessage.remove();
                                }

                                existingSpecialPriceRanges.appendChild(newItem);

                                // Reset form
                                document.getElementById('special_price_start_date').value = '';
                                document.getElementById('special_price_end_date').value = '';
                                document.getElementById('special_price_range').value = '';

                                alert('Special price range berhasil ditambahkan!');
                            } else {
                                alert('Gagal menambahkan special price range: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan saat menambahkan special price range');
                        });
                });
            }
        });
    </script>
</x-app-layout>
