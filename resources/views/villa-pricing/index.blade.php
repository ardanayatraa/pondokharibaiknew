{{-- resources/views/harga-villa/index.blade.php --}}
<x-app-layout>
    <div class="py-2">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-sm font-semibold text-gray-800">Villa Pricing</h1>
                    <a href="{{ route('villa-pricing.create') }}">
                        <x-button>Tambah Villa Pricing</x-button>
                    </a>
                </div>
                @livewire('table.villa-pricing-table')
            </div>
        </div>
    </div>
</x-app-layout>
