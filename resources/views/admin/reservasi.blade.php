<x-app-layout>

    <div class="mx-auto ">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b overflow-auto space-y-5 border-gray-200">
                @livewire('reservasi.create')
                @livewire('table.reservasi-table')
            </div>
        </div>
        @livewire('reservasi.update')
        @livewire('reservasi.delete')


</x-app-layout>
