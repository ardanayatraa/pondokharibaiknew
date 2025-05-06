<x-app-layout>

    <div class="mx-auto ">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b overflow-auto space-y-5 border-gray-200">
                @livewire('villa.create')
                @livewire('table.villa-table')
            </div>
        </div>
        @livewire('villa.update')
        @livewire('villa.delete')
        @livewire('villa.show-facility')

</x-app-layout>
