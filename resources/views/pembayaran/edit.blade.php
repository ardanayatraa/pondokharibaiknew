{{-- resources/views/pembayaran/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-sm text-gray-800">Edit Pembayaran</h2>
    </x-slot>
    <div class="py-2">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="w-full mb-4 bg-white dark:bg-gray-900 py-4  px-6">
                <h2 class="text-sm font-bold">
                    Edit Pembayaran
                </h2>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6">
                <form action="{{ route('pembayaran.update', $pembayaran) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-label for="guest_id" value="Guest" />
                            <select id="guest_id" name="guest_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Guest --</option>
                                @foreach ($guests as $g)
                                    <option value="{{ $g->id_guest }}" @selected(old('guest_id', $pembayaran->guest_id) == $g->id_guest)>
                                        {{ $g->full_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('guest_id')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <x-label for="reservation_id" value="Reservasi" />
                            <select id="reservation_id" name="reservation_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Reservasi --</option>
                                @foreach ($reservasis as $r)
                                    <option value="{{ $r->id_reservation }}" @selected(old('reservation_id', $pembayaran->reservation_id) == $r->id_reservation)>
                                        {{ $r->villa->name }} ({{ $r->start_date }} s.d. {{ $r->end_date }})
                                    </option>
                                @endforeach
                            </select>
                            @error('reservation_id')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <x-label for="amount" value="Jumlah Pembayaran" />
                            <x-input id="amount" name="amount" type="number" class="mt-1 block w-full"
                                :value="old('amount', $pembayaran->amount)" required />
                            @error('amount')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <x-label for="payment_date" value="Tanggal Bayar" />
                            <x-input id="payment_date" name="payment_date" type="date" class="mt-1 block w-full"
                                :value="old('payment_date', $pembayaran->payment_date)" required />
                            @error('payment_date')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <x-label for="notifikasi" value="Notifikasi" />
                            <textarea id="notifikasi" name="notifikasi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                rows="2">{{ old('notifikasi', $pembayaran->notifikasi) }}</textarea>
                            @error('notifikasi')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <x-label for="snap_token" value="Snap Token" />
                            <x-input id="snap_token" name="snap_token" type="text" class="mt-1 block w-full"
                                :value="old('snap_token', $pembayaran->snap_token)" />
                        </div>
                        <div>
                            <x-label for="status" value="Status" />
                            <x-input id="status" name="status" type="text" class="mt-1 block w-full"
                                :value="old('status', $pembayaran->status)" required />
                            @error('status')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-4">
                        <a href="{{ route('pembayaran.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100">
                            Batal
                        </a>
                        <x-button>
                            Update
                        </x-button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
