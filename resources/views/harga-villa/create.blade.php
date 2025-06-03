<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-sm text-gray-800">Tambah Harga Villa</h2>
    </x-slot>

    <div class="py-2">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="w-full mb-4 bg-white dark:bg-gray-900 py-4 px-6">
                <h2 class="text-sm font-bold">
                    Tambah Harga Villa
                </h2>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-6">
                <form action="{{ route('harga-villa.store') }}" method="POST" id="form-create-pricing">
                    @csrf

                    <div class="space-y-6">
                        {{-- 1) Pilih Villa --}}
                        <div>
                            <x-label for="villa_id" value="Villa" />
                            <select id="villa_id" name="villa_id"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="" disabled {{ old('villa_id') ? '' : 'selected' }}>-- Pilih Villa
                                    --</option>
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

                        {{-- 2) Pilih Season --}}
                        <div>
                            <x-label for="season_id" value="Season" />
                            <select id="season_id" name="season_id"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="" disabled {{ old('season_id') ? '' : 'selected' }}>-- Pilih Season
                                    --</option>
                                @foreach ($seasons as $season)
                                    <option value="{{ $season->id_season }}"
                                        {{ old('season_id') == $season->id_season ? 'selected' : '' }}>
                                        {{ $season->nama_season }} ({{ $season->periode_label }})
                                    </option>
                                @endforeach
                            </select>
                            @error('season_id')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- 3) Checkbox: Samakan Semua Hari --}}
                        <div id="container-samakan-semua" class="flex items-center space-x-2" style="display: none;">
                            <input type="checkbox" id="samakan_semua"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded" />
                            <label for="samakan_semua" class="font-medium text-gray-700">
                                Samakan Harga ke Semua Hari
                            </label>
                        </div>

                        {{-- 4) Input harga tunggal (muncul jika "samakan semua" dicentang) --}}
                        <div id="container-harga-semua" class="mt-2" style="display: none;">
                            <x-label for="harga_semua" value="Harga Semua Hari" />
                            <x-input id="harga_semua" name="harga_semua" type="number" min="0"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Masukkan harga yang sama untuk semua hari" />
                            <span class="text-sm text-gray-500">Nilai ini akan diterapkan ke semua hari sesuai
                                season.</span>
                        </div>

                        {{-- 5) Container tempat input harga per-hari --}}
                        <div id="container-pricing-fields"
                            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                            {{-- Field akan digenerate di JavaScript berdasarkan season_id --}}
                            @if (old('season_id'))
                                {{-- Saat validasi gagal, kita render ulang fields-nya --}}
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
                                    $oldSeason = collect($seasons)->firstWhere('id_season', old('season_id'));
                                    $oldDaysArray = $oldSeason ? $oldSeason->days_of_week : [];
                                @endphp
                                @foreach ($oldDaysArray as $dayIndex)
                                    @php
                                        $dayName = $mappingNamaHari[$dayIndex];
                                        $fieldValue = old($dayName . '_pricing');
                                    @endphp
                                    <div class="pricing-field" data-day="{{ $dayName }}">
                                        <x-label for="{{ $dayName }}_pricing" :value="ucfirst($dayName) . ' Pricing'" />
                                        <x-input id="{{ $dayName }}_pricing" name="{{ $dayName }}_pricing"
                                            type="number" min="0"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                            value="{{ $fieldValue }}" placeholder="Kosongkan jika tidak ada" />
                                        @error($dayName . '_pricing')
                                            <span class="text-sm text-red-600">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endforeach
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
                            Simpan
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ---------------------------------------------
         SCRIPT: Generate/Render Input Harga Berdasarkan season_id
        --------------------------------------------- --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mapping index hari → nama field
            const dayMap = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

            // Kirim array { id: season_id, days: days_of_week } ke JS
            const seasons = @json(
                $seasons->map(fn($s) => [
                        'id' => $s->id_season,
                        'days' => $s->days_of_week,
                    ]));

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
                    const dayName = dayMap[dayIndex]; // ex: 'monday'
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

                    // Prefill bila old() ada (validasi gagal)
                    @if (old('season_id'))
                        if (selectSeason.value == '{{ old('season_id') }}' && dayName) {
                            const oldVal = '{{ old(`${dayName}_pricing`) }}';
                            if (oldVal !== '') {
                                input.value = oldVal;
                            }
                        }
                    @endif

                    wrapper.appendChild(label);
                    wrapper.appendChild(input);
                    containerFields.appendChild(wrapper);
                });
            }

            // Event: saat season_id berubah
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
                    // Jika season tidak punya days_of_week → sembunyikan
                    containerSamakan.style.display = 'none';
                    containerHargaAll.style.display = 'none';
                    clearPricingFields();
                }
            });

            // Event: checkbox “Samakan Semua Hari”
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

            // Jika validasi gagal (ada old('season_id')), re-trigger event change
            @if (old('season_id'))
                selectSeason.value = '{{ old('season_id') }}';
                selectSeason.dispatchEvent(new Event('change'));
            @endif
        });
    </script>
</x-app-layout>
