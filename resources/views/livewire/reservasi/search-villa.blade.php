<div class="p-6 bg-white rounded shadow space-y-4">

    {{-- Input tanggal --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <x-label for="checkin_date" value="Tanggal Check-In" />
            <x-input id="checkin_date" type="date" wire:model="checkin_date" class="w-full" />
        </div>
        <div>
            <x-label for="checkout_date" value="Tanggal Check-Out" />
            <x-input id="checkout_date" type="date" wire:model="checkout_date" class="w-full" />
        </div>
    </div>

    {{-- Tombol Cek Ketersediaan --}}
    <div class="flex justify-end mt-2">
        <x-button wire:click="cekKetersediaan" class="bg-green-600 hover:bg-green-700 text-white">
            Cek Ketersediaan
        </x-button>
    </div>

    {{-- Daftar overlap --}}
    @if ($checked)
        <div class="mt-4">
            <h2 class="font-bold text-lg mb-2">Entri Booking yang Overlap</h2>

            @if (count($availableSlots))
                <ul class="space-y-2">
                    @foreach ($availableSlots as $slot)
                        <li class="border p-4 rounded flex justify-between items-center">
                            <div>
                                <div><strong>Villa:</strong> {{ $slot['villa_name'] }}</div>
                                <div>
                                    <strong>Periode:</strong>
                                    {{ $slot['start_date'] }} &ndash; {{ $slot['end_date'] }}
                                </div>
                            </div>
                            <div>
                                {{-- Link ke form reservasi --}}
                                <a href="{{ route('reservasi.create', [
                                    'villa_id' => $slot['villa_id'],
                                    'cek_ketersediaan_id' => $slot['cek_id'],
                                    'start_date' => $slot['start_raw'],
                                    'end_date' => $slot['end_raw'],
                                ]) }}"
                                    class="inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                                    Pesan Sekarang
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="text-sm text-gray-500">
                    Tidak ada booking dalam rentang {{ $checkin_date }} – {{ $checkout_date }}.
                </div>
            @endif
        </div>
    @endif

</div>
