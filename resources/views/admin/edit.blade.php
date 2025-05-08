{{-- resources/views/admin/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-sm text-gray-800">Edit Admin</h2>
    </x-slot>

    <div class="py-2">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="w-full mb-4 bg-white dark:bg-gray-900 py-4  px-6">
                <h2 class="text-sm font-bold">
                    Edit Admin
                </h2>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-6">
                <form action="{{ route('update', $admin) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="space-y-6">
                        <div>
                            <x-label for="username" value="Username" />
                            <x-input id="username" name="username" type="text" class="mt-1 block w-full"
                                :value="old('username', $admin->username)" required autofocus />
                            @error('username')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="email" value="Email" />
                            <x-input id="email" name="email" type="email" class="mt-1 block w-full"
                                :value="old('email', $admin->email)" required />
                            @error('email')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="password" value="Password Baru (opsional)" />
                            <x-input id="password" name="password" type="password" class="mt-1 block w-full" />
                            @error('password')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="password_confirmation" value="Konfirmasi Password" />
                            <x-input id="password_confirmation" name="password_confirmation" type="password"
                                class="mt-1 block w-full" />
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-4">
                        <a href="{{ route('index') }}"
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
