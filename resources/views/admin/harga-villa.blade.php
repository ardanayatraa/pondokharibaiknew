<x-app-layout>

    <div class="mx-auto ">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b overflow-auto space-y-5 border-gray-200">
                @livewire('harga-villa.create')
                @livewire('table.harga-villa-table')
            </div>
        </div>
        @livewire('harga-villa.update')
        @livewire('harga-villa.delete')


</x-app-layout>
