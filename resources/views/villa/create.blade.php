<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-sm text-gray-800">Tambah Villa</h2>
    </x-slot>

    <div class="py-2">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="w-full mb-4 bg-white dark:bg-gray-900 py-4 px-6">
                <h2 class="text-sm font-bold">Tambah Villa</h2>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-6">
                <form action="{{ route('villa.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Facilities --}}
                    <div class="mb-8">
                        <x-label value="Facilities" />
                        <div class="mt-2 border border-gray-200 rounded-lg p-4 h-64 overflow-y-auto bg-white shadow-sm">
                            @foreach ($facilities as $type => $items)
                                <div class="mb-4">
                                    <h3 class="font-semibold text-gray-700 mb-2 capitalize">
                                        {{ str_replace('_', ' ', $type) }}
                                    </h3>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                        @foreach ($items as $f)
                                            <label class="inline-flex items-start space-x-2">
                                                <input type="checkbox" name="facility_id[]"
                                                    value="{{ $f->id_facility }}"
                                                    class="form-checkbox h-4 w-4 text-indigo-600 border-gray-300 rounded"
                                                    {{ in_array($f->id_facility, old('facility_id', [])) ? 'checked' : '' }} />
                                                <span class="text-gray-700">
                                                    {{ $f->name_facility }}
                                                    @if ($f->description)
                                                        <small class="block text-sm text-gray-500">
                                                            ({{ $f->description }})
                                                        </small>
                                                    @endif
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @error('facility_id')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Nama Villa --}}
                    <div class="mb-6">
                        <x-label for="name" value="Nama Villa" />
                        <x-input id="name" name="name" type="text" class="mt-1 block w-full"
                            :value="old('name')" required />
                        @error('name')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-6">
                        <x-label for="description" value="Deskripsi" />
                        <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Gambar Villa --}}
                    <div class="mb-6">
                        <x-label for="picture" value="Gambar Villa" />

                        <label for="picture"
                            class="mt-2 flex items-center justify-center px-4 py-3 bg-white border-2 border-dashed border-gray-300 rounded-lg shadow-sm cursor-pointer hover:bg-gray-50 transition duration-200">
                            <svg class="w-6 h-6 text-indigo-600 mr-2" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 15a4 4 0 004 4h10a4 4 0 004-4M16 10l-4-4m0 0l-4 4m4-4v12" />
                            </svg>
                            <span class="text-sm text-gray-700">Klik untuk unggah gambar</span>
                            <input id="picture" name="picture" type="file" class="hidden"
                                onchange="previewImage(event)">
                        </label>

                        @error('picture')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror

                        {{-- Preview Gambar Baru --}}
                        <div id="new-preview-container" class="mt-6 hidden">
                            <div class="flex justify-center">
                                <img id="new-preview"
                                    class="rounded-xl shadow-lg w-full max-w-lg object-cover border border-gray-300" />
                            </div>
                        </div>
                    </div>

                    {{-- Kapasitas --}}
                    <div class="mb-6">
                        <x-label for="capacity" value="Kapasitas" />
                        <x-input id="capacity" name="capacity" type="number" class="mt-1 block w-full"
                            :value="old('capacity')" required />
                        @error('capacity')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="mt-6 flex justify-end space-x-4">
                        <a href="{{ route('villa.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100">
                            Batal
                        </a>
                        <x-button>Simpan</x-button>
                    </div>
                </form>

                <script>
                    function previewImage(event) {
                        const file = event.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const newPreview = document.getElementById('new-preview');
                                const newPreviewContainer = document.getElementById('new-preview-container');
                                newPreview.src = e.target.result;
                                newPreviewContainer.classList.remove('hidden');
                            };
                            reader.readAsDataURL(file);
                        }
                    }
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
