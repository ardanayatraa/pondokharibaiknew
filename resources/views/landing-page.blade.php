<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pondok Hari Baik - Luxury Villa in Balian, Bali</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                        'hero-pattern': "linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1582610116397-edb318620f90?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')",
                        'about-pattern': "url('https://images.unsplash.com/photo-1540541338287-41700207dee6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')",
                        'family-bungalow': "url('https://images.unsplash.com/photo-1590490360182-c33d57733427?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')",
                        'family-garden': "url('https://images.unsplash.com/photo-1578683010236-d716f9a3f461?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')",
                        'twins-garden': "url('https://images.unsplash.com/photo-1595576508898-0ad5c879a061?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')",
                        'pattern-bg': "url('data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23C0A062' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')"
                    }
                }
            }
        }
    </script>
    <style>
        /* Animation classes */
        .animate-hidden {
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .animate-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .delay-100 {
            transition-delay: 0.1s;
        }

        .delay-200 {
            transition-delay: 0.2s;
        }

        .delay-300 {
            transition-delay: 0.3s;
        }

        .delay-400 {
            transition-delay: 0.4s;
        }

        .delay-500 {
            transition-delay: 0.5s;
        }

        /* Parallax effect */
        .parallax {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #C0A062;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #9A8050;
        }

        /* Language switcher */
        .language-switcher {
            position: relative;
        }

        .language-options {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: #0F1E2D;
            border-radius: 0;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2);
            min-width: 120px;
            z-index: 20;
            overflow: hidden;
            opacity: 0;
            transform: translateY(-10px);
            visibility: hidden;
            transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s;
            border: 1px solid #C0A062;
        }

        .language-options.active {
            opacity: 1;
            transform: translateY(0);
            visibility: visible;
        }

        .language-option {
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .language-option:hover {
            background-color: #1A2A3A;
        }

        .language-flag {
            width: 20px;
            height: 15px;
            margin-right: 0.5rem;
            object-fit: cover;
        }

        /* Gold border */
        .gold-border {
            position: relative;
        }

        .gold-border::before {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            border: 1px solid #C0A062;
            z-index: -1;
        }

        /* Decorative elements */
        .decorative-line {
            position: relative;
            height: 1px;
            background: linear-gradient(90deg, transparent, #C0A062, transparent);
        }

        .decorative-line::before,
        .decorative-line::after {
            content: '';
            position: absolute;
            width: 6px;
            height: 6px;
            background-color: #C0A062;
            border-radius: 50%;
            top: -3px;
        }

        .decorative-line::before {
            left: calc(50% - 40px);
        }

        .decorative-line::after {
            right: calc(50% - 40px);
        }

        /* Elegant button */
        .btn-elegant {
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
            z-index: 1;
        }

        .btn-elegant:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* Elegant card */
        .elegant-card {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .elegant-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        /* Subtle shadow */
        .subtle-shadow {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: box-shadow 0.3s ease;
        }

        .subtle-shadow:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="font-montserrat text-elegant-charcoal bg-elegant-cream bg-pattern-bg">
    <!-- Header -->
    <header class="fixed w-full z-50 bg-elegant-navy/95 backdrop-blur-md shadow-md transition-all duration-300"
        id="header">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="#" class="flex items-center">
                <span class="font-cormorant text-3xl font-bold text-elegant-gold">Pondok Hari Baik</span>
            </a>

            <div class="flex items-center">
                <!-- Language Switcher -->
                <div class="language-switcher mr-6">
                    <button id="language-toggle"
                        class="flex items-center text-elegant-gold hover:text-elegant-white transition-colors duration-300">
                        <img id="current-language-flag" src="https://flagcdn.com/w20/gb.png" alt="English"
                            class="w-5 h-4 mr-2">
                        <span id="current-language">EN</span>
                        <i class="fas fa-chevron-down ml-2 text-xs"></i>
                    </button>

                    <div id="language-options" class="language-options">
                        <div class="language-option" data-lang="en">
                            <img src="https://flagcdn.com/w20/gb.png" alt="English" class="language-flag">
                            <span class="text-elegant-gold">English</span>
                        </div>
                        <div class="language-option" data-lang="id">
                            <img src="https://flagcdn.com/w20/id.png" alt="Indonesian" class="language-flag">
                            <span class="text-elegant-gold">Indonesia</span>
                        </div>
                    </div>
                </div>

                <button class="lg:hidden text-elegant-gold focus:outline-none" id="mobile-menu-button">
                    <i class="fas fa-bars text-2xl"></i>
                </button>

                <nav class="hidden lg:flex items-center space-x-8">
                    <a href="#home"
                        class="text-elegant-gold hover:text-elegant-white transition-colors duration-300 font-medium"
                        data-lang-key="nav_home">Home</a>
                    <a href="#about"
                        class="text-elegant-gold hover:text-elegant-white transition-colors duration-300 font-medium"
                        data-lang-key="nav_about">About</a>
                    <a href="#rooms"
                        class="text-elegant-gold hover:text-elegant-white transition-colors duration-300 font-medium"
                        data-lang-key="nav_rooms">Rooms</a>
                    <a href="#amenities"
                        class="text-elegant-gold hover:text-elegant-white transition-colors duration-300 font-medium"
                        data-lang-key="nav_amenities">Amenities</a>
                    <a href="#location"
                        class="text-elegant-gold hover:text-elegant-white transition-colors duration-300 font-medium"
                        data-lang-key="nav_location">Location</a>
                    @php
                        // Asumsikan kamu sudah menyimpan role di session atau di variabel $role
                        $role = session('role') ?? null;
                    @endphp

                    @if ($role === 'guest')
                        {{-- Tampilkan email guest --}}
                        <div class="font-medium text-sm text-gray-500">
                            {{ Auth::guard('guest')->user()->email }}
                        </div>
                    @elseif($role === 'owner')
                        {{-- Tombol Dashboard untuk owner --}}
                        <a href="{{ route('owner.dashboard') }}"
                            class="bg-elegant-burgundy hover:bg-elegant-burgundy/80
                                  text-elegant-white px-6 py-2 transition-all duration-300
                                  btn-elegant border border-elegant-gold"
                            data-lang-key="nav_dashboard">
                            Dashboard
                        </a>
                    @elseif($role === 'admin')
                        {{-- Tombol Dashboard untuk admin --}}
                        <a href="{{ route('admin.dashboard') }}"
                            class="bg-elegant-burgundy hover:bg-elegant-burgundy/80
                                  text-elegant-white px-6 py-2 transition-all duration-300
                                  btn-elegant border border-elegant-gold"
                            data-lang-key="nav_dashboard">
                            Dashboard
                        </a>
                    @else
                        {{-- Belum login --}}
                        <a href="{{ route('login') }}"
                            class="bg-elegant-burgundy hover:bg-elegant-burgundy/80
                                  text-elegant-white px-6 py-2 transition-all duration-300
                                  btn-elegant border border-elegant-gold"
                            data-lang-key="nav_book">
                            Login
                        </a>
                    @endif

                </nav>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="lg:hidden hidden bg-elegant-navy shadow-lg absolute w-full left-0 z-20 transition-all duration-300 border-t border-elegant-gold/20"
            id="mobile-menu">
            <div class="container mx-auto px-4 py-4 flex flex-col space-y-4">
                <a href="#home"
                    class="text-elegant-gold hover:text-elegant-white transition-colors duration-300 font-medium py-2 border-b border-elegant-gold/20"
                    data-lang-key="nav_home">Home</a>
                <a href="#about"
                    class="text-elegant-gold hover:text-elegant-white transition-colors duration-300 font-medium py-2 border-b border-elegant-gold/20"
                    data-lang-key="nav_about">About</a>
                <a href="#rooms"
                    class="text-elegant-gold hover:text-elegant-white transition-colors duration-300 font-medium py-2 border-b border-elegant-gold/20"
                    data-lang-key="nav_rooms">Rooms</a>
                <a href="#amenities"
                    class="text-elegant-gold hover:text-elegant-white transition-colors duration-300 font-medium py-2 border-b border-elegant-gold/20"
                    data-lang-key="nav_amenities">Amenities</a>
                <a href="#location"
                    class="text-elegant-gold hover:text-elegant-white transition-colors duration-300 font-medium py-2 border-b border-elegant-gold/20"
                    data-lang-key="nav_location">Location</a>
                @php
                    // Asumsikan kamu sudah menyimpan role di session atau di variabel $role
                    $role = session('role') ?? null;
                @endphp

                @if ($role === 'guest')
                    <div id="user-menu" class="relative inline-block text-left">
                        {{-- Tombol bulat + email --}}
                        <button id="user-menu-btn" class="flex items-center space-x-2 focus:outline-none">
                            <span
                                class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-gray-600">
                                <i class="fas fa-user"></i>
                            </span>
                            <span class="font-medium text-sm text-gray-500">
                                {{ Auth::guard('guest')->user()->email }}
                            </span>
                        </button>

                        {{-- Dropdown menu --}}
                        <div id="user-dropdown"
                            class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50">
                            <button type="button" id="profile-btn"
                                class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                Update Profil
                            </button>
                            <button type="button" id="transactions-btn"
                                class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                Riwayat Transaksi
                            </button>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const btn = document.getElementById('user-menu-btn');
                            const dropdown = document.getElementById('user-dropdown');
                            const profileBtn = document.getElementById('profile-btn');
                            const transBtn = document.getElementById('transactions-btn');

                            // Toggle dropdown
                            btn.addEventListener('click', function(e) {
                                e.stopPropagation();
                                dropdown.classList.toggle('hidden');
                            });

                            // Klik di luar tutup dropdown
                            document.addEventListener('click', function() {
                                dropdown.classList.add('hidden');
                            });

                            // Jangan tutup kalau klik di dalam dropdown
                            dropdown.addEventListener('click', function(e) {
                                e.stopPropagation();
                            });

                            // Dispatch Livewire event untuk Update Profil
                            profileBtn.addEventListener('click', function(e) {
                                e.stopPropagation();
                                window.livewire.emit('editProfile'); // listener di Livewire: editProfile
                                dropdown.classList.add('hidden');
                            });

                            // Dispatch Livewire event untuk Riwayat Transaksi
                            transBtn.addEventListener('click', function(e) {
                                e.stopPropagation();
                                window.livewire.emit('showTransactions'); // listener di Livewire: showTransactions
                                dropdown.classList.add('hidden');
                            });
                        });
                    </script>
                @elseif($role === 'owner')
                    {{-- Tombol Dashboard untuk owner --}}
                    <a href="{{ route('owner.dashboard') }}"
                        class="bg-elegant-burgundy hover:bg-elegant-burgundy/80
                              text-elegant-white px-6 py-2 transition-all duration-300
                              btn-elegant border border-elegant-gold"
                        data-lang-key="nav_dashboard">
                        Dashboard
                    </a>
                @elseif($role === 'admin')
                    {{-- Tombol Dashboard untuk admin --}}
                    <a href="{{ route('admin.dashboard') }}"
                        class="bg-elegant-burgundy hover:bg-elegant-burgundy/80
                              text-elegant-white px-6 py-2 transition-all duration-300
                              btn-elegant border border-elegant-gold"
                        data-lang-key="nav_dashboard">
                        Dashboard
                    </a>
                @else
                    {{-- Belum login --}}
                    <a href="{{ route('login') }}"
                        class="bg-elegant-burgundy hover:bg-elegant-burgundy/80
                              text-elegant-white px-6 py-2 transition-all duration-300
                              btn-elegant border border-elegant-gold"
                        data-lang-key="nav_book">
                        Login
                    </a>
                @endif

            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="home"
        class="bg-hero-pattern bg-cover bg-center h-screen flex items-center justify-center parallax">
        <div class="container mx-auto px-4 text-center">
            <div class="inline-block mb-6 animate-hidden">
                <div class="w-20 h-px bg-elegant-gold mx-auto mb-6"></div>
                <h1 class="font-cormorant text-5xl md:text-7xl font-bold text-elegant-white mb-6 tracking-wide">
                    <span data-lang-key="hero_welcome">Welcome to</span> <span class="text-elegant-gold">Pondok Hari
                        Baik</span>
                </h1>
                <div class="w-20 h-px bg-elegant-gold mx-auto"></div>
            </div>
            <p class="text-xl md:text-2xl text-elegant-white mb-10 max-w-3xl mx-auto animate-hidden delay-200 font-light"
                data-lang-key="hero_subtitle">Experience the tranquility of Bali in our luxurious villa with stunning
                views and exceptional service</p>
            <a href="#rooms"
                class="inline-block bg-transparent border border-elegant-gold text-elegant-gold hover:bg-elegant-gold hover:text-elegant-navy px-8 py-4 text-lg font-medium transition-all duration-300 animate-hidden delay-300 btn-elegant">
                <span data-lang-key="hero_button">Explore Our Rooms</span>
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-24 bg-elegant-navy text-elegant-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16 animate-hidden">
                <div class="inline-block">
                    <span class="text-elegant-gold text-sm uppercase tracking-widest">Discover</span>
                    <h2 class="font-cormorant text-4xl md:text-5xl font-bold text-elegant-gold mb-4 tracking-wide"
                        data-lang-key="about_title">About Our Villa</h2>
                    <div class="decorative-line w-40 mx-auto mt-4"></div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row items-center gap-12">
                <div class="lg:w-1/2 animate-hidden">
                    <p class="text-lg mb-6 leading-relaxed text-elegant-white/90" data-lang-key="about_p1">Located in
                        Balian, less than 1 km from Bonian Beach, Pondok Hari Baik features accommodation with an
                        outdoor swimming pool, free private parking, a garden and a terrace. The property is set 2 km
                        from Balian Beach, 2.2 km from Batulumbang Beach and 36 km from Tanah Lot Temple.</p>
                    <p class="text-lg mb-6 leading-relaxed text-elegant-white/90" data-lang-key="about_p2">At the
                        hotel rooms come with air conditioning, a desk, a balcony with a garden view, a private bathroom
                        and a flat-screen TV. Pondok Hari Baik offers some rooms with pool views, and each room has a
                        patio.</p>
                    <p class="text-lg leading-relaxed text-elegant-white/90" data-lang-key="about_p3">A continental,
                        Asian or vegetarian breakfast can be enjoyed at the property. At the accommodation you will find
                        a restaurant serving Indonesian cuisine. Vegetarian, halal and vegan options can also be
                        requested.</p>

                    <div class="mt-10 flex items-center">
                        <div
                            class="w-16 h-16 rounded-full bg-elegant-gold/20 flex items-center justify-center border border-elegant-gold">
                            <i class="fas fa-star text-elegant-gold text-xl"></i>
                        </div>
                        <div class="ml-6">
                            <h3 class="font-cormorant text-2xl font-bold text-elegant-gold"
                                data-lang-key="about_luxury">Luxury Experience</h3>
                            <p class="text-elegant-white/70" data-lang-key="about_since">Since 2010</p>
                        </div>
                    </div>
                </div>

                <div class="lg:w-1/2 animate-hidden delay-200">
                    <div class="relative gold-border">
                        <div
                            class="bg-about-pattern bg-cover bg-center h-96 shadow-md transform hover:scale-105 transition-transform duration-500 subtle-shadow">
                        </div>
                        <div class="absolute -bottom-6 -right-6 bg-elegant-burgundy text-elegant-white p-6 shadow-md">
                            <p class="font-cormorant text-2xl font-bold">5★</p>
                            <p class="uppercase tracking-widest text-sm">Luxury</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Rooms Section -->
    <section id="rooms" class="py-24 bg-elegant-cream bg-pattern-bg">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16 animate-hidden">
                <span class="text-elegant-gold text-sm uppercase tracking-widest">Accommodation</span>
                <h2 class="font-cormorant text-4xl md:text-5xl font-bold text-elegant-burgundy mb-4 tracking-wide"
                    data-lang-key="rooms_title">Our Luxurious Rooms</h2>
                <div class="decorative-line w-40 mx-auto mt-4"></div>
                <p class="text-lg mt-6 max-w-3xl mx-auto text-elegant-charcoal" data-lang-key="rooms_subtitle">
                    Discover our elegantly designed rooms offering comfort, privacy, and stunning views</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                <!-- Room 1 -->
                <div
                    class="bg-elegant-white border border-elegant-gold/30 overflow-hidden shadow-md transform hover:scale-105 transition-all duration-500 animate-hidden elegant-card">
                    <div class="relative">
                        <div class="bg-family-bungalow bg-cover bg-center h-72"></div>
                        <div class="absolute top-4 right-4 bg-elegant-gold text-elegant-navy px-4 py-2 font-medium uppercase tracking-wider text-xs"
                            data-lang-key="rooms_popular">
                            Popular
                        </div>
                    </div>
                    <div class="p-8">
                        <h3 class="font-cormorant text-2xl font-bold text-elegant-burgundy mb-2"
                            data-lang-key="room1_title">Family Bungalow</h3>
                        <div class="flex items-center mb-4">
                            <div class="text-elegant-gold text-xl font-bold">Rp 450.000</div>
                            <div class="text-elegant-gray ml-2" data-lang-key="rooms_per_night">/night</div>
                        </div>
                        <div class="flex items-center mb-6">
                            <i class="fas fa-user-friends text-elegant-gold mr-2"></i>
                            <span class="text-elegant-charcoal" data-lang-key="room1_capacity">Maximum capacity 4
                                people</span>
                        </div>
                        <ul class="mb-6 space-y-2 text-elegant-charcoal">
                            <li class="flex items-center">
                                <i class="fas fa-check text-elegant-gold mr-2"></i>
                                <span data-lang-key="room_feature1">AC & Flat Screen TV</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-elegant-gold mr-2"></i>
                                <span data-lang-key="room_feature2">Private Balcony</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-elegant-gold mr-2"></i>
                                <span data-lang-key="room_feature3">Private Bathroom</span>
                            </li>
                        </ul>
                        <a href="#contact"
                            class="block text-center bg-elegant-burgundy hover:bg-elegant-burgundy/80 text-elegant-white px-6 py-3 transition-all duration-300 btn-elegant"
                            data-lang-key="rooms_book">
                            Book Now
                        </a>
                    </div>
                </div>

                <!-- Room 2 -->
                <div
                    class="bg-elegant-white border border-elegant-gold/30 overflow-hidden shadow-md transform hover:scale-105 transition-all duration-500 animate-hidden delay-200 elegant-card">
                    <div class="relative">
                        <div class="bg-family-garden bg-cover bg-center h-72"></div>
                        <div class="absolute top-4 right-4 bg-elegant-gold text-elegant-navy px-4 py-2 font-medium uppercase tracking-wider text-xs"
                            data-lang-key="rooms_best_value">
                            Best Value
                        </div>
                    </div>
                    <div class="p-8">
                        <h3 class="font-cormorant text-2xl font-bold text-elegant-burgundy mb-2"
                            data-lang-key="room2_title">Family Room with Garden View</h3>
                        <div class="flex items-center mb-4">
                            <div class="text-elegant-gold text-xl font-bold">Rp 750.000</div>
                            <div class="text-elegant-gray ml-2" data-lang-key="rooms_per_night">/night</div>
                        </div>
                        <div class="flex items-center mb-6">
                            <i class="fas fa-user-friends text-elegant-gold mr-2"></i>
                            <span class="text-elegant-charcoal" data-lang-key="room2_capacity">Maximum capacity 4
                                people</span>
                        </div>
                        <ul class="mb-6 space-y-2 text-elegant-charcoal">
                            <li class="flex items-center">
                                <i class="fas fa-check text-elegant-gold mr-2"></i>
                                <span data-lang-key="room_feature1">AC & Flat Screen TV</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-elegant-gold mr-2"></i>
                                <span data-lang-key="room_feature4">Garden View</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-elegant-gold mr-2"></i>
                                <span data-lang-key="room_feature5">Premium Bathroom</span>
                            </li>
                        </ul>
                        <a href="#contact"
                            class="block text-center bg-elegant-burgundy hover:bg-elegant-burgundy/80 text-elegant-white px-6 py-3 transition-all duration-300 btn-elegant"
                            data-lang-key="rooms_book">
                            Book Now
                        </a>
                    </div>
                </div>

                <!-- Room 3 -->
                <div
                    class="bg-elegant-white border border-elegant-gold/30 overflow-hidden shadow-md transform hover:scale-105 transition-all duration-500 animate-hidden delay-300 elegant-card">
                    <div class="relative">
                        <div class="bg-twins-garden bg-cover bg-center h-72"></div>
                    </div>
                    <div class="p-8">
                        <h3 class="font-cormorant text-2xl font-bold text-elegant-burgundy mb-2"
                            data-lang-key="room3_title">Twins Room with Garden View</h3>
                        <div class="flex items-center mb-4">
                            <div class="text-elegant-gold text-xl font-bold">Rp 650.000</div>
                            <div class="text-elegant-gray ml-2" data-lang-key="rooms_per_night">/night</div>
                        </div>
                        <div class="flex items-center mb-6">
                            <i class="fas fa-user-friends text-elegant-gold mr-2"></i>
                            <span class="text-elegant-charcoal" data-lang-key="room3_capacity">Maximum capacity 2
                                people</span>
                        </div>
                        <ul class="mb-6 space-y-2 text-elegant-charcoal">
                            <li class="flex items-center">
                                <i class="fas fa-check text-elegant-gold mr-2"></i>
                                <span data-lang-key="room_feature1">AC & Flat Screen TV</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-elegant-gold mr-2"></i>
                                <span data-lang-key="room_feature4">Garden View</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-elegant-gold mr-2"></i>
                                <span data-lang-key="room_feature3">Private Bathroom</span>
                            </li>
                        </ul>
                        <a href="#contact"
                            class="block text-center bg-elegant-burgundy hover:bg-elegant-burgundy/80 text-elegant-white px-6 py-3 transition-all duration-300 btn-elegant"
                            data-lang-key="rooms_book">
                            Book Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Amenities Section -->
    <section id="amenities" class="py-24 bg-elegant-burgundy text-elegant-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16 animate-hidden">
                <span class="text-elegant-gold text-sm uppercase tracking-widest">Services</span>
                <h2 class="font-cormorant text-4xl md:text-5xl font-bold mb-4 tracking-wide text-elegant-white"
                    data-lang-key="amenities_title">Premium Amenities</h2>
                <div class="decorative-line w-40 mx-auto mt-4"></div>
                <p class="text-lg mt-6 max-w-3xl mx-auto text-elegant-white/80" data-lang-key="amenities_subtitle">
                    Enjoy our world-class facilities designed for your comfort and relaxation</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                <!-- Amenity 1 -->
                <div
                    class="bg-elegant-navy/30 backdrop-blur-sm p-6 text-center transform hover:scale-105 transition-all duration-300 animate-hidden border border-elegant-gold/30 subtle-shadow">
                    <div
                        class="bg-elegant-gold/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 border border-elegant-gold">
                        <i class="fas fa-swimming-pool text-2xl text-elegant-gold"></i>
                    </div>
                    <h3 class="font-cormorant font-bold text-xl mb-2 text-elegant-gold"
                        data-lang-key="amenity1_title">Outdoor Pool</h3>
                    <p class="text-elegant-white/70 text-sm" data-lang-key="amenity1_desc">Enjoy swimming with
                        beautiful natural views</p>
                </div>

                <!-- Amenity 2 -->
                <div
                    class="bg-elegant-navy/30 backdrop-blur-sm p-6 text-center transform hover:scale-105 transition-all duration-300 animate-hidden delay-100 border border-elegant-gold/30 subtle-shadow">
                    <div
                        class="bg-elegant-gold/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 border border-elegant-gold">
                        <i class="fas fa-smoking-ban text-2xl text-elegant-gold"></i>
                    </div>
                    <h3 class="font-cormorant font-bold text-xl mb-2 text-elegant-gold"
                        data-lang-key="amenity2_title">Non-Smoking Rooms</h3>
                    <p class="text-elegant-white/70 text-sm" data-lang-key="amenity2_desc">Fresh air for your comfort
                    </p>
                </div>

                <!-- Amenity 3 -->
                <div
                    class="bg-elegant-navy/30 backdrop-blur-sm p-6 text-center transform hover:scale-105 transition-all duration-300 animate-hidden delay-200 border border-elegant-gold/30 subtle-shadow">
                    <div
                        class="bg-elegant-gold/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 border border-elegant-gold">
                        <i class="fas fa-plane text-2xl text-elegant-gold"></i>
                    </div>
                    <h3 class="font-cormorant font-bold text-xl mb-2 text-elegant-gold"
                        data-lang-key="amenity3_title">Airport Shuttle</h3>
                    <p class="text-elegant-white/70 text-sm" data-lang-key="amenity3_desc">Exclusive transportation
                        service</p>
                </div>

                <!-- Amenity 4 -->
                <div
                    class="bg-elegant-navy/30 backdrop-blur-sm p-6 text-center transform hover:scale-105 transition-all duration-300 animate-hidden delay-300 border border-elegant-gold/30 subtle-shadow">
                    <div
                        class="bg-elegant-gold/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 border border-elegant-gold">
                        <i class="fas fa-spa text-2xl text-elegant-gold"></i>
                    </div>
                    <h3 class="font-cormorant font-bold text-xl mb-2 text-elegant-gold"
                        data-lang-key="amenity4_title">Spa & Wellness Center</h3>
                    <p class="text-elegant-white/70 text-sm" data-lang-key="amenity4_desc">Premium relaxation and
                        treatments</p>
                </div>

                <!-- Amenity 5 -->
                <div
                    class="bg-elegant-navy/30 backdrop-blur-sm p-6 text-center transform hover:scale-105 transition-all duration-300 animate-hidden delay-400 border border-elegant-gold/30 subtle-shadow">
                    <div
                        class="bg-elegant-gold/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 border border-elegant-gold">
                        <i class="fas fa-parking text-2xl text-elegant-gold"></i>
                    </div>
                    <h3 class="font-cormorant font-bold text-xl mb-2 text-elegant-gold"
                        data-lang-key="amenity5_title">Free Parking</h3>
                    <p class="text-elegant-white/70 text-sm" data-lang-key="amenity5_desc">Safe and convenient parking
                    </p>
                </div>

                <!-- Amenity 6 -->
                <div
                    class="bg-elegant-navy/30 backdrop-blur-sm p-6 text-center transform hover:scale-105 transition-all duration-300 animate-hidden border border-elegant-gold/30 subtle-shadow">
                    <div
                        class="bg-elegant-gold/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 border border-elegant-gold">
                        <i class="fas fa-concierge-bell text-2xl text-elegant-gold"></i>
                    </div>
                    <h3 class="font-cormorant font-bold text-xl mb-2 text-elegant-gold"
                        data-lang-key="amenity6_title">Room Service</h3>
                    <p class="text-elegant-white/70 text-sm" data-lang-key="amenity6_desc">24-hour service for your
                        convenience</p>
                </div>

                <!-- Amenity 7 -->
                <div
                    class="bg-elegant-navy/30 backdrop-blur-sm p-6 text-center transform hover:scale-105 transition-all duration-300 animate-hidden delay-100 border border-elegant-gold/30 subtle-shadow">
                    <div
                        class="bg-elegant-gold/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 border border-elegant-gold">
                        <i class="fas fa-wifi text-2xl text-elegant-gold"></i>
                    </div>
                    <h3 class="font-cormorant font-bold text-xl mb-2 text-elegant-gold"
                        data-lang-key="amenity7_title">Free WiFi</h3>
                    <p class="text-elegant-white/70 text-sm" data-lang-key="amenity7_desc">Fast internet connection
                        throughout</p>
                </div>

                <!-- Amenity 8 -->
                <div
                    class="bg-elegant-navy/30 backdrop-blur-sm p-6 text-center transform hover:scale-105 transition-all duration-300 animate-hidden delay-200 border border-elegant-gold/30 subtle-shadow">
                    <div
                        class="bg-elegant-gold/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 border border-elegant-gold">
                        <i class="fas fa-utensils text-2xl text-elegant-gold"></i>
                    </div>
                    <h3 class="font-cormorant font-bold text-xl mb-2 text-elegant-gold"
                        data-lang-key="amenity8_title">Restaurant</h3>
                    <p class="text-elegant-white/70 text-sm" data-lang-key="amenity8_desc">Indonesian and
                        international cuisine</p>
                </div>

                <!-- Amenity 9 -->
                <div
                    class="bg-elegant-navy/30 backdrop-blur-sm p-6 text-center transform hover:scale-105 transition-all duration-300 animate-hidden delay-300 border border-elegant-gold/30 subtle-shadow">
                    <div
                        class="bg-elegant-gold/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 border border-elegant-gold">
                        <i class="fas fa-users text-2xl text-elegant-gold"></i>
                    </div>
                    <h3 class="font-cormorant font-bold text-xl mb-2 text-elegant-gold"
                        data-lang-key="amenity9_title">Family Rooms</h3>
                    <p class="text-elegant-white/70 text-sm" data-lang-key="amenity9_desc">Comfortable accommodation
                        for families</p>
                </div>

                <!-- Amenity 10 -->
                <div
                    class="bg-elegant-navy/30 backdrop-blur-sm p-6 text-center transform hover:scale-105 transition-all duration-300 animate-hidden delay-400 border border-elegant-gold/30 subtle-shadow">
                    <div
                        class="bg-elegant-gold/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 border border-elegant-gold">
                        <i class="fas fa-coffee text-2xl text-elegant-gold"></i>
                    </div>
                    <h3 class="font-cormorant font-bold text-xl mb-2 text-elegant-gold"
                        data-lang-key="amenity10_title">Breakfast</h3>
                    <p class="text-elegant-white/70 text-sm" data-lang-key="amenity10_desc">Continental, Asian, and
                        vegetarian options</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="py-24 bg-elegant-cream bg-pattern-bg">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16 animate-hidden">
                <span class="text-elegant-gold text-sm uppercase tracking-widest">Reviews</span>
                <h2 class="font-cormorant text-4xl md:text-5xl font-bold text-elegant-burgundy mb-4 tracking-wide"
                    data-lang-key="testimonials_title">Guest Experiences</h2>
                <div class="decorative-line w-40 mx-auto mt-4"></div>
                <p class="text-lg mt-6 max-w-3xl mx-auto text-elegant-charcoal" data-lang-key="testimonials_subtitle">
                    What our guests say about their stay at Pondok Hari Baik</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Testimonial 1 -->
                <div class="bg-elegant-white p-8 shadow-md animate-hidden border border-elegant-gold/30 subtle-shadow">
                    <div class="flex items-center mb-6">
                        <div class="text-elegant-gold">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="ml-auto text-sm text-elegant-gray">June 2025</div>
                    </div>
                    <p class="text-lg mb-6 italic font-light text-elegant-charcoal" data-lang-key="testimonial1_text">
                        "An amazing stay experience. Beautiful views, comfortable rooms, and friendly service. We will
                        definitely be back!"</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-300 rounded-full overflow-hidden">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Guest"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="ml-4">
                            <h4 class="font-medium text-elegant-burgundy">Sarah Johnson</h4>
                            <p class="text-sm text-elegant-gray">Jakarta, Indonesia</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div
                    class="bg-elegant-white p-8 shadow-md animate-hidden delay-200 border border-elegant-gold/30 subtle-shadow">
                    <div class="flex items-center mb-6">
                        <div class="text-elegant-gold">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="ml-auto text-sm text-elegant-gray">May 2025</div>
                    </div>
                    <p class="text-lg mb-6 italic font-light text-elegant-charcoal" data-lang-key="testimonial2_text">
                        "The perfect place for a family vacation. Clean pool, delicious food, and strategic location
                        near the beach made our holiday very enjoyable."</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-300 rounded-full overflow-hidden">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Guest"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="ml-4">
                            <h4 class="font-medium text-elegant-burgundy">David Chen</h4>
                            <p class="text-sm text-elegant-gray">Singapore</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div
                    class="bg-elegant-white p-8 shadow-md animate-hidden delay-300 border border-elegant-gold/30 subtle-shadow">
                    <div class="flex items-center mb-6">
                        <div class="text-elegant-gold">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <div class="ml-auto text-sm text-elegant-gray">April 2025</div>
                    </div>
                    <p class="text-lg mb-6 italic font-light text-elegant-charcoal" data-lang-key="testimonial3_text">
                        "Very helpful and friendly staff. Clean and comfortable rooms. Delicious breakfast with many
                        choices. Highly recommended!"</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-300 rounded-full overflow-hidden">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Guest"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="ml-4">
                            <h4 class="font-medium text-elegant-burgundy">Emma Wilson</h4>
                            <p class="text-sm text-elegant-gray">Melbourne, Australia</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Location Section -->
    <section id="location" class="py-24 bg-elegant-navy text-elegant-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16 animate-hidden">
                <span class="text-elegant-gold text-sm uppercase tracking-widest">Find Us</span>
                <h2 class="font-cormorant text-4xl md:text-5xl font-bold text-elegant-gold mb-4 tracking-wide"
                    data-lang-key="location_title">Our Location</h2>
                <div class="decorative-line w-40 mx-auto mt-4"></div>
                <p class="text-lg mt-6 max-w-3xl mx-auto" data-lang-key="location_subtitle">Strategically located with
                    easy access to Bali's most beautiful beaches</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-12">
                <div class="lg:w-1/2 animate-hidden">
                    <div class="overflow-hidden shadow-md h-96 border border-elegant-gold/30 subtle-shadow">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3945.2170366854!2d114.97!3d-8.55!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zOMKwMzMnMDAuMCJTIDExNMKwNTgnMTIuMCJF!5e0!3m2!1sen!2sid!4v1617000000000!5m2!1sen!2sid"
                            width="100%" height="100%" style="border:0;" allowfullscreen=""
                            loading="lazy"></iframe>
                    </div>
                </div>

                <div class="lg:w-1/2 animate-hidden delay-200">
                    <div class="bg-elegant-burgundy/90 p-8 shadow-md h-full border border-elegant-gold/30">
                        <h3 class="font-cormorant text-3xl font-bold text-elegant-gold mb-6">Pondok Hari Baik</h3>
                        <p class="text-lg mb-6" data-lang-key="location_address">Jalan Raya Denpasar - Gilimanuk,
                            Tabanan, Bali, Indonesia, 82162</p>
                        <p class="text-lg mb-8" data-lang-key="location_description">Located in a strategic location
                            with easy access to various popular tourist attractions in Bali.</p>

                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 bg-elegant-gold/20 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-umbrella-beach text-elegant-gold"></i>
                                </div>
                                <span data-lang-key="location_bonian">Bonian Beach: < 1 km</span>
                            </div>

                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 bg-elegant-gold/20 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-umbrella-beach text-elegant-gold"></i>
                                </div>
                                <span data-lang-key="location_balian">Balian Beach: 2 km</span>
                            </div>

                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 bg-elegant-gold/20 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-umbrella-beach text-elegant-gold"></i>
                                </div>
                                <span data-lang-key="location_batulumbang">Batulumbang Beach: 2.2 km</span>
                            </div>

                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 bg-elegant-gold/20 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-landmark text-elegant-gold"></i>
                                </div>
                                <span data-lang-key="location_tanah_lot">Tanah Lot Temple: 36 km</span>
                            </div>

                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 bg-elegant-gold/20 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-plane-departure text-elegant-gold"></i>
                                </div>
                                <span data-lang-key="location_airport">Ngurah Rai International Airport: 57 km</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section
        class="py-24 bg-elegant-burgundy text-elegant-white bg-[url('https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')] bg-cover bg-center relative">
        <div class="absolute inset-0 bg-elegant-navy/80"></div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <div class="max-w-3xl mx-auto animate-hidden">
                <h2 class="font-cormorant text-4xl md:text-5xl font-bold mb-6 text-elegant-gold"
                    data-lang-key="cta_title">Ready for an Unforgettable Experience?</h2>
                <div class="w-20 h-px bg-elegant-gold mx-auto mb-6"></div>
                <p class="text-xl mb-10 text-elegant-white/90" data-lang-key="cta_subtitle">Book your stay now and
                    enjoy the tranquility of Bali at Pondok Hari Baik</p>
                <a href="#contact"
                    class="inline-block bg-elegant-gold hover:bg-elegant-gold/80 text-elegant-navy px-8 py-4 text-lg font-medium transition-all duration-300 btn-elegant border border-elegant-white/20">
                    <span data-lang-key="cta_button">Book Your Stay</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-24 bg-elegant-cream bg-pattern-bg">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16 animate-hidden">
                <span class="text-elegant-gold text-sm uppercase tracking-widest">Reach Us</span>
                <h2 class="font-cormorant text-4xl md:text-5xl font-bold text-elegant-burgundy mb-4 tracking-wide"
                    data-lang-key="contact_title">Contact Us</h2>
                <div class="decorative-line w-40 mx-auto mt-4"></div>
                <p class="text-lg mt-6 max-w-3xl mx-auto text-elegant-charcoal" data-lang-key="contact_subtitle">Have
                    questions or ready to book? Reach out to us</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-12">
                <div class="lg:w-1/2 animate-hidden">
                    <form class="bg-elegant-white p-8 shadow-md border border-elegant-gold/30 subtle-shadow">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-elegant-charcoal mb-2"
                                    data-lang-key="contact_name">Name</label>
                                <input type="text" id="name"
                                    class="w-full px-4 py-3 border border-elegant-gold/30 bg-elegant-cream/50 text-elegant-charcoal focus:outline-none focus:ring-2 focus:ring-elegant-gold">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-elegant-charcoal mb-2"
                                    data-lang-key="contact_email">Email</label>
                                <input type="email" id="email"
                                    class="w-full px-4 py-3 border border-elegant-gold/30 bg-elegant-cream/50 text-elegant-charcoal focus:outline-none focus:ring-2 focus:ring-elegant-gold">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="phone" class="block text-sm font-medium text-elegant-charcoal mb-2"
                                data-lang-key="contact_phone">Phone Number</label>
                            <input type="tel" id="phone"
                                class="w-full px-4 py-3 border border-elegant-gold/30 bg-elegant-cream/50 text-elegant-charcoal focus:outline-none focus:ring-2 focus:ring-elegant-gold">
                        </div>

                        <div class="mb-6">
                            <label for="message" class="block text-sm font-medium text-elegant-charcoal mb-2"
                                data-lang-key="contact_message">Message</label>
                            <textarea id="message" rows="5"
                                class="w-full px-4 py-3 border border-elegant-gold/30 bg-elegant-cream/50 text-elegant-charcoal focus:outline-none focus:ring-2 focus:ring-elegant-gold"></textarea>
                        </div>

                        <button type="submit"
                            class="w-full bg-elegant-burgundy hover:bg-elegant-burgundy/80 text-elegant-white px-6 py-3 transition-all duration-300 btn-elegant font-medium"
                            data-lang-key="contact_send">
                            Send Message
                        </button>
                    </form>
                </div>

                <div class="lg:w-1/2 animate-hidden delay-200">
                    <div class="bg-elegant-navy text-elegant-white p-8 shadow-md h-full border border-elegant-gold/30">
                        <h3 class="font-cormorant text-3xl font-bold text-elegant-gold mb-6"
                            data-lang-key="contact_get_in_touch">Get in Touch</h3>

                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div
                                    class="w-10 h-10 bg-elegant-gold/20 rounded-full flex items-center justify-center mr-4 mt-1">
                                    <i class="fas fa-map-marker-alt text-elegant-gold"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-lg mb-1 text-elegant-gold"
                                        data-lang-key="contact_address_label">Address</h4>
                                    <p class="text-elegant-white/80" data-lang-key="contact_address">Jalan Raya
                                        Denpasar - Gilimanuk, Tabanan, Bali, Indonesia, 82162</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div
                                    class="w-10 h-10 bg-elegant-gold/20 rounded-full flex items-center justify-center mr-4 mt-1">
                                    <i class="fas fa-phone text-elegant-gold"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-lg mb-1 text-elegant-gold"
                                        data-lang-key="contact_phone_label">Phone</h4>
                                    <p class="text-elegant-white/80">+62 812 3456 7890</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div
                                    class="w-10 h-10 bg-elegant-gold/20 rounded-full flex items-center justify-center mr-4 mt-1">
                                    <i class="fas fa-envelope text-elegant-gold"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-lg mb-1 text-elegant-gold"
                                        data-lang-key="contact_email_label">Email</h4>
                                    <p class="text-elegant-white/80">info@pondokharibaik.com</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div
                                    class="w-10 h-10 bg-elegant-gold/20 rounded-full flex items-center justify-center mr-4 mt-1">
                                    <i class="fas fa-clock text-elegant-gold"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-lg mb-1 text-elegant-gold"
                                        data-lang-key="contact_hours_label">Operating Hours</h4>
                                    <p class="text-elegant-white/80" data-lang-key="contact_checkin">Check-in: 14:00 -
                                        22:00</p>
                                    <p class="text-elegant-white/80" data-lang-key="contact_checkout">Check-out:
                                        Before 12:00</p>
                                    <p class="text-elegant-white/80" data-lang-key="contact_reception">Reception: 24
                                        Hours</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <h4 class="font-medium text-lg mb-4 text-elegant-gold" data-lang-key="contact_follow">
                                Follow Us</h4>
                            <div class="flex space-x-4">
                                <a href="#"
                                    class="w-10 h-10 bg-elegant-gold/20 rounded-full flex items-center justify-center hover:bg-elegant-gold transition-colors duration-300 hover:text-elegant-navy text-elegant-gold">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#"
                                    class="w-10 h-10 bg-elegant-gold/20 rounded-full flex items-center justify-center hover:bg-elegant-gold transition-colors duration-300 hover:text-elegant-navy text-elegant-gold">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#"
                                    class="w-10 h-10 bg-elegant-gold/20 rounded-full flex items-center justify-center hover:bg-elegant-gold transition-colors duration-300 hover:text-elegant-navy text-elegant-gold">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#"
                                    class="w-10 h-10 bg-elegant-gold/20 rounded-full flex items-center justify-center hover:bg-elegant-gold transition-colors duration-300 hover:text-elegant-navy text-elegant-gold">
                                    <i class="fab fa-tripadvisor"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-elegant-navy text-elegant-white pt-16 pb-6 border-t border-elegant-gold/30">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-10">
                <div>
                    <h3 class="font-cormorant text-2xl font-bold text-elegant-gold mb-6">Pondok Hari Baik</h3>
                    <p class="mb-6 text-elegant-white/70" data-lang-key="footer_description">Luxury villa with
                        beautiful views and excellent service in Balian, Bali.</p>
                    <div class="flex space-x-4">
                        <a href="#"
                            class="w-10 h-10 bg-elegant-gold/20 rounded-full flex items-center justify-center hover:bg-elegant-gold transition-colors duration-300 hover:text-elegant-navy text-elegant-gold">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-elegant-gold/20 rounded-full flex items-center justify-center hover:bg-elegant-gold transition-colors duration-300 hover:text-elegant-navy text-elegant-gold">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-elegant-gold/20 rounded-full flex items-center justify-center hover:bg-elegant-gold transition-colors duration-300 hover:text-elegant-navy text-elegant-gold">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-elegant-gold/20 rounded-full flex items-center justify-center hover:bg-elegant-gold transition-colors duration-300 hover:text-elegant-navy text-elegant-gold">
                            <i class="fab fa-tripadvisor"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="font-cormorant text-xl font-bold text-elegant-gold mb-6"
                        data-lang-key="footer_quick_links">Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="#home"
                                class="text-elegant-white/70 hover:text-elegant-gold transition-colors duration-300"
                                data-lang-key="nav_home">Home</a></li>
                        <li><a href="#about"
                                class="text-elegant-white/70 hover:text-elegant-gold transition-colors duration-300"
                                data-lang-key="nav_about">About</a></li>
                        <li><a href="#rooms"
                                class="text-elegant-white/70 hover:text-elegant-gold transition-colors duration-300"
                                data-lang-key="nav_rooms">Rooms</a></li>
                        <li><a href="#amenities"
                                class="text-elegant-white/70 hover:text-elegant-gold transition-colors duration-300"
                                data-lang-key="nav_amenities">Amenities</a></li>
                        <li><a href="#location"
                                class="text-elegant-white/70 hover:text-elegant-gold transition-colors duration-300"
                                data-lang-key="nav_location">Location</a></li>
                        <li><a href="#contact"
                                class="text-elegant-white/70 hover:text-elegant-gold transition-colors duration-300"
                                data-lang-key="nav_contact">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-cormorant text-xl font-bold text-elegant-gold mb-6"
                        data-lang-key="footer_contact">Contact</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt text-elegant-gold mt-1 mr-3"></i>
                            <span class="text-elegant-white/70" data-lang-key="footer_address">Jalan Raya Denpasar -
                                Gilimanuk, Tabanan, Bali</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone text-elegant-gold mt-1 mr-3"></i>
                            <span class="text-elegant-white/70">+62 812 3456 7890</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope text-elegant-gold mt-1 mr-3"></i>
                            <span class="text-elegant-white/70">info@pondokharibaik.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-elegant-gold/20 pt-6 text-center">
                <p class="text-elegant-white/50">&copy; 2025 Pondok Hari Baik. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Language translations
        const translations = {
            en: {
                // Navigation
                nav_home: "Home",
                nav_about: "About",
                nav_rooms: "Rooms",
                nav_amenities: "Amenities",
                nav_location: "Location",
                nav_contact: "Contact",
                nav_book: "Login",

                // Hero Section
                hero_welcome: "Welcome to",
                hero_subtitle: "Experience the tranquility of Bali in our luxurious villa with stunning views and exceptional service",
                hero_button: "Explore Our Rooms",

                // About Section
                about_title: "About Our Villa",
                about_p1: "Located in Balian, less than 1 km from Bonian Beach, Pondok Hari Baik features accommodation with an outdoor swimming pool, free private parking, a garden and a terrace. The property is set 2 km from Balian Beach, 2.2 km from Batulumbang Beach and 36 km from Tanah Lot Temple.",
                about_p2: "At the hotel rooms come with air conditioning, a desk, a balcony with a garden view, a private bathroom and a flat-screen TV. Pondok Hari Baik offers some rooms with pool views, and each room has a patio.",
                about_p3: "A continental, Asian or vegetarian breakfast can be enjoyed at the property. At the accommodation you will find a restaurant serving Indonesian cuisine. Vegetarian, halal and vegan options can also be requested.",
                about_luxury: "Luxury Experience",
                about_since: "Since 2010",

                // Rooms Section
                rooms_title: "Our Luxurious Rooms",
                rooms_subtitle: "Discover our elegantly designed rooms offering comfort, privacy, and stunning views",
                rooms_popular: "Popular",
                rooms_best_value: "Best Value",
                rooms_per_night: "/night",
                rooms_book: "Book Now",

                room1_title: "Family Bungalow",
                room1_capacity: "Maximum capacity 4 people",

                room2_title: "Family Room with Garden View",
                room2_capacity: "Maximum capacity 4 people",

                room3_title: "Twins Room with Garden View",
                room3_capacity: "Maximum capacity 2 people",

                room_feature1: "AC & Flat Screen TV",
                room_feature2: "Private Balcony",
                room_feature3: "Private Bathroom",
                room_feature4: "Garden View",
                room_feature5: "Premium Bathroom",

                // Amenities Section
                amenities_title: "Premium Amenities",
                amenities_subtitle: "Enjoy our world-class facilities designed for your comfort and relaxation",

                amenity1_title: "Outdoor Pool",
                amenity1_desc: "Enjoy swimming with beautiful natural views",

                amenity2_title: "Non-Smoking Rooms",
                amenity2_desc: "Fresh air for your comfort",

                amenity3_title: "Airport Shuttle",
                amenity3_desc: "Exclusive transportation service",

                amenity4_title: "Spa & Wellness Center",
                amenity4_desc: "Premium relaxation and treatments",

                amenity5_title: "Free Parking",
                amenity5_desc: "Safe and convenient parking",

                amenity6_title: "Room Service",
                amenity6_desc: "24-hour service for your convenience",

                amenity7_title: "Free WiFi",
                amenity7_desc: "Fast internet connection throughout",

                amenity8_title: "Restaurant",
                amenity8_desc: "Indonesian and international cuisine",

                amenity9_title: "Family Rooms",
                amenity9_desc: "Comfortable accommodation for families",

                amenity10_title: "Breakfast",
                amenity10_desc: "Continental, Asian, and vegetarian options",

                // Testimonials
                testimonials_title: "Guest Experiences",
                testimonials_subtitle: "What our guests say about their stay at Pondok Hari Baik",

                testimonial1_text: "\"An amazing stay experience. Beautiful views, comfortable rooms, and friendly service. We will definitely be back!\"",
                testimonial2_text: "\"The perfect place for a family vacation. Clean pool, delicious food, and strategic location near the beach made our holiday very enjoyable.\"",
                testimonial3_text: "\"Very helpful and friendly staff. Clean and comfortable rooms. Delicious breakfast with many choices. Highly recommended!\"",

                // Location
                location_title: "Our Location",
                location_subtitle: "Strategically located with easy access to Bali's most beautiful beaches",
                location_address: "Jalan Raya Denpasar - Gilimanuk, Tabanan, Bali, Indonesia, 82162",
                location_description: "Located in a strategic location with easy access to various popular tourist attractions in Bali.",

                location_bonian: "Bonian Beach: < 1 km",
                location_balian: "Balian Beach: 2 km",
                location_batulumbang: "Batulumbang Beach: 2.2 km",
                location_tanah_lot: "Tanah Lot Temple: 36 km",
                location_airport: "Ngurah Rai International Airport: 57 km",

                // CTA Section
                cta_title: "Ready for an Unforgettable Experience?",
                cta_subtitle: "Book your stay now and enjoy the tranquility of Bali at Pondok Hari Baik",
                cta_button: "Book Your Stay",

                // Contact Section
                contact_title: "Contact Us",
                contact_subtitle: "Have questions or ready to book? Reach out to us",
                contact_name: "Name",
                contact_email: "Email",
                contact_phone: "Phone Number",
                contact_message: "Message",
                contact_send: "Send Message",

                contact_get_in_touch: "Get in Touch",
                contact_address_label: "Address",
                contact_address: "Jalan Raya Denpasar - Gilimanuk, Tabanan, Bali, Indonesia, 82162",
                contact_phone_label: "Phone",
                contact_email_label: "Email",
                contact_hours_label: "Operating Hours",
                contact_checkin: "Check-in: 14:00 - 22:00",
                contact_checkout: "Check-out: Before 12:00",
                contact_reception: "Reception: 24 Hours",
                contact_follow: "Follow Us",

                // Footer
                footer_description: "Luxury villa with beautiful views and excellent service in Balian, Bali.",
                footer_quick_links: "Quick Links",
                footer_contact: "Contact",
                footer_address: "Jalan Raya Denpasar - Gilimanuk, Tabanan, Bali",
                footer_privacy: "We respect your privacy. Your information is safe with us."
            },
            id: {
                // Navigation
                nav_home: "Beranda",
                nav_about: "Tentang",
                nav_rooms: "Kamar",
                nav_amenities: "Fasilitas",
                nav_location: "Lokasi",
                nav_contact: "Kontak",
                nav_book: "Masuk",

                // Hero Section
                hero_welcome: "Selamat Datang di",
                hero_subtitle: "Nikmati ketenangan Bali di villa mewah kami dengan pemandangan menakjubkan dan pelayanan luar biasa",
                hero_button: "Jelajahi Kamar Kami",

                // About Section
                about_title: "Tentang Villa Kami",
                about_p1: "Terletak di Balian, kurang dari 1 km dari Pantai Bonian, Pondok Hari Baik menawarkan akomodasi dengan kolam renang outdoor, parkir pribadi gratis, taman, dan teras. Akomodasi ini berjarak sekitar 2 km dari Pantai Balian, 2,2 km dari Pantai Batulumbang, dan 36 km dari Pura Tanah Lot.",
                about_p2: "Di hotel, kamar memiliki AC, meja kerja, balkon dengan pemandangan taman, kamar mandi pribadi, TV layar datar, seprai, dan handuk. Pondok Hari Baik menyediakan beberapa kamar dengan pemandangan kolam, dan setiap kamar memiliki patio.",
                about_p3: "Sarapan yang meliputi pilihan kontinental, Asia, dan vegetarian tersedia setiap pagi. Anda akan menemukan restoran yang menyajikan masakan Indonesia di Pondok Hari Baik. Pilihan hidangan vegetarian, halal, dan vegan juga dapat dipesan.",
                about_luxury: "Pengalaman Mewah",
                about_since: "Sejak 2010",

                // Rooms Section
                rooms_title: "Kamar Mewah Kami",
                rooms_subtitle: "Temukan kamar kami yang dirancang dengan elegan menawarkan kenyamanan, privasi, dan pemandangan menakjubkan",
                rooms_popular: "Populer",
                rooms_best_value: "Nilai Terbaik",
                rooms_per_night: "/malam",
                rooms_book: "Pesan Sekarang",

                room1_title: "Family Bungalow",
                room1_capacity: "Kapasitas maksimum 4 orang",

                room2_title: "Family Room with Garden View",
                room2_capacity: "Kapasitas maksimum 4 orang",

                room3_title: "Twins Room with Garden View",
                room3_capacity: "Kapasitas maksimum 2 orang",

                room_feature1: "AC & TV Layar Datar",
                room_feature2: "Balkon Pribadi",
                room_feature3: "Kamar Mandi Pribadi",
                room_feature4: "Pemandangan Taman",
                room_feature5: "Kamar Mandi Premium",

                // Amenities Section
                amenities_title: "Fasilitas Premium",
                amenities_subtitle: "Nikmati fasilitas kelas dunia kami yang dirancang untuk kenyamanan dan relaksasi Anda",

                amenity1_title: "Kolam Renang Outdoor",
                amenity1_desc: "Nikmati berenang dengan pemandangan alam yang indah",

                amenity2_title: "Kamar Bebas Rokok",
                amenity2_desc: "Udara segar untuk kenyamanan Anda",

                amenity3_title: "Antar-Jemput Bandara",
                amenity3_desc: "Layanan transportasi eksklusif",

                amenity4_title: "Spa & Pusat Kesehatan",
                amenity4_desc: "Relaksasi dan perawatan premium",

                amenity5_title: "Parkir Gratis",
                amenity5_desc: "Parkir aman dan nyaman",

                amenity6_title: "Layanan Kamar",
                amenity6_desc: "Layanan 24 jam untuk kenyamanan Anda",

                amenity7_title: "WiFi Gratis",
                amenity7_desc: "Koneksi internet cepat di seluruh area",

                amenity8_title: "Restoran",
                amenity8_desc: "Hidangan Indonesia dan internasional",

                amenity9_title: "Kamar Keluarga",
                amenity9_desc: "Akomodasi nyaman untuk keluarga",

                amenity10_title: "Sarapan",
                amenity10_desc: "Pilihan kontinental, Asia, dan vegetarian",

                // Testimonials
                testimonials_title: "Pengalaman Tamu",
                testimonials_subtitle: "Apa yang tamu kami katakan tentang pengalaman menginap di Pondok Hari Baik",

                testimonial1_text: "\"Pengalaman menginap yang luar biasa. Pemandangan indah, kamar yang nyaman, dan pelayanan yang ramah. Kami pasti akan kembali lagi!\"",
                testimonial2_text: "\"Tempat yang sempurna untuk liburan keluarga. Kolam renang yang bersih, makanan yang lezat, dan lokasi yang strategis dekat pantai membuat liburan kami sangat menyenangkan.\"",
                testimonial3_text: "\"Staff yang sangat membantu dan ramah. Kamar bersih dan nyaman. Sarapan enak dengan banyak pilihan. Sangat direkomendasikan!\"",

                // Location
                location_title: "Lokasi Kami",
                location_subtitle: "Terletak strategis dengan akses mudah ke pantai-pantai terindah di Bali",
                location_address: "Jalan Raya Denpasar - Gilimanuk, Tabanan, Bali, Indonesia, 82162",
                location_description: "Terletak di lokasi yang strategis dengan akses mudah ke berbagai tempat wisata populer di Bali.",

                location_bonian: "Pantai Bonian: < 1 km",
                location_balian: "Pantai Balian: 2 km",
                location_batulumbang: "Pantai Batulumbang: 2,2 km",
                location_tanah_lot: "Pura Tanah Lot: 36 km",
                location_airport: "Bandara Internasional Ngurah Rai: 57 km",

                // CTA Section
                cta_title: "Siap untuk Pengalaman yang Tak Terlupakan?",
                cta_subtitle: "Pesan penginapan Anda sekarang dan nikmati ketenangan Bali di Pondok Hari Baik",
                cta_button: "Pesan Sekarang",

                // Contact Section
                contact_title: "Hubungi Kami",
                contact_subtitle: "Punya pertanyaan atau siap memesan? Hubungi kami",
                contact_name: "Nama",
                contact_email: "Email",
                contact_phone: "Nomor Telepon",
                contact_message: "Pesan",
                contact_send: "Kirim Pesan",

                contact_get_in_touch: "Hubungi Kami",
                contact_address_label: "Alamat",
                contact_address: "Jalan Raya Denpasar - Gilimanuk, Tabanan, Bali, Indonesia, 82162",
                contact_phone_label: "Telepon",
                contact_email_label: "Email",
                contact_hours_label: "Jam Operasional",
                contact_checkin: "Check-in: 14:00 - 22:00",
                contact_checkout: "Check-out: Sebelum 12:00",
                contact_reception: "Resepsionis: 24 Jam",
                contact_follow: "Ikuti Kami",

                // Footer
                footer_description: "Villa mewah dengan pemandangan indah dan pelayanan terbaik di Balian, Bali.",
                footer_quick_links: "Link Cepat",
                footer_contact: "Kontak",
                footer_address: "Jalan Raya Denpasar - Gilimanuk, Tabanan, Bali",
                footer_privacy: "Kami menghormati privasi Anda. Informasi Anda aman bersama kami."
            }
        };

        // Language switcher functionality
        const languageToggle = document.getElementById('language-toggle');
        const languageOptions = document.getElementById('language-options');
        const languageOptionItems = document.querySelectorAll('.language-option');
        const currentLanguageFlag = document.getElementById('current-language-flag');
        const currentLanguage = document.getElementById('current-language');

        // Get saved language preference or default to English
        let activeLanguage = localStorage.getItem('language') || 'en';

        // Initialize page with saved language
        updateLanguage(activeLanguage);
        updateLanguageToggle(activeLanguage);

        // Toggle language dropdown
        languageToggle.addEventListener('click', () => {
            languageOptions.classList.toggle('active');
        });

        // Close language dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!languageToggle.contains(e.target) && !languageOptions.contains(e.target)) {
                languageOptions.classList.remove('active');
            }
        });

        // Language selection
        languageOptionItems.forEach(option => {
            option.addEventListener('click', () => {
                const lang = option.getAttribute('data-lang');
                activeLanguage = lang;

                // Save language preference
                localStorage.setItem('language', lang);

                // Update UI
                updateLanguage(lang);
                updateLanguageToggle(lang);

                // Close dropdown
                languageOptions.classList.remove('active');
            });
        });

        // Update language toggle display
        function updateLanguageToggle(lang) {
            if (lang === 'en') {
                currentLanguageFlag.src = 'https://flagcdn.com/w20/gb.png';
                currentLanguage.textContent = 'EN';
            } else if (lang === 'id') {
                currentLanguageFlag.src = 'https://flagcdn.com/w20/id.png';
                currentLanguage.textContent = 'ID';
            }
        }

        // Update all text content based on selected language
        function updateLanguage(lang) {
            const elements = document.querySelectorAll('[data-lang-key]');

            elements.forEach(element => {
                const key = element.getAttribute('data-lang-key');

                if (translations[lang] && translations[lang][key]) {
                    if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                        element.placeholder = translations[lang][key];
                    } else {
                        element.textContent = translations[lang][key];
                    }
                }
            });

            // Update document title based on language
            document.title = lang === 'en' ?
                'Pondok Hari Baik - Luxury Villa in Balian, Bali' :
                'Pondok Hari Baik - Villa Mewah di Balian, Bali';
        }

        // Mobile Menu Toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const header = document.getElementById('header');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Close mobile menu when clicking on a link
        const mobileLinks = mobileMenu.querySelectorAll('a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
            });
        });

        // Scroll animations
        const animateElements = document.querySelectorAll('.animate-hidden');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-visible');
                } else {
                    // Uncomment the line below if you want elements to hide again when scrolled out of view
                    // entry.target.classList.remove('animate-visible');
                }
            });
        }, {
            threshold: 0.1
        });

        animateElements.forEach(element => {
            observer.observe(element);
        });

        // Header scroll effect
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('py-2');
                header.classList.remove('py-4');
            } else {
                header.classList.add('py-4');
                header.classList.remove('py-2');
            }
        });

        // Initialize animations for elements in view on page load
        window.addEventListener('load', () => {
            animateElements.forEach(element => {
                const rect = element.getBoundingClientRect();
                if (rect.top < window.innerHeight) {
                    element.classList.add('animate-visible');
                }
            });
        });
    </script>
</body>

</html>
