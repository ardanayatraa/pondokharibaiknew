<x-dialog-modal wire:model="showFacilityModal">
    <x-slot name="title">Daftar Fasilitas</x-slot>

    <x-slot name="content">
        <ul class="list-disc pl-5 text-sm text-gray-800 space-y-1">
            @foreach ($selectedFacilityNames as $name)
                <li>{{ $name }}</li>
            @endforeach
        </ul>
    </x-slot>

    <x-slot name="footer">
        <x-button wire:click="$set('showFacilityModal', false)">Tutup</x-button>
    </x-slot>
</x-dialog-modal>
