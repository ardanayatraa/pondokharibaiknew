{{-- resources/views/report/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-sm text-gray-800">Tambah Report</h2>
    </x-slot>
    <div class="py-2">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="w-full mb-4 bg-white dark:bg-gray-900 py-4  px-6">
                <h2 class="text-sm font-bold">
                    Tambah Report
                </h2>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6">
                <form action="{{ route('report.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <x-label for="report_type" value="Tipe Laporan" />
                            <x-input id="report_type" name="report_type" type="text" class="mt-1 block w-full"
                                :value="old('report_type')" required autofocus />
                            @error('report_type')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <x-label for="date_range" value="Rentang Tanggal" />
                            <x-input id="date_range" name="date_range" type="text" class="mt-1 block w-full"
                                :value="old('date_range')" required />
                            @error('date_range')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-4">
                        <a href="{{ route('report.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100">
                            Batal
                        </a>
                        <x-button>
                            Simpan
                        </x-button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
