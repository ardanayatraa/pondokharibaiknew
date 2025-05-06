<x-app-layout>

    <div class="mx-auto ">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b overflow-auto space-y-5 border-gray-200">
                @livewire('pembayaran.create')
                @livewire('table.pembayaran-table')
            </div>
        </div>
        @livewire('pembayaran.update')
        @livewire('pembayaran.delete')


</x-app-layout>
