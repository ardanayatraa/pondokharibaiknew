<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="">
        <!-- Tab Navigation -->
        <div class="mb-6">
            <div class="border-b border-gray-300 flex space-x-4">
                <!-- Admin Tab -->
                <button id="tab-admin"
                    class="tab-button pb-2 px-4 text-lg font-semibold text-gray-500 hover:text-blue-600">
                    Admin
                </button>

                <!-- Siswa Tab -->
                <button id="tab-guest"
                    class="tab-button pb-2 px-4 text-lg font-semibold text-gray-500 hover:text-blue-600">
                    Siswa
                </button>

                <!-- Guru Tab -->
                <button id="tab-owner"
                    class="tab-button pb-2 px-4 text-lg font-semibold text-gray-500 hover:text-blue-600">
                    Guru
                </button>

                <!-- Kepsek Tab -->
                <button id="tab-kepsek"
                    class="tab-button pb-2 px-4 text-lg font-semibold text-gray-500 hover:text-blue-600">
                    Kepsek
                </button>
            </div>
        </div>

        <div class="tab-content space-y-6">
            <!-- Admin Tab -->
            <div id="content-admin" class="tab-panel hidden flex flex-col space-y-4">
                <h3 class="text-xl font-semibold text-gray-800 p-4 border rounded-lg mb-4">Admin Management</h3>
                <div class="p-4 border rounded-lg mb-4">
                    @livewire('admin.add')

                </div>
                <div class="p-4 border rounded-lg mb-4">
                    @livewire('table.adminTable')
                </div>

                @livewire('admin.update')
                @livewire('admin.delete')
            </div>

            <!-- Siswa Tab -->
            <div id="content-guest" class="tab-panel hidden">
                <h3 class="text-xl font-semibold text-gray-800 p-4 border rounded-lg mb-4">Siswa Management</h3>
                <div class="p-4 border rounded-lg mb-4">
                    @livewire('akun-guest.add')
                </div>
                <div class="p-4 border rounded-lg mb-4">
                    @livewire('table.akun-guest-table')
                </div>

                @livewire('akun-guest.update')
                @livewire('akun-guest.delete')
            </div>
        </div>

        <!-- Guru Tab -->
        <div id="content-owner" class="tab-panel hidden">
            <h3 class="text-xl font-semibold text-gray-800 p-4 border rounded-lg mb-4">Guru Management</h3>
            <div class="p-4 border rounded-lg mb-4">
                @livewire('owner.add')
            </div>
            <div class="p-4 border rounded-lg mb-4">
                @livewire('table.owner-table')
            </div>
            @livewire('owner.update')
            @livewire('owner.delete')
        </div>
    </div>

    <!-- Kepsek Tab -->
    <div id="content-kepsek" class="tab-panel hidden">
        <h3 class="text-xl font-semibold text-gray-800 p-4 border rounded-lg mb-4">Kepsek Management</h3>
        <div class="p-4 border rounded-lg mb-4">
            @livewire('kepala-sekolah.add')
        </div>
        <div class="p-4 border rounded-lg mb-4">
            @livewire('table.kepala-sekolah-table')
        </div>
        @livewire('kepala-sekolah.update')
        @livewire('kepala-sekolah.delete')

    </div>
    </div>

    </div>

    <script>
        // Vanilla JavaScript to manage the active tab
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab-button');
            const panels = document.querySelectorAll('.tab-panel');

            // Function to reset all tabs and content visibility
            function resetTabs() {
                tabs.forEach(tab => tab.classList.remove('text-blue-600', 'border-b-2', 'border-blue-600'));
                panels.forEach(panel => panel.classList.add('hidden'));
            }

            // Function to activate the selected tab
            function activateTab(tabId, contentId) {
                resetTabs();

                // Add styles for active tab
                const activeTab = document.getElementById(tabId);
                activeTab.classList.add('text-blue-600', 'border-b-2', 'border-blue-600');

                // Show the related content
                const activeContent = document.getElementById(contentId);
                activeContent.classList.remove('hidden');
            }

            // Set default active tab (Admin)
            activateTab('tab-admin', 'content-admin');

            // Add event listeners for tabs
            document.getElementById('tab-admin').addEventListener('click', () => activateTab('tab-admin',
                'content-admin'));
            document.getElementById('tab-guest').addEventListener('click', () => activateTab('tab-guest',
                'content-guest'));
            document.getElementById('tab-owner').addEventListener('click', () => activateTab('tab-owner',
                'content-owner'));
            document.getElementById('tab-kepsek').addEventListener('click', () => activateTab('tab-kepsek',
                'content-kepsek'));
        });
    </script>
</x-app-layout>
