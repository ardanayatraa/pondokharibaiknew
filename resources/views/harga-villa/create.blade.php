<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-sm text-gray-800">Tambah Villa Pricing</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <form action="{{ route('harga-villa.store') }}" method="POST" id="pricing-form">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        {{-- Villa --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Villa</label>
                            <select name="villa_id" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">-- Pilih Villa --</option>
                                @foreach ($villas as $villa)
                                    <option value="{{ $villa->id_villa }}" @selected(old('villa_id') == $villa->id_villa)>
                                        {{ $villa->name }}</option>
                                @endforeach
                            </select>
                            @error('villa_id')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- Season --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Season</label>
                            <select id="season_id" name="season_id" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">-- Pilih Season --</option>
                                @foreach ($seasons as $s)
                                    <option value="{{ $s->id_season }}" @selected(old('season_id') == $s->id_season)>
                                        {{ $s->nama_season }}</option>
                                @endforeach
                            </select>
                            @error('season_id')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    @foreach ($seasons as $s)
                        <div id="fields-{{ $s->id_season }}" class="season-fields hidden mb-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                @if ($s->repeat_weekly)
                                    {{-- all_same --}}
                                    <div class="col-span-full">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="all_same[{{ $s->id_season }}]"
                                                id="all_same_{{ $s->id_season }}"
                                                class="form-checkbox all-same-checkbox"
                                                {{ old("all_same.{$s->id_season}") ? 'checked' : '' }} />
                                            <span class="ml-2">
                                                Harga sama untuk:
                                                {{ collect($s->days_of_week)->map(fn($d) => ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][$d])->join(', ') }}
                                            </span>
                                        </label>
                                    </div>
                                    {{-- group_pricing --}}
                                    <div class="col-span-full group-field" style="display:none">
                                        <label class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                                        <input type="number" name="group_pricing[{{ $s->id_season }}]"
                                            id="group_pricing_{{ $s->id_season }}"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                            min="0" step="1"
                                            value="{{ old("group_pricing.{$s->id_season}") }}" />
                                        @error("group_pricing.{$s->id_season}")
                                            <p class="text-red-600 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    {{-- individual --}}
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
                                            <label class="block text-sm font-medium text-gray-700">{{ $label }}
                                                (Rp)
                                            </label>
                                            <input type="number"
                                                name="pricing[{{ $s->id_season }}][{{ $map }}]"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                                min="0" step="1"
                                                value="{{ old("pricing.{$s->id_season}.{$map}") }}" />
                                            @error("pricing.{$s->id_season}.{$map}")
                                                <p class="text-red-600 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    @endforeach
                                @else
                                    {{-- non-weekly: tetap nested pricing --}}
                                    @foreach (['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'] as $day)
                                        @php $map = "{$day}_pricing"; @endphp
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">{{ ucfirst($day) }}
                                                (Rp)
                                            </label>
                                            <input type="number"
                                                name="pricing[{{ $s->id_season }}][{{ $map }}]"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                                min="0" step="1"
                                                value="{{ old("pricing.{$s->id_season}.{$map}") }}" />
                                            @error("pricing.{$s->id_season}.{$map}")
                                                <p class="text-red-600 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-8 flex justify-end space-x-4">
                        <a href="{{ route('harga-villa.index') }}"
                            class="px-4 py-2 border rounded text-gray-700 hover:bg-gray-100">Batal</a>
                        <x-button>Simpan</x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sel = document.getElementById('season_id');
        const all = document.querySelectorAll('.season-fields');

        function toggle() {
            all.forEach(d => d.classList.add('hidden'));
            const s = sel.value;
            if (!s) return;
            const div = document.getElementById(`fields-${s}`);
            if (!div) return;
            div.classList.remove('hidden');

            const cb = div.querySelector('.all-same-checkbox');
            const grp = div.querySelector('.group-field');
            const indiv = div.querySelectorAll('.individual-field');

            function upd() {
                if (cb && cb.checked) {
                    grp && (grp.style.display = '');
                    indiv.forEach(i => i.style.display = 'none');
                } else {
                    grp && (grp.style.display = 'none');
                    indiv.forEach(i => i.style.display = '');
                }
            }
            if (cb) {
                cb.addEventListener('change', upd);
                upd();
            }
        }

        sel.addEventListener('change', toggle);
        toggle();
    });
</script>
