<div>
    {{-- Modal manual --}}
    @if ($showModal)
        {{-- Backdrop --}}
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            {{-- Kontainer modal --}}
            <div class="bg-white w-full max-w-2xl mx-4 rounded-lg shadow-lg overflow-hidden">
                {{-- Header Modal --}}
                <div class="relative bg-green-600 px-6 py-4">
                    <h2 class="text-white text-xl font-semibold">Detail Reservasi</h2>
                    {{-- Tombol tutup --}}
                    <button wire:click="closeModal"
                        class="absolute top-3 right-4 text-white hover:text-gray-200 text-2xl leading-none">&times;</button>
                </div>

                {{-- Body Modal --}}
                <div class="px-6 py-4 max-h-[70vh] overflow-y-auto">
                    @if ($reservation)
                        {{-- Informasi Tamu --}}
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-700 mb-2">Informasi Tamu</h3>
                            <p>
                                <span class="font-semibold text-gray-600">Nama:</span>
                                <span class="text-gray-800">{{ $reservation->guest->full_name }}</span>
                            </p>
                            <p class="mt-1">
                                <span class="font-semibold text-gray-600">Email:</span>
                                <span class="text-gray-800">{{ $reservation->guest->email }}</span>
                            </p>
                            <p class="mt-1">
                                <span class="font-semibold text-gray-600">No. Telp:</span>
                                <span class="text-gray-800">{{ $reservation->guest->phone_number }}</span>
                            </p>
                        </div>

                        {{-- Detail Reservasi --}}
                        @php
                            $start = \Carbon\Carbon::parse($reservation->start_date);
                            $end = \Carbon\Carbon::parse($reservation->end_date);
                            $nights = $start->diffInDays($end);
                        @endphp

                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-700 mb-2">Detail Reservasi</h3>
                            <p>
                                <span class="font-semibold text-gray-600">Villa:</span>
                                <span class="text-gray-800">{{ $reservation->villa->name }}</span>
                            </p>
                            <p class="mt-1">
                                <span class="font-semibold text-gray-600">Check-in:</span>
                                <span class="text-gray-800">{{ $start->format('d M Y') }}</span>
                            </p>
                            <p class="mt-1">
                                <span class="font-semibold text-gray-600">Check-out:</span>
                                <span class="text-gray-800">{{ $end->format('d M Y') }}</span>
                            </p>
                            <p class="mt-1">
                                <span class="font-semibold text-gray-600">Durasi:</span>
                                <span class="text-gray-800">{{ $nights }} malam</span>
                            </p>
                        </div>

                        {{-- Rincian Harga per Malam --}}
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-700 mb-2">Rincian Harga per Malam</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white border border-gray-200 rounded-md">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="px-4 py-2 text-left text-gray-600">Tanggal</th>
                                            <th class="px-4 py-2 text-right text-gray-600">Harga/Malam (Rp)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($i = 0; $i < $nights; $i++)
                                            @php
                                                $dateObj = $start->copy()->addDays($i);
                                                $formattedDate = $dateObj->format('d M Y');
                                                // Asumsikan di model Villa ada method priceForDate($date)
                                                $price = $reservation->villa->priceForDate($dateObj->toDateString());
                                            @endphp
                                            <tr class="{{ $i % 2 === 0 ? 'bg-gray-50' : '' }}">
                                                <td class="px-4 py-2 text-gray-800">{{ $formattedDate }}</td>
                                                <td class="px-4 py-2 text-right text-gray-800">
                                                    {{ number_format($price, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Totals PD --}}
                        <div class="mb-6">
                            <table class="w-full bg-white border border-gray-200 rounded-md">
                                <tbody>
                                    <tr>
                                        <th class="text-left px-4 py-2 font-medium text-gray-600">Total
                                            ({{ $nights }} malam)</th>
                                        <td class="text-right px-4 py-2 text-gray-800">
                                            Rp {{ number_format($reservation->total_amount, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @if (isset($reservation->pembayaran))
                                        <tr>
                                            <th class="text-left px-4 py-2 font-medium text-gray-600">Dibayar</th>
                                            <td class="text-right px-4 py-2 text-gray-800">
                                                Rp {{ number_format($reservation->pembayaran->amount, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-100">
                                            <th class="text-left px-4 py-2 font-semibold text-gray-600">Sisa</th>
                                            @php
                                                $sisa = $reservation->total_amount - $reservation->pembayaran->amount;
                                            @endphp
                                            <td class="text-right px-4 py-2 font-semibold text-gray-800">
                                                Rp {{ number_format($sisa, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @else
                                        <tr class="bg-gray-100">
                                            <th class="text-left px-4 py-2 font-semibold text-gray-600">Sisa</th>
                                            <td class="text-right px-4 py-2 font-semibold text-gray-800">
                                                Rp {{ number_format($reservation->total_amount, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        {{-- Aksi Reschedule / Cancel --}}
                        @if ($reservation->status === 'confirmed')
                            <div class="flex space-x-3">
                                <button
                                    onclick="if(confirm('Anda yakin ingin reschedule? Cek email setelah tekan Ok!')){ @this.rescheduleReservation() }"
                                    class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">
                                    Reschedule
                                </button>
                                <button
                                    onclick="if(confirm('Anda yakin ingin membatalkan? Cek email setelah tekan Ok!')){ @this.cancelReservation() }"
                                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                                    Batalkan
                                </button>
                            </div>
                        @endif
                    @else
                        <div class="text-center text-red-600 py-8">
                            Reservasi tidak ditemukan.
                        </div>
                    @endif
                </div>

                {{-- Footer Modal --}}
                <div class="px-6 py-4 border-t bg-gray-100 text-right">
                    <button wire:click="closeModal"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
