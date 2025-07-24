{{-- resources/views/season/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-sm text-gray-800">Tambah Season</h2>
    </x-slot>

    <div class="py-2">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="w-full mb-4 bg-white dark:bg-gray-900 py-4 px-6">
                <h2 class="text-sm font-bold">Tambah Season</h2>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6">
                <form action="{{ route('season.store') }}" method="POST" id="season-form">
                    @csrf

                    {{-- Nama --}}
                    <div class="space-y-6">
                        <div>
                            <x-label for="nama_season" value="Nama Season" />
                            <x-input id="nama_season" name="nama_season" type="text" class="mt-1 block w-full"
                                value="{{ old('nama_season') }}" required autofocus />
                            @error('nama_season')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tipe --}}
                        <div>
                            <x-label value="Tipe Season" />
                            <div class="flex items-center space-x-4 mt-1">
                                <label class="flex items-center">
                                    <input type="radio" name="repeat_weekly" value="1" class="form-radio"
                                        {{ old('repeat_weekly') === '1' ? 'checked' : '' }} />
                                    <span class="ml-2">Mingguan</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="repeat_weekly" value="0" class="form-radio"
                                        {{ old('repeat_weekly', '0') === '0' ? 'checked' : '' }} />
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
                                            {{ in_array((string) $num, old('days_of_week', [])) ? 'checked' : '' }}
                                            class="form-checkbox" />
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
                                    class="mt-1 block w-full" value="{{ old('tgl_mulai_season') }}" />
                                @error('tgl_mulai_season')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <x-label for="tgl_akhir_season" value="Tanggal Akhir" />
                                <x-input id="tgl_akhir_season" name="tgl_akhir_season" type="date"
                                    class="mt-1 block w-full" value="{{ old('tgl_akhir_season') }}" />
                                @error('tgl_akhir_season')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Priority --}}
                        <div>
                            <x-label for="priority" value="Priority (0=rendah, lebih tinggi=prioritas)" />
                            <x-input id="priority" name="priority" type="number" min="0"
                                class="mt-1 block w-full" value="{{ old('priority', 0) }}" required />
                            @error('priority')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <x-button>Simpan</x-button>
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
        const form = document.getElementById('season-form');
        const checkboxes = weekly.querySelectorAll('input[type="checkbox"]');
        const dateInputs = range.querySelectorAll('input[type="date"]');
        const startDateInput = document.getElementById('tgl_mulai_season');
        const endDateInput = document.getElementById('tgl_akhir_season');

        function toggle() {
            const val = document.querySelector('input[name="repeat_weekly"]:checked').value;
            if (val === '1') {
                weekly.classList.remove('hidden');
                range.classList.add('hidden');

                // Atur required fields
                checkboxes.forEach(cb => cb.required = false);
                dateInputs.forEach(d => {
                    d.required = false;
                    d.value = '';
                });
            } else {
                weekly.classList.add('hidden');
                range.classList.remove('hidden');

                // Atur required fields
                checkboxes.forEach(cb => {
                    cb.required = false;
                    cb.checked = false;
                });
                dateInputs.forEach(d => d.required = true);
            }
        }

        // Validasi form sebelum submit
        form.addEventListener('submit', function(e) {
            const isWeekly = document.querySelector('input[name="repeat_weekly"]:checked').value ===
            '1';

            if (isWeekly) {
                // Validasi minimal satu hari dipilih untuk tipe mingguan
                const checkedDays = Array.from(checkboxes).filter(cb => cb.checked).length;
                if (checkedDays === 0) {
                    e.preventDefault();
                    alert('Pilih minimal satu hari dalam seminggu.');
                    return false;
                }
            } else {
                // Validasi rentang tanggal
                if (!startDateInput.value) {
                    e.preventDefault();
                    alert('Tanggal mulai harus diisi.');
                    startDateInput.focus();
                    return false;
                }

                if (!endDateInput.value) {
                    e.preventDefault();
                    alert('Tanggal akhir harus diisi.');
                    endDateInput.focus();
                    return false;
                }

                // Validasi tanggal akhir harus setelah atau sama dengan tanggal mulai
                if (new Date(endDateInput.value) < new Date(startDateInput.value)) {
                    e.preventDefault();
                    alert('Tanggal akhir harus setelah atau sama dengan tanggal mulai.');
                    endDateInput.focus();
                    return false;
                }
            }
        });

        radios.forEach(r => r.addEventListener('change', toggle));
        toggle();
    });
</script>
