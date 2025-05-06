<x-app-layout>

    <div class="mx-auto ">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b overflow-auto space-y-5 border-gray-200">
                @livewire('villa-pricing.create')
                @livewire('table.villa-pricing-table')
            </div>
        </div>
        @livewire('villa-pricing.update')
        @livewire('villa-pricing.delete')


</x-app-layout>
