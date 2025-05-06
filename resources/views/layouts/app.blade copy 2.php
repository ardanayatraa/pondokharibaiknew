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

        <!-- Navigation -->
        <nav class="py-4">
            <div class="px-4 mb-2 text-elegant-white/50 text-xs uppercase tracking-wider">Main</div>
            <a href="#"
                class="flex items-center px-4 py-3 text-elegant-gold bg-elegant-white/5 border-l-4 border-elegant-gold">
                <i class="fas fa-tachometer-alt w-5 text-center"></i>
                <span class="ml-3">Dashboard</span>
            </a>
            <a href="#"
                class="flex items-center px-4 py-3 text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white transition-colors duration-200">
                <i class="fas fa-calendar-alt w-5 text-center"></i>
                <span class="ml-3">Bookings</span>
            </a>
            <a href="#"
                class="flex items-center px-4 py-3 text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white transition-colors duration-200">
                <i class="fas fa-bed w-5 text-center"></i>
                <span class="ml-3">Rooms</span>
            </a>
            <a href="#"
                class="flex items-center px-4 py-3 text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white transition-colors duration-200">
                <i class="fas fa-users w-5 text-center"></i>
                <span class="ml-3">Guests</span>
            </a>

            <div class="px-4 mt-6 mb-2 text-elegant-white/50 text-xs uppercase tracking-wider">Content</div>
            <a href="#"
                class="flex items-center px-4 py-3 text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white transition-colors duration-200">
                <i class="fas fa-home w-5 text-center"></i>
                <span class="ml-3">Homepage</span>
            </a>
            <a href="#"
                class="flex items-center px-4 py-3 text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white transition-colors duration-200">
                <i class="fas fa-image w-5 text-center"></i>
                <span class="ml-3">Gallery</span>
            </a>
            <a href="#"
                class="flex items-center px-4 py-3 text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white transition-colors duration-200">
                <i class="fas fa-star w-5 text-center"></i>
                <span class="ml-3">Reviews</span>
            </a>

            <div class="px-4 mt-6 mb-2 text-elegant-white/50 text-xs uppercase tracking-wider">Settings</div>
            <a href="#"
                class="flex items-center px-4 py-3 text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white transition-colors duration-200">
                <i class="fas fa-user-cog w-5 text-center"></i>
                <span class="ml-3">User Management</span>
            </a>
            <a href="#"
                class="flex items-center px-4 py-3 text-elegant-white/70 hover:bg-elegant-white/5 hover:text-elegant-white transition-colors duration-200">
                <i class="fas fa-cog w-5 text-center"></i>
                <span class="ml-3">Site Settings</span>
            </a>
        </nav>
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
                    <h1 class="text-xl font-semibold text-elegant-charcoal">Dashboard</h1>
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
                    <div class="relative">
                        <button class="flex items-center space-x-2">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Admin"
                                class="w-8 h-8 rounded-full object-cover border-2 border-elegant-gold">
                            <span class="hidden md:inline-block text-elegant-charcoal">Admin User</span>
                            <i class="fas fa-chevron-down text-elegant-gray text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="p-6">
            <!-- Breadcrumbs -->
            <div class="mb-6 flex items-center text-sm text-elegant-gray">
                <a href="#" class="hover:text-elegant-burgundy">Home</a>
                <i class="fas fa-chevron-right text-xs mx-2"></i>
                <span class="text-elegant-charcoal">Dashboard</span>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Bookings -->
                <div class="bg-elegant-white rounded-lg shadow p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-elegant-gray text-sm">Total Bookings</p>
                            <h3 class="text-3xl font-bold text-elegant-charcoal mt-1">248</h3>
                            <p class="text-elegant-gold text-sm mt-2">
                                <i class="fas fa-arrow-up mr-1"></i>
                                <span>12% from last month</span>
                            </p>
                        </div>
                        <div class="bg-elegant-cream/50 p-3 rounded-full">
                            <i class="fas fa-calendar-check text-2xl text-elegant-burgundy"></i>
                        </div>
                    </div>
                </div>

                <!-- Revenue -->
                <div class="bg-elegant-white rounded-lg shadow p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-elegant-gray text-sm">Total Revenue</p>
                            <h3 class="text-3xl font-bold text-elegant-charcoal mt-1">$42,580</h3>
                            <p class="text-elegant-gold text-sm mt-2">
                                <i class="fas fa-arrow-up mr-1"></i>
                                <span>8% from last month</span>
                            </p>
                        </div>
                        <div class="bg-elegant-cream/50 p-3 rounded-full">
                            <i class="fas fa-dollar-sign text-2xl text-elegant-burgundy"></i>
                        </div>
                    </div>
                </div>

                <!-- Occupancy Rate -->
                <div class="bg-elegant-white rounded-lg shadow p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-elegant-gray text-sm">Occupancy Rate</p>
                            <h3 class="text-3xl font-bold text-elegant-charcoal mt-1">78%</h3>
                            <p class="text-elegant-gold text-sm mt-2">
                                <i class="fas fa-arrow-up mr-1"></i>
                                <span>5% from last month</span>
                            </p>
                        </div>
                        <div class="bg-elegant-cream/50 p-3 rounded-full">
                            <i class="fas fa-bed text-2xl text-elegant-burgundy"></i>
                        </div>
                    </div>
                </div>

                <!-- New Guests -->
                <div class="bg-elegant-white rounded-lg shadow p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-elegant-gray text-sm">New Guests</p>
                            <h3 class="text-3xl font-bold text-elegant-charcoal mt-1">64</h3>
                            <p class="text-elegant-gold text-sm mt-2">
                                <i class="fas fa-arrow-up mr-1"></i>
                                <span>18% from last month</span>
                            </p>
                        </div>
                        <div class="bg-elegant-cream/50 p-3 rounded-full">
                            <i class="fas fa-users text-2xl text-elegant-burgundy"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Bookings & Availability -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Recent Bookings -->
                <div class="lg:col-span-2 bg-elegant-white rounded-lg shadow overflow-hidden">
                    <div class="flex items-center justify-between p-6 border-b border-elegant-gray/10">
                        <h2 class="font-cormorant text-xl font-semibold text-elegant-navy">Recent Bookings</h2>
                        <a href="#"
                            class="text-sm text-elegant-burgundy hover:text-elegant-burgundy/80 flex items-center">
                            <span>View All</span>
                            <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full admin-table">
                            <thead>
                                <tr class="bg-elegant-cream/30">
                                    <th class="px-6 py-3 text-left text-elegant-charcoal">Guest</th>
                                    <th class="px-6 py-3 text-left text-elegant-charcoal">Room</th>
                                    <th class="px-6 py-3 text-left text-elegant-charcoal">Check In</th>
                                    <th class="px-6 py-3 text-left text-elegant-charcoal">Check Out</th>
                                    <th class="px-6 py-3 text-left text-elegant-charcoal">Status</th>
                                    <th class="px-6 py-3 text-right text-elegant-charcoal">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-elegant-gray/10">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Guest"
                                                class="w-8 h-8 rounded-full mr-3">
                                            <div>
                                                <p class="font-medium">Sarah Johnson</p>
                                                <p class="text-elegant-gray text-sm">ID: #BK-2458</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">Family Bungalow</td>
                                    <td class="px-6 py-4">Apr 10, 2025</td>
                                    <td class="px-6 py-4">Apr 15, 2025</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Confirmed</span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-medium">$1,250</td>
                                </tr>
                                <tr class="border-b border-elegant-gray/10">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Guest"
                                                class="w-8 h-8 rounded-full mr-3">
                                            <div>
                                                <p class="font-medium">David Chen</p>
                                                <p class="text-elegant-gray text-sm">ID: #BK-2457</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">Garden View Room</td>
                                    <td class="px-6 py-4">Apr 8, 2025</td>
                                    <td class="px-6 py-4">Apr 12, 2025</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Checked
                                            In</span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-medium">$980</td>
                                </tr>
                                <tr class="border-b border-elegant-gray/10">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Guest"
                                                class="w-8 h-8 rounded-full mr-3">
                                            <div>
                                                <p class="font-medium">Emma Wilson</p>
                                                <p class="text-elegant-gray text-sm">ID: #BK-2456</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">Twins Room</td>
                                    <td class="px-6 py-4">Apr 5, 2025</td>
                                    <td class="px-6 py-4">Apr 9, 2025</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">Checked
                                            Out</span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-medium">$850</td>
                                </tr>
                                <tr class="border-b border-elegant-gray/10">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Guest"
                                                class="w-8 h-8 rounded-full mr-3">
                                            <div>
                                                <p class="font-medium">Michael Brown</p>
                                                <p class="text-elegant-gray text-sm">ID: #BK-2455</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">Family Bungalow</td>
                                    <td class="px-6 py-4">Apr 12, 2025</td>
                                    <td class="px-6 py-4">Apr 18, 2025</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Pending</span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-medium">$1,450</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Room Availability -->
                <div class="bg-elegant-white rounded-lg shadow overflow-hidden">
                    <div class="p-6 border-b border-elegant-gray/10">
                        <h2 class="font-cormorant text-xl font-semibold text-elegant-navy">Room Availability</h2>
                    </div>
                    <div class="p-6">
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-elegant-charcoal">Family Bungalow</span>
                                <span class="text-elegant-burgundy font-medium">2/5 available</span>
                            </div>
                            <div class="w-full bg-elegant-gray/20 rounded-full h-2">
                                <div class="bg-elegant-burgundy h-2 rounded-full" style="width: 60%"></div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-elegant-charcoal">Garden View Room</span>
                                <span class="text-elegant-burgundy font-medium">4/8 available</span>
                            </div>
                            <div class="w-full bg-elegant-gray/20 rounded-full h-2">
                                <div class="bg-elegant-burgundy h-2 rounded-full" style="width: 50%"></div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-elegant-charcoal">Twins Room</span>
                                <span class="text-elegant-burgundy font-medium">1/6 available</span>
                            </div>
                            <div class="w-full bg-elegant-gray/20 rounded-full h-2">
                                <div class="bg-elegant-burgundy h-2 rounded-full" style="width: 83%"></div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-elegant-charcoal">Deluxe Suite</span>
                                <span class="text-elegant-burgundy font-medium">2/3 available</span>
                            </div>
                            <div class="w-full bg-elegant-gray/20 rounded-full h-2">
                                <div class="bg-elegant-burgundy h-2 rounded-full" style="width: 33%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-elegant-charcoal">Presidential Villa</span>
                                <span class="text-elegant-burgundy font-medium">0/1 available</span>
                            </div>
                            <div class="w-full bg-elegant-gray/20 rounded-full h-2">
                                <div class="bg-elegant-burgundy h-2 rounded-full" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-elegant-cream/30 border-t border-elegant-gray/10">
                        <a href="#"
                            class="text-elegant-burgundy hover:text-elegant-burgundy/80 text-sm font-medium flex items-center justify-center">
                            <span>Manage Room Inventory</span>
                            <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activities & Tasks -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Recent Activities -->
                <div class="lg:col-span-2 bg-elegant-white rounded-lg shadow">
                    <div class="flex items-center justify-between p-6 border-b border-elegant-gray/10">
                        <h2 class="font-cormorant text-xl font-semibold text-elegant-navy">Recent Activities</h2>
                        <a href="#"
                            class="text-sm text-elegant-burgundy hover:text-elegant-burgundy/80 flex items-center">
                            <span>View All</span>
                            <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </a>
                    </div>
                    <div class="p-6">
                        <div class="relative pl-8 pb-6 border-l-2 border-elegant-gold/30">
                            <div
                                class="absolute -left-2 top-0 w-5 h-5 rounded-full bg-elegant-burgundy flex items-center justify-center">
                                <i class="fas fa-check text-elegant-white text-xs"></i>
                            </div>
                            <div class="mb-1">
                                <span class="font-medium text-elegant-charcoal">New booking confirmed</span>
                                <span class="text-elegant-gray text-sm ml-2">2 hours ago</span>
                            </div>
                            <p class="text-elegant-gray">Sarah Johnson booked a Family Bungalow for 5 nights.</p>
                        </div>

                        <div class="relative pl-8 pb-6 border-l-2 border-elegant-gold/30">
                            <div
                                class="absolute -left-2 top-0 w-5 h-5 rounded-full bg-elegant-gold flex items-center justify-center">
                                <i class="fas fa-user text-elegant-white text-xs"></i>
                            </div>
                            <div class="mb-1">
                                <span class="font-medium text-elegant-charcoal">Guest checked in</span>
                                <span class="text-elegant-gray text-sm ml-2">5 hours ago</span>
                            </div>
                            <p class="text-elegant-gray">David Chen checked in to Garden View Room #203.</p>
                        </div>

                        <div class="relative pl-8 pb-6 border-l-2 border-elegant-gold/30">
                            <div
                                class="absolute -left-2 top-0 w-5 h-5 rounded-full bg-elegant-navy flex items-center justify-center">
                                <i class="fas fa-star text-elegant-white text-xs"></i>
                            </div>
                            <div class="mb-1">
                                <span class="font-medium text-elegant-charcoal">New review received</span>
                                <span class="text-elegant-gray text-sm ml-2">8 hours ago</span>
                            </div>
                            <p class="text-elegant-gray">Emma Wilson left a 5-star review after her stay.</p>
                        </div>

                        <div class="relative pl-8">
                            <div
                                class="absolute -left-2 top-0 w-5 h-5 rounded-full bg-elegant-charcoal flex items-center justify-center">
                                <i class="fas fa-sync-alt text-elegant-white text-xs"></i>
                            </div>
                            <div class="mb-1">
                                <span class="font-medium text-elegant-charcoal">Room maintenance completed</span>
                                <span class="text-elegant-gray text-sm ml-2">12 hours ago</span>
                            </div>
                            <p class="text-elegant-gray">Scheduled maintenance for Twins Room #105 completed.</p>
                        </div>
                    </div>
                </div>

                <!-- Tasks -->
                <div class="bg-elegant-white rounded-lg shadow">
                    <div class="flex items-center justify-between p-6 border-b border-elegant-gray/10">
                        <h2 class="font-cormorant text-xl font-semibold text-elegant-navy">Tasks</h2>
                        <a href="#"
                            class="text-sm text-elegant-burgundy hover:text-elegant-burgundy/80 flex items-center">
                            <span>Add Task</span>
                            <i class="fas fa-plus ml-1 text-xs"></i>
                        </a>
                    </div>
                    <div class="p-6">
                        <div class="mb-4">
                            <div class="flex items-center">
                                <input type="checkbox"
                                    class="w-4 h-4 text-elegant-burgundy rounded border-elegant-gray/30 focus:ring-elegant-burgundy/50">
                                <span class="ml-3 text-elegant-charcoal">Confirm weekend bookings</span>
                            </div>
                            <p class="text-elegant-gray text-sm ml-7 mt-1">Due today</p>
                        </div>

                        <div class="mb-4">
                            <div class="flex items-center">
                                <input type="checkbox"
                                    class="w-4 h-4 text-elegant-burgundy rounded border-elegant-gray/30 focus:ring-elegant-burgundy/50">
                                <span class="ml-3 text-elegant-charcoal">Update room availability</span>
                            </div>
                            <p class="text-elegant-gray text-sm ml-7 mt-1">Due today</p>
                        </div>

                        <div class="mb-4">
                            <div class="flex items-center">
                                <input type="checkbox"
                                    class="w-4 h-4 text-elegant-burgundy rounded border-elegant-gray/30 focus:ring-elegant-burgundy/50"
                                    checked>
                                <span class="ml-3 text-elegant-charcoal line-through text-elegant-gray">Respond to
                                    guest inquiries</span>
                            </div>
                            <p class="text-elegant-gray text-sm ml-7 mt-1">Completed</p>
                        </div>

                        <div class="mb-4">
                            <div class="flex items-center">
                                <input type="checkbox"
                                    class="w-4 h-4 text-elegant-burgundy rounded border-elegant-gray/30 focus:ring-elegant-burgundy/50">
                                <span class="ml-3 text-elegant-charcoal">Schedule staff meeting</span>
                            </div>
                            <p class="text-elegant-gray text-sm ml-7 mt-1">Due tomorrow</p>
                        </div>

                        <div>
                            <div class="flex items-center">
                                <input type="checkbox"
                                    class="w-4 h-4 text-elegant-burgundy rounded border-elegant-gray/30 focus:ring-elegant-burgundy/50">
                                <span class="ml-3 text-elegant-charcoal">Review monthly revenue report</span>
                            </div>
                            <p class="text-elegant-gray text-sm ml-7 mt-1">Due in 2 days</p>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-elegant-cream/30 border-t border-elegant-gray/10">
                        <a href="#"
                            class="text-elegant-burgundy hover:text-elegant-burgundy/80 text-sm font-medium flex items-center justify-center">
                            <span>View All Tasks</span>
                            <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-elegant-white border-t border-elegant-gray/10 p-6 text-center text-elegant-gray text-sm">
            <p>&copy; 2025 Pondok Hari Baik Villa. All rights reserved.</p>
        </footer>
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

    @livewireScripts
</body>

</html>
