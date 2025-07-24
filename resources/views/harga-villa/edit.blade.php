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

                        {{-- 3) Pilih Jenis Harga --}}
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h3 class="font-semibold text-gray-700 mb-4">Jenis Harga</h3>

                            <div class="space-y-4">
                                {{-- Opsi: Harga per hari --}}
                                <div class="flex items-start">
                                    <input type="radio" id="price_type_daily" name="price_type" value="daily"
                                        class="h-4 w-4 text-indigo-600 border-gray-300 mt-1"
                                        {{ old('use_special_price') ?? $pricing->use_special_price ? '' : 'checked' }} />
                                    <label for="price_type_daily" class="ml-2 block">
                                        <span class="font-medium text-gray-700">Harga per Hari</span>
                                        <span class="block text-sm text-gray-500">
                                            Atur harga berbeda untuk setiap hari dalam seminggu (Senin-Minggu)
                                        </span>
                                    </label>
                                </div>

                                {{-- Opsi: Harga khusus --}}
                                <div class="flex items-start">
                                    <input type="radio" id="price_type_special" name="price_type" value="special"
                                        class="h-4 w-4 text-indigo-600 border-gray-300 mt-1"
                                        {{ old('use_special_price') ?? $pricing->use_special_price ? 'checked' : '' }} />
                                    <label for="price_type_special" class="ml-2 block">
                                        <span class="font-medium text-gray-700">Harga Khusus</span>
                                        <span class="block text-sm text-gray-500">
                                            Atur satu harga untuk seluruh periode (misalnya: liburan, event khusus)
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- 4) Input untuk Harga Khusus --}}
                        <div id="container-special-price" class="bg-white p-4 rounded-lg border border-gray-200"
                            style="{{ old('use_special_price') ?? $pricing->use_special_price ? '' : 'display: none;' }}">
                            <h3 class="font-semibold text-gray-700 mb-4">Detail Harga Khusus</h3>

                            <div class="space-y-4">
                                {{-- Input: Harga Khusus --}}
                                <div>
                                    <x-label for="special_price" value="Harga Khusus" />
                                    <x-input id="special_price" name="special_price" type="number" min="0"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        :value="old('special_price', $pricing->special_price)" placeholder="Masukkan harga khusus" />
                                    @error('special_price')
                                        <span class="text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Input: Deskripsi Harga Khusus --}}
                                <div>
                                    <x-label for="special_price_description" value="Deskripsi Harga Khusus" />
                                    <x-input id="special_price_description" name="special_price_description"
                                        type="text"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        :value="old(
                                            'special_price_description',
                                            $pricing->special_price_description,
                                        )"
                                        placeholder="Contoh: Harga Liburan Natal, Harga Event Khusus, dll." />
                                    <span class="text-sm text-gray-500">
                                        Deskripsi ini akan membantu mengidentifikasi tujuan harga khusus
                                    </span>
                                    @error('special_price_description')
                                        <span class="text-sm text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Hidden input untuk use_special_price --}}
                                <input type="hidden" id="use_special_price" name="use_special_price"
                                    value="{{ old('use_special_price') ?? $pricing->use_special_price ? '1' : '0' }}" />
                            </div>
                        </div>

                        {{-- 5) Checkbox: Samakan Semua Hari (hanya untuk harga per hari) --}}
                        <div id="container-samakan-semua" class="flex items-center space-x-2"
                            style="{{ old('use_special_price') ?? $pricing->use_special_price ? 'display: none;' : 'display: flex;' }}">
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

                        {{-- 7) Container tempat input harga per-hari --}}
                        <div id="container-pricing-fields"
                            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-4"
                            style="{{ old('use_special_price') ?? $pricing->use_special_price ? 'display: none;' : '' }}">
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
            const containerSpecialPrice = document.getElementById('container-special-price');
            const radioPriceTypeDaily = document.getElementById('price_type_daily');
            const radioPriceTypeSpecial = document.getElementById('price_type_special');
            const inputUseSpecialPrice = document.getElementById('use_special_price');

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

            // Toggle UI berdasarkan jenis harga yang dipilih
            function togglePriceTypeUI() {
                if (radioPriceTypeDaily.checked) {
                    // Harga per hari
                    containerSpecialPrice.style.display = 'none';
                    containerFields.style.display = 'grid';
                    containerSamakan.style.display = 'flex';
                    inputUseSpecialPrice.value = '0';
                } else {
                    // Harga khusus
                    containerSpecialPrice.style.display = 'block';
                    containerFields.style.display = 'none';
                    containerSamakan.style.display = 'none';
                    containerHargaAll.style.display = 'none';
                    inputUseSpecialPrice.value = '1';
                }
            }

            // Event: season_id berubah
            selectSeason.addEventListener('change', function() {
                const selectedId = this.value;
                const daysArray = getDaysBySeasonId(selectedId);

                if (daysArray.length > 0) {
                    renderPricingFields(daysArray);
                    togglePriceTypeUI(); // Refresh UI berdasarkan jenis harga
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

            // Event: radio button jenis harga berubah
            radioPriceTypeDaily.addEventListener('change', togglePriceTypeUI);
            radioPriceTypeSpecial.addEventListener('change', togglePriceTypeUI);

            // Inisialisasi awal: langsung render fields sesuai $pricing->season
            (function initialRender() {
                const initialId = '{{ $pricing->season_id }}';
                const initialDays = getDaysBySeasonId(initialId);
                if (initialDays.length > 0) {
                    renderPricingFields(initialDays);
                    togglePriceTypeUI(); // Set UI berdasarkan jenis harga yang dipilih
                }
            })();

            // Jika validasi gagal (ada old('season_id')), ulangi render
            @if (old('season_id'))
                selectSeason.value = '{{ old('season_id') }}';
                selectSeason.dispatchEvent(new Event('change'));
            @endif
        });
    </script>
</x-app-layout>
