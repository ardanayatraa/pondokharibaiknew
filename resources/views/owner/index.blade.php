{{-- resources/views/owner/index.blade.php --}}
<x-app-layout>
    <div class="py-2">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-sm font-semibold text-gray-800">Owner</h1>
                    <a href="{{ route('owner.create') }}">
                        <x-button>Tambah Owner</x-button>
                    </a>
                </div>
                @livewire('table.owner-table')
            </div>
        </div>
    </div>
</x-app-layout>
