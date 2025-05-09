<x-app-layout>
    <div class="mx-auto">
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-elegant-cream border border-elegant-gold/30 rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white  p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold mb-2 text-elegant-burgundy">Total Transaksi</h3>
                        <p class="text-2xl font-bold text-green-700">Rp {{ number_format($totalTransaksi, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold mb-2 text-elegant-burgundy">Jumlah Pelanggan</h3>
                        <p class="text-2xl font-bold text-blue-700">{{ $jumlahGuest }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
