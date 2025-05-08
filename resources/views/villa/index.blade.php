{{-- resources/views/villa/index.blade.php --}}
<x-app-layout>
    <div class="py-2">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-sm font-semibold text-gray-800">Villa</h1>
                    <a href="{{ route('villa.create') }}">
                        <x-button>Tambah Villa</x-button>
                    </a>
                </div>
                @livewire('table.villa-table')
                @livewire('villa.show-facility')
            </div>
        </div>
    </div>
</x-app-layout>
