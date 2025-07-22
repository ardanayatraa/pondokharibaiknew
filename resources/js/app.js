import './bootstrap';
import '../../vendor/rappasoft/laravel-livewire-tables/resources/imports/laravel-livewire-tables.js';
import '../../vendor/rappasoft/laravel-livewire-tables/resources/imports/laravel-livewire-tables-all.js';

// Fungsi untuk inject badge fasilitas ke Room Details
window.renderRoomFacilities = function(facilityNames = [], targetId = 'room-facilities') {
    console.log('[DEBUG] renderRoomFacilities target:', targetId, 'facilityNames:', facilityNames);
    const container = document.getElementById(targetId);
    if (!container) return;
    container.innerHTML = '';
    if (facilityNames.length === 0) {
        container.innerHTML = '<span class="text-gray-400 text-xs">No facilities listed.</span>';
        return;
    }
    facilityNames.forEach(name => {
        const badge = document.createElement('span');
        badge.className = 'inline-block px-3 py-1 rounded-full bg-elegant-green/10 text-elegant-green font-semibold border border-elegant-green text-xs mb-1';
        badge.textContent = name;
        container.appendChild(badge);
    });
}
