<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    @php
        $role = session('role');
    @endphp
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ ucfirst($role) }} Dashboard - Pondok Hari Baik Villa</title>

    <!-- SEO Meta Tags -->
    <meta name="description"
        content="Admin dashboard for Pondok Hari Baik Villa management system. Manage reservations, villas, and reports.">
    <meta name="robots" content="noindex, nofollow"> <!-- Prevent search engines from indexing admin pages -->
    <meta name="author" content="Pondok Hari Baik">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/logo.png') }}" type="image/png">
    <link rel="icon" href="{{ asset('assets/logo.png') }}" type="image/png">

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

        /* Fix for horizontal scrolling */
        html,
        body {
            overflow-x: hidden;
            max-width: 100%;
        }

        /* Ensure content doesn't get covered by sidebar */
        @media (min-width: 1024px) {
            .content-wrapper {
                margin-left: 16rem;
                width: calc(100% - 16rem);
            }
        }
    </style>


</head>

<body class="font-montserrat text-elegant-charcoal bg-elegant-cream min-h-screen">
    <!-- Skip to main content link for accessibility -->
    <a href="#main-content"
        class="sr-only focus:not-sr-only focus:absolute focus:p-4 focus:bg-elegant-navy focus:text-elegant-white focus:z-50">
        Skip to main content
    </a>

    <!-- Sidebar -->
    <aside id="sidebar"
        class="bg-elegant-navy text-elegant-white w-64 min-h-screen fixed left-0 top-0 z-30 sidebar-transition lg:translate-x-0 -translate-x-full overflow-y-auto"
        aria-label="Main Navigation">
        <!-- Logo -->
        <div class="p-4 border-b border-elegant-white/10">
            <div class="flex items-center justify-between">
                <a href="#" class="flex items-center">
                    <span class="font-cormorant text-2xl font-bold text-elegant-gold">Pondok Hari Baik</span>
                </a>
                <button id="close-sidebar" class="lg:hidden text-elegant-white/70 hover:text-elegant-white"
                    aria-label="Close sidebar">
                    <i class="fas fa-times" aria-hidden="true"></i>
                </button>
            </div>
        </div>

        @php
            $role = session('role');
        @endphp

        @if ($role == 'admin')
            <nav class="py-4" aria-label="Admin Navigation">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-4 py-3 {{ request()->routeIs('dashboard') ? 'text-elegant-gold bg-elegant-white/5 border-l-4 border-elegant-gold' : 'text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white' }} transition-colors duration-200"
                    aria-current="{{ request()->routeIs('dashboard') ? 'page' : 'false' }}">
                    <i class="fas fa-home w-5 text-center" aria-hidden="true"></i>
                    <span class="ml-3">Beranda</span>
                </a>

                <a href="{{ route('villa.index') }}"
                    class="flex items-center px-4 py-3 {{ request()->routeIs('villa.*') ? 'text-elegant-gold bg-elegant-white/5 border-l-4 border-elegant-gold' : 'text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white' }} transition-colors duration-200"
                    aria-current="{{ request()->routeIs('villa.*') ? 'page' : 'false' }}">
                    <i class="fas fa-hotel w-5 text-center" aria-hidden="true"></i>
                    <span class="ml-3">Data Villa</span>
                </a>

                <a href="{{ route('facility.index') }}"
                    class="flex items-center px-4 py-3 {{ request()->routeIs('facility.*') ? 'text-elegant-gold bg-elegant-white/5 border-l-4 border-elegant-gold' : 'text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white' }} transition-colors duration-200"
                    aria-current="{{ request()->routeIs('facility.*') ? 'page' : 'false' }}">
                    <i class="fas fa-tools w-5 text-center" aria-hidden="true"></i>
                    <span class="ml-3">Data Fasilitas</span>
                </a>

                <a href="{{ route('season.index') }}"
                    class="flex items-center px-4 py-3 {{ request()->routeIs('season.*') ? 'text-elegant-gold bg-elegant-white/5 border-l-4 border-elegant-gold' : 'text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white' }} transition-colors duration-200"
                    aria-current="{{ request()->routeIs('season.*') ? 'page' : 'false' }}">
                    <i class="fas fa-calendar-alt w-5 text-center" aria-hidden="true"></i>
                    <span class="ml-3">Season</span>
                </a>

                <a href="{{ route('harga-villa.index') }}"
                    class="flex items-center px-4 py-3 {{ request()->routeIs('harga-villa.*') ? 'text-elegant-gold bg-elegant-white/5 border-l-4 border-elegant-gold' : 'text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white' }} transition-colors duration-200"
                    aria-current="{{ request()->routeIs('harga-villa.*') ? 'page' : 'false' }}">
                    <i class="fas fa-tags w-5 text-center" aria-hidden="true"></i>
                    <span class="ml-3">Harga Villa</span>
                </a>

                <a href="{{ route('guest.index') }}"
                    class="flex items-center px-4 py-3 {{ request()->routeIs('guest.*') ? 'text-elegant-gold bg-elegant-white/5 border-l-4 border-elegant-gold' : 'text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white' }} transition-colors duration-200"
                    aria-current="{{ request()->routeIs('guest.*') ? 'page' : 'false' }}">
                    <i class="fas fa-users w-5 text-center" aria-hidden="true"></i>
                    <span class="ml-3">Akun Guest</span>
                </a>

                <a href="{{ route('reservasi.index') }}"
                    class="flex items-center px-4 py-3 {{ request()->routeIs('reservasi.*') ? 'text-elegant-gold bg-elegant-white/5 border-l-4 border-elegant-gold' : 'text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white' }} transition-colors duration-200"
                    aria-current="{{ request()->routeIs('reservasi.*') ? 'page' : 'false' }}">
                    <i class="fas fa-calendar-check w-5 text-center" aria-hidden="true"></i>
                    <span class="ml-3">Reservasi</span>
                </a>

                <a href="{{ route('pembayaran.index') }}"
                    class="flex items-center px-4 py-3 {{ request()->routeIs('pembayaran.*') ? 'text-elegant-gold bg-elegant-white/5 border-l-4 border-elegant-gold' : 'text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white' }} transition-colors duration-200"
                    aria-current="{{ request()->routeIs('pembayaran.*') ? 'page' : 'false' }}">
                    <i class="fas fa-money-bill-wave w-5 text-center" aria-hidden="true"></i>
                    <span class="ml-3">Pembayaran</span>
                </a>

                <a href="{{ route('laporan') }}"
                    class="flex items-center px-4 py-3
                {{ url()->current() == route('laporan') ? 'text-elegant-gold bg-elegant-white/5 border-l-4 border-elegant-gold' : 'text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white' }}
                transition-colors duration-200"
                    aria-current="{{ url()->current() == route('laporan') ? 'page' : 'false' }}">
                    <i class="fas fa-chart-line w-5 text-center" aria-hidden="true"></i>
                    <span class="ml-3">Laporan</span>
                </a>

            </nav>
        @endif

        @if ($role == 'owner')
            <!-- Sidebar Owner -->
            <nav class="py-4" aria-label="Owner Navigation">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-4 py-3 {{ request()->routeIs('dashboard') ? 'text-elegant-gold bg-elegant-white/5 border-l-4 border-elegant-gold' : 'text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white' }}"
                    aria-current="{{ request()->routeIs('dashboard') ? 'page' : 'false' }}">
                    <i class="fas fa-home w-5 text-center" aria-hidden="true"></i>
                    <span class="ml-3">Beranda</span>
                </a>
                <a href="{{ route('laporan') }}"
                    class="flex items-center px-4 py-3
            {{ url()->current() == route('laporan') ? 'text-elegant-gold bg-elegant-white/5 border-l-4 border-elegant-gold' : 'text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white' }}
            transition-colors duration-200"
                    aria-current="{{ url()->current() == route('laporan') ? 'page' : 'false' }}">
                    <i class="fas fa-chart-line w-5 text-center" aria-hidden="true"></i>
                    <span class="ml-3">Laporan</span>
                </a>
            </nav>
        @endif

    </aside>

    <!-- Main Content -->
    <div class="content-wrapper">
        <!-- Header -->
        <header class="bg-elegant-white shadow-sm sticky top-0 z-20">
            <div class="flex items-center justify-between px-6 py-3">
                <div class="flex items-center">
                    <button id="toggle-sidebar"
                        class="lg:hidden mr-4 text-elegant-charcoal hover:text-elegant-burgundy"
                        aria-label="Toggle sidebar menu">
                        <i class="fas fa-bars text-sm" aria-hidden="true"></i>
                    </button>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Search -->
                    <div class="relative hidden md:block">

                    </div>

                    <!-- Notifications -->
                    <div class="relative">

                    </div>
                    @php
                        $user = Auth::guard('owner')->check()
                            ? Auth::guard('owner')->user()
                            : (Auth::guard('guest')->check()
                                ? Auth::guard('guest')->user()
                                : Auth::user());
                    @endphp

                    <div class="relative" id="profile-dropdown">
                        <button id="profileToggle" class="flex items-center space-x-2 focus:outline-none"
                            aria-label="User profile menu" aria-expanded="false" aria-haspopup="true">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->email ?? 'User') }}&background=FFEDD5&color=DC2626&size=256"
                                alt="Profile picture of {{ $user->email ?? 'User' }}"
                                class="w-8 h-8 rounded-full object-cover border-2 border-elegant-gold">
                            <span
                                class="hidden md:inline-block text-elegant-charcoal">{{ $user->email ?? 'User' }}</span>
                            <i class="fas fa-chevron-down text-elegant-gray text-xs" aria-hidden="true"></i>
                        </button>

                        <div id="profileMenu"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg overflow-hidden z-50 border border-elegant-gold hidden"
                            role="menu" aria-orientation="vertical" aria-labelledby="profileToggle">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition"
                                    role="menuitem">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>

                    <script>
                        const toggleBtn = document.getElementById('profileToggle');
                        const menu = document.getElementById('profileMenu');

                        toggleBtn.addEventListener('click', function(e) {
                            e.stopPropagation();
                            const expanded = this.getAttribute('aria-expanded') === 'true' || false;
                            this.setAttribute('aria-expanded', !expanded);
                            menu.classList.toggle('hidden');
                        });

                        document.addEventListener('click', function(e) {
                            const dropdown = document.getElementById('profile-dropdown');
                            if (!dropdown.contains(e.target)) {
                                menu.classList.add('hidden');
                                toggleBtn.setAttribute('aria-expanded', 'false');
                            }
                        });
                    </script>


                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main id="main-content" tabindex="-1">
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

            // Update ARIA attributes
            const expanded = sidebar.classList.contains('-translate-x-full') ? 'false' : 'true';
            toggleSidebar.setAttribute('aria-expanded', expanded);
        });

        closeSidebar.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            toggleSidebar.setAttribute('aria-expanded', 'false');
        });

        sidebarOverlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            toggleSidebar.setAttribute('aria-expanded', 'false');
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
