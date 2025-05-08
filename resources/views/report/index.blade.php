{{-- resources/views/report/index.blade.php --}}
<x-app-layout>
    <div class="py-2">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-sm font-semibold text-gray-800">Report</h1>
                    <a href="{{ route('report.create') }}">
                        <x-button>Tambah Report</x-button>
                    </a>
                </div>
                @livewire('table.report-table')
            </div>
        </div>
    </div>
</x-app-layout>
