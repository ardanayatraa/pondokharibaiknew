<div>
    <x-dialog-modal wire:model="open">
        <x-slot name="title">Hapus Season</x-slot>
        <x-slot name="content">
            Yakin ingin menghapus season ini? Aksi ini tidak bisa dibatalkan.
        </x-slot>
        <x-slot name="footer">
            <x-button wire:click="$set('open', false)">Batal</x-button>
            <x-button wire:click="delete" class="bg-red-600 hover:bg-red-700 text-white">Hapus</x-button>
        </x-slot>
    </x-dialog-modal>

</div>
