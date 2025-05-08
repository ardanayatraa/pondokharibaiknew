{{-- resources/views/admin/create.blade.php --}}
<x-app-layout>

    <div class="py-2">

        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="w-full mb-4 bg-white dark:bg-gray-900 py-4  px-6">
                <h2 class="text-xl font-bold">
                    Tambah Admin
                </h2>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-6">
                <form action="{{ route('store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <x-label for="username" value="Username" />
                            <x-input id="username" name="username" type="text" class="mt-1 block w-full"
                                :value="old('username')" required autofocus />
                            @error('username')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="email" value="Email" />
                            <x-input id="email" name="email" type="email" class="mt-1 block w-full"
                                :value="old('email')" required />
                            @error('email')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="password" value="Password" />
                            <x-input id="password" name="password" type="password" class="mt-1 block w-full"
                                required />
                            @error('password')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="password_confirmation" value="Konfirmasi Password" />
                            <x-input id="password_confirmation" name="password_confirmation" type="password"
                                class="mt-1 block w-full" required />
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-4">
                        <a href="{{ route('index') }}"
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
