{{-- resources/views/harga-villa/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-sm text-gray-800">Tambah Villa Pricing</h2>
    </x-slot>

    <div class="py-2">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="w-full mb-4 bg-white dark:bg-gray-900 py-4  px-6">
                <h2 class="text-sm font-bold">
                    Tambah Villa Pricing
                </h2>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6">
                <form action="{{ route('harga-villa.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-label for="villa_id" value="Villa" />
                            <select id="villa_id" name="villa_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Villa --</option>
                                @foreach ($villas as $v)
                                    <option value="{{ $v->id_villa }}" @selected(old('villa_id') == $v->id_villa)>{{ $v->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('villa_id')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="season_id" value="Season" />
                            <select id="season_id" name="season_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Season --</option>
                                @foreach ($seasons as $s)
                                    <option value="{{ $s->id_season }}" @selected(old('season_id') == $s->id_season)>
                                        {{ $s->nama_season }}</option>
                                @endforeach
                            </select>
                            @error('season_id')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        @foreach (['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'] as $day)
                            <div>
                                <x-label for="{{ $day }}_pricing" :value="ucfirst($day) . ' Pricing'" />
                                <x-input id="{{ $day }}_pricing" name="{{ $day }}_pricing"
                                    type="number" step="0.01" class="mt-1 block w-full" :value="old($day . '_pricing')"
                                    required />
                                @error($day . '_pricing')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        @endforeach
                    </div>

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
</x-app-layout>
