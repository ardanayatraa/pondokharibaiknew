<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-sm text-gray-800">Detail Pembayaran</h2>
    </x-slot>

    <div class="py-2">
        <div class="w-full mx-auto sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="w-full mb-6 bg-white dark:bg-gray-900 py-4 px-6 rounded-lg shadow">
                <h2 class="text-lg font-bold">Informasi Detail Pembayaran</h2>
            </div>

            {{-- Informasi Pembayaran --}}
            <section class="bg-white shadow rounded-lg p-6 mb-8">
                <h3 class="font-semibold text-gray-800 mb-4 border-b border-gray-200 pb-2">Informasi Pembayaran</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-sm text-gray-700">
                    <div><strong>ID Pembayaran:</strong> {{ $pembayaran->id_pembayaran }}</div>
                    <div><strong>Status:</strong>
                        <span
                            class="inline-block px-2 py-1 rounded-md text-xs
                            {{ $pembayaran->status === 'confirmed'
                                ? 'bg-green-100 text-green-700'
                                : ($pembayaran->status === 'cancelled'
                                    ? 'bg-red-100 text-red-700'
                                    : 'bg-yellow-100 text-yellow-700') }}">
                            {{ ucfirst($pembayaran->status) }}
                        </span>
                    </div>
                    <div><strong>Tanggal Bayar:</strong>
                        {{ \Carbon\Carbon::parse($pembayaran->payment_date)->format('d M Y H:i') }}</div>
                    <div><strong>Jumlah Dibayar:</strong> Rp{{ number_format($pembayaran->amount, 0, ',', '.') }}</div>
                    <div><strong>Order ID:</strong> {{ $pembayaran->order_id ?? '-' }}</div>
                </div>
            </section>

            {{-- Informasi Tamu --}}
            <section class="bg-white shadow rounded-lg p-6 mb-8">
                <h3 class="font-semibold text-gray-800 mb-4 border-b border-gray-200 pb-2">Informasi Tamu</h3>
                @if ($pembayaran->guest)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-sm text-gray-700">
                        <div><strong>Nama:</strong> {{ $pembayaran->guest->full_name }}</div>
                        <div><strong>Email:</strong> {{ $pembayaran->guest->email }}</div>
                        <div><strong>Telepon:</strong> {{ $pembayaran->guest->phone_number }}</div>
                        <div><strong>Tanggal Lahir:</strong>
                            {{ \Carbon\Carbon::parse($pembayaran->guest->birthdate)->format('d M Y') }}</div>
                        <div><strong>No KTP:</strong> {{ $pembayaran->guest->id_card_number }}</div>
                        <div><strong>Gender:</strong> {{ ucfirst($pembayaran->guest->gender) }}</div>
                    </div>
                @else
                    <p class="text-red-500 italic">Data tamu tidak tersedia.</p>
                @endif
            </section>

            {{-- Informasi Reservasi --}}
            <section class="bg-white shadow rounded-lg p-6 mb-8">
                <h3 class="font-semibold text-gray-800 mb-4 border-b border-gray-200 pb-2">Informasi Reservasi</h3>
                @if ($pembayaran->reservasi)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-sm text-gray-700">
                        <div><strong>Villa:</strong> {{ $pembayaran->reservasi->villa->name ?? '-' }}</div>
                        <div><strong>Check-in:</strong>
                            {{ \Carbon\Carbon::parse($pembayaran->reservasi->start_date)->format('d M Y') }}</div>
                        <div><strong>Check-out:</strong>
                            {{ \Carbon\Carbon::parse($pembayaran->reservasi->end_date)->format('d M Y') }}</div>
                        <div><strong>Durasi:</strong>
                            {{ \Carbon\Carbon::parse($pembayaran->reservasi->start_date)->diffInDays($pembayaran->reservasi->end_date) }}
                            malam
                        </div>
                        <div>
                            <strong>Status Reservasi:</strong>
                            <span
                                class="inline-block px-2 py-1 rounded-md text-xs
                                {{ $pembayaran->reservasi->status === 'confirmed'
                                    ? 'bg-green-100 text-green-700'
                                    : ($pembayaran->reservasi->status === 'cancelled'
                                        ? 'bg-red-100 text-red-700'
                                        : 'bg-yellow-100 text-yellow-700') }}">
                                {{ ucfirst($pembayaran->reservasi->status) }}
                            </span>
                        </div>
                        @if ($pembayaran->reservasi->cancelation_date)
                            <div><strong>Tanggal Pembatalan:</strong>
                                {{ \Carbon\Carbon::parse($pembayaran->reservasi->cancelation_date)->format('d M Y') }}
                            </div>
                        @endif
                        <div><strong>Total Tagihan:</strong>
                            Rp{{ number_format($pembayaran->reservasi->total_amount, 0, ',', '.') }}</div>
                    </div>
                @else
                    <p class="text-red-500 italic">Data reservasi tidak tersedia.</p>
                @endif
            </section>

            {{-- Tombol Kembali --}}
            <div class="flex justify-end">
                <a href="{{ route('pembayaran.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali ke
                    daftar pembayaran</a>
            </div>
        </div>
    </div>
</x-app-layout>
