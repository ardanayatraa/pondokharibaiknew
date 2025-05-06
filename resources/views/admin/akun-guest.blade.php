<x-app-layout>

    <div class="mx-auto ">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b overflow-auto space-y-5 border-gray-200">
                @livewire('guest.create')
                @livewire('table.guest-table')
            </div>
        </div>
        @livewire('guest.update')
        @livewire('guest.delete')


</x-app-layout>
