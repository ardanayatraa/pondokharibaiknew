{{-- resources/views/reservasi/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-sm text-gray-800">Tambah Reservasi</h2>
    </x-slot>

    <div class="py-2">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="w-full mb-4 bg-white dark:bg-gray-900 py-4  px-6">
                <h2 class="text-sm font-bold">
                    Tambah Reservasi
                </h2>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6">
                <form action="{{ route('reservasi.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <x-label for="guest_id" value="Guest" />
                            <select id="guest_id" name="guest_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Guest --</option>
                                @foreach ($guests as $g)
                                    <option value="{{ $g->id_guest }}" @selected(old('guest_id') == $g->id_guest)>{{ $g->full_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('guest_id')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

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
                            <x-label for="cek_ketersediaan_id" value="Cek Ketersediaan" />
                            <select id="cek_ketersediaan_id" name="cek_ketersediaan_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih --</option>
                                @foreach ($cekKetersediaans as $c)
                                    <option value="{{ $c->id_cek_ketersediaan }}" @selected(old('cek_ketersediaan_id') == $c->id_cek_ketersediaan)>
                                        {{ $c->date }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cek_ketersediaan_id')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="villa_pricing_id" value="Villa Pricing" />
                            <select id="villa_pricing_id" name="villa_pricing_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Harga --</option>
                                @foreach ($villaPricings as $p)
                                    <option value="{{ $p->id_villa_pricing }}" @selected(old('villa_pricing_id') == $p->id_villa_pricing)>
                                        {{ $p->season->nama_season }} — IDR {{ $p->sunday_pricing }}
                                    </option>
                                @endforeach
                            </select>
                            @error('villa_pricing_id')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="start_date" value="Tanggal Mulai" />
                            <x-input id="start_date" name="start_date" type="date" class="mt-1 block w-full"
                                :value="old('start_date')" required />
                            @error('start_date')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="end_date" value="Tanggal Akhir" />
                            <x-input id="end_date" name="end_date" type="date" class="mt-1 block w-full"
                                :value="old('end_date')" required />
                            @error('end_date')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="status" value="Status" />
                            <x-input id="status" name="status" type="text" class="mt-1 block w-full"
                                :value="old('status')" required />
                            @error('status')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="total_amount" value="Total Amount" />
                            <x-input id="total_amount" name="total_amount" type="number" class="mt-1 block w-full"
                                :value="old('total_amount')" required />
                            @error('total_amount')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <div class="mt-6 flex justify-end space-x-4">
                            <a href="{{ route('reservasi.index') }}"
                                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100">
                                Batal
                            </a>
                            <x-button>
                                Simpan
                            </x-button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
