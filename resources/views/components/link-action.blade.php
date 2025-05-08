<div>
    <a href="{{ route($routeName . '.edit', $id) }}" class="text-indigo-600 hover:underline font-semibold">Edit</a>
    <button onclick="confirmDelete('{{ route($routeName . '.destroy', $id) }}')"
        class="text-red-600 hover:underline font-semibold ml-4">Hapus</button>
</div>

<!-- Modal Konfirmasi -->
<div id="delete-modal" onclick="if (event.target === this) closeModal()"
    class="fixed inset-0 bg-black bg-opacity-0 backdrop-blur-sm flex items-center justify-center z-50 pointer-events-none opacity-0 transition-opacity duration-300 ease-out hidden">
    <div id="delete-modal-content"
        class="bg-white p-6 rounded-2xl shadow-xl max-w-md w-full transform scale-95 opacity-0 transition-all duration-300 ease-out">
        <h2 class="text-lg font-bold mb-4 text-gray-800">Konfirmasi Hapus</h2>
        <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus data ini?</p>
        <div class="flex justify-end space-x-6"><!-- space-x-6 untuk jarak lebih luas -->
            <button type="button" onclick="closeModal()"
                class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 transition">Batal</button>
            <form id="delete-form" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">Hapus</button>
            </form>
        </div>
    </div>
    >
</div>

<script>
    function confirmDelete(deleteUrl) {
        const modal = document.getElementById('delete-modal');
        const content = document.getElementById('delete-modal-content');
        const form = document.getElementById('delete-form');
        form.action = deleteUrl;

        modal.classList.remove('hidden', 'pointer-events-none');
        // animasi overlay fade-in + blur
        requestAnimationFrame(() => {
            modal.classList.replace('opacity-0', 'opacity-100');
            modal.classList.replace('bg-opacity-0', 'bg-opacity-50');
        });
        // animasi modal zoom-in + fade-in
        requestAnimationFrame(() => {
            content.classList.replace('scale-95', 'scale-100');
            content.classList.replace('opacity-0', 'opacity-100');
        });
    }

    function closeModal() {
        const modal = document.getElementById('delete-modal');
        const content = document.getElementById('delete-modal-content');

        // animasi reverse: zoom-out + fade-out
        content.classList.replace('scale-100', 'scale-95');
        content.classList.replace('opacity-100', 'opacity-0');
        modal.classList.replace('bg-opacity-50', 'bg-opacity-0');
        modal.classList.replace('opacity-100', 'opacity-0');

        // setelah animasi selesai, sembunyikan modal
        setTimeout(() => {
            modal.classList.add('hidden', 'pointer-events-none');
        }, 300);
    }
</script>
