@php
    $canCheckIn =
        $row->status === 'confirmed' &&
        $row->status_check_in === 'pending' &&
        now()->toDateString() >= $row->start_date;
    $canCheckOut = $row->status === 'confirmed' && $row->status_check_in === 'checked_in';
@endphp
@if ($row->status_check_in === 'checked_out')
    <span class="inline-block px-3 py-1 rounded-full bg-gray-200 text-gray-700 text-xs font-semibold">Sudah
        Check-out</span>
@else
    @if ($canCheckIn)
        <form method="POST" action="{{ route('reservasi.checkin', $row->id_reservation) }}" style="display:inline">
            @csrf
            <button type="submit"
                class="px-3 py-1 bg-green-600 text-white rounded text-xs font-semibold hover:bg-green-700">Check-in</button>
        </form>
    @endif
    @if ($canCheckOut)
        <button type="button" onclick="showCheckoutModal{{ $row->id_reservation }}()"
            class="px-3 py-1 bg-gray-600 text-white rounded text-xs font-semibold hover:bg-gray-700">Check-out</button>
        <div id="checkout-modal-{{ $row->id_reservation }}"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm text-center animate-fade-in">
                <h3 class="text-lg font-bold mb-2 text-elegant-green">Konfirmasi Check-out</h3>
                <p class="text-gray-700 mb-4">Yakin ingin check-out sekarang?<br><span
                        class="text-xs text-gray-500">Jika check-out lebih awal, sisa masa inap akan hangus.</span></p>
                <form method="POST" action="{{ route('reservasi.checkout', $row->id_reservation) }}">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 bg-elegant-burgundy text-white rounded font-semibold hover:bg-elegant-orange transition">Ya,
                        Check-out</button>
                    <button type="button" onclick="hideCheckoutModal{{ $row->id_reservation }}()"
                        class="ml-2 px-4 py-2 bg-gray-200 text-gray-700 rounded font-semibold hover:bg-gray-300 transition">Batal</button>
                </form>
            </div>
        </div>
        <script>
            function showCheckoutModal{{ $row->id_reservation }}() {
                document.getElementById('checkout-modal-{{ $row->id_reservation }}').classList.remove('hidden');
            }

            function hideCheckoutModal{{ $row->id_reservation }}() {
                document.getElementById('checkout-modal-{{ $row->id_reservation }}').classList.add('hidden');
            }
        </script>
    @endif
@endif
