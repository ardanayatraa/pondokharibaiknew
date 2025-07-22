<x-app-layout>
    <div class="mx-auto">
        <div class="w-full mx-auto py-6 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Total Villa -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-2">Total Villa</h3>
                    <p class="text-2xl font-bold">{{ $totalRoom }}</p>
                </div>

                <!-- Jumlah Pelanggan -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-2">Jumlah Pelanggan</h3>
                    <p class="text-2xl font-bold">{{ $jumlahGuest }}</p>
                </div>

                <!-- Jumlah Reservasi -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-2">Jumlah Reservasi</h3>
                    <p class="text-2xl font-bold">{{ $jumlahReservasi }}</p>
                </div>

                <!-- Jumlah Cancel -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-2">Jumlah Cancel</h3>
                    <p class="text-2xl font-bold">{{ $jumlahCancel }}</p>
                </div>

                <!-- Jumlah Reschedule -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-2">Jumlah Reschedule</h3>
                    <p class="text-2xl font-bold">{{ $jumlahReschedule }}</p>
                </div>

                <!-- Total Transaksi -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-2">Total Transaksi</h3>
                    <p class="text-2xl font-bold">
                        Rp {{ number_format($totalTransaksi, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
