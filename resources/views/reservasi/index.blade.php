<x-app-layout>
    <div class="py-2">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-sm font-semibold text-gray-800">Reservasi</h1>
                </div>

                {{-- Tampilkan session error --}}
                @if (session('error'))
                    <div class="mb-4 px-4 py-2 bg-red-100 border border-red-400 text-red-700 text-sm rounded">
                        {{ session('error') }}
                    </div>
                @endif

                @livewire('table.reservasi-table')
            </div>
        </div>
    </div>
</x-app-layout>
