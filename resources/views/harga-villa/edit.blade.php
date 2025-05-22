<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-sm text-gray-800">Edit Villa Pricing</h2>
    </x-slot>

    <div class="py-6">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <form action="{{ route('harga-villa.update', $villa_pricing->id_villa_pricing) }}" method="POST"
                    id="pricing-form">
                    @csrf
                    @method('PUT')

                    {{-- PILIH --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        {{-- Villa --}}
                        <div>
                            <label for="villa_id" class="block text-sm font-medium text-gray-700">Villa</label>
                            <select id="villa_id" name="villa_id" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">-- Pilih Villa --</option>
                                @foreach ($villas as $v)
                                    <option value="{{ $v->id_villa }}" @selected(old('villa_id', $villa_pricing->villa_id) == $v->id_villa)>
                                        {{ $v->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('villa_id')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- Season --}}
                        <div>
                            <label for="season_id" class="block text-sm font-medium text-gray-700">Season</label>
                            <select id="season_id" name="season_id" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">-- Pilih Season --</option>
                                @foreach ($seasons as $s)
                                    <option value="{{ $s->id_season }}" @selected(old('season_id', $villa_pricing->season_id) == $s->id_season)>
                                        {{ $s->nama_season }}
                                    </option>
                                @endforeach
                            </select>
                            @error('season_id')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- FIELDS (identik dengan create) --}}
                    @foreach ($seasons as $s)
                        <div id="fields-{{ $s->id_season }}" class="season-fields hidden mb-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                @php
                                    $exists = $villa_pricing->season_id == $s->id_season ? $villa_pricing : null;
                                @endphp
                                @if ($s->repeat_weekly)
                                    {{-- ALL SAME --}}
                                    <div class="col-span-full">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="all_same" id="all_same_{{ $s->id_season }}"
                                                class="form-checkbox all-same-checkbox"
                                                {{ old(
                                                    'all_same',
                                                    collect($s->days_of_week)->every(
                                                        fn($d) => $exists?->{[
                                                            'sunday_pricing',
                                                            'monday_pricing',
                                                            'tuesday_pricing',
                                                            'wednesday_pricing',
                                                            'thursday_pricing',
                                                            'friday_pricing',
                                                            'saturday_pricing',
                                                        ][$d]} ==
                                                            $exists?->{[
                                                                'sunday_pricing',
                                                                'monday_pricing',
                                                                'tuesday_pricing',
                                                                'wednesday_pricing',
                                                                'thursday_pricing',
                                                                'friday_pricing',
                                                                'saturday_pricing',
                                                            ][$d]},
                                                    )
                                                        ? 'checked'
                                                        : '',
                                                ) }}>
                                            <span class="ml-2">
                                                Harga sama untuk
                                                {{ collect($s->days_of_week)->map(fn($d) => ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][$d])->join(', ') }}
                                            </span>
                                        </label>
                                    </div>
                                    {{-- GROUP --}}
                                    <div class="col-span-full group-field" style="display:none">
                                        <label for="group_pricing" class="block text-sm font-medium text-gray-700">
                                            Harga (Rp)
                                        </label>
                                        <input type="number" name="group_pricing"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                            min="0" step="1"
                                            value="{{ old('group_pricing', $exists?->sunday_pricing) }}">
                                        @error('group_pricing')
                                            <p class="text-red-600 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    {{-- INDIVIDUAL --}}
                                    @foreach ($s->days_of_week as $dow)
                                        @php
                                            $fields = [
                                                'sunday_pricing',
                                                'monday_pricing',
                                                'tuesday_pricing',
                                                'wednesday_pricing',
                                                'thursday_pricing',
                                                'friday_pricing',
                                                'saturday_pricing',
                                            ];
                                            $map = $fields[$dow];
                                            $label = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][
                                                $dow
                                            ];
                                        @endphp
                                        <div class="individual-field">
                                            <label for="pricing_{{ $s->id_season }}_{{ $map }}"
                                                class="block text-sm font-medium text-gray-700">{{ $label }}
                                                (Rp)
                                            </label>
                                            <input type="number"
                                                name="pricing[{{ $s->id_season }}][{{ $map }}]"
                                                id="pricing_{{ $s->id_season }}_{{ $map }}"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                                min="0" step="1"
                                                value="{{ old("pricing.{$s->id_season}.{$map}", $exists?->{$map}) }}">
                                            @error("pricing.{$s->id_season}.{$map}")
                                                <p class="text-red-600 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    @endforeach
                                @else
                                    {{-- NON-WEEKLY --}}
                                    @foreach (['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'] as $day)
                                        @php $map = "{$day}_pricing"; @endphp
                                        <div>
                                            <label for="pricing_{{ $s->id_season }}_{{ $map }}"
                                                class="block text-sm font-medium text-gray-700">
                                                {{ ucfirst($day) }} (Rp)
                                            </label>
                                            <input type="number"
                                                name="pricing[{{ $s->id_season }}][{{ $map }}]"
                                                id="pricing_{{ $s->id_season }}_{{ $map }}"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                                min="0" step="1"
                                                value="{{ old("pricing.{$s->id_season}.{$map}", $exists?->{$map}) }}">
                                            @error("pricing.{$s->id_season}.{$map}")
                                                <p class="text-red-600 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach

                    {{-- SUBMIT --}}
                    <div class="mt-8 flex justify-end space-x-4">
                        <a href="{{ route('harga-villa.index') }}"
                            class="px-4 py-2 border rounded text-gray-700 hover:bg-gray-100">Batal</a>
                        <x-button>Update</x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

{{-- Script sama dengan create --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const seasonSelect = document.getElementById('season_id');
        const containers = document.querySelectorAll('.season-fields');

        function showFields() {
            containers.forEach(c => c.classList.add('hidden'));
            const sel = seasonSelect.value;
            if (!sel) return;
            const div = document.getElementById(`fields-${sel}`);
            if (!div) return;
            div.classList.remove('hidden');

            const checkbox = div.querySelector('.all-same-checkbox');
            const groupField = div.querySelector('.group-field');
            const indivs = div.querySelectorAll('.individual-field');

            function update() {
                if (checkbox && checkbox.checked) {
                    groupField && (groupField.style.display = '');
                    indivs.forEach(i => i.style.display = 'none');
                } else {
                    groupField && (groupField.style.display = 'none');
                    indivs.forEach(i => i.style.display = '');
                }
            }
            if (checkbox) {
                checkbox.addEventListener('change', update);
                update();
            }
        }

        seasonSelect.addEventListener('change', showFields);
        showFields();
    });
</script>
