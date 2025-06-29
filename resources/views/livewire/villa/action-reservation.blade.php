<div>
    {{-- Modal Detail Reservasi --}}
    @if ($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            wire:click.self="closeModal">
            <div class="bg-white w-full max-w-2xl mx-4 rounded-lg shadow-lg overflow-hidden">
                {{-- Header Modal --}}
                <div class="relative bg-green-600 px-6 py-4">
                    <h2 class="text-white text-xl font-semibold">Detail Reservasi</h2>
                    <button wire:click="closeModal"
                        class="absolute top-3 right-4 text-white hover:text-gray-200 text-2xl leading-none">&times;</button>
                </div>

                {{-- Body Modal --}}
                <div class="px-6 py-4 max-h-[70vh] overflow-y-auto">
                    @if ($reservation)
                        {{-- Status Badge --}}
                        <div class="mb-4">
                            <span
                                class="px-3 py-1 rounded-full text-sm font-medium
                                @if ($reservation->status === 'confirmed') bg-green-100 text-green-800
                                @elseif($reservation->status === 'rescheduled') bg-blue-100 text-blue-800
                                @elseif($reservation->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($reservation->status === 'cancelled') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                @if ($reservation->status === 'rescheduled')
                                    Rescheduled
                                @elseif($reservation->status === 'cancelled')
                                    Cancelled
                                    @if ($reservation->cancelation_date)
                                        ({{ \Carbon\Carbon::parse($reservation->cancelation_date)->format('d M Y H:i') }})
                                    @endif
                                @else
                                    {{ ucfirst($reservation->status) }}
                                @endif
                            </span>
                        </div>

                        {{-- Debug Payment Info (only show in development) --}}
                        @if (config('app.debug') && $debugPaymentInfo)
                            <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                <h4 class="font-semibold text-blue-800 mb-2">Debug Payment Info:</h4>
                                <div class="text-xs text-blue-700 space-y-1">
                                    <p><strong>Payment ID:</strong> {{ $debugPaymentInfo['id'] }}</p>
                                    <p><strong>Snap Token:</strong> {{ $debugPaymentInfo['snap_token'] ?? 'N/A' }}</p>
                                    <p><strong>Notifikasi:</strong> {{ $debugPaymentInfo['notifikasi'] ?? 'N/A' }}</p>
                                    <p><strong>Amount:</strong> Rp
                                        {{ number_format($debugPaymentInfo['amount'], 0, ',', '.') }}</p>
                                    @if ($refundInfo && isset($refundInfo['order_id']))
                                        <p><strong>Order ID:</strong> {{ $refundInfo['order_id'] ?? 'N/A' }}</p>
                                    @endif
                                </div>
                            </div>
                        @endif

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

                        {{-- Totals --}}
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
                                    @php
                                        $totalPaid = $reservation->pembayaran()->where('status', 'paid')->sum('amount');
                                        $sisa = $reservation->total_amount - $totalPaid;
                                    @endphp

                                    @if ($totalPaid > 0)
                                        <tr>
                                            <th class="text-left px-4 py-2 font-medium text-gray-600">Dibayar</th>
                                            <td class="text-right px-4 py-2 text-gray-800">
                                                Rp {{ number_format($totalPaid, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endif

                                    {{-- Show refund info if cancelled --}}
                                    @if ($reservation->status === 'cancelled')
                                        @php
                                            $refundAmount = $reservation
                                                ->pembayaran()
                                                ->where('status', 'refunded')
                                                ->sum('amount');
                                        @endphp
                                        @if ($refundAmount < 0)
                                            <tr>
                                                <th class="text-left px-4 py-2 font-medium text-green-600">Refund (50%)
                                                </th>
                                                <td class="text-right px-4 py-2 text-green-600">
                                                    Rp {{ number_format(abs($refundAmount), 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endif

                                    <tr class="bg-gray-100">
                                        <th class="text-left px-4 py-2 font-semibold text-gray-600">
                                            @if ($reservation->status === 'cancelled')
                                                Status
                                            @else
                                                Sisa
                                            @endif
                                        </th>
                                        <td class="text-right px-4 py-2 font-semibold text-gray-800">
                                            @if ($reservation->status === 'cancelled')
                                                <span class="text-red-600 font-bold">DIBATALKAN</span>
                                            @elseif ($sisa <= 0)
                                                <span class="text-green-600 font-bold">LUNAS</span>
                                            @else
                                                Rp {{ number_format($sisa, 0, ',', '.') }}
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        {{-- Aksi Reschedule / Cancel --}}
                        @if (in_array($reservation->status, ['confirmed', 'rescheduled']))
                            <div class="flex space-x-3">
                                <button wire:click="rescheduleReservation"
                                    class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">
                                    {{ $reservation->status === 'rescheduled' ? 'Reschedule Again' : 'Reschedule' }}
                                </button>
                                <button wire:click="cancelReservation"
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

    {{-- Modal Konfirmasi Pembatalan --}}
    @if ($showCancelModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            wire:click.self="closeCancelModal">
            <div class="bg-white w-full max-w-lg mx-4 rounded-lg shadow-lg overflow-hidden">
                {{-- Header --}}
                <div class="relative bg-red-600 px-6 py-4">
                    <h2 class="text-white text-xl font-semibold">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Konfirmasi Pembatalan
                    </h2>
                    <button wire:click="closeCancelModal"
                        class="absolute top-3 right-4 text-white hover:text-gray-200 text-2xl leading-none">&times;</button>
                </div>

                {{-- Body --}}
                <div class="px-6 py-4">
                    @if ($refundInfo && isset($refundInfo['total_paid']))
                        <div class="mb-4">
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-info-circle text-yellow-600 mr-2"></i>
                                    <h3 class="font-semibold text-yellow-800">Kebijakan Refund Midtrans</h3>
                                </div>
                                <p class="text-yellow-700 text-sm">
                                    Pembatalan reservasi akan dikenakan biaya administrasi 50%.
                                    Anda akan menerima refund sebesar 50% dari total pembayaran melalui Midtrans.
                                </p>
                            </div>

                            <div class="space-y-3 mb-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Total Dibayar:</span>
                                    <span class="font-semibold">Rp
                                        {{ number_format($refundInfo['total_paid'], 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Biaya Administrasi (50%):</span>
                                    <span class="text-red-600">- Rp
                                        {{ number_format($refundInfo['total_paid'] - $refundInfo['refund_amount'], 0, ',', '.') }}</span>
                                </div>
                                <hr class="border-gray-300">
                                <div class="flex justify-between text-lg font-bold">
                                    <span class="text-green-600">Jumlah Refund:</span>
                                    <span class="text-green-600">Rp
                                        {{ number_format($refundInfo['refund_amount'], 0, ',', '.') }}</span>
                                </div>
                            </div>

                            @if ($refundInfo['can_refund'] ?? false)
                                <div class="p-3 bg-green-50 border border-green-200 rounded-lg mb-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-check-circle text-green-600 mr-2"></i>
                                        <div class="text-green-700 text-sm">
                                            <p><strong>Metode Pembayaran:</strong>
                                                {{ $refundInfo['payment_method'] ?? 'QRIS' }}</p>
                                            <p class="text-xs mt-1">Pembayaran dapat direfund</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="p-3 bg-red-50 border border-red-200 rounded-lg mb-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-times-circle text-red-600 mr-2"></i>
                                        <div class="text-red-700 text-sm">
                                            <p>Refund hanya tersedia untuk pembayaran menggunakan QRIS</p>
                                            <p><strong>Metode Anda:</strong>
                                                {{ $refundInfo['payment_method'] ?? 'Unknown' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="text-xs text-gray-500 space-y-1">
                                <p><i class="fas fa-clock mr-1"></i> Refund akan diproses dalam 3-5 hari kerja</p>
                                <p><i class="fas fa-credit-card mr-1"></i> Dana akan dikembalikan ke metode pembayaran
                                    yang sama</p>
                                <p><i class="fas fa-envelope mr-1"></i> Konfirmasi refund akan dikirim via email</p>
                            </div>
                        </div>
                    @else
                        <div class="text-center text-red-600 py-4">
                            <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                            <p>Tidak dapat memuat informasi refund</p>
                        </div>
                    @endif
                </div>

                {{-- Footer --}}
                <div class="px-6 py-4 border-t bg-gray-100 flex justify-end space-x-3">
                    <button wire:click="closeCancelModal"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded hover:bg-gray-100 text-sm">
                        <i class="fas fa-times mr-1"></i>
                        Batal
                    </button>
                    @if ($refundInfo && ($refundInfo['can_refund'] ?? false))
                        <button wire:click="processCancellation" wire:loading.attr="disabled"
                            wire:loading.class="opacity-50 cursor-not-allowed"
                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm {{ $isProcessing ? 'opacity-50 cursor-not-allowed' : '' }}"
                            {{ $isProcessing ? 'disabled' : '' }}>
                            <span wire:loading.remove wire:target="processCancellation">
                                <i class="fas fa-check mr-1"></i>
                                Proses Pembatalan
                            </span>
                            <span wire:loading wire:target="processCancellation">
                                <i class="fas fa-spinner fa-spin mr-1"></i>
                                Memproses...
                            </span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>

{{-- JavaScript untuk handling alerts --}}
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('show-alert', (event) => {
            const data = event[0];
            showAlert(data.type, data.message);
        });

        Livewire.on('reservation-cancelled', () => {
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        });
    });

    function showAlert(type, message) {
        const existingAlerts = document.querySelectorAll('.alert-notification');
        existingAlerts.forEach(alert => alert.remove());

        const alertDiv = document.createElement('div');
        alertDiv.className = `alert-notification fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        } text-white`;

        alertDiv.innerHTML = `
            <div class="flex items-center">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-2"></i>
                ${message}
            </div>
        `;

        document.body.appendChild(alertDiv);

        setTimeout(() => {
            alertDiv.style.opacity = '0';
            setTimeout(() => {
                alertDiv.remove();
            }, 300);
        }, 5000);
    }
</script>
