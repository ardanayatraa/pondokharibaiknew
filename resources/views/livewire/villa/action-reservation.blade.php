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
                                @if ($reservation->status === 'confirmed' || $reservation->status_pembayaran === 'success') bg-green-100 text-green-800
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
                                @elseif($reservation->status === 'confirmed' || $reservation->status_pembayaran === 'success')
                                    Confirmed
                                @else
                                    {{ ucfirst($reservation->status) }}
                                @endif
                            </span>
                        </div>

                        {{-- H-7 Reschedule Eligibility Info --}}
                        @if (in_array($reservation->status, ['confirmed', 'rescheduled']))
                            <div
                                class="mb-4 p-3 rounded-lg border {{ $canReschedule ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
                                <div class="flex items-center">
                                    <i
                                        class="fas {{ $canReschedule ? 'fa-check-circle text-green-600' : 'fa-exclamation-triangle text-red-600' }} mr-2"></i>
                                    <div>
                                        <h4
                                            class="font-semibold {{ $canReschedule ? 'text-green-800' : 'text-red-800' }} text-sm">
                                            Status Reschedule
                                        </h4>
                                        <p class="{{ $canReschedule ? 'text-green-700' : 'text-red-700' }} text-sm">
                                            {{ $rescheduleMessage }}
                                        </p>
                                        <p
                                            class="text-xs {{ $canReschedule ? 'text-green-600' : 'text-red-600' }} mt-1">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            Kebijakan: Reschedule harus dilakukan minimal H-7 (7 hari) sebelum check-in
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- H-7 Cancellation Policy Info --}}
                            @php
                                $checkInDate = \Carbon\Carbon::parse($reservation->start_date);
                                $today = \Carbon\Carbon::today();
                                $daysUntilCheckIn = $today->diffInDays($checkInDate, false);
                                $canGetRefund = $daysUntilCheckIn >= 7;
                            @endphp

                            <div
                                class="mb-4 p-3 rounded-lg border {{ $canGetRefund ? 'bg-blue-50 border-blue-200' : 'bg-orange-50 border-orange-200' }}">
                                <div class="flex items-center">
                                    <i
                                        class="fas {{ $canGetRefund ? 'fa-money-bill-wave text-blue-600' : 'fa-exclamation-circle text-orange-600' }} mr-2"></i>
                                    <div>
                                        <h4
                                            class="font-semibold {{ $canGetRefund ? 'text-blue-800' : 'text-orange-800' }} text-sm">
                                            Kebijakan Refund Pembatalan
                                        </h4>
                                        @if ($canGetRefund)
                                            <p class="text-blue-700 text-sm">
                                                Refund 50% tersedia ({{ $daysUntilCheckIn }} hari sebelum check-in)
                                            </p>
                                            <p class="text-xs text-blue-600 mt-1">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Pembatalan dengan refund 50% dapat dilakukan hingga
                                                {{ $checkInDate->copy()->subDays(7)->format('d M Y') }}
                                            </p>
                                        @else
                                            <p class="text-orange-700 text-sm">
                                                Tidak ada refund ({{ $daysUntilCheckIn }} hari sebelum check-in)
                                            </p>
                                            <p class="text-xs text-orange-600 mt-1">
                                                <i class="fas fa-times-circle mr-1"></i>
                                                Batas refund 50% telah terlewati (H-7:
                                                {{ $checkInDate->copy()->subDays(7)->format('d M Y') }})
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Show cancellation reason if cancelled --}}
                        @if ($reservation->status === 'cancelled' && $reservation->cancelation_reason)
                            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                                <h4 class="font-semibold text-red-800 mb-1">Alasan Pembatalan:</h4>
                                <p class="text-red-700 text-sm">{{ $reservation->cancelation_reason }}</p>
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
                                            $manualRefundAmount = $reservation
                                                ->pembayaran()
                                                ->whereIn('status', [
                                                    'manual_refund_required',
                                                    'refund_failed_manual_required',
                                                ])
                                                ->sum('amount');
                                            $noRefund = $reservation
                                                ->pembayaran()
                                                ->where('status', 'no_refund')
                                                ->exists();
                                        @endphp

                                        @if ($refundAmount < 0)
                                            <tr>
                                                <th class="text-left px-4 py-2 font-medium text-green-600">Refund (50%)
                                                    - Berhasil</th>
                                                <td class="text-right px-4 py-2 text-green-600">
                                                    Rp {{ number_format(abs($refundAmount), 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @elseif($manualRefundAmount < 0)
                                            <tr>
                                                <th class="text-left px-4 py-2 font-medium text-blue-600">Refund (50%)
                                                    - Akan Diproses Manual</th>
                                                <td class="text-right px-4 py-2 text-blue-600">
                                                    Rp {{ number_format(abs($manualRefundAmount), 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @elseif($noRefund)
                                            <tr>
                                                <th class="text-left px-4 py-2 font-medium text-red-600">Refund</th>
                                                <td class="text-right px-4 py-2 text-red-600">
                                                    Tidak Ada (< H-7) </td>
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
                                    class="px-4 py-2 rounded text-sm transition-colors duration-200 {{ $canReschedule ? 'bg-yellow-500 hover:bg-yellow-600 text-white' : 'bg-gray-300 text-gray-500 cursor-not-allowed' }}"
                                    {{ $canReschedule ? '' : 'disabled' }}
                                    title="{{ $canReschedule ? '' : $rescheduleMessage }}">
                                    <i class="fas fa-calendar-alt mr-1"></i>
                                    {{ $reservation->status === 'rescheduled' ? 'Reschedule Again' : 'Reschedule' }}
                                </button>
                                <button wire:click="cancelReservation"
                                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                                    <i class="fas fa-times mr-1"></i>
                                    Batalkan
                                    @if ($canGetRefund)
                                        <span class="text-xs">(Refund 50%)</span>
                                    @else
                                        <span class="text-xs">(No Refund)</span>
                                    @endif
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
                            {{-- H-7 Policy Info --}}
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                                    <h3 class="font-semibold text-blue-800">Kebijakan Refund H-7</h3>
                                </div>
                                <div class="text-blue-700 text-sm space-y-1">
                                    <p><strong>• H-7 atau lebih:</strong> Refund 50% dari total pembayaran</p>
                                    <p><strong>• Kurang dari H-7:</strong> Tidak ada refund</p>
                                    <p class="text-xs mt-2">
                                        <i class="fas fa-calendar mr-1"></i>
                                        Check-in: {{ $refundInfo['check_in_date'] ?? 'N/A' }}
                                        ({{ $refundInfo['days_until_checkin'] ?? 0 }} hari lagi)
                                    </p>
                                </div>
                            </div>

                            {{-- H-7 Status --}}
                            @if ($refundInfo['is_h7_eligible'] ?? false)
                                <div class="p-3 bg-green-50 border border-green-200 rounded-lg mb-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-check-circle text-green-600 mr-2"></i>
                                        <div class="text-green-700 text-sm">
                                            <p><strong>✓ Eligible untuk Refund 50%</strong></p>
                                            <p>Pembatalan dilakukan {{ $refundInfo['days_until_checkin'] ?? 0 }} hari
                                                sebelum check-in</p>
                                            <p class="text-xs mt-1">
                                                <i class="fas fa-info-circle mr-1"></i>
                                                Refund akan diproses dalam 3-5 hari kerja (otomatis) atau 1x24 jam
                                                (manual)
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="p-3 bg-red-50 border border-red-200 rounded-lg mb-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-times-circle text-red-600 mr-2"></i>
                                        <div class="text-red-700 text-sm">
                                            <p><strong>✗ Tidak Eligible untuk Refund</strong></p>
                                            <p>Pembatalan dilakukan {{ $refundInfo['days_until_checkin'] ?? 0 }} hari
                                                sebelum check-in (kurang dari H-7)</p>
                                            <p class="text-xs mt-1">
                                                <i class="fas fa-clock mr-1"></i>
                                                Batas refund: {{ $refundInfo['h7_deadline'] ?? 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Important Notice --}}
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                                <div class="flex items-center">
                                    <i class="fas fa-info-circle text-yellow-600 mr-2"></i>
                                    <div class="text-yellow-800 text-sm">
                                        <p><strong>Penting:</strong> Pembatalan reservasi akan tetap diproses meskipun
                                            ada masalah dengan refund.</p>
                                        <p class="text-xs mt-1">Jika refund otomatis gagal, tim kami akan memproses
                                            secara manual.</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Cancellation Reason Input --}}
                            <div class="mb-4">
                                <label for="cancelation_reason" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-comment-alt mr-1"></i>
                                    Alasan Pembatalan <span class="text-red-500">*</span>
                                </label>
                                <textarea wire:model="cancelationReason" id="cancelation_reason" rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm"
                                    placeholder="Mohon jelaskan alasan pembatalan reservasi Anda..." maxlength="500"></textarea>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ strlen($cancelationReason) }}/500 karakter
                                </div>
                            </div>

                            {{-- Payment Summary --}}
                            <div class="space-y-3 mb-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Total Dibayar:</span>
                                    <span class="font-semibold">Rp
                                        {{ number_format($refundInfo['total_paid'], 0, ',', '.') }}</span>
                                </div>

                                @if ($refundInfo['is_h7_eligible'] ?? false)
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
                                @else
                                    <hr class="border-gray-300">
                                    <div class="flex justify-between text-lg font-bold">
                                        <span class="text-red-600">Jumlah Refund:</span>
                                        <span class="text-red-600">Rp 0 (Tidak ada refund)</span>
                                    </div>
                                @endif
                            </div>

                            <div class="text-xs text-gray-500 space-y-1">
                                @if ($refundInfo['is_h7_eligible'] ?? false)
                                    <p><i class="fas fa-clock mr-1"></i> Refund akan diproses dalam 3-5 hari kerja
                                        (otomatis) atau 1x24 jam (manual)</p>
                                    <p><i class="fas fa-credit-card mr-1"></i> Dana akan dikembalikan ke metode
                                        pembayaran yang sama</p>
                                @else
                                    <p><i class="fas fa-ban mr-1"></i> Tidak ada refund untuk pembatalan kurang dari
                                        H-7</p>
                                @endif
                                <p><i class="fas fa-envelope mr-1"></i> Konfirmasi pembatalan akan dikirim via email
                                </p>
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
                    <button wire:click="processCancellation" wire:loading.attr="disabled"
                        wire:loading.class="opacity-50 cursor-not-allowed"
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm {{ $isProcessing ? 'opacity-50 cursor-not-allowed' : '' }}"
                        {{ $isProcessing ? 'disabled' : '' }}>
                        <span wire:loading.remove wire:target="processCancellation">
                            <i class="fas fa-check mr-1"></i>
                            @if ($refundInfo && ($refundInfo['is_h7_eligible'] ?? false))
                                Batalkan & Proses Refund 50%
                            @else
                                Batalkan Reservasi (No Refund)
                            @endif
                        </span>
                        <span wire:loading wire:target="processCancellation">
                            <i class="fas fa-spinner fa-spin mr-1"></i>
                            Memproses...
                        </span>
                    </button>
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
            type === 'success' ? 'bg-green-500' :
            type === 'warning' ? 'bg-yellow-500' : 'bg-red-500'
        } text-white max-w-md`;

        alertDiv.innerHTML = `
            <div class="flex items-center">
                <i class="fas ${
                    type === 'success' ? 'fa-check-circle' :
                    type === 'warning' ? 'fa-exclamation-triangle' : 'fa-exclamation-circle'
                } mr-2"></i>
                <div class="text-sm">${message}</div>
            </div>
        `;

        document.body.appendChild(alertDiv);

        // Auto-hide after 8 seconds for success/warning, 10 seconds for error
        const hideDelay = type === 'error' ? 10000 : 8000;

        setTimeout(() => {
            alertDiv.style.opacity = '0';
            alertDiv.style.transform = 'translateX(100%)';
            setTimeout(() => {
                alertDiv.remove();
            }, 300);
        }, hideDelay);
    }
</script>
