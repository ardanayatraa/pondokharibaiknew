<div class="space-y-6 p-6 bg-white rounded-lg shadow-lg">

    {{-- Modern Stepper --}}
    @php $titles = ['Cari','Pilih','Data Tamu','Bayar','Selesai']; @endphp
    <div class="relative mb-8">
        {{-- Progress bar background --}}
        <div class="absolute top-5 left-0 w-full h-1 bg-gray-200 rounded-full"></div>

        {{-- Active progress bar --}}
        <div class="absolute top-5 left-0 h-1 bg-blue-600 rounded-full transition-all duration-300 ease-in-out"
            style="width: {{ ($step - 1) * 25 }}%"></div>

        {{-- Steps --}}
        <div class="relative flex justify-between">
            @foreach ($titles as $i => $t)
                <div class="flex flex-col items-center">
                    <div
                        class="w-10 h-10 flex items-center justify-center rounded-full border-2 transition-all duration-300 ease-in-out
                        {{ $step > $i ? 'border-blue-600 bg-blue-600 text-white shadow-md' : ($step == $i + 1 ? 'border-blue-600 bg-white text-blue-600' : 'border-gray-300 bg-white text-gray-400') }}">
                        @if ($step > $i)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        @else
                            {{ $i + 1 }}
                        @endif
                    </div>
                    <div
                        class="mt-2 text-xs font-medium transition-all duration-300 ease-in-out
                        {{ $step > $i ? 'text-blue-600' : ($step == $i + 1 ? 'text-blue-600' : 'text-gray-400') }}">
                        {{ $t }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- STEP 1 --}}
    @if ($step === 1)
        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 mb-4">
            @php
                $minDate = \Carbon\Carbon::today()->toDateString();
                $minCheckout = $checkin_date ?: $minDate;
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Check-In</label>
                    <input type="date" wire:model="checkin_date" min="{{ $minDate }}"
                        class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('checkin_date')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Check-Out</label>
                    <input type="date" wire:model="checkout_date" min="{{ $minCheckout }}"
                        class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('checkout_date')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="md:col-span-2 flex justify-end">
                    <button wire:click="searchAvailability"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md transition duration-150 ease-in-out transform hover:scale-105 flex items-center">
                        <span>Cari Slot</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- STEP 2 --}}
    @if ($step === 2)
        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 mb-4">
            @if (count($availableSlots))
                <h2 class="font-bold mb-4 text-gray-800">
                    Slot mencakup {{ \Carbon\Carbon::parse($checkin_date)->format('d/m/Y') }}
                    – {{ \Carbon\Carbon::parse($checkout_date)->format('d/m/Y') }}
                </h2>
                <ul class="space-y-3">
                    @foreach ($availableSlots as $s)
                        <li
                            class="border border-gray-200 p-4 rounded-lg bg-white hover:shadow-md transition-shadow duration-200 flex justify-between items-center">
                            <div>
                                <strong class="text-gray-800">{{ $s['villa_name'] }}</strong><br>
                                <span class="text-gray-600 text-sm">({{ $s['slot_start'] }} –
                                    {{ $s['slot_end'] }})</span>
                            </div>
                            <button wire:click="selectSlot({{ $s['cek_id'] }})"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-150 ease-in-out transform hover:scale-105 flex items-center">
                                <span>Pilih</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="text-gray-500 p-4 bg-white rounded-lg border border-gray-200 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-2" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Tidak ada slot yang mencakup periode ini.
                </div>
            @endif
            <div class="mt-4 flex justify-start">
                <button wire:click="goToStep(1)"
                    class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-md transition duration-150 ease-in-out flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Kembali</span>
                </button>
            </div>
        </div>
    @endif

    {{-- STEP 3 --}}
    @if ($step === 3)
        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 mb-4">
            <h2 class="font-bold mb-4 text-gray-800">Data Tamu</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" wire:model="guest_name"
                        class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('guest_name')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" wire:model="guest_email"
                        class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('guest_email')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mt-6 flex justify-between">
                <button wire:click="goToStep(2)"
                    class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-md transition duration-150 ease-in-out flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Kembali</span>
                </button>
                <button wire:click="submitGuestDetails"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md transition duration-150 ease-in-out transform hover:scale-105 flex items-center">
                    <span>Lanjut Bayar</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    {{-- STEP 4 --}}
    @if ($step === 4)
        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 mb-4">
            <h2 class="font-bold mb-4 text-gray-800">Pembayaran</h2>
            <div class="mb-6 p-4 bg-white rounded-lg border border-gray-200">
                <div class="grid grid-cols-2 gap-2">
                    <div class="text-gray-600">Villa:</div>
                    <div class="font-medium text-gray-800">{{ $selectedSlot['villa_name'] }}</div>

                    <div class="text-gray-600">Booking:</div>
                    <div class="font-medium text-gray-800">{{ $selectedSlot['display_start'] }} –
                        {{ $selectedSlot['display_end'] }}</div>

                    @php
                        $n = \Carbon\Carbon::parse($selectedSlot['booking_start'])->diffInDays(
                            \Carbon\Carbon::parse($selectedSlot['booking_end']),
                        );
                    @endphp
                    <div class="text-gray-600">Durasi:</div>
                    <div class="font-medium text-gray-800">{{ $n }} malam</div>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran</label>
                <select wire:model="payment_method"
                    class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- pilih --</option>
                    <option value="midtrans">Midtrans Snap</option>
                </select>
                @error('payment_method')
                    <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-6 flex justify-between">
                <button wire:click="goToStep(3)"
                    class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-md transition duration-150 ease-in-out flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Kembali</span>
                </button>
                <button wire:click="submitPayment"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition duration-150 ease-in-out transform hover:scale-105 flex items-center">
                    <span>Bayar via Midtrans</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    {{-- STEP 5 --}}
    @if ($step === 5)
        <div class="bg-green-50 p-6 rounded-lg border border-green-100 text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h2 class="text-xl font-bold text-green-600 mb-4">Pembayaran Berhasil!</h2>
            <div class="bg-white p-4 rounded-lg border border-gray-200 inline-block mx-auto mb-4">
                <p class="mb-2"><span class="text-gray-600">ID Reservasi:</span> <span
                        class="font-medium text-gray-800">{{ $reservationId }}</span></p>
                <p><span class="text-gray-600">ID Pembayaran:</span> <span
                        class="font-medium text-gray-800">{{ $paymentId }}</span></p>
            </div>
            <button wire:click="goToStep(1)"
                class="mt-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition duration-150 ease-in-out transform hover:scale-105">
                Buat Lagi
            </button>
        </div>
    @endif

    {{-- JS listener untuk popup Midtrans --}}

</div>
