<x-dialog-modal wire:model="open">
    <x-slot name="title">Hapus Guest</x-slot>
    <x-slot name="content">
        Apakah kamu yakin ingin menghapus guest ini? Tindakan ini tidak bisa dibatalkan.
    </x-slot>
    <x-slot name="footer">
        <x-button wire:click="$set('open', false)">Batal</x-button>
        <x-button wire:click="delete" class="bg-red-600 hover:bg-red-700 text-white">Hapus</x-button>
    </x-slot>
</x-dialog-modal>
