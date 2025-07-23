{{-- resources/views/reservasi/lanjutkan-pembayaran.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-sm text-gray-800">Lanjutkan Pembayaran</h2>
    </x-slot>

    <div class="py-2">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            {{-- Header Section --}}
            <div class="w-full mb-6 bg-white dark:bg-gray-900 py-4 px-6 rounded-lg shadow">
                <h2 class="text-lg font-bold">
                    Lanjutkan Pembayaran Reservasi
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Silakan klik tombol di bawah untuk melanjutkan pembayaran yang terputus.
                </p>
            </div>

            {{-- Detail Reservasi Section --}}
            <section class="bg-white shadow rounded-lg p-6 mb-8">
                <h3 class="font-semibold text-gray-800 mb-4 border-b border-gray-200 pb-2">Detail Reservasi</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-sm text-gray-700">
                    <div><strong>Villa:</strong> {{ $reservasi->villa->name }}</div>
                    <div><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($reservasi->start_date)->format('d M Y') }}
                    </div>
                    <div><strong>Check-out:</strong> {{ \Carbon\Carbon::parse($reservasi->end_date)->format('d M Y') }}
                    </div>
                    <div><strong>Durasi:</strong>
                        {{ \Carbon\Carbon::parse($reservasi->start_date)->diffInDays($reservasi->end_date) }} malam
                    </div>
                    <div>
                        <strong>Status:</strong>
                        <span
                            class="inline-block px-2 py-1 rounded-md text-xs
                            {{ $reservasi->status === 'confirmed'
                                ? 'bg-green-100 text-green-700'
                                : ($reservasi->status === 'cancelled'
                                    ? 'bg-red-100 text-red-700'
                                    : 'bg-yellow-100 text-yellow-700') }}">
                            {{ ucfirst($reservasi->status) }}
                        </span>
                    </div>
                    <div><strong>Total Tagihan:</strong> Rp{{ number_format($reservasi->total_amount, 0, ',', '.') }}
                    </div>
                </div>
            </section>

            {{-- Informasi Pembayaran Section --}}
            <section class="bg-white shadow rounded-lg p-6 mb-8">
                <h3 class="font-semibold text-gray-800 mb-4 border-b border-gray-200 pb-2">Informasi Pembayaran</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-sm text-gray-700">
                    <div><strong>Status Pembayaran:</strong>
                        <span class="inline-block px-2 py-1 rounded-md text-xs bg-yellow-100 text-yellow-700">
                            Pending
                        </span>
                    </div>
                    <div><strong>Batas Waktu Pembayaran:</strong>
                        {{ \Carbon\Carbon::parse($reservasi->batas_waktu_pembayaran)->format('d M Y H:i') }}
                    </div>
                    <div><strong>Jumlah yang Harus Dibayar:</strong>
                        Rp{{ number_format($reservasi->total_amount, 0, ',', '.') }}</div>
                </div>

                <div class="mt-8 flex justify-center">
                    <button id="pay-button" data-snap-token="{{ $snap_token }}"
                        class="bg-elegant-green hover:bg-elegant-green/90 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-200 flex items-center">
                        <i class="fas fa-credit-card mr-2"></i> Lanjutkan Pembayaran
                    </button>
                </div>
            </section>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end">
                <a href="{{ route('dashboard') }}" class="text-sm text-blue-600 hover:underline">← Kembali ke
                    dashboard</a>
            </div>

        </div>
    </div>

    <!-- Hidden input untuk menyimpan snap token -->
    <input type="hidden" id="snap-token" value="{{ $snap_token }}">

    <!-- Load continue-payment.js -->
    <script src="{{ asset('dist/continue-payment.js') }}"></script>
</x-app-layout>
