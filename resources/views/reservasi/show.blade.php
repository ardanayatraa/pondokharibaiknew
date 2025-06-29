{{-- resources/views/reservasi/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-sm text-gray-800">Detail Reservasi</h2>
    </x-slot>

    <div class="py-2">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            {{-- Header Section --}}
            <div class="w-full mb-6 bg-white dark:bg-gray-900 py-4 px-6 rounded-lg shadow">
                <h2 class="text-lg font-bold">
                    Informasi Detail Reservasi
                </h2>
            </div>

            {{-- Informasi Tamu Section --}}
            <section class="bg-white shadow rounded-lg p-6 mb-8">
                <h3 class="font-semibold text-gray-800 mb-4 border-b border-gray-200 pb-2">Informasi Tamu</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-sm text-gray-700">
                    <div><strong>Nama:</strong> {{ $reservasi->guest->full_name }}</div>
                    <div><strong>Email:</strong> {{ $reservasi->guest->email }}</div>
                    <div><strong>Telepon:</strong> {{ $reservasi->guest->phone_number }}</div>
                    <div><strong>Tanggal Lahir:</strong>
                        {{ \Carbon\Carbon::parse($reservasi->guest->birthdate)->format('d M Y') }}</div>
                    <div><strong>No KTP:</strong> {{ $reservasi->guest->id_card_number }}</div>
                    <div><strong>Gender:</strong> {{ ucfirst($reservasi->guest->gender) }}</div>
                </div>
            </section>

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
                    @if ($reservasi->cancelation_date)
                        <div><strong>Tanggal Pembatalan:</strong>
                            {{ \Carbon\Carbon::parse($reservasi->cancelation_date)->format('d M Y') }}</div>
                    @endif
                    <div><strong>Total Tagihan:</strong> Rp{{ number_format($reservasi->total_amount, 0, ',', '.') }}
                    </div>
                </div>
            </section>

            {{-- Informasi Pembayaran Section --}}
            <section class="bg-white shadow rounded-lg p-6 mb-8">
                <h3 class="font-semibold text-gray-800 mb-4 border-b border-gray-200 pb-2">Informasi Pembayaran</h3>
                @if ($reservasi->pembayaran)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-sm text-gray-700">
                        <div><strong>Status:</strong> {{ ucfirst($reservasi->pembayaran->status) }}</div>
                        <div><strong>Tanggal:</strong>
                            {{ \Carbon\Carbon::parse($reservasi->pembayaran->payment_date)->format('d M Y H:i') }}
                        </div>
                        <div><strong>Jumlah Dibayar:</strong>
                            Rp{{ number_format($reservasi->total_amount, 0, ',', '.') }}</div>
                    </div>
                @else
                    <p class="text-red-500 italic">Belum ada data pembayaran.</p>
                @endif
            </section>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end">
                <a href="{{ route('reservasi.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali ke
                    daftar</a>
            </div>

        </div>
    </div>
</x-app-layout>
