<x-dialog-modal wire:model="open">
    <x-slot name="title">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12l2 2l4 -4M12 20a8 8 0 1 0 0-16a8 8 0 0 0 0 16z" />
            </svg>
            <span class="text-base font-semibold text-gray-800">Daftar Fasilitas</span>
        </div>
    </x-slot>

    <x-slot name="content">
        @if (!empty($selectedFacilityNames))
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach ($selectedFacilityNames as $name)
                    <div class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg bg-white shadow-sm">
                        <div class="text-indigo-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="text-sm text-gray-700">{{ $name }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-4 text-center bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-500">
                Tidak ada fasilitas terdaftar.
            </div>
        @endif
    </x-slot>

    <x-slot name="footer">
        <x-button wire:click="$set('open', false)" class="bg-gray-600 hover:bg-gray-700 text-white">
            Tutup
        </x-button>
    </x-slot>
</x-dialog-modal>
