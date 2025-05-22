{{-- resources/views/season/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-sm text-gray-800">Edit Season</h2>
    </x-slot>

    <div class="py-2">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="w-full mb-4 bg-white dark:bg-gray-900 py-4 px-6">
                <h2 class="text-sm font-bold">Edit Season</h2>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6">
                <form action="{{ route('season.update', $season) }}" method="POST" id="season-form">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        {{-- Nama Season --}}
                        <div>
                            <x-label for="nama_season" value="Nama Season" />
                            <x-input id="nama_season" name="nama_season" type="text" class="mt-1 block w-full"
                                value="{{ old('nama_season', $season->nama_season) }}" required autofocus />
                            @error('nama_season')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tipe Season --}}
                        <div>
                            <x-label value="Tipe Season" />
                            <div class="flex items-center space-x-4 mt-1">
                                <label class="flex items-center">
                                    <input type="radio" name="repeat_weekly" value="1" class="form-radio"
                                        {{ old('repeat_weekly', $season->repeat_weekly) == '1' ? 'checked' : '' }} />
                                    <span class="ml-2">Mingguan (Weekday/Weekend)</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="repeat_weekly" value="0" class="form-radio"
                                        {{ old('repeat_weekly', $season->repeat_weekly) == '0' ? 'checked' : '' }} />
                                    <span class="ml-2">Rentang Tanggal</span>
                                </label>
                            </div>
                            @error('repeat_weekly')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Section Mingguan --}}
                        <div id="weekly-section" class="hidden space-y-2">
                            <x-label value="Pilih Hari dalam Minggu" />
                            <div class="grid grid-cols-4 gap-2 mt-1">
                                @foreach ($daysOfWeek as $num => $label)
                                    <label class="flex items-center">
                                        <input type="checkbox" name="days_of_week[]" value="{{ $num }}"
                                            class="form-checkbox"
                                            {{ in_array($num, old('days_of_week', $season->days_of_week ?? [])) ? 'checked' : '' }} />
                                        <span class="ml-2">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('days_of_week')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Section Rentang Tanggal --}}
                        <div id="date-range-section" class="hidden space-y-4">
                            <div>
                                <x-label for="tgl_mulai_season" value="Tanggal Mulai" />
                                <x-input id="tgl_mulai_season" name="tgl_mulai_season" type="date"
                                    class="mt-1 block w-full"
                                    value="{{ old('tgl_mulai_season', optional($season->tgl_mulai_season)->format('Y-m-d')) }}" />
                                @error('tgl_mulai_season')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <x-label for="tgl_akhir_season" value="Tanggal Akhir" />
                                <x-input id="tgl_akhir_season" name="tgl_akhir_season" type="date"
                                    class="mt-1 block w-full"
                                    value="{{ old('tgl_akhir_season', optional($season->tgl_akhir_season)->format('Y-m-d')) }}" />
                                @error('tgl_akhir_season')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Priority --}}
                        <div>
                            <x-label for="priority" value="Priority (0 = rendah, lebih tinggi = prioritas)" />
                            <x-input id="priority" name="priority" type="number" min="0"
                                class="mt-1 block w-full" value="{{ old('priority', $season->priority) }}" required />
                            @error('priority')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-4">
                        <a href="{{ route('season.index') }}"
                            class="px-4 py-2 border rounded text-gray-700 hover:bg-gray-100">Batal</a>
                        <x-button>Update</x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const radios = document.querySelectorAll('input[name="repeat_weekly"]');
        const weekly = document.getElementById('weekly-section');
        const range = document.getElementById('date-range-section');

        function toggle() {
            const val = document.querySelector('input[name="repeat_weekly"]:checked').value;
            if (val === '1') {
                weekly.classList.remove('hidden');
                range.classList.add('hidden');
                weekly.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.required = true);
                range.querySelectorAll('input[type="date"]').forEach(d => d.required = false);
            } else {
                weekly.classList.add('hidden');
                range.classList.remove('hidden');
                weekly.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.required = false);
                range.querySelectorAll('input[type="date"]').forEach(d => d.required = true);
            }
        }

        radios.forEach(r => r.addEventListener('change', toggle));
        toggle();
    });
</script>
