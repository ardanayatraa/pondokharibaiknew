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

    <!-- Production-ready Tailwind CSS -->
    @if (app()->environment('production'))
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Cormorant:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap">
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Axios CDN -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>

    @livewireStyles

    <script>
        @if (!app()->environment('production'))
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
                            'about-pattern': "url('/assets/bg-section.JPG')",
                            'family-bungalow': "url('https://images.unsplash.com/photo-1590490360182-c33d57733427?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')",
                            'family-garden': "url('https://images.unsplash.com/photo-1578683010236-d716f9a3f461?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')",
                            'twins-garden': "url('https://images.unsplash.com/photo-1595576508898-0ad5c879a061?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')",
                            'pattern-bg': "url('data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%233F7D58' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')"
                        }
                    }
                }
            }
        @endif
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

        /* Avatar styles */
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #3F7D58;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #3F7D58;
            color: white;
            font-weight: bold;
            font-size: 16px;
        }

        .user-avatar:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(63, 125, 88, 0.3);
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        /* New booking modal styles */
        .booking-step-icon {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            margin-right: 12px;
        }

        .booking-step-active .booking-step-icon {
            background-color: #EF9651;
            color: white;
        }

        .booking-step-inactive .booking-step-icon {
            background-color: #E5E7EB;
            color: #6B7280;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #D1D5DB;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: #3F7D58;
            box-shadow: 0 0 0 3px rgba(63, 125, 88, 0.1);
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-label.required::after {
            content: ' *';
            color: #EF4444;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6B7280;
            font-size: 16px;
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon .form-input {
            padding-left: 40px;
        }

        .payment-method-card {
            border: 1px solid #D1D5DB;
            border-radius: 8px;
            padding: 16px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .payment-method-card:hover {
            border-color: #3F7D58;
        }

        .payment-method-card.selected {
            border-color: #3F7D58;
            background-color: #F0F9F4;
        }

        .step-progress {
            height: 4px;
            background-color: #E5E7EB;
            border-radius: 2px;
            overflow: hidden;
        }

        .step-progress-bar {
            height: 100%;
            background-color: #EF9651;
            transition: width 0.3s ease;
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

    @php
        $currentGuestId = Auth::guard('guest')->check() ? Auth::guard('guest')->user()->id_guest : null;
    @endphp

    <script>
        window.guestId = {{ $currentGuestId ?? 'null' }};

        @if ($currentGuestId)
            window.guestUpdateUrl = "/guest/{{ $currentGuestId }}";
        @else
            window.guestUpdateUrl = null;
        @endif

        // Initialize CSRF header for axios
        if (typeof axios !== 'undefined') {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content');
        }
    </script>

    <script src="/dist/general.js" defer></script>
    <script src="/dist/stepper.js" defer></script>
</head>

<body class="font-montserrat text-elegant-charcoal bg-white bg-pattern-bg">
    <!-- Header -->
    <header class="fixed w-full z-30 bg-white/95 backdrop-blur-md shadow-md transition-all duration-300 py-4"
        id="header">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('assets/logo.png') }}" alt="Pondok Hari Baik Logo"
                        class="h-12 w-12 object-contain">
                    <div>
                        <h1 class="text-xl font-cormorant font-bold text-elegant-green">Pondok Hari Baik</h1>
                        <p class="text-xs text-elegant-gray">Luxury Villa in Balian, Bali</p>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="#home"
                        class="text-elegant-charcoal hover:text-elegant-green transition-colors duration-300 font-medium">Home</a>
                    <a href="#villas"
                        class="text-elegant-charcoal hover:text-elegant-green transition-colors duration-300 font-medium">Villas</a>
                    <a href="#facilities"
                        class="text-elegant-charcoal hover:text-elegant-green transition-colors duration-300 font-medium">Facilities</a>
                    <a href="#location"
                        class="text-elegant-charcoal hover:text-elegant-green transition-colors duration-300 font-medium">Location</a>
                </nav>

                <!-- User Section -->
                <div class="flex items-center space-x-4">
                    @if (Auth::guard('guest')->check())
                        <!-- User Avatar -->
                        <div class="user-avatar" onclick="toggleGuestModal()">
                            {{ strtoupper(substr(Auth::guard('guest')->user()->full_name, 0, 1)) }}
                        </div>
                    @else
                        <!-- Login/Register Buttons -->
                        <div class="hidden md:flex items-center space-x-3">
                            <a href="/login"
                                class="text-elegant-charcoal hover:text-elegant-green transition-colors duration-300 font-medium">Login</a>
                            <a href="/register"
                                class="bg-elegant-green text-white px-4 py-2 rounded-lg hover:bg-elegant-green/90 transition-colors duration-300 font-medium">Register</a>
                        </div>
                    @endif

                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-button"
                        class="md:hidden text-elegant-charcoal hover:text-elegant-green transition-colors duration-300">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="md:hidden mt-4 pb-4 border-t border-elegant-gray/20 hidden">
                <nav class="flex flex-col space-y-3 mt-4">
                    <a href="#home"
                        class="text-elegant-charcoal hover:text-elegant-green transition-colors duration-300 font-medium">Home</a>
                    <a href="#villas"
                        class="text-elegant-charcoal hover:text-elegant-green transition-colors duration-300 font-medium">Villas</a>
                    <a href="#facilities"
                        class="text-elegant-charcoal hover:text-elegant-green transition-colors duration-300 font-medium">Facilities</a>
                    <a href="#location"
                        class="text-elegant-charcoal hover:text-elegant-green transition-colors duration-300 font-medium">Location</a>
                    @if (!Auth::guard('guest')->check())
                        <div class="flex flex-col space-y-2 pt-3 border-t border-elegant-gray/20">
                            <a href="/login"
                                class="text-elegant-charcoal hover:text-elegant-green transition-colors duration-300 font-medium">Login</a>
                            <a href="/register"
                                class="bg-elegant-green text-white px-4 py-2 rounded-lg hover:bg-elegant-green/90 transition-colors duration-300 font-medium text-center">Register</a>
                        </div>
                    @endif
                </nav>
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


    <!-- Villas Section -->
    <section id="villas" class="py-24 bg-white bg-pattern-bg">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16 animate-hidden">
                <h2 class="text-4xl md:text-5xl font-cormorant font-bold text-elegant-charcoal mb-4">Our Villas</h2>
                <div class="decorative-line w-24 mx-auto mb-6"></div>
                <p class="text-lg text-elegant-gray max-w-2xl mx-auto">
                    Choose from our carefully curated selection of luxury accommodations, each designed to provide the
                    ultimate comfort and serenity
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($villa as $v)
                    <div
                        class="elegant-card bg-white rounded-xl overflow-hidden subtle-shadow animate-hidden delay-{{ $loop->index * 100 }}">
                        <div class="relative overflow-hidden">
                            <img src="{{ asset('storage/' . $v->picture) }}" alt="{{ $v->name }}"
                                class="w-full h-64 object-cover transition-transform duration-500 hover:scale-110">
                            <div
                                class="absolute top-4 right-4 bg-elegant-green text-white px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $v->tag }}
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-2xl font-cormorant font-bold text-elegant-charcoal mb-3">
                                {{ $v->name }}</h3>
                            <p class="text-elegant-gray mb-4 leading-relaxed">{{ $v->description }}</p>
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center text-elegant-gray">
                                    <i class="fas fa-users mr-2"></i>
                                    <span>Up to {{ $v->capacity }} guests</span>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-elegant-green">Rp
                                        {{ number_format($v->today_price, 0, ',', '.') }}</div>
                                    <div class="text-sm text-elegant-gray">per night</div>
                                </div>
                            </div>
                            <button
                                class="book-now-btn w-full bg-elegant-green text-white py-3 rounded-lg font-semibold hover:bg-elegant-green/90 transition-all duration-300 btn-elegant"
                                data-room-id="{{ $v->id_villa }}">
                                Book Now
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Facilities Section -->
    <section id="facilities" class="py-24 bg-elegant-green text-elegant-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16 animate-hidden">
                <span class="text-elegant-orange text-sm uppercase tracking-widest">Facilities</span>
                <h2 class="font-cormorant text-4xl md:text-5xl font-bold mb-4 tracking-wide text-elegant-white">
                    Premium Facilities
                </h2>
                <div class="decorative-line w-40 mx-auto mt-4"></div>
                <p class="text-lg mt-6 max-w-3xl mx-auto text-elegant-white/80">
                    Enjoy our world-class facilities designed for your comfort and relaxation
                </p>
            </div>
            <div class="flex flex-wrap justify-center gap-3 mb-10">
                @foreach($facilities as $facility)
                    <span class="inline-block px-4 py-2 rounded-full bg-elegant-white/90 text-elegant-burgundy font-semibold shadow hover:bg-elegant-gold hover:text-elegant-white transition-all duration-200 border border-elegant-gold text-sm">
                        {{ $facility->name_facility }}
                    </span>
                @endforeach
            </div>
            <!-- (Optional) Tambahkan deskripsi atau grid lain di bawah badge jika ingin -->
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
        class="py-24 bg-elegant-redorange text-elegant-white bg-[url('/assets/bg-section.JPG')] bg-cover bg-center relative">
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
                        <li><a href="#villas"
                                class="text-elegant-white hover:text-elegant-orange transition-colors duration-300">Villas</a>
                        </li>
                        <li><a href="#facilities"
                                class="text-elegant-white hover:text-elegant-orange transition-colors duration-300">Facilities</a>
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
        <div id="modal-backdrop" class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div id="modal-content"
                class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden opacity-0 scale-95 transition-all duration-300">
                <!-- Modal Header -->
                <div class="bg-elegant-green text-white p-6 relative">
                    <h3 class="text-2xl font-cormorant font-bold text-elegant-gold">Book Your Luxury Stay</h3>
                    <p class="text-sm opacity-90 mt-1">Experience the tranquility of Bali in our luxurious villa with
                        stunning views and exceptional service</p>
                    <button id="close-modal" class="absolute top-4 right-4 text-white hover:text-gray-200 text-2xl">
                        <i class="fas fa-times"></i>
                    </button>
                    <!-- Progress Bar -->
                    <div class="mt-4">
                        <div class="step-progress">
                            <div id="progress-bar" class="step-progress-bar" style="width: 20%"></div>
                        </div>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-6 overflow-y-auto max-h-[calc(90vh-200px)]">
                    <!-- Step 1: Date Selection -->
                    <div id="step-1" class="step-content">
                        <div class="flex items-center mb-6 booking-step-active">
                            <div class="booking-step-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <h4 class="text-xl font-semibold text-elegant-charcoal">Select Your Dates</h4>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="form-label">Check-in Date</label>
                                <div class="input-with-icon">
                                    <i class="input-icon fas fa-calendar"></i>
                                    <input type="text" id="check-in" class="form-input"
                                        placeholder="Select check-in date">
                                </div>
                                <div id="check-in-error" class="error-message hidden">Please select a check-in date
                                </div>
                            </div>
                            <div>
                                <label class="form-label">Check-out Date</label>
                                <div class="input-with-icon">
                                    <i class="input-icon fas fa-calendar"></i>
                                    <input type="text" id="check-out" class="form-input"
                                        placeholder="Select check-out date">
                                </div>
                                <div id="check-out-error" class="error-message hidden">Please select a check-out date
                                </div>
                            </div>
                        </div>
                        <div id="date-range-error" class="error-message hidden mb-4">Check-out date must be after
                            check-in date</div>

                        <!-- Selected Room -->
                        <div class="bg-gray-50 rounded-lg p-4 mb-6">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <i class="fas fa-home text-elegant-orange mr-2"></i>
                                    <span class="font-semibold text-elegant-charcoal">Selected Room</span>
                                </div>
                                <button id="change-room-btn"
                                    class="text-elegant-green hover:underline text-sm">Change</button>
                            </div>
                            <h5 id="selected-room-name" class="font-semibold text-lg mb-2">Family Bungallo</h5>
                            <div id="calc-status" class="text-sm text-gray-600"></div>
                            <div id="calc-total" class="hidden">
                                <div class="text-2xl font-bold text-elegant-green" id="calc-amount">Rp 5.650.000</div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Room Details -->
                    <div id="step-2" class="step-content hidden">
                        <div class="flex items-center mb-6 booking-step-active">
                            <div class="booking-step-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <h4 class="text-xl font-semibold text-elegant-charcoal">Room Details</h4>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
                            <div class="grid md:grid-cols-2 gap-6">
                                <!-- Room Image and Info -->
                                <div>
                                    <img id="room-image" src="/placeholder.svg?height=200&width=300" alt="Room"
                                        class="w-full h-48 object-cover rounded-lg mb-4">
                                    <h5 id="room-detail-name" class="text-xl font-semibold mb-2 text-elegant-green">
                                        Family Bungallo</h5>
                                    <p id="room-description" class="text-gray-600 mb-4">This air-conditioned family
                                        room has a desk, a terrace, garden views and a private bathroom. The unit has 2
                                        beds.</p>
                                    <div id="room-facilities" class="flex flex-wrap gap-2 mb-2"></div>
                                </div>

                                <!-- Booking Summary -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex items-center mb-4">
                                        <i class="fas fa-clipboard-list text-elegant-orange mr-2"></i>
                                        <h5 class="font-semibold">Booking Summary</h5>
                                    </div>

                                    <div class="space-y-3 mb-4">
                                        <h6 class="font-medium text-elegant-green">Stay Details</h6>
                                        <div class="space-y-2 text-sm">
                                            <div class="flex items-center">
                                                <i class="fas fa-calendar text-elegant-orange mr-2 w-4"></i>
                                                <span class="text-gray-600">Check-in:</span>
                                                <span id="summary-checkin"
                                                    class="ml-auto font-medium">2025-06-28</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-calendar text-elegant-orange mr-2 w-4"></i>
                                                <span class="text-gray-600">Check-out:</span>
                                                <span id="summary-checkout"
                                                    class="ml-auto font-medium">2025-07-04</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-moon text-elegant-orange mr-2 w-4"></i>
                                                <span class="text-gray-600">Nights:</span>
                                                <span id="summary-nights" class="ml-auto font-medium">6</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-y-3">
                                        <h6 class="font-medium text-elegant-green">Price Details</h6>
                                        <div class="space-y-2 text-sm">
                                            <div class="flex justify-between">
                                                <span id="room-rate-label" class="text-gray-600">Total Rate for 6
                                                    nights:</span>
                                                <span id="room-rate-total" class="font-medium">Rp 5.650.000</span>
                                            </div>
                                            <hr class="border-gray-300">
                                            <div class="flex justify-between font-bold text-lg">
                                                <span class="text-elegant-green">Total:</span>
                                                <span id="summary-total" class="text-elegant-green">Rp
                                                    5.650.000</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Guest Information -->
                    <div id="step-3" class="step-content hidden">
                        <div class="flex items-center mb-6 booking-step-active">
                            <div class="booking-step-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <h4 class="text-xl font-semibold text-elegant-charcoal">Guest Information</h4>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="form-label required">Username</label>
                                <div class="input-with-icon">
                                    <i class="input-icon fas fa-user"></i>
                                    <input type="text" id="guest-username" class="form-input" placeholder="guest"
                                        required>
                                </div>
                            </div>
                            <div>
                                <label class="form-label required">Full Name</label>
                                <div class="input-with-icon">
                                    <i class="input-icon fas fa-user"></i>
                                    <input type="text" id="guest-name" class="form-input"
                                        placeholder="I gst md putra yasa n" required>
                                </div>
                            </div>
                            <div>
                                <label class="form-label required">Email Address</label>
                                <div class="input-with-icon">
                                    <i class="input-icon fas fa-envelope"></i>
                                    <input type="email" id="guest-email" class="form-input"
                                        placeholder="itsriaa.id@gmail.com" required>
                                </div>
                            </div>
                            <div>
                                <label class="form-label required">Phone Number</label>
                                <div class="input-with-icon">
                                    <i class="input-icon fas fa-phone"></i>
                                    <input type="tel" id="guest-phone" class="form-input"
                                        placeholder="082247467123" required>
                                </div>
                            </div>
                            <div>
                                <label class="form-label">Address</label>
                                <div class="input-with-icon">
                                    <i class="input-icon fas fa-map-marker-alt"></i>
                                    <textarea id="guest-address" rows="3" class="form-input" placeholder="jl teratai"></textarea>
                                </div>
                            </div>
                            <div>
                                <label class="form-label">ID Card Number</label>
                                <div class="input-with-icon">
                                    <i class="input-icon fas fa-id-card"></i>
                                    <input type="text" id="guest-id-card" class="form-input"
                                        placeholder="327508120899001">
                                </div>
                            </div>
                            <div>
                                <label class="form-label">Passport Number</label>
                                <div class="input-with-icon">
                                    <i class="input-icon fas fa-passport"></i>
                                    <input type="text" id="guest-passport" class="form-input"
                                        placeholder="X1234678">
                                </div>
                            </div>
                            <div>
                                <label class="form-label">Birthdate</label>
                                <div class="input-with-icon">
                                    <i class="input-icon fas fa-calendar"></i>
                                    <input type="date" id="guest-birthdate" class="form-input"
                                        value="2005-01-08">
                                </div>
                            </div>
                            <div class="md:col-span-2">
                                <label class="form-label">Gender</label>
                                <div class="input-with-icon">
                                    <i class="input-icon fas fa-venus-mars"></i>
                                    <select id="guest-gender" class="form-input">
                                        <option value="">Select Gender</option>
                                        <option value="male" selected>Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Payment -->
                    <div id="step-4" class="step-content hidden">
                        <div class="flex items-center mb-6 booking-step-active">
                            <div class="booking-step-icon">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <h4 class="text-xl font-semibold text-elegant-charcoal">Payment Information</h4>
                        </div>

                        <div class="grid md:grid-cols-2 gap-8">
                            <!-- Payment Summary -->
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h5 class="text-lg font-semibold mb-4 text-elegant-green">Payment Summary</h5>
                                <div class="space-y-3 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Villa Name:</span>
                                        <span id="payment-villa-name" class="font-medium text-elegant-green">Family
                                            Bungallo</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Check-in Date:</span>
                                        <span id="payment-checkin" class="font-medium">2025-06-28</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Check-out Date:</span>
                                        <span id="payment-checkout" class="font-medium">2025-07-04</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Number of Nights:</span>
                                        <span id="payment-nights" class="font-medium">6 nights</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600" id="payment-nights-label">Room Rate (6
                                            nights):</span>
                                        <span id="payment-room-rate" class="font-medium">Rp 5.650.000</span>
                                    </div>
                                    <hr class="border-gray-300">
                                    <div class="flex justify-between text-lg font-bold">
                                        <span class="text-elegant-green">Total Amount:</span>
                                        <span id="payment-total" class="text-elegant-green">Rp 5.650.000</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div>
                                <h5 class="text-lg font-semibold mb-4 text-elegant-green">Payment Method</h5>
                                <div class="payment-method-card selected">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <input type="radio" id="midtrans" name="payment-method"
                                                value="midtrans" checked class="text-elegant-green mr-3">
                                            <div>
                                                <div class="font-medium">Midtrans</div>
                                                <div class="text-sm text-gray-600">Credit Card, Bank Transfer, E-Wallet
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <button id="btn-paynow"
                                    class="w-full mt-6 bg-elegant-green text-white py-3 rounded-lg font-semibold hover:bg-elegant-green/90 transition-all duration-300 btn-elegant">
                                    Pay Now
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 5: Confirmation -->
                    <div id="step-5" class="step-content hidden">
                        <div class="text-center py-8">
                            <div
                                class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-check text-2xl text-green-600"></i>
                            </div>
                            <h4 class="text-2xl font-semibold text-elegant-charcoal mb-4">Booking Confirmed!</h4>
                            <p class="text-gray-600 mb-6">Thank you for your booking. You will receive a confirmation
                                email shortly.</p>

                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="bg-gray-50 px-6 py-4 flex justify-between items-center">
                    <button id="prev-step"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-300 hidden">
                        <i class="fas fa-arrow-left mr-2"></i>Previous
                    </button>
                    <button id="next-step"
                        class="px-6 py-2 bg-elegant-green text-white rounded-lg hover:bg-elegant-green/90 transition-colors duration-300">
                        <div class="flex items-center">
                            <span>Next</span>
                            <i class="fas fa-arrow-right ml-2"></i>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if (Auth::guard('guest')->check())
        @livewire('villa.action-reservation')

        <!-- Guest Modal -->
        <div id="guest-modal"
            class="fixed inset-0 backdrop-blur-sm bg-black/30 flex items-center justify-center z-40 hidden">
            <div id="guest-modal-content"
                class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl mx-4 max-h-[90vh] overflow-hidden opacity-0 scale-95 transition-all duration-300">
                <!-- Header -->
                <div class="bg-elegant-green text-white p-6 relative">
                    <h2 class="text-2xl font-cormorant font-bold">My Account</h2>
                    <button onclick="toggleGuestModal()"
                        class="absolute top-4 right-4 text-white hover:text-gray-200 text-2xl">
                        <i class="fas fa-times"></i>
                    </button>

                    <form action="{{ route('logout') }}" method="POST">

                        @csrf
                        <button type="submit"
                            class="absolute top-4 right-16 text-white hover:text-gray-200 text-2xl">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>

                <!-- Tabs -->
                <div id="guest-tabs" class="border-b border-gray-200">
                    <div class="flex">
                        <button onclick="switchTab('profil')"
                            class="tab-btn px-6 py-3 text-elegant-green border-b-2 border-elegant-green font-semibold">
                            Profile
                        </button>
                        <button onclick="switchTab('riwayat')"
                            class="tab-btn px-6 py-3 text-gray-600 hover:text-elegant-green">
                            Booking History
                        </button>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6 max-h-[calc(90vh-200px)] overflow-y-auto">
                    <!-- Profile Tab -->
                    <div id="tab-profil">
                        <h3 class="text-xl font-semibold mb-6">Profile Information</h3>
                        <form id="guest-profile-form" class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                                <input type="text" id="modal-guest-username"
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-elegant-green focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                <input type="text" id="modal-guest-name"
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-elegant-green focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" id="modal-guest-email"
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-elegant-green focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                <input type="tel" id="modal-guest-phone"
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-elegant-green focus:border-transparent">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                <textarea id="modal-guest-address" rows="3"
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-elegant-green focus:border-transparent"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">ID Card Number</label>
                                <input type="text" id="modal-guest-id-card"
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-elegant-green focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Passport Number</label>
                                <input type="text" id="modal-guest-passport"
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-elegant-green focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Birthdate</label>
                                <input type="date" id="modal-guest-birthdate"
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-elegant-green focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                                <select id="modal-guest-gender"
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-elegant-green focus:border-transparent">
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div class="md:col-span-2 flex justify-end space-x-4">
                                <button type="button" onclick="toggleGuestModal()"
                                    class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-300">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-6 py-2 bg-elegant-green text-white rounded-lg hover:bg-elegant-green/90 transition-colors duration-300">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Booking History Tab -->
                    <div id="tab-riwayat" class="hidden">
                        <h3 class="text-xl font-semibold mb-6">Booking History</h3>
                        @if ($reservation && count($reservation) > 0)
                            <div class="space-y-4">
                                @foreach ($reservation as $res)
                                    <div
                                        class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="font-semibold text-lg">{{ $res->villa->name }}</h4>
                                                <p class="text-gray-600">
                                                    {{ \Carbon\Carbon::parse($res->start_date)->format('d M Y') }} -
                                                    {{ \Carbon\Carbon::parse($res->end_date)->format('d M Y') }}</p>
                                                <p class="text-sm text-gray-500">
                                                    {{ \Carbon\Carbon::parse($res->start_date)->diffInDays(\Carbon\Carbon::parse($res->end_date)) }}
                                                    nights</p>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-lg font-bold text-elegant-green">Rp
                                                    {{ number_format($res->total_amount, 0, ',', '.') }}</div>
                                                <div class="text-sm">
                                                    <span
                                                        class="px-2 py-1 rounded-full text-xs font-medium
                                                        @if ($res->status === 'confirmed') bg-green-100 text-green-800
                                                        @elseif($res->status === 'rescheduled') bg-blue-100 text-blue-800
                                                        @elseif($res->status === 'pending') bg-yellow-100 text-yellow-800
                                                        @else bg-red-100 text-red-800 @endif">
                                                        @if ($res->status === 'rescheduled')
                                                            Rescheduled
                                                        @else
                                                            {{ ucfirst($res->status) }}
                                                        @endif
                                                    </span>
                                                </div>
                                                <button
                                                    onclick="Livewire.dispatch('openModal', [{{ $res->id_reservation }}])"
                                                    class="mt-2 text-elegant-green hover:underline text-sm">
                                                    View Details
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-calendar-times text-4xl text-gray-400 mb-4"></i>
                                <p class="text-gray-600">No booking history found</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Script untuk Guest Modal -->
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

                    // Load guest info when modal opens
                    loadGuestInfoToModal();
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
                    buttons[1].classList.remove('text-elegant-green', 'border-b-2', 'border-elegant-green', 'font-semibold');
                } else {
                    profil.classList.add('hidden');
                    riwayat.classList.remove('hidden');
                    buttons[0].classList.remove('text-elegant-green', 'border-b-2', 'border-elegant-green', 'font-semibold');
                    buttons[1].classList.add('text-elegant-green', 'border-b-2', 'border-elegant-green', 'font-semibold');
                }
            }

            // Load guest info to modal
            async function loadGuestInfoToModal() {
                if (!window.guestId) return;

                try {
                    const res = await fetch(`/guestbyID/${window.guestId}`);
                    if (!res.ok) throw new Error(res.status);

                    const guest = await res.json();

                    // Update modal form fields
                    const modalFields = {
                        "modal-guest-username": guest.username,
                        "modal-guest-name": guest.full_name,
                        "modal-guest-email": guest.email,
                        "modal-guest-phone": guest.phone_number,
                        "modal-guest-address": guest.address,
                        "modal-guest-id-card": guest.id_card_number,
                        "modal-guest-passport": guest.passport_number,
                        "modal-guest-birthdate": guest.birthdate,
                        "modal-guest-gender": guest.gender,
                    };

                    Object.entries(modalFields).forEach(([id, value]) => {
                        const el = document.getElementById(id);
                        if (el) el.value = value || "";
                    });
                } catch (error) {
                    console.warn("Failed to load guest info to modal:", error);
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

    <!-- Load reschedule script after other scripts -->
    <script src="/dist/reschedule.js" defer></script>
    <script src="/dist/profile-update.js" defer></script>
</body>

</html>
