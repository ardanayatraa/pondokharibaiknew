<x-dialog-modal wire:model="open">
    <x-slot name="title">Hapus Pembayaran</x-slot>
    <x-slot name="content">
        <p class="text-sm text-gray-700">
            Apakah kamu yakin ingin menghapus pembayaran ini? Tindakan ini tidak dapat dibatalkan.
        </p>
    </x-slot>
    <x-slot name="footer">
        <x-button wire:click="$set('open', false)" class="bg-gray-500 hover:bg-gray-600 text-white">Batal</x-button>
        <x-button wire:click="delete" class="bg-red-600 hover:bg-red-700 text-white">Hapus</x-button>
    </x-slot>
</x-dialog-modal>
