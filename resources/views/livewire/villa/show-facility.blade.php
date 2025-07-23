<x-dialog-modal wire:model="open">
    <x-slot name="title">
        <div class="flex items-center gap-2">
            <i class="fas fa-home text-elegant-green"></i>
            <span class="text-base font-semibold text-gray-800">Fasilitas Villa</span>
        </div>
    </x-slot>

    <x-slot name="content">
        @if (!empty($facilityDetails))
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @foreach ($facilityDetails as $facility)
                    <div
                        class="flex flex-col items-center p-4 border border-gray-200 rounded-lg bg-white shadow-sm hover:shadow-md transition-shadow duration-300 hover:border-elegant-green">
                        <div
                            class="w-12 h-12 flex items-center justify-center rounded-full bg-elegant-green/10 text-elegant-green mb-3">
                            <i class="fas {{ $facility['icon'] }} text-xl"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-800 text-center">{{ $facility['name'] }}</span>
                        @if (!empty($facility['description']))
                            <span
                                class="text-xs text-gray-500 mt-1 text-center">{{ Str::limit($facility['description'], 30) }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-6 text-center bg-gray-50 border border-gray-200 rounded-lg">
                <div class="w-16 h-16 mx-auto flex items-center justify-center rounded-full bg-gray-100 mb-4">
                    <i class="fas fa-home text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-gray-500 font-medium mb-1">Tidak Ada Fasilitas</h3>
                <p class="text-gray-400 text-sm">Villa ini belum memiliki fasilitas terdaftar.</p>
            </div>
        @endif
    </x-slot>

    <x-slot name="footer">
        <x-button wire:click="$set('open', false)" class="bg-elegant-green hover:bg-elegant-green/90 text-white">
            Tutup
        </x-button>
    </x-slot>
</x-dialog-modal>
