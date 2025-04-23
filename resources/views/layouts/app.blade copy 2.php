<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - TK Sari Kumara</title>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&family=Fredoka+One&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3498DB',
                        secondary: '#2ECC71',
                        accent: '#FF9800',
                        yellow: '#FFC312',
                        teal: '#1ABC9C',
                        orange: '#E67E22',
                        dark: '#2C3E50',
                        'dark-blue': '#1e3a8a',
                        'light-blue': '#e0f2fe',
                    },
                    fontFamily: {
                        sans: ['Nunito', 'sans-serif'],
                        display: ['Fredoka One', 'cursive'],
                    },
                    boxShadow: {
                        'soft': '0 10px 25px -5px rgba(0, 0, 0, 0.05)',
                        'hover': '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
                    }
                }
            }
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    <!-- Adds the Core Table Styles -->
    @rappasoftTableStyles

    <!-- Adds any relevant Third-Party Styles (Used for DateRangeFilter (Flatpickr) and NumberRangeFilter) -->
    @rappasoftTableThirdPartyStyles
</head>

<body class="font-sans bg-gray-50 flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-dark text-white hidden md:flex flex-col">
        <div class="p-4 border-b border-gray-700">
            <div class="flex items-center space-x-3">
                <div
                    class="h-10 w-10 rounded-lg bg-primary flex items-center justify-center text-white font-bold text-xl">
                    SK</div>
                <span class="text-white font-bold text-xl tracking-tight font-display">Sari Kumara</span>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto py-4">
            <div class="px-4 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                Menu Utama
            </div>
            @php
                $role = session('role');
            @endphp

            @if ($role === 'admin')
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-3 text-white {{ Request::is('admin/dashboard') ? 'bg-primary/20 border-r-4 border-primary' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.data-account') }}"
                    class="flex items-center px-4 py-3 text-gray-300 hover:bg-dark-blue/20 hover:text-white transition-colors {{ Request::is('admin/data-akun') ? 'bg-primary/20 border-r-4 border-primary' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Data Akun
                </a>
            @elseif($role === 'owner')
                <a href="{{ route('owner.dashboard') }}"
                    class="flex items-center px-4 py-3 text-white {{ Request::is('owner/dashboard') ? 'bg-primary/20 border-r-4 border-primary' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('owner.aspek-penilaian') }}"
                    class="flex items-center px-4 py-3 text-white {{ Request::is('owner/aspek-penilaian') ? 'bg-primary/20 border-r-4 border-primary' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-6h13v6m-13 0H4a1 1 0 01-1-1v-4a1 1 0 011-1h5m0 6v2m0-2v-2" />
                    </svg>
                    Aspek Penilaian
                </a>

                <a href="{{ route('owner.kategori') }}"
                    class="flex items-center px-4 py-3 text-white {{ Request::is('owner/kategori') ? 'bg-primary/20 border-r-4 border-primary' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    Kategori
                </a>

                <a href="{{ route('owner.penilaian') }}"
                    class="flex items-center px-4 py-3 text-white {{ Request::is('owner/penilaian') ? 'bg-primary/20 border-r-4 border-primary' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m-6-8h6m2-2v12a2 2 0 002 2H5a2 2 0 01-2-2V6a2 2 0 012-2h16a2 2 0 012 2z" />
                    </svg>
                    Penilaian
                </a>
            @elseif($role === 'guest')
                <div class="font-medium text-sm text-gray-500">{{ Auth::guard('guest')->user()->email }}</div>
            @elseif($role === 'kepsek')
                <div class="font-medium text-sm text-gray-500">{{ Auth::guard('kepsek')->user()->email }}</div>
            @else
                <div class="font-medium text-sm text-gray-500">User tidak ditemukan</div>
            @endif



        </nav>

        <div class="p-4 border-t border-gray-700">
            <a href="#" class="flex items-center text-gray-300 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Keluar
            </a>
        </div>
    </aside>

    <!-- Mobile sidebar backdrop -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-black/50 z-20 md:hidden hidden"></div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Navigation -->
        <header class="bg-white shadow-sm z-10">
            <div class="flex items-center justify-between h-16 px-4">
                <div class="flex items-center">
                    <button id="mobile-menu-button"
                        class="text-gray-500 hover:text-gray-700 md:hidden focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="ml-4 md:hidden flex items-center">
                        <div
                            class="h-8 w-8 rounded-lg bg-primary flex items-center justify-center text-white font-bold text-sm">
                            SK</div>
                        <span class="text-dark font-bold text-lg ml-2 tracking-tight font-display">Sari Kumara</span>
                    </div>
                    <div class="hidden md:block ml-4">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input type="text"
                                class="w-64 pl-10 pr-4 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="Cari...">
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="text-gray-500 hover:text-gray-700 focus:outline-none relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                    </button>
                    <div class="relative">
                        <button class="flex items-center focus:outline-none" id="user-menu-button">
                            <img src="https://randomuser.me/api/portraits/women/28.jpg" alt="User Avatar"
                                class="h-8 w-8 rounded-full object-cover">
                            @if ($role === 'guest')
                                <span
                                    class="ml-2 text-sm font-medium text-gray-700 hidden md:block">{{ Auth::guard('guest')->user()->namaSiswa }}</span>
                            @elseif($role === 'owner')
                                <span
                                    class="ml-2 text-sm font-medium text-gray-700 hidden md:block">{{ Auth::guard('owner')->user()->namaGuru }}</span>
                            @elseif($role === 'kepsek')
                                <span
                                    class="ml-2 text-sm font-medium text-gray-700 hidden md:block">{{ Auth::guard('kepsek')->user()->namaKepalaSekolah }}</span>
                            @else
                                <span
                                    class="ml-2 text-sm font-medium text-gray-700 hidden md:block">{{ Auth::guard('admin')->user()->email }}</span>
                            @endif

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 ml-1 hidden md:block"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden"
                            id="user-menu">
                            <div class="border-t border-gray-100"></div>
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-responsive-nav-link>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto bg-gray-50 p-4">
            <div class="">
                {{ $slot }}
            </div>
        </main>
    </div>

    <!-- Mobile Sidebar -->
    <div id="mobile-sidebar"
        class="fixed inset-y-0 left-0 w-64 bg-dark text-white z-30 transform -translate-x-full transition-transform duration-300 ease-in-out md:hidden">
        <div class="p-4 border-b border-gray-700">
            <div class="flex items-center space-x-3">
                <div
                    class="h-10 w-10 rounded-lg bg-primary flex items-center justify-center text-white font-bold text-xl">
                    SK</div>
                <span class="text-white font-bold text-xl tracking-tight font-display">Sari Kumara</span>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto py-4">
            <div class="px-4 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                Menu Utama
            </div>
            <a href="#" class="flex items-center px-4 py-3 text-white bg-primary/20 border-r-4 border-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>
            <!-- Other menu items same as desktop sidebar -->
        </nav>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileSidebar = document.getElementById('mobile-sidebar');
            const sidebarBackdrop = document.getElementById('sidebar-backdrop');

            mobileMenuButton.addEventListener('click', function() {
                mobileSidebar.classList.toggle('-translate-x-full');
                sidebarBackdrop.classList.toggle('hidden');
            });

            sidebarBackdrop.addEventListener('click', function() {
                mobileSidebar.classList.add('-translate-x-full');
                sidebarBackdrop.classList.add('hidden');
            });

            // User menu dropdown
            const userMenuButton = document.getElementById('user-menu-button');
            const userMenu = document.getElementById('user-menu');

            userMenuButton.addEventListener('click', function() {
                userMenu.classList.toggle('hidden');
            });

            // Close user menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                    userMenu.classList.add('hidden');
                }
            });
        });
    </script>

    <!-- Adds the Core Table Scripts -->
    @rappasoftTableScripts
    @stack('modals')

    @livewireScripts
    <!-- Adds any relevant Third-Party Scripts (e.g. Flatpickr) -->
    @rappasoftTableThirdPartyScripts
</body>

</html>
