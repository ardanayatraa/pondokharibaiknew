{{-- resources/views/components/status-dropdown.blade.php --}}
<div x-data="{
    reservasiId: {{ $reservasi->id_reservation }},
    oldStatus: '{{ $reservasi->status }}', // status sebelum diubah
    newStatus: '{{ $reservasi->status }}',
    showModal: false,
    showNotif: false,

    confirmChange() {
        $wire.call('updateStatus', this.reservasiId, this.newStatus)
            .then(() => {
                // Karena Livewire hanya mengizinkan update jika oldStatus == 'confirmed',
                // maka di sini oldStatus akan di‐override dengan newStatus (yang pasti 'cancelled' atau 'reschedule')
                this.oldStatus = this.newStatus;
                this.showModal = false;
                this.showNotif = true;
                // Sembunyikan notifikasi setelah 4 detik
                setTimeout(() => { this.showNotif = false }, 4000);
            });
    },

    cancelChange() {
        // Batalkan perubahan: kembalikan newStatus ke oldStatus
        this.newStatus = this.oldStatus;
        this.showModal = false;
    }
}" class="relative inline-block">
    {{-- Jika oldStatus BUKAN 'confirmed', tampilkan status sebagai teks biasa --}}
    <template x-if="oldStatus !== 'confirmed'">
        <span class="inline-block px-2 py-1 bg-gray-100 text-gray-700 rounded-md text-sm">
            <span x-text="oldStatus"></span>
        </span>
    </template>

    {{-- Jika oldStatus == 'confirmed', tampilkan dropdown untuk memilih cancelled atau reschedule --}}
    <template x-if="oldStatus === 'confirmed'">
        <div>
            {{-- Dropdown Status --}}
            <select x-model="newStatus" @change="showModal = true"
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm py-1 px-2">
                {{-- Pilihan default tetap 'confirmed' (karena oldStatus == confirmed) --}}
                <option value="confirmed">confirmed</option>
                <option value="cancelled">cancelled</option>
                <option value="reschedule">reschedule</option>
            </select>
        </div>
    </template>

    {{-- Modal Konfirmasi (teleport ke <body>) --}}
    <template x-teleport="body">
        <div x-show="showModal" x-transition.opacity
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
            <div @click.away="cancelChange()" class="bg-white rounded-lg shadow-xl max-w-sm w-full p-6 mx-4">
                <h2 class="text-lg font-semibold mb-4">Konfirmasi Ubah Status</h2>
                <p class="mb-6 text-sm">
                    Anda akan mengubah status reservasi
                    <strong>#{{ $reservasi->id_reservation }}</strong>
                    dari
                    <span class="font-medium text-gray-800" x-text="oldStatus"></span>
                    menjadi
                    <span class="font-medium text-gray-800" x-text="newStatus"></span>.
                    Apakah Anda yakin?
                </p>
                <div class="flex justify-end space-x-2">
                    <button @click="cancelChange()"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 text-sm">
                        Batal
                    </button>
                    <button @click="confirmChange()"
                        class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm">
                        Konfirmasi
                    </button>
                </div>
            </div>
        </div>
    </template>

    {{-- Notifikasi di pojok kanan atas (teleport ke <body>) --}}
    <template x-teleport="body">
        <div x-show="showNotif" x-transition.opacity.duration.300ms
            class="fixed top-4 right-4 bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-2 rounded-md shadow-lg z-[100]"
            style="display: none;">
            Status berhasil diupdate menjadi <span x-text="newStatus"></span>.
            <span class="block mt-1 text-xs text-gray-700">Silakan cek email untuk informasi lebih lanjut.</span>
        </div>
    </template>
</div>
