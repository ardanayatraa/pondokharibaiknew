<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pondok Hari Baik - Luxury Villa in Balian, Bali</title>

    <!-- SEO Meta Tags -->
    <meta name="description"
        content="Experience the tranquility of Bali in our luxurious villa with stunning views and exceptional service. Book your stay at Pondok Hari Baik in Balian Beach, Bali.">
    <meta name="keywords"
        content="luxury villa bali, balian beach accommodation, pondok hari baik, bali villa, beach villa, family bungalow bali">
    <meta name="author" content="Pondok Hari Baik">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.pondokharibaik.id/">
    <meta property="og:title" content="Pondok Hari Baik - Luxury Villa in Balian, Bali">
    <meta property="og:description"
        content="Experience the tranquility of Bali in our luxurious villa with stunning views and exceptional service.">
    <meta property="og:image" content="{{ asset('assets/logo.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://www.pondokharibaik.id/">
    <meta property="twitter:title" content="Pondok Hari Baik - Luxury Villa in Balian, Bali">
    <meta property="twitter:description"
        content="Experience the tranquility of Bali in our luxurious villa with stunning views and exceptional service.">
    <meta property="twitter:image" content="{{ asset('assets/logo.png') }}">

    <!-- Canonical URL -->
    <link rel="canonical" href="https://www.pondokharibaik.id/">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Cormorant:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap">
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>

    @livewireStyles

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        elegant: {
                            green: '#3F7D58',
                            lightgray: '#FFFFFF',
                            orange: '#EF9651',
                            redorange: '#EC5228',
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
                        'hero-pattern': "linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/assets/bg-hero.JPG')",
                        'about-pattern': "url('https://images.unsplash.com/photo-1540541338287-41700207dee6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')",
                        'family-bungalow': "url('https://images.unsplash.com/photo-1590490360182-c33d57733427?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')",
                        'family-garden': "url('https://images.unsplash.com/photo-1578683010236-d716f9a3f461?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')",
                        'twins-garden': "url('https://images.unsplash.com/photo-1595576508898-0ad5c879a061?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')",
                        'pattern-bg': "url('data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%233F7D58' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')"
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
            background: #3F7D58;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #2F5E42;
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
            border: 1px solid #3F7D58;
            z-index: -1;
        }

        /* Decorative elements */
        .decorative-line {
            position: relative;
            height: 1px;
            background: linear-gradient(90deg, transparent, #3F7D58, transparent);
        }

        .decorative-line::before,
        .decorative-line::after {
            content: '';
            position: absolute;
            width: 6px;
            height: 6px;
            background-color: #3F7D58;
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

        /* Custom styles for the booking stepper */
        .step-content {
            transition: opacity 0.3s ease;
        }

        /* Payment radio button styles */
        .payment-option input:checked~label .payment-radio {
            border-color: #3F7D58;
        }

        .payment-option input:not(:checked)~label .payment-radio-dot {
            display: none;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideInUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        #modal-content {
            animation: slideInUp 0.5s ease forwards;
        }

        /* Form validation styles */
        .input-error {
            border-color: #EF4444 !important;
        }

        .error-message {
            color: #EF4444;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        /* Loading spinner */
        .spinner {
            border: 3px solid rgba(63, 125, 88, 0.3);
            border-radius: 50%;
            border-top: 3px solid #3F7D58;
            width: 24px;
            height: 24px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <link rel="shortcut icon" href="{{ asset('assets/logo.png') }}" type="image/png">
    <link rel="icon" href="{{ asset('assets/logo.png') }}" type="image/png">

    <!-- Structured Data for Rich Snippets -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LodgingBusiness",
      "name": "Pondok Hari Baik",
      "image": "{{ asset('assets/logo.png') }}",
      "description": "Experience the tranquility of Bali in our luxurious villa with stunning views and exceptional service.",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Jalan Raya Denpasar - Gilimanuk",
        "addressLocality": "Tabanan",
        "addressRegion": "Bali",
        "postalCode": "82162",
        "addressCountry": "ID"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": -8.55,
        "longitude": 114.97
      },
      "telephone": "+6281234567890",
      "priceRange": "$$",
      "amenityFeature": [
        {"@type": "LocationFeatureSpecification", "name": "Outdoor Pool"},
        {"@type": "LocationFeatureSpecification", "name": "Free WiFi"},
        {"@type": "LocationFeatureSpecification", "name": "Restaurant"},
        {"@type": "LocationFeatureSpecification", "name": "Spa & Wellness Center"},
        {"@type": "LocationFeatureSpecification", "name": "Free Parking"}
      ],
      "starRating": {
        "@type": "Rating",
        "ratingValue": "4.8",
        "bestRating": "5"
      }
    }
    </script>

    @auth
        <script>
            window.apiToken = "{{ config('services.reservation_api.token') }}";
        </script>

        @if (Auth::guard('guest')->check())
            <script>
                window.guestId = {{ Auth::guard('guest')->user()->id_guest }};
            </script>
        @endif
    @else
        <script>
            window.guestId = null;
        </script>
    @endauth

    <script src="/dist/general.js" defer></script>
    <script src="/dist/stepper.js" defer></script>
</head>

<body class="font-montserrat text-elegant-charcoal bg-white bg-pattern-bg">
    <!-- Header -->
    <header class="fixed w-full z-50 bg-white/95 backdrop-blur-md shadow-md transition-all duration-300" id="header">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="#" class="flex items-center">
                <div class="w-12 h-12  rounded-full flex items-center justify-center mr-3 overflow-hidden">
                    <img src="{{ asset('assets/logo.png') }}" alt="Pondok Hari Baik Logo"
                        class="w-full h-full object-cover">
                </div>

                <span class="font-cormorant text-3xl font-bold text-elegant-green">Pondok Hari Baik</span>
            </a>

            <div class="flex items-center">
                <button class="lg:hidden text-elegant-white focus:outline-none" id="mobile-menu-button"
                    aria-label="Toggle menu">
                    <i class="fas fa-bars text-2xl"></i>
                </button>

                <nav class="hidden lg:flex items-center space-x-8">
                    <a href="#home"
                        class="text-elegant-green hover:text-elegant-orange transition-colors duration-300 font-medium">Home</a>

                    <a href="#rooms"
                        class="text-elegant-green hover:text-elegant-orange transition-colors duration-300 font-medium">Rooms</a>
                    <a href="#amenities"
                        class="text-elegant-green hover:text-elegant-orange transition-colors duration-300 font-medium">Amenities</a>
                    <a href="#location"
                        class="text-elegant-green hover:text-elegant-orange transition-colors duration-300 font-medium">Location</a>

                    @php
                        $isGuest = Auth::guard('guest')->check();
                        $user = Auth::guard('guest')->user();
                        $isOwner = Auth::guard('owner')->check();
                        $isAdmin = Auth::guard('admin')->check();
                    @endphp

                    <div class="relative inline-block">
                        @if ($isGuest)
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="bg-elegant-green hover:bg-elegant-green/80 text-elegant-white px-6 py-2 rounded transition">
                                    Logout
                                </button>
                            </form>
                        @elseif($isOwner)
                            <a href="{{ route('dashboard') }}"
                                class="bg-elegant-green hover:bg-elegant-green/80 text-elegant-white px-6 py-2 rounded transition">
                                Dashboard Owner
                            </a>
                        @elseif($isAdmin)
                            <a href="{{ route('dashboard') }}"
                                class="bg-elegant-green hover:bg-elegant-green/80 text-elegant-white px-6 py-2 rounded transition">
                                Dashboard Admin
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="bg-elegant-green hover:bg-elegant-green/80 text-elegant-white px-6 py-2 rounded transition">
                                Login
                            </a>
                        @endif
                    </div>

                </nav>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="lg:hidden hidden bg-white shadow-lg absolute w-full left-0 z-20 transition-all duration-300 border-t border-elegant-green/20"
            id="mobile-menu">
            <div class="container mx-auto px-4 py-4 flex flex-col space-y-4">
                <a href="#home"
                    class="text-elegant-green hover:text-elegant-orange transition-colors duration-300 font-medium py-2 border-b border-elegant-green/20">Home</a>

                <a href="#rooms"
                    class="text-elegant-green hover:text-elegant-orange transition-colors duration-300 font-medium py-2 border-b border-elegant-green/20">Rooms</a>
                <a href="#amenities"
                    class="text-elegant-green hover:text-elegant-orange transition-colors duration-300 font-medium py-2 border-b border-elegant-green/20">Amenities</a>
                <a href="#location"
                    class="text-elegant-green hover:text-elegant-orange transition-colors duration-300 font-medium py-2 border-b border-elegant-green/20">Location</a>
                @php
                    $isGuest = Auth::guard('guest')->check();
                    $user = Auth::guard('guest')->user();
                    $isOwner = Auth::guard('owner')->check();
                    $isAdmin = Auth::guard('admin')->check();
                @endphp

                <div class="relative inline-block">
                    @if ($isGuest)
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="bg-elegant-green hover:bg-elegant-green/80 text-elegant-white px-6 py-2 rounded transition">
                                Logout
                            </button>
                        </form>
                    @elseif($isOwner)
                        <a href="{{ route('dashboard') }}"
                            class="bg-elegant-green hover:bg-elegant-green/80 text-elegant-white px-6 py-2 rounded transition">
                            Dashboard Owner
                        </a>
                    @elseif($isAdmin)
                        <a href="{{ route('dashboard') }}"
                            class="bg-elegant-green hover:bg-elegant-green/80 text-elegant-white px-6 py-2 rounded transition">
                            Dashboard Admin
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="bg-elegant-green hover:bg-elegant-green/80 text-elegant-white px-6 py-2 rounded transition">
                            Login
                        </a>
                    @endif
                </div>

            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="home"
        class="bg-hero-pattern bg-cover bg-center h-screen flex items-center justify-center parallax">
        <div class="container mx-auto px-4 text-center">
            <div class="inline-block mb-6 animate-hidden">
                <div class="w-20 h-px bg-elegant-orange mx-auto mb-6"></div>
                <h1 class="font-cormorant text-5xl md:text-7xl font-bold text-elegant-white mb-6 tracking-wide">
                    Welcome to <span class="text-elegant-orange">Pondok Hari Baik</span>
                </h1>
                <div class="w-20 h-px bg-elegant-orange mx-auto"></div>
            </div>
            <p class="text-xl md:text-2xl text-elegant-white mb-10 w-full mx-auto animate-hidden delay-200 font-light">
                Experience the tranquility of Bali in our luxurious villa with stunning views and exceptional service
            </p>
            <button id="hero-book-btn"
                class="inline-block bg-transparent border border-elegant-orange text-elegant-orange hover:bg-elegant-orange hover:text-elegant-white px-8 py-4 text-lg font-medium transition-all duration-300 animate-hidden delay-300 btn-elegant">
                Book Your Stay
                <i class="fas fa-arrow-right ml-2"></i>
            </button>
        </div>
    </section>

    <!-- Rooms Section -->
    <section id="rooms" class="py-24 bg-white bg-pattern-bg">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16 animate-hidden">
                <span class="text-elegant-green text-sm uppercase tracking-widest">Accommodation</span>
                <h2 class="font-cormorant text-4xl md:text-5xl font-bold text-elegant-green mb-4 tracking-wide">
                    Our Luxurious Rooms</h2>
                <div class="decorative-line w-40 mx-auto mt-4"></div>
                <p class="text-lg mt-6 w-full mx-auto text-elegant-charcoal">
                    Discover our elegantly designed rooms offering comfort, privacy, and stunning views</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach ($villa as $item)
                    <!-- Room 1 -->
                    <div
                        class="bg-elegant-white border border-elegant-green/30 overflow-hidden shadow-md transform hover:scale-105 transition-all duration-500 animate-hidden elegant-card">
                        <div class="relative">
                            <div class="h-72 overflow-hidden rounded-lg shadow">
                                <img src="{{ asset('storage/' . $item->picture) }}"
                                    alt="{{ $item->name }} - Luxury Villa in Bali"
                                    class="w-full h-72 object-cover rounded">

                            </div>


                        </div>
                        <div class="p-8">
                            <h3 class="font-cormorant text-2xl font-bold text-elegant-green mb-2">
                                {{ $item->name }}
                            </h3>
                            <div class="flex items-center mb-4">

                            </div>
                            <div class="flex items-center mb-6">
                                <i class="fas fa-user-friends text-elegant-orange mr-2"></i>
                                <span class="text-elegant-charcoal">Maximum capacity {{ $item->capacity }}
                                    people</span>
                            </div>
                            <p class="mb-6 space-y-2 text-elegant-charcoal">
                                {{ $item->description }}
                            </p>
                            <button
                                class="book-now-btn block text-center bg-elegant-green hover:bg-elegant-green/80 text-elegant-white px-6 py-3 transition-all duration-300 btn-elegant w-full"
                                data-room-id="{{ $item->id_villa }}" data-room-name="{{ $item->name }}"
                                data-room-price="{{ $item->today_price }}">
                                Book Now
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <section id="amenities" class="py-24 bg-elegant-green text-elegant-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16 animate-hidden">
                <span class="text-elegant-orange text-sm uppercase tracking-widest">Services</span>
                <h2 class="font-cormorant text-4xl md:text-5xl font-bold mb-4 tracking-wide text-elegant-white"
                    data-lang-key="amenities_title">Premium Amenities</h2>
                <div class="decorative-line w-40 mx-auto mt-4"></div>
                <p class="text-lg mt-6 max-w-3xl mx-auto text-elegant-white/80" data-lang-key="amenities_subtitle">
                    Enjoy our world-class facilities designed for your comfort and relaxation</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                <!-- Amenity 1 -->
                <div
                    class="bg-elegant-navy/30 backdrop-blur-sm p-6 text-center transform hover:scale-105 transition-all duration-300 animate-hidden border border-elegant-orange/30 subtle-shadow">
                    <div
                        class="bg-elegant-orange/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 border border-elegant-orange">
                        <i class="fas fa-swimming-pool text-2xl text-elegant-orange"></i>
                    </div>
                    <h3 class="font-cormorant font-bold text-xl mb-2 text-elegant-orange"
                        data-lang-key="amenity1_title">Outdoor Pool</h3>
                    <p class="text-elegant-white/70 text-sm" data-lang-key="amenity1_desc">Enjoy swimming with
                        beautiful natural views</p>
                </div>

                <!-- Amenity 2 -->
                <div
                    class="bg-elegant-navy/30 backdrop-blur-sm p-6 text-center transform hover:scale-105 transition-all duration-300 animate-hidden delay-100 border border-elegant-orange/30 subtle-shadow">
                    <div
                        class="bg-elegant-orange/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 border border-elegant-orange">
                        <i class="fas fa-smoking-ban text-2xl text-elegant-orange"></i>
                    </div>
                    <h3 class="font-cormorant font-bold text-xl mb-2 text-elegant-orange"
                        data-lang-key="amenity2_title">Non-Smoking Rooms</h3>
                    <p class="text-elegant-white/70 text-sm" data-lang-key="amenity2_desc">Fresh air for your comfort
                    </p>
                </div>

                <!-- Amenity 3 -->
                <div
                    class="bg-elegant-navy/30 backdrop-blur-sm p-6 text-center transform hover:scale-105 transition-all duration-300 animate-hidden delay-200 border border-elegant-orange/30 subtle-shadow">
                    <div
                        class="bg-elegant-orange/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 border border-elegant-orange">
                        <i class="fas fa-plane text-2xl text-elegant-orange"></i>
                    </div>
                    <h3 class="font-cormorant font-bold text-xl mb-2 text-elegant-orange"
                        data-lang-key="amenity3_title">Airport Shuttle</h3>
                    <p class="text-elegant-white/70 text-sm" data-lang-key="amenity3_desc">Exclusive transportation
                        service</p>
                </div>

                <!-- Amenity 4 -->
                <div
                    class="bg-elegant-navy/30 backdrop-blur-sm p-6 text-center transform hover:scale-105 transition-all duration-300 animate-hidden delay-300 border border-elegant-orange/30 subtle-shadow">
                    <div
                        class="bg-elegant-orange/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 border border-elegant-orange">
                        <i class="fas fa-spa text-2xl text-elegant-orange"></i>
                    </div>
                    <h3 class="font-cormorant font-bold text-xl mb-2 text-elegant-orange"
                        data-lang-key="amenity4_title">Spa & Wellness Center</h3>
                    <p class="text-elegant-white/70 text-sm" data-lang-key="amenity4_desc">Premium relaxation and
                        treatments</p>
                </div>

                <!-- Amenity 5 -->
                <div
                    class="bg-elegant-navy/30 backdrop-blur-sm p-6 text-center transform hover:scale-105 transition-all duration-300 animate-hidden delay-400 border border-elegant-orange/30 subtle-shadow">
                    <div
                        class="bg-elegant-orange/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 border border-elegant-orange">
                        <i class="fas fa-parking text-2xl text-elegant-orange"></i>
                    </div>
                    <h3 class="font-cormorant font-bold text-xl mb-2 text-elegant-orange"
                        data-lang-key="amenity5_title">Free Parking</h3>
                    <p class="text-elegant-white/70 text-sm" data-lang-key="amenity5_desc">Safe and convenient parking
                    </p>
                </div>

                <!-- Amenity 6 -->
                <div
                    class="bg-elegant-navy/30 backdrop-blur-sm p-6 text-center transform hover:scale-105 transition-all duration-300 animate-hidden border border-elegant-orange/30 subtle-shadow">
                    <div
                        class="bg-elegant-orange/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 border border-elegant-orange">
                        <i class="fas fa-concierge-bell text-2xl text-elegant-orange"></i>
                    </div>
                    <h3 class="font-cormorant font-bold text-xl mb-2 text-elegant-orange"
                        data-lang-key="amenity6_title">Room Service</h3>
                    <p class="text-elegant-white/70 text-sm" data-lang-key="amenity6_desc">24-hour service for your
                        convenience</p>
                </div>

                <!-- Amenity 7 -->
                <div
                    class="bg-elegant-navy/30 backdrop-blur-sm p-6 text-center transform hover:scale-105 transition-all duration-300 animate-hidden delay-100 border border-elegant-orange/30 subtle-shadow">
                    <div
                        class="bg-elegant-orange/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 border border-elegant-orange">
                        <i class="fas fa-wifi text-2xl text-elegant-orange"></i>
                    </div>
                    <h3 class="font-cormorant font-bold text-xl mb-2 text-elegant-orange"
                        data-lang-key="amenity7_title">Free WiFi</h3>
                    <p class="text-elegant-white/70 text-sm" data-lang-key="amenity7_desc">Fast internet connection
                        throughout</p>
                </div>

                <!-- Amenity 8 -->
                <div
                    class="bg-elegant-navy/30 backdrop-blur-sm p-6 text-center transform hover:scale-105 transition-all duration-300 animate-hidden delay-200 border border-elegant-orange/30 subtle-shadow">
                    <div
                        class="bg-elegant-orange/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 border border-elegant-orange">
                        <i class="fas fa-utensils text-2xl text-elegant-orange"></i>
                    </div>
                    <h3 class="font-cormorant font-bold text-xl mb-2 text-elegant-orange"
                        data-lang-key="amenity8_title">Restaurant</h3>
                    <p class="text-elegant-white/70 text-sm" data-lang-key="amenity8_desc">Indonesian and
                        international cuisine</p>
                </div>

                <!-- Amenity 9 -->
                <div
                    class="bg-elegant-navy/30 backdrop-blur-sm p-6 text-center transform hover:scale-105 transition-all duration-300 animate-hidden delay-300 border border-elegant-orange/30 subtle-shadow">
                    <div
                        class="bg-elegant-orange/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 border border-elegant-orange">
                        <i class="fas fa-users text-2xl text-elegant-orange"></i>
                    </div>
                    <h3 class="font-cormorant font-bold text-xl mb-2 text-elegant-orange"
                        data-lang-key="amenity9_title">Family Rooms</h3>
                    <p class="text-elegant-white/70 text-sm" data-lang-key="amenity9_desc">Comfortable accommodation
                        for families</p>
                </div>

                <!-- Amenity 10 -->
                <div
                    class="bg-elegant-navy/30 backdrop-blur-sm p-6 text-center transform hover:scale-105 transition-all duration-300 animate-hidden delay-400 border border-elegant-orange/30 subtle-shadow">
                    <div
                        class="bg-elegant-orange/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 border border-elegant-orange">
                        <i class="fas fa-coffee text-2xl text-elegant-orange"></i>
                    </div>
                    <h3 class="font-cormorant font-bold text-xl mb-2 text-elegant-orange"
                        data-lang-key="amenity10_title">Breakfast</h3>
                    <p class="text-elegant-white/70 text-sm" data-lang-key="amenity10_desc">Continental, Asian, and
                        vegetarian options</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="py-24 bg-white bg-pattern-bg">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16 animate-hidden">
                <span class="text-elegant-green text-sm uppercase tracking-widest">Reviews</span>
                <h2 class="font-cormorant text-4xl md:text-5xl font-bold text-elegant-green mb-4 tracking-wide"
                    data-lang-key="testimonials_title">Guest Experiences</h2>
                <div class="decorative-line w-40 mx-auto mt-4"></div>
                <p class="text-lg mt-6 max-w-3xl mx-auto text-elegant-charcoal" data-lang-key="testimonials_subtitle">
                    What our guests say about their stay at Pondok Hari Baik</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Testimonial 1 -->
                <div
                    class="bg-elegant-white p-8 shadow-md animate-hidden border border-elegant-green/30 subtle-shadow">
                    <div class="flex items-center mb-6">
                        <div class="text-elegant-orange">
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
                            <img src="https://randomuser.me/api/portraits/women/44.jpg"
                                alt="Sarah Johnson - Guest Review" class="w-full h-full object-cover">
                        </div>
                        <div class="ml-4">
                            <h4 class="font-medium text-elegant-green">Sarah Johnson</h4>
                            <p class="text-sm text-elegant-gray">Jakarta, Indonesia</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div
                    class="bg-elegant-white p-8 shadow-md animate-hidden delay-200 border border-elegant-green/30 subtle-shadow">
                    <div class="flex items-center mb-6">
                        <div class="text-elegant-orange">
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
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="David Chen - Guest Review"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="ml-4">
                            <h4 class="font-medium text-elegant-green">David Chen</h4>
                            <p class="text-sm text-elegant-gray">Singapore</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div
                    class="bg-elegant-white p-8 shadow-md animate-hidden delay-300 border border-elegant-green/30 subtle-shadow">
                    <div class="flex items-center mb-6">
                        <div class="text-elegant-orange">
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
                            <img src="https://randomuser.me/api/portraits/women/68.jpg"
                                alt="Emma Wilson - Guest Review" class="w-full h-full object-cover">
                        </div>
                        <div class="ml-4">
                            <h4 class="font-medium text-elegant-green">Emma Wilson</h4>
                            <p class="text-sm text-elegant-gray">Melbourne, Australia</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Location Section -->
    <section id="location" class="py-24 bg-elegant-green text-elegant-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16 animate-hidden">
                <span class="text-elegant-orange text-sm uppercase tracking-widest">Find Us</span>
                <h2 class="font-cormorant text-4xl md:text-5xl font-bold text-elegant-orange mb-4 tracking-wide"
                    data-lang-key="location_title">Our Location</h2>
                <div class="decorative-line w-40 mx-auto mt-4"></div>
                <p class="text-lg mt-6 max-w-3xl mx-auto" data-lang-key="location_subtitle">Strategically located with
                    easy access to Bali's most beautiful beaches</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-12">
                <div class="lg:w-1/2 animate-hidden">
                    <div class="overflow-hidden shadow-md h-96 border border-elegant-orange/30 subtle-shadow">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3946.016208733885!2d114.9764275!3d-8.4978042!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd22d0001d1a4fb%3A0x834ddac063985b18!2sPondok%20Hari%20Baik!5e0!3m2!1sid!2sid!4v1747820804099!5m2!1sid!2sid"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

                <div class="lg:w-1/2 animate-hidden delay-200">
                    <div class="bg-white p-8 shadow-md h-full border border-elegant-orange/30 text-elegant-orange">
                        <h3 class="font-cormorant text-3xl font-bold mb-6">Pondok Hari Baik</h3>
                        <p class="text-lg mb-6" data-lang-key="location_address">
                            Jalan Raya Denpasar - Gilimanuk, Tabanan, Bali, Indonesia, 82162
                        </p>
                        <p class="text-lg mb-8" data-lang-key="location_description">
                            Located in a strategic location with easy access to various popular tourist attractions in
                            Bali.
                        </p>

                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 bg-elegant-orange/20 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-umbrella-beach text-elegant-orange"></i>
                                </div>
                                <span data-lang-key="location_bonian">Bonian Beach: < 1 km</span>
                            </div>

                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 bg-elegant-orange/20 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-umbrella-beach text-elegant-orange"></i>
                                </div>
                                <span data-lang-key="location_balian">Balian Beach: 2 km</span>
                            </div>

                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 bg-elegant-orange/20 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-umbrella-beach text-elegant-orange"></i>
                                </div>
                                <span data-lang-key="location_batulumbang">Batulumbang Beach: 2.2 km</span>
                            </div>

                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 bg-elegant-orange/20 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-landmark text-elegant-orange"></i>
                                </div>
                                <span data-lang-key="location_tanah_lot">Tanah Lot Temple: 36 km</span>
                            </div>

                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 bg-elegant-orange/20 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-plane-departure text-elegant-orange"></i>
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
        class="py-24 bg-elegant-redorange text-elegant-white bg-[url('https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')] bg-cover bg-center relative">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <div class="w-full mx-auto animate-hidden">
                <h2 class="font-cormorant text-4xl md:text-5xl font-bold mb-6 text-elegant-orange">
                    Ready for an Unforgettable Experience?</h2>
                <div class="w-20 h-px bg-elegant-orange mx-auto mb-6"></div>
                <p class="text-xl mb-10 text-elegant-white/90">Book your stay now and
                    enjoy the tranquility of Bali at Pondok Hari Baik</p>
                <button id="cta-book-btn"
                    class="inline-block bg-elegant-orange hover:bg-elegant-orange/80 text-elegant-white px-8 py-4 text-lg font-medium transition-all duration-300 btn-elegant border border-elegant-white">
                    Book Your Stay
                    <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-elegant-green text-elegant-white pt-16 pb-6 border-t border-elegant-orange/30">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-10">
                <div>
                    <h3 class="font-cormorant text-2xl font-bold text-elegant-orange mb-6">Pondok Hari Baik</h3>
                    <p class="mb-6 text-elegant-white">Luxury villa with
                        beautiful views and excellent service in Balian, Bali.</p>
                    <div class="flex space-x-4">
                        <a href="#" aria-label="Facebook"
                            class="w-10 h-10 bg-elegant-orange/20 rounded-full flex items-center justify-center hover:bg-elegant-orange transition-colors duration-300 hover:text-elegant-green text-elegant-orange">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" aria-label="Instagram"
                            class="w-10 h-10 bg-elegant-orange/20 rounded-full flex items-center justify-center hover:bg-elegant-orange transition-colors duration-300 hover:text-elegant-green text-elegant-orange">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" aria-label="Twitter"
                            class="w-10 h-10 bg-elegant-orange/20 rounded-full flex items-center justify-center hover:bg-elegant-orange transition-colors duration-300 hover:text-elegant-green text-elegant-orange">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" aria-label="TripAdvisor"
                            class="w-10 h-10 bg-elegant-orange/20 rounded-full flex items-center justify-center hover:bg-elegant-orange transition-colors duration-300 hover:text-elegant-green text-elegant-orange">
                            <i class="fab fa-tripadvisor"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="font-cormorant text-xl font-bold text-elegant-orange mb-6">
                        Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="#home"
                                class="text-elegant-white hover:text-elegant-orange transition-colors duration-300">Home</a>
                        </li>
                        <li><a href="#about"
                                class="text-elegant-white hover:text-elegant-orange transition-colors duration-300">About</a>
                        </li>
                        <li><a href="#rooms"
                                class="text-elegant-white hover:text-elegant-orange transition-colors duration-300">Rooms</a>
                        </li>
                        <li><a href="#amenities"
                                class="text-elegant-white hover:text-elegant-orange transition-colors duration-300">Amenities</a>
                        </li>
                        <li><a href="#location"
                                class="text-elegant-white hover:text-elegant-orange transition-colors duration-300">Location</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-cormorant text-xl font-bold text-elegant-orange mb-6">
                        Contact</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt text-elegant-orange mt-1 mr-3"></i>
                            <span class="text-elegant-white">Jalan Raya Denpasar -
                                Gilimanuk, Tabanan, Bali</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone text-elegant-orange mt-1 mr-3"></i>
                            <span class="text-elegant-white">+62 812 3456 7890</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope text-elegant-orange mt-1 mr-3"></i>
                            <span class="text-elegant-white">info@pondokharibaik.id</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-elegant-orange/20 pt-6 text-center">
                <p class="text-elegant-white">&copy; 2025 Pondok Hari Baik. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Booking Stepper Modal -->
    <div id="booking-stepper-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <!-- Overlay with blur effect -->
            <div class="fixed inset-0 bg-elegant-black bg-opacity-60 backdrop-blur-sm transition-opacity"
                id="modal-backdrop"></div>

            <!-- Modal Content -->
            <div class="relative bg-elegant-lightgray max-w-5xl w-full mx-auto rounded-lg shadow-2xl overflow-hidden z-10 transform transition-all duration-500 scale-95 opacity-0"
                id="modal-content">
                <!-- Decorative elements -->
                <div
                    class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-elegant-green/20 via-elegant-green to-elegant-green/20">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-elegant-green/20 via-elegant-green to-elegant-green/20">
                </div>
                <div
                    class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-elegant-green/20 via-elegant-green to-elegant-green/20">
                </div>
                <div
                    class="absolute top-0 right-0 w-1 h-full bg-gradient-to-b from-elegant-green/20 via-elegant-green to-elegant-green/20">
                </div>

                <!-- Close Button -->
                <button id="close-modal"
                    class="absolute top-6 right-6 text-elegant-orange hover:text-elegant-redorange transition-colors z-20 group"
                    aria-label="Close booking modal">
                    <div class="relative">
                        <div
                            class="w-8 h-8 rounded-full bg-elegant-green border border-elegant-orange/50 flex items-center justify-center group-hover:bg-elegant-redorange transition-all duration-300">
                            <i class="fas fa-times"></i>
                        </div>
                        <div
                            class="absolute -inset-1 rounded-full border border-elegant-orange/30 group-hover:border-elegant-orange/50 opacity-0 group-hover:opacity-100 transition-all duration-300">
                        </div>
                    </div>
                </button>

                <!-- Header -->
                <div class="bg-elegant-green p-8 border-b border-elegant-orange/30 relative overflow-hidden">
                    <!-- Decorative pattern -->
                    <div class="absolute inset-0 opacity-5">
                        <div class="absolute inset-0"
                            style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23EF9651\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                        </div>
                    </div>

                    <div class="relative">
                        <h3 class="font-cormorant text-3xl md:text-4xl font-bold text-elegant-orange mb-2">Book Your
                            Luxury Stay</h3>
                        <p class="text-elegant-white/80 max-w-2xl">Experience the tranquility of Bali in our luxurious
                            villa with stunning views and exceptional service</p>
                    </div>
                </div>

                <!-- Stepper Progress -->
                <div class="px-8 pt-8 pb-4 bg-elegant-lightgray">
                    <div class="relative">
                        <!-- Progress bar background -->
                        <div class="absolute top-1/2 left-0 w-full h-1 bg-elegant-orange/20 -translate-y-1/2"></div>

                        <!-- Active progress bar -->
                        <div id="progress-bar"
                            class="absolute top-1/2 left-0 h-1 bg-elegant-redorange -translate-y-1/2 transition-all duration-500"
                            style="width: 0%"></div>


                    </div>
                </div>

                <!-- Step Content -->
                <div class="p-8 bg-elegant-lightgray min-h-[400px]">
                    <!-- Step 1: Check Availability -->
                    <div class="step-content" id="step-1">
                        <div class="max-w-4xl mx-auto">
                            <div class="flex items-center mb-6">
                                <div
                                    class="w-10 h-10 rounded-full bg-elegant-redorange/10 flex items-center justify-center mr-4">
                                    <i class="fas fa-calendar-alt text-elegant-redorange"></i>
                                </div>
                                <h4 class="font-cormorant text-2xl font-bold text-elegant-green">Select Your Dates
                                </h4>
                            </div>

                            <div class="space-y-6">

                                {{-- Datepickers dalam grid --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                                    {{-- Check-in --}}
                                    <div
                                        class="bg-elegant-white p-6 rounded-lg shadow-md border border-elegant-green/20 hover:border-elegant-green/40 transition-all duration-300">
                                        <label for="check-in"
                                            class="block text-sm font-medium text-elegant-charcoal mb-2">Check-in Date
                                            <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <input type="text" id="check-in" name="start_date"
                                                class="w-full px-4 py-3 border border-elegant-green/30 bg-elegant-lightgray/50 text-elegant-charcoal focus:outline-none focus:ring-2 focus:ring-elegant-green rounded-md pl-10"
                                                placeholder="Pilih tanggal">
                                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-elegant-green">
                                                <i class="fas fa-calendar-day"></i>
                                            </div>
                                        </div>
                                        <div id="check-in-error" class="text-sm text-red-600 mt-1 hidden">
                                            Please select a check-in date
                                        </div>
                                    </div>

                                    {{-- Check-out --}}
                                    <div
                                        class="bg-elegant-white p-6 rounded-lg shadow-md border border-elegant-green/20 hover:border-elegant-green/40 transition-all duration-300">
                                        <label for="check-out"
                                            class="block text-sm font-medium text-elegant-charcoal mb-2">Check-out Date
                                            <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <input type="text" id="check-out" name="end_date"
                                                class="w-full px-4 py-3 border border-elegant-green/30 bg-elegant-lightgray/50 text-elegant-charcoal focus:outline-none focus:ring-2 focus:ring-elegant-green rounded-md pl-10"
                                                placeholder="Pilih tanggal">
                                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-elegant-green">
                                                <i class="fas fa-calendar-day"></i>
                                            </div>
                                        </div>
                                        <div id="check-out-error" class="text-sm text-red-600 mt-1 hidden">
                                            Please select a check-out date
                                        </div>
                                        <div id="date-range-error" class="text-sm text-red-600 mt-1 hidden">
                                            Check-out date must be after check-in date
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="mt-8 bg-elegant-white p-6 rounded-lg shadow-md border border-elegant-green/20 space-y-6">

                                <!-- Header -->
                                <div class="flex items-center">
                                    <div
                                        class="w-10 h-10 rounded-full bg-elegant-redorange/10 flex items-center justify-center mr-4">
                                        <i class="fas fa-home text-elegant-redorange text-lg"></i>
                                    </div>
                                    <h5 class="font-cormorant text-2xl font-bold text-elegant-green">
                                        Selected Room
                                    </h5>
                                </div>

                                <!-- Room Info -->
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p id="selected-room-name"
                                            class="text-lg font-semibold text-elegant-charcoal">Family Bungalow</p>

                                    </div>
                                    <button id="change-room-btn"
                                        class="text-elegant-green hover:text-elegant-orange transition-colors text-sm font-medium">
                                        <i class="fas fa-exchange-alt mr-1"></i> Change
                                    </button>
                                </div>

                                <!-- Price Calculation -->
                                <div id="price-calculation"
                                    class="p-4 bg-elegant-white text-elegant-charcoal rounded-lg border border-elegant-green/20">
                                    <p id="calc-status" class="italic text-sm">Please select check‑out date to see
                                        total price.</p>
                                    <div id="calc-total" class="mt-2 text-xl font-bold text-elegant-green hidden">
                                        Total: <span id="calc-amount"></span>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <!-- Step 2: Room Details -->
                    <div class="step-content hidden" id="step-2">
                        <div class="max-w-4xl mx-auto">
                            <div class="flex items-center mb-6">
                                <div
                                    class="w-10 h-10 rounded-full bg-elegant-redorange/10 flex items-center justify-center mr-4">
                                    <i class="fas fa-home text-elegant-redorange"></i>
                                </div>
                                <h4 class="font-cormorant text-2xl font-bold text-elegant-green">Room Details</h4>
                            </div>

                            <div class="bg-elegant-white p-6 rounded-lg shadow-md border border-elegant-green/20 mb-8">
                                <div class="flex flex-col md:flex-row">
                                    <div class="md:w-2/5 mb-4 md:mb-0 md:mr-6">
                                        <div class="relative rounded-lg overflow-hidden shadow-md group">
                                            <img id="room-image"
                                                src="https://images.unsplash.com/photo-1590490360182-c33d57733427?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                                                alt="Room"
                                                class="w-full h-64 object-cover transition-transform duration-700 group-hover:scale-110">
                                            <div
                                                class="absolute inset-0 bg-gradient-to-t from-elegant-green/70 to-transparent">
                                            </div>
                                            <div class="absolute bottom-4 left-4 text-elegant-white">
                                                <div class="flex items-center">
                                                    <div class="text-elegant-orange">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star-half-alt"></i>
                                                    </div>
                                                    <span class="ml-2 text-sm">4.8/5</span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="md:w-3/5">
                                        <h5 id="room-detail-name"
                                            class="font-cormorant text-2xl font-bold text-elegant-green mb-2">Family
                                            Bungalow</h5>
                                        <div class="flex items-center mb-4">

                                        </div>
                                        <p class="text-elegant-charcoal/80 mb-4" id="room-description">Luxurious
                                            bungalow with private
                                            balcony, perfect for families looking for comfort and privacy. Enjoy
                                            stunning views and premium amenities.</p>
                                        <div class="grid grid-cols-2 gap-2 mb-4">
                                            <div class="flex items-center">
                                                <i class="fas fa-user-friends text-elegant-orange mr-2"></i>
                                                <span id="room-capacity" class="text-elegant-charcoal">Up to 4
                                                    people</span>
                                            </div>

                                            <div class="flex items-center">
                                                <i class="fas fa-bath text-elegant-orange mr-2"></i>
                                                <span class="text-elegant-charcoal">Private Bathroom</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-tv text-elegant-orange mr-2"></i>
                                                <span class="text-elegant-charcoal">Flat Screen TV</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center mb-6">
                                <div
                                    class="w-10 h-10 rounded-full bg-elegant-redorange/10 flex items-center justify-center mr-4">
                                    <i class="fas fa-receipt text-elegant-redorange"></i>
                                </div>
                                <h4 class="font-cormorant text-2xl font-bold text-elegant-green">Booking Summary
                                </h4>
                            </div>

                            <div class="bg-elegant-white p-6 rounded-lg shadow-md border border-elegant-green/20">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h6
                                            class="font-medium text-elegant-green mb-4 pb-2 border-b border-elegant-orange/20">
                                            Stay Details</h6>
                                        <div class="space-y-3 text-elegant-charcoal">
                                            <div class="flex justify-between items-center">
                                                <div class="flex items-center">
                                                    <i class="fas fa-calendar-check text-elegant-orange mr-2"></i>
                                                    <span>Check-in:</span>
                                                </div>
                                                <span id="summary-checkin" class="font-medium">May 10, 2025</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <div class="flex items-center">
                                                    <i class="fas fa-calendar-times text-elegant-orange mr-2"></i>
                                                    <span>Check-out:</span>
                                                </div>
                                                <span id="summary-checkout" class="font-medium">May 15, 2025</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <div class="flex items-center">
                                                    <i class="fas fa-moon text-elegant-orange mr-2"></i>
                                                    <span>Nights:</span>
                                                </div>
                                                <span id="summary-nights" class="font-medium">5</span>
                                            </div>

                                        </div>
                                    </div>

                                    <div>
                                        <h6
                                            class="font-medium text-elegant-green mb-4 pb-2 border-b border-elegant-orange/20">
                                            Price Details</h6>
                                        <div class="space-y-3 text-elegant-charcoal">
                                            <div class="flex justify-between items-center">
                                                <span id="room-rate-label">Room Rate (5 nights):</span>
                                                <span id="room-rate-total">Rp 2,250,000</span>
                                            </div>

                                            <div class="pt-3 mt-3 border-t border-elegant-orange/20">
                                                <div
                                                    class="flex justify-between items-center font-bold text-elegant-green">
                                                    <span>Total:</span>
                                                    <span id="summary-total">Rp 2,475,000</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Guest Information -->
                    <div class="step-content hidden" id="step-3">
                        <div class="max-w-4xl mx-auto">
                            <div class="flex items-center mb-6">
                                <div
                                    class="w-10 h-10 rounded-full bg-elegant-redorange/10 flex items-center justify-center mr-4">
                                    <i class="fas fa-user-circle text-elegant-redorange"></i>
                                </div>
                                <h4 class="font-cormorant text-2xl font-bold text-elegant-green">Guest Information
                                </h4>
                            </div>

                            <div class="bg-elegant-white p-6 rounded-lg shadow-md border border-elegant-green/20 mb-8">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label for="guest-name"
                                            class="block text-sm font-medium text-elegant-charcoal mb-2">Full
                                            Name <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <input type="text" id="guest-name" placeholder="Enter your full name"
                                                class="w-full px-4 py-3 border border-elegant-green/30 bg-elegant-lightgray/50 text-elegant-charcoal focus:outline-none focus:ring-2 focus:ring-elegant-green rounded-md pl-10">
                                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-elegant-green">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        </div>
                                        <div id="guest-name-error" class="error-message hidden">Please enter your full
                                            name</div>
                                    </div>
                                    <div>
                                        <label for="guest-email"
                                            class="block text-sm font-medium text-elegant-charcoal mb-2">Email
                                            Address <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <input type="email" id="guest-email"
                                                placeholder="Enter your email address"
                                                class="w-full px-4 py-3 border border-elegant-green/30 bg-elegant-lightgray/50 text-elegant-charcoal focus:outline-none focus:ring-2 focus:ring-elegant-green rounded-md pl-10">
                                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-elegant-green">
                                                <i class="fas fa-envelope"></i>
                                            </div>
                                        </div>
                                        <div id="guest-email-error" class="error-message hidden">Please enter a valid
                                            email address</div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label for="guest-phone"
                                            class="block text-sm font-medium text-elegant-charcoal mb-2">Phone
                                            Number <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <input type="tel" id="guest-phone"
                                                placeholder="Enter your phone number"
                                                class="w-full px-4 py-3 border border-elegant-green/30 bg-elegant-lightgray/50 text-elegant-charcoal focus:outline-none focus:ring-2 focus:ring-elegant-green rounded-md pl-10">
                                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-elegant-green">
                                                <i class="fas fa-phone"></i>
                                            </div>
                                        </div>
                                        <div id="guest-phone-error" class="error-message hidden">Please enter your
                                            phone number</div>
                                    </div>
                                    <div>
                                        <label for="guest-address"
                                            class="block text-sm font-medium text-elegant-charcoal mb-2">Address
                                            <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <textarea id="guest-address" rows="3" placeholder="Enter your address"
                                                class="w-full px-4 py-3 border border-elegant-green/30 bg-elegant-lightgray/50 text-elegant-charcoal focus:outline-none focus:ring-2 focus:ring-elegant-green rounded-md pl-10 resize-none"></textarea>
                                            <div class="absolute left-3 top-4 text-elegant-green">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </div>
                                        </div>
                                        <div id="guest-address-error" class="error-message hidden">Please enter your
                                            address</div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Step 4: Payment -->
                    <div class="step-content hidden" id="step-4">
                        <div class="max-w-4xl mx-auto">
                            <div class="flex items-center mb-6">
                                <div
                                    class="w-10 h-10 rounded-full bg-elegant-redorange/10 flex items-center justify-center mr-4">
                                    <i class="fas fa-credit-card text-elegant-redorange"></i>
                                </div>
                                <h4 class="font-cormorant text-2xl font-bold text-elegant-green">Payment Information
                                </h4>
                            </div>

                            <div class="bg-elegant-white p-6 rounded-lg shadow-md border border-elegant-green/20 mb-8">
                                <h5 class="font-medium text-elegant-green mb-4 pb-2 border-b border-elegant-orange/20">
                                    Payment Summary
                                </h5>
                                <div class="space-y-3 text-elegant-charcoal">
                                    <div class="flex justify-between items-center">
                                        <span>Villa Name:</span>
                                        <span id="payment-villa-name" class="text-elegant-green font-bold"></span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span>Check‑in Date:</span>
                                        <span id="payment-checkin" class="text-elegant-green font-bold"></span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span>Check‑out Date:</span>
                                        <span id="payment-checkout" class="text-elegant-green font-bold"></span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span>Number of Nights:</span>
                                        <span id="payment-nights" class="text-elegant-green font-bold"></span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span>Room Rate (<span id="payment-nights-label"></span>):</span>
                                        <span id="payment-room-rate" class="text-elegant-green font-bold"></span>
                                    </div>


                                    <div class="pt-3 mt-3 border-t border-elegant-orange/20">
                                        <div class="flex justify-between items-center font-bold text-elegant-green">
                                            <span>Total Amount:</span>
                                            <span id="payment-total" class="text-elegant-green font-bold"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-elegant-white p-6 rounded-lg shadow-md border border-elegant-green/20">
                                <h5 class="font-medium text-elegant-green mb-4 pb-2 border-b border-elegant-orange/20">
                                    Payment Method</h5>
                                <div class="space-y-4">
                                    <!-- Metode Pembayaran - Midtrans (default) dan Tunai -->
                                    <div class="payment-option relative">
                                        <input type="radio" id="payment-midtrans" name="payment-method"
                                            class="hidden" checked>
                                        <label for="payment-midtrans"
                                            class="flex items-center p-4 border border-elegant-green/30 rounded-lg cursor-pointer transition-all duration-300 hover:bg-elegant-lightgray/50">
                                            <div
                                                class="w-6 h-6 rounded-full border-2 border-elegant-orange flex items-center justify-center mr-3">
                                                <div class="w-3 h-3 rounded-full bg-elegant-redorange"></div>
                                            </div>
                                            <span class="mr-4">Midtrans</span>
                                            <div class="ml-auto">
                                                <i class="fab fa-cc-visa text-blue-700 text-xl"></i>
                                                <i class="fab fa-cc-mastercard text-red-600 text-xl"></i>
                                                <i class="fab fa-cc-amex text-blue-500 text-xl"></i>
                                            </div>
                                        </label>
                                    </div>


                                </div>
                            </div>

                            <div class="mt-6 flex justify-end space-x-4">

                                <button id="btn-paynow"
                                    class="px-4 py-2 bg-elegant-green text-white rounded-md hover:bg-elegant-green/80">
                                    Pay Now
                                </button>
                            </div>
                        </div>
                    </div>


                    <!-- Step 5: Completion -->
                    <div class="step-content hidden" id="step-5">
                        <div class="max-w-4xl mx-auto text-center">
                            <div class="mb-8">
                                <div
                                    class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 relative">
                                    <div
                                        class="absolute inset-0 rounded-full border-4 border-green-500 opacity-30 animate-ping">
                                    </div>
                                    <i class="fas fa-check text-green-600 text-4xl"></i>
                                </div>
                                <h4 class="font-cormorant text-3xl font-bold text-elegant-green mb-4">Booking
                                    Confirmed!</h4>
                                <p class="text-elegant-charcoal mb-2">Thank you for your booking at Pondok Hari Baik.
                                </p>
                                <p class="text-elegant-charcoal mb-6">We've sent a confirmation email to <span
                                        id="confirmation-email" class="font-medium">your email address</span>.</p>
                            </div>


                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="bg-elegant-lightgray p-8 border-t border-elegant-orange/30 flex justify-between">
                    <button id="prev-step"
                        class="bg-elegant-green hover:bg-elegant-green/80 text-elegant-white px-6 py-3 transition-all duration-300 btn-elegant border border-elegant-orange/30 rounded-md hidden group">
                        <div class="flex items-center">
                            <i
                                class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform duration-300"></i>
                            <span>Previous</span>
                        </div>
                    </button>
                    <div class="ml-auto">
                        <button id="next-step"
                            class="bg-elegant-green hover:bg-elegant-green/80 text-elegant-white px-6 py-3 transition-all duration-300 btn-elegant border border-elegant-orange/30 rounded-md group">
                            <div class="flex items-center">
                                <span>Next</span>
                                <i
                                    class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @if (Auth::guard('guest')->check())
        <!-- Floating Button -->
        <div class="fixed bottom-6 right-6 z-50">
            <button onclick="toggleGuestModal()"
                class="bg-elegant-green text-white p-4 rounded-full shadow-lg hover:bg-elegant-green/90 transition">
                <i class="fas fa-user"></i>
            </button>
        </div>



        <!-- Modal -->
        <div id="guest-modal"
            class="fixed inset-0 backdrop-blur-sm bg-black/30 flex items-center justify-center z-50 hidden">
            <div id="guest-modal-content"
                class="bg-white w-full max-w-7xl mx-8 rounded-lg shadow-lg relative opacity-0 scale-95 transition-all duration-300 overflow-y-auto max-h-screen">

                <!-- Close Button -->
                <button onclick="toggleGuestModal()"
                    class="absolute top-3 right-4 text-gray-400 hover:text-gray-600 text-xl font-bold">
                    &times;
                </button>

                <!-- Modal Content -->
                <div class="p-6">
                    <h2 class="text-lg font-bold text-elegant-green mb-4">Akun Anda</h2>

                    <!-- Tabs -->
                    <div class="border-b mb-4">
                        <nav class="-mb-px flex space-x-6" id="guest-tabs">
                            <button
                                class="tab-btn text-elegant-green border-b-2 border-elegant-green pb-2 font-semibold"
                                onclick="switchTab('profil')">Profil</button>
                            <button class="tab-btn text-gray-500 hover:text-elegant-green pb-2"
                                onclick="switchTab('riwayat')">Riwayat Reservasi</button>
                        </nav>
                    </div>

                    <!-- Tab Contents -->
                    <div id="tab-profil">
                        <form action="{{ route('guest.update', ['guest' => $user]) }}" method="POST"
                            class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="_debug" value="1">

                            {{-- Username --}}
                            <div>
                                <label class="block text-sm font-medium text-elegant-charcoal mb-1">Username</label>
                                <div class="relative">
                                    <input type="text" name="username" value="{{ $user->username }}"
                                        placeholder="Enter your username"
                                        class="w-full pl-11 pr-4 py-3 border border-elegant-green/30 bg-elegant-lightgray/50 text-elegant-charcoal placeholder-gray-400 rounded-md shadow-sm focus:ring-2 focus:ring-elegant-green focus:border-elegant-green transition" />
                                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-elegant-green">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="block text-sm font-medium text-elegant-charcoal mb-1">Email</label>
                                <div class="relative">
                                    <input type="email" name="email" value="{{ $user->email }}"
                                        placeholder="Enter your email"
                                        class="w-full pl-11 pr-4 py-3 border border-elegant-green/30 bg-elegant-lightgray/50 text-elegant-charcoal placeholder-gray-400 rounded-md shadow-sm focus:ring-2 focus:ring-elegant-green focus:border-elegant-green transition" />
                                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-elegant-green">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                </div>
                            </div>


                            {{-- Full Name --}}
                            <div>
                                <label class="block text-sm font-medium text-elegant-charcoal mb-1">Full Name</label>
                                <div class="relative">
                                    <input type="text" name="full_name" value="{{ $user->full_name }}"
                                        placeholder="Enter full name"
                                        class="w-full pl-11 pr-4 py-3 border border-elegant-green/30 bg-elegant-lightgray/50 text-elegant-charcoal rounded-md shadow-sm focus:ring-2 focus:ring-elegant-green focus:border-elegant-green transition" />
                                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-elegant-green">
                                        <i class="fas fa-id-card"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Phone Number --}}
                            <div>
                                <label class="block text-sm font-medium text-elegant-charcoal mb-1">Phone
                                    Number</label>
                                <div class="relative">
                                    <input type="text" name="phone_number" value="{{ $user->phone_number }}"
                                        placeholder="Enter phone number"
                                        class="w-full pl-11 pr-4 py-3 border border-elegant-green/30 bg-elegant-lightgray/50 text-elegant-charcoal rounded-md shadow-sm focus:ring-2 focus:ring-elegant-green focus:border-elegant-green transition" />
                                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-elegant-green">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- ID Card Number --}}
                            <div>
                                <label class="block text-sm font-medium text-elegant-charcoal mb-1">ID Card
                                    Number</label>
                                <div class="relative">
                                    <input type="text" name="id_card_number" value="{{ $user->id_card_number }}"
                                        placeholder="Enter ID number"
                                        class="w-full pl-11 pr-4 py-3 border border-elegant-green/30 bg-elegant-lightgray/50 text-elegant-charcoal rounded-md shadow-sm focus:ring-2 focus:ring-elegant-green focus:border-elegant-green transition" />
                                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-elegant-green">
                                        <i class="fas fa-id-badge"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Passport Number --}}
                            <div>
                                <label class="block text-sm font-medium text-elegant-charcoal mb-1">Passport
                                    Number</label>
                                <div class="relative">
                                    <input type="text" name="passport_number"
                                        value="{{ $user->passport_number }}" placeholder="Enter passport number"
                                        class="w-full pl-11 pr-4 py-3 border border-elegant-green/30 bg-elegant-lightgray/50 text-elegant-charcoal rounded-md shadow-sm focus:ring-2 focus:ring-elegant-green focus:border-elegant-green transition" />
                                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-elegant-green">
                                        <i class="fas fa-passport"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Birthdate --}}
                            <div>
                                <label class="block text-sm font-medium text-elegant-charcoal mb-1">Birthdate</label>
                                <div class="relative">
                                    <input type="date" name="birthdate" value="{{ $user->birthdate }}"
                                        class="w-full pl-11 pr-4 py-3 border border-elegant-green/30 bg-elegant-lightgray/50 text-elegant-charcoal rounded-md shadow-sm focus:ring-2 focus:ring-elegant-green focus:border-elegant-green transition" />
                                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-elegant-green">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Gender --}}
                            <div>
                                <label class="block text-sm font-medium text-elegant-charcoal mb-1">Gender</label>
                                <select name="gender"
                                    class="w-full px-4 py-3 border border-elegant-green/30 bg-elegant-lightgray/50 text-elegant-charcoal rounded-md shadow-sm focus:ring-2 focus:ring-elegant-green focus:border-elegant-green transition">
                                    <option value="male" {{ $user->gender === 'male' ? 'selected' : '' }}>Male
                                    </option>
                                    <option value="female" {{ $user->gender === 'female' ? 'selected' : '' }}>Female
                                    </option>
                                </select>
                            </div>

                            {{-- Address - full width --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-elegant-charcoal mb-1">Address</label>
                                <textarea name="address" rows="2" placeholder="Enter your address"
                                    class="w-full px-4 py-3 border border-elegant-green/30 bg-elegant-lightgray/50 text-elegant-charcoal placeholder-gray-400 rounded-md shadow-sm focus:ring-2 focus:ring-elegant-green focus:border-elegant-green transition">{{ $user->address }}</textarea>
                            </div>

                            {{-- Tombol --}}
                            <div class="md:col-span-2">
                                <button type="submit"
                                    class="w-full bg-elegant-green text-white py-3 rounded-md shadow hover:bg-elegant-green/90 transition font-semibold">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>


                    </div>
                    <div id="tab-riwayat" class="hidden">
                        @livewire('table.guest-reservasi-table', ['guestId' => $user->id_guest])
                    </div>
                </div>
            </div>
        </div>

        <!-- FontAwesome -->
        <script src="https://kit.fontawesome.com/your-kit-code.js" crossorigin="anonymous"></script>

        <!-- Script -->
        <script>
            function toggleGuestModal() {
                const modal = document.getElementById('guest-modal');
                const content = document.getElementById('guest-modal-content');

                if (modal.classList.contains('hidden')) {
                    modal.classList.remove('hidden');
                    setTimeout(() => {
                        content.classList.remove('opacity-0', 'scale-95');
                        content.classList.add('opacity-100', 'scale-100');
                    }, 10);
                } else {
                    content.classList.remove('opacity-100', 'scale-100');
                    content.classList.add('opacity-0', 'scale-95');
                    setTimeout(() => {
                        modal.classList.add('hidden');
                    }, 300);
                }
            }

            function switchTab(tab) {
                const profil = document.getElementById('tab-profil');
                const riwayat = document.getElementById('tab-riwayat');
                const buttons = document.querySelectorAll('#guest-tabs .tab-btn');

                if (tab === 'profil') {
                    profil.classList.remove('hidden');
                    riwayat.classList.add('hidden');
                    buttons[0].classList.add('text-elegant-green', 'border-b-2', 'border-elegant-green', 'font-semibold');
                    buttons[1].classList.remove('text-elegant-green', 'border-b-2', 'border-elegant-green',
                        'font-semibold');
                } else {
                    profil.classList.add('hidden');
                    riwayat.classList.remove('hidden');
                    buttons[0].classList.remove('text-elegant-green', 'border-b-2', 'border-elegant-green',
                        'font-semibold');
                    buttons[1].classList.add('text-elegant-green', 'border-b-2', 'border-elegant-green', 'font-semibold');
                }
            }

            document.getElementById('guest-modal').addEventListener('click', function(e) {
                if (e.target.id === 'guest-modal') {
                    toggleGuestModal();
                }
            });
        </script>
    @endif
    @livewireScripts

</body>

</html>
