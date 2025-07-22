<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Cek Ketersediaan
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <form method="GET" class="mb-6 flex flex-wrap items-center gap-4">
                    <label for="start" class="font-semibold">Dari:</label>
                    <input type="date" id="start" name="start" value="{{ $start }}" class="border rounded px-2 py-1">
                    <label for="end" class="font-semibold">Sampai:</label>
                    <input type="date" id="end" name="end" value="{{ $end }}" class="border rounded px-2 py-1">
                    <button type="submit" class="bg-elegant-burgundy text-white px-4 py-2 rounded">Filter</button>
                </form>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($villas as $item)
                        <div class="border rounded-lg p-6 shadow text-center {{ $item['tersedia'] ? 'bg-green-50' : 'bg-red-50' }}">
                            <h3 class="text-lg font-bold mb-2">{{ $item['villa']->name }}</h3>
                            <div class="mb-2">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $item['tersedia'] ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                    {{ $item['tersedia'] ? 'Tersedia' : 'Tidak Tersedia' }}
                                </span>
                            </div>
                            <div class="text-gray-500 text-sm mb-2">Kapasitas: {{ $item['villa']->capacity }}</div>
                            @if(!$item['tersedia'])
                                <div class="bg-red-100 text-red-800 text-xs rounded p-2 mt-2">
                                    <b>Sudah dipesan pada:</b>
                                    <ul class="list-disc list-inside">
                                        @foreach($item['reservasi_bentrok'] as $r)
                                            <li>{{ \Carbon\Carbon::parse($r->start_date)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($r->end_date)->format('d M Y') }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 