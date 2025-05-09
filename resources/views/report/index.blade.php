<x-app-layout>
    <div class="w-full mx-auto px-4 py-10">
        {{-- Filter --}}
        <div class="bg-elegant-white p-6 rounded-lg shadow border border-elegant-gold/20 mb-6">
            <h2 class="text-xl font-bold text-elegant-burgundy mb-4">Filter Laporan</h2>
            <form method="GET" action="{{ route('report.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="text-sm font-medium text-elegant-charcoal">Tipe Laporan</label>
                    <select name="type"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-elegant-gold focus:ring focus:ring-elegant-gold/30">
                        <option value="">-- Pilih --</option>
                        <option value="reservasi" {{ request('type') == 'reservasi' ? 'selected' : '' }}>Reservasi
                        </option>
                        <option value="pembayaran" {{ request('type') == 'pembayaran' ? 'selected' : '' }}>Pembayaran
                        </option>
                        <option value="pembatalan" {{ request('type') == 'pembatalan' ? 'selected' : '' }}>Pembatalan
                        </option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-medium text-elegant-charcoal">Dari Tanggal</label>
                    <input type="date" name="start"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-elegant-gold focus:ring focus:ring-elegant-gold/30"
                        value="{{ request('start') }}">
                </div>
                <div>
                    <label class="text-sm font-medium text-elegant-charcoal">Sampai Tanggal</label>
                    <input type="date" name="end"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-elegant-gold focus:ring focus:ring-elegant-gold/30"
                        value="{{ request('end') }}">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="w-full px-4 py-2 bg-elegant-burgundy text-white rounded-md hover:bg-elegant-burgundy/80 transition">
                        Tampilkan
                    </button>
                    <a href="{{ route('report.index') }}"
                        class="w-full px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition text-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Export PDF --}}
        @if ($data && count($data))
            <div class="mb-4 flex justify-end">
                <a href="{{ route('report.export', request()->query()) }}"
                    class="w-full px-4 py-2 bg-elegant-burgundy text-white rounded-md hover:bg-elegant-burgundy/80 transition">
                    <i class="fas fa-file-pdf"></i>
                    <span>Export PDF</span>
                </a>
            </div>
        @endif

        {{-- Table --}}
        @if ($data && count($data))
            <div class="bg-white rounded-lg shadow overflow-x-auto border border-gray-200">
                <table class="min-w-full text-sm table-auto">
                    <thead class="bg-elegant-burgundy text-white uppercase">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold tracking-wide">No</th>
                            <th class="px-6 py-3 text-left font-semibold tracking-wide">Tipe</th>
                            <th class="px-6 py-3 text-left font-semibold tracking-wide">Tanggal</th>
                            <th class="px-6 py-3 text-left font-semibold tracking-wide">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-elegant-charcoal">
                        @foreach ($data as $i => $item)
                            <tr class="{{ $loop->odd ? 'bg-white' : 'bg-elegant-cream/50' }} hover:bg-elegant-gold/10">
                                <td class="px-6 py-3">{{ $data->firstItem() + $i }}</td>
                                <td class="px-6 py-3 capitalize">{{ $type }}</td>
                                <td class="px-6 py-3">
                                    {{ $type === 'pembayaran' ? $item->payment_date : $item->start_date ?? '-' }}
                                </td>
                                <td class="px-6 py-3">
                                    @if ($type === 'pembayaran')
                                        Pembayaran sebesar
                                        <strong>Rp{{ number_format($item->amount, 0, ',', '.') }}</strong>
                                    @else
                                        {{ $item->villa->name ?? 'Villa tidak ditemukan' }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $data->withQueryString()->links() }}
            </div>
        @elseif(request()->all())
            <div class="text-center text-gray-500 mt-8">
                Tidak ada data untuk filter yang dipilih.
            </div>
        @endif
    </div>
</x-app-layout>
