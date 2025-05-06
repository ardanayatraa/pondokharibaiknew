<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    @php
        $role = session('role');
    @endphp
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ucfirst($role) }} Dashboard - Pondok Hari Baik Villa</title>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Cormorant:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        elegant: {
                            navy: '#0F1E2D',
                            burgundy: '#5E1224',
                            gold: '#C0A062',
                            cream: '#F8F4E3',
                            charcoal: '#2C3539',
                            black: '#000000',
                            white: '#FFFFFF',
                            gray: '#6D7A82'
                        }
                    },
                    fontFamily: {
                        'cormorant': ['Cormorant', 'serif'],
                        'montserrat': ['Montserrat', 'sans-serif']
                    },
                    backgroundImage: {
                        'pattern-bg': "url('data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23C0A062' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')"
                    }
                }
            }
        }
    </script>
    <!-- Adds the Core Table Styles -->
    @rappasoftTableStyles

    <!-- Adds any relevant Third-Party Styles (Used for DateRangeFilter (Flatpickr) and NumberRangeFilter) -->
    @rappasoftTableThirdPartyStyles
    <style>
        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #C0A062;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #5E1224;
        }

        /* Transition for sidebar */
        .sidebar-transition {
            transition: width 0.3s ease, transform 0.3s ease;
        }

        /* Card hover effect */
        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        /* Table styling */
        .admin-table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .admin-table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }

        .admin-table tr {
            transition: background-color 0.2s ease;
        }

        .admin-table tbody tr:hover {
            background-color: rgba(192, 160, 98, 0.05);
        }
    </style>


</head>

<body class="font-montserrat text-elegant-charcoal bg-elegant-cream min-h-screen flex">
    <!-- Sidebar -->
    <aside id="sidebar"
        class="bg-elegant-navy text-elegant-white w-64 min-h-screen fixed left-0 top-0 z-30 sidebar-transition lg:translate-x-0 -translate-x-full">
        <!-- Logo -->
        <div class="p-4 border-b border-elegant-white/10">
            <div class="flex items-center justify-between">
                <a href="#" class="flex items-center">
                    <span class="font-cormorant text-2xl font-bold text-elegant-gold">Pondok Hari Baik</span>
                </a>
                <button id="close-sidebar" class="lg:hidden text-elegant-white/70 hover:text-elegant-white">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>




        @php
            $role = session('role');
        @endphp

        @if ($role == 'admin')
            <!-- Sidebar Admin -->
            <nav class="py-4">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'text-elegant-gold bg-elegant-white/5 border-l-4 border-elegant-gold' : 'text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white' }} transition-colors duration-200">
                    <i class="fas fa-home w-5 text-center"></i>
                    <span class="ml-3">Beranda</span>
                </a>

                <a href="{{ route('admin.villa') }}"
                    class="flex items-center px-4 py-3 {{ request()->routeIs('admin.villa') ? 'text-elegant-gold bg-elegant-white/5 border-l-4 border-elegant-gold' : 'text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white' }} transition-colors duration-200">
                    <i class="fas fa-hotel w-5 text-center"></i>
                    <span class="ml-3">Data Villa</span>
                </a>

                <a href="{{ route('admin.season') }}"
                    class="flex items-center px-4 py-3 {{ request()->routeIs('admin.season') ? 'text-elegant-gold bg-elegant-white/5 border-l-4 border-elegant-gold' : 'text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white' }} transition-colors duration-200">
                    <i class="fas fa-calendar-alt w-5 text-center"></i>
                    <span class="ml-3">Season</span>
                </a>

                <a href="{{ route('admin.harga-villa') }}"
                    class="flex items-center px-4 py-3 {{ request()->routeIs('admin.harga-villa') ? 'text-elegant-gold bg-elegant-white/5 border-l-4 border-elegant-gold' : 'text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white' }} transition-colors duration-200">
                    <i class="fas fa-tags w-5 text-center"></i>
                    <span class="ml-3">Harga Villa</span>
                </a>

                <a href="{{ route('admin.akun-guest') }}"
                    class="flex items-center px-4 py-3 {{ request()->routeIs('admin.akun-guest') ? 'text-elegant-gold bg-elegant-white/5 border-l-4 border-elegant-gold' : 'text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white' }} transition-colors duration-200">
                    <i class="fas fa-users w-5 text-center"></i>
                    <span class="ml-3">Akun Guest</span>
                </a>

                <a href="{{ route('admin.reservasi') }}"
                    class="flex items-center px-4 py-3 {{ request()->routeIs('admin.reservasi') ? 'text-elegant-gold bg-elegant-white/5 border-l-4 border-elegant-gold' : 'text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white' }} transition-colors duration-200">
                    <i class="fas fa-calendar-check w-5 text-center"></i>
                    <span class="ml-3">Reservasi</span>
                </a>

                <a href="{{ route('admin.pembayaran') }}"
                    class="flex items-center px-4 py-3 {{ request()->routeIs('admin.pembayaran') ? 'text-elegant-gold bg-elegant-white/5 border-l-4 border-elegant-gold' : 'text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white' }} transition-colors duration-200">
                    <i class="fas fa-money-bill-wave w-5 text-center"></i>
                    <span class="ml-3">Pembayaran</span>
                </a>

                <a href="{{ route('admin.laporan') }}"
                    class="flex items-center px-4 py-3 {{ request()->routeIs('admin.laporan') ? 'text-elegant-gold bg-elegant-white/5 border-l-4 border-elegant-gold' : 'text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white' }} transition-colors duration-200">
                    <i class="fas fa-chart-line w-5 text-center"></i>
                    <span class="ml-3">Laporan</span>
                </a>
            </nav>
        @endif
        @if ($role == 'owner')
            <!-- Sidebar Admin -->
            <nav class="py-4">
                <nav class="py-4">
                    <a href="{{ route('owner.dashboard') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('owner.dashboard') ? 'text-elegant-gold bg-elegant-white/5 border-l-4 border-elegant-gold' : 'text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white' }}">
                        <i class="fas fa-home w-5 text-center"></i>
                        <span class="ml-3">Beranda</span>
                    </a>

                    <a href="{{ route('owner.laporan') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('owner.laporan') ? 'text-elegant-gold bg-elegant-white/5 border-l-4 border-elegant-gold' : 'text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white' }}">
                        <i class="fas fa-calendar-check w-5 text-center"></i>
                        <span class="ml-3">Laporan</span>
                    </a>


                    <a href="{{ route('owner.villa') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('owner.villa') ? 'text-elegant-gold bg-elegant-white/5 border-l-4 border-elegant-gold' : 'text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white' }}">
                        <i class="fas fa-building w-5 text-center"></i>
                        <span class="ml-3">Lihat Villa</span>
                    </a>
                </nav>

            </nav>
        @endif
        @if ($role == 'guest')
            <!-- Sidebar Admin -->
            <nav class="py-4">
                <nav class="py-4">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('dashboard') ? 'text-elegant-gold bg-elegant-white/5 border-l-4 border-elegant-gold' : 'text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white' }}">
                        <i class="fas fa-home w-5 text-center"></i>
                        <span class="ml-3">Beranda</span>
                    </a>

                    <a href="{{ route('villa') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('villa') ? 'text-elegant-gold bg-elegant-white/5 border-l-4 border-elegant-gold' : 'text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white' }}">
                        <i class="fas fa-hotel w-5 text-center"></i>
                        <span class="ml-3">Lihat Villa</span>
                    </a>


                    <a href="{{ route('reservasi') }}"
                        class="flex items-center px-4 py-3 {{ request()->routeIs('reservasi') ? 'text-elegant-gold bg-elegant-white/5 border-l-4 border-elegant-gold' : 'text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white' }}">
                        <i class="fas fa-history w-5 text-center"></i>
                        <span class="ml-3">Riwayat Reservasi</span>
                    </a>

                    {{-- <a href="{{ route('pembayaran') }}"
                            class="flex items-center px-4 py-3 {{ request()->routeIs('pembayaran') ? 'text-elegant-gold bg-elegant-white/5 border-l-4 border-elegant-gold' : 'text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white' }}">
                            <i class="fas fa-wallet w-5 text-center"></i>
                            <span class="ml-3">Pembayaran</span>
                        </a> --}}
                </nav>

            </nav>
        @endif



    </aside>

    <!-- Main Content -->
    <div class="flex-1 lg:ml-64 relative">
        <!-- Header -->
        <header class="bg-elegant-white shadow-sm sticky top-0 z-20">
            <div class="flex items-center justify-between px-6 py-3">
                <div class="flex items-center">
                    <button id="toggle-sidebar"
                        class="lg:hidden mr-4 text-elegant-charcoal hover:text-elegant-burgundy">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    @php
                        $activeTitle = match (true) {
                            request()->routeIs('admin.dashboard') => 'Beranda',
                            request()->routeIs('admin.villa') => 'Data Villa',
                            request()->routeIs('admin.season') => 'Season',
                            request()->routeIs('admin.harga-villa') => 'Harga Villa',
                            request()->routeIs('admin.akun-guest') => 'Akun Guest',
                            request()->routeIs('admin.reservasi') => 'Reservasi',
                            request()->routeIs('admin.pembayaran') => 'Pembayaran',
                            request()->routeIs('admin.laporan') => 'Laporan',
                            default => 'Dashboard',
                        };
                    @endphp

                    @php
                        $activeTitle = match (true) {
                            request()->routeIs('dashboard') => 'Beranda',
                            request()->routeIs('villa') => 'Lihat Villa',
                            request()->routeIs('reservasi') => 'Riwayat Reservasi',
                            request()->routeIs('pembayaran') => 'Pembayaran',
                            default => 'Dashboard',
                        };
                    @endphp

                    @php
                        $activeTitle = match (true) {
                            request()->routeIs('owner.dashboard') => 'Beranda',
                            request()->routeIs('owner.laporan') => 'Laporan',
                            request()->routeIs('owner.villa') => 'Data Villa',
                            default => 'Dashboard',
                        };
                    @endphp

                    <h1 class="text-xl font-semibold text-elegant-charcoal">{{ $activeTitle }}</h1>

                </div>

                <div class="flex items-center space-x-4">
                    <!-- Search -->
                    <div class="relative hidden md:block">
                        <input type="text" placeholder="Search..."
                            class="w-64 pl-10 pr-4 py-2 rounded-md border border-elegant-gray/20 focus:outline-none focus:ring-2 focus:ring-elegant-gold/50">
                        <div class="absolute left-3 top-2.5 text-elegant-gray">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>

                    <!-- Notifications -->
                    <div class="relative">
                        <button class="text-elegant-charcoal hover:text-elegant-burgundy relative">
                            <i class="fas fa-bell text-xl"></i>
                            <span
                                class="absolute -top-1 -right-1 bg-elegant-burgundy text-elegant-white rounded-full w-4 h-4 flex items-center justify-center text-xs">3</span>
                        </button>
                    </div>

                    <!-- User Menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Admin"
                                class="w-8 h-8 rounded-full object-cover border-2 border-elegant-gold">
                            <span class="hidden md:inline-block text-elegant-charcoal">Admin User</span>
                            <i class="fas fa-chevron-down text-elegant-gray text-xs"></i>
                        </button>

                        <div x-show="open" @click.outside="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg overflow-hidden z-50 border border-elegant-gold">
                            <a href="#"
                                class="block px-4 py-2 text-sm text-elegant-charcoal hover:bg-elegant-white/10 transition">
                                Profil
                            </a>

                            <!-- Logout Form -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="">
            {{ $slot }}
        </main>


    </div>

    <!-- Overlay for mobile sidebar -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-elegant-black/50 z-20 hidden lg:hidden"></div>

    <script>
        // Sidebar toggle functionality
        const sidebar = document.getElementById('sidebar');
        const toggleSidebar = document.getElementById('toggle-sidebar');
        const closeSidebar = document.getElementById('close-sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        toggleSidebar.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        });

        closeSidebar.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });

        sidebarOverlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });

        // Responsive adjustments
        function handleResize() {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
            }
        }

        window.addEventListener('resize', handleResize);
        handleResize(); // Initial check
    </script>
    @stack('modals')

    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
    @livewireScripts

    <!-- Adds the Core Table Scripts -->
    @rappasoftTableScripts

    <!-- Adds any relevant Third-Party Scripts (e.g. Flatpickr) -->
    @rappasoftTableThirdPartyScripts

    <script>
        Livewire.on('midtrans-token', tokenArr => {
            const token = Array.isArray(tokenArr) ? tokenArr[0] : tokenArr;
            snap.pay(token, {
                onSuccess: result => Livewire.dispatch('midtransSuccess', result),
                onPending: result => Livewire.dispatch('midtransPending', result),
                onError: result => Livewire.dispatch('midtransError', result),
            });
        });
    </script>

</body>

</html>
