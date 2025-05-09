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
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


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

        /* Custom styles for the booking stepper */
        .step-content {
            transition: opacity 0.3s ease;
        }

        /* Payment radio button styles */
        .payment-option input:checked~label .payment-radio {
            border-color: #5E1224;
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
            border: 3px solid rgba(192, 160, 98, 0.3);
            border-radius: 50%;
            border-top: 3px solid #C0A062;
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

    <script src="/dist/general.js" defer></script>
    <script src="/dist/stepper.js" defer></script>
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
                <button class="lg:hidden text-elegant-gold focus:outline-none" id="mobile-menu-button">
                    <i class="fas fa-bars text-2xl"></i>
                </button>

                <nav class="hidden lg:flex items-center space-x-8">
                    <a href="#home"
                        class="text-elegant-gold hover:text-elegant-white transition-colors duration-300 font-medium">Home</a>
                    <a href="#about"
                        class="text-elegant-gold hover:text-elegant-white transition-colors duration-300 font-medium">About</a>
                    <a href="#rooms"
                        class="text-elegant-gold hover:text-elegant-white transition-colors duration-300 font-medium">Rooms</a>
                    <a href="#amenities"
                        class="text-elegant-gold hover:text-elegant-white transition-colors duration-300 font-medium">Amenities</a>
                    <a href="#location"
                        class="text-elegant-gold hover:text-elegant-white transition-colors duration-300 font-medium">Location</a>
                    <a href="#"
                        class="bg-elegant-burgundy hover:bg-elegant-burgundy/80
                              text-elegant-white px-6 py-2 transition-all duration-300
                              btn-elegant border border-elegant-gold">
                        Login
                    </a>
                </nav>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="lg:hidden hidden bg-elegant-navy shadow-lg absolute w-full left-0 z-20 transition-all duration-300 border-t border-elegant-gold/20"
            id="mobile-menu">
            <div class="container mx-auto px-4 py-4 flex flex-col space-y-4">
                <a href="#home"
                    class="text-elegant-gold hover:text-elegant-white transition-colors duration-300 font-medium py-2 border-b border-elegant-gold/20">Home</a>
                <a href="#about"
                    class="text-elegant-gold hover:text-elegant-white transition-colors duration-300 font-medium py-2 border-b border-elegant-gold/20">About</a>
                <a href="#rooms"
                    class="text-elegant-gold hover:text-elegant-white transition-colors duration-300 font-medium py-2 border-b border-elegant-gold/20">Rooms</a>
                <a href="#amenities"
                    class="text-elegant-gold hover:text-elegant-white transition-colors duration-300 font-medium py-2 border-b border-elegant-gold/20">Amenities</a>
                <a href="#location"
                    class="text-elegant-gold hover:text-elegant-white transition-colors duration-300 font-medium py-2 border-b border-elegant-gold/20">Location</a>
                <a href="#"
                    class="bg-elegant-burgundy hover:bg-elegant-burgundy/80
                          text-elegant-white px-6 py-2 transition-all duration-300
                          btn-elegant border border-elegant-gold">
                    Login
                </a>
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
                    Welcome to <span class="text-elegant-gold">Pondok Hari Baik</span>
                </h1>
                <div class="w-20 h-px bg-elegant-gold mx-auto"></div>
            </div>
            <p class="text-xl md:text-2xl text-elegant-white mb-10 w-full mx-auto animate-hidden delay-200 font-light">
                Experience the tranquility of Bali in our luxurious villa with stunning views and exceptional service
            </p>
            <button id="hero-book-btn"
                class="inline-block bg-transparent border border-elegant-gold text-elegant-gold hover:bg-elegant-gold hover:text-elegant-navy px-8 py-4 text-lg font-medium transition-all duration-300 animate-hidden delay-300 btn-elegant">
                Book Your Stay
                <i class="fas fa-arrow-right ml-2"></i>
            </button>
        </div>
    </section>

    <!-- Rooms Section -->
    <section id="rooms" class="py-24 bg-elegant-cream bg-pattern-bg">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16 animate-hidden">
                <span class="text-elegant-gold text-sm uppercase tracking-widest">Accommodation</span>
                <h2 class="font-cormorant text-4xl md:text-5xl font-bold text-elegant-burgundy mb-4 tracking-wide">
                    Our Luxurious Rooms</h2>
                <div class="decorative-line w-40 mx-auto mt-4"></div>
                <p class="text-lg mt-6 w-full mx-auto text-elegant-charcoal">
                    Discover our elegantly designed rooms offering comfort, privacy, and stunning views</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach ($villa as $item)
                    <!-- Room 1 -->
                    <div
                        class="bg-elegant-white border border-elegant-gold/30 overflow-hidden shadow-md transform hover:scale-105 transition-all duration-500 animate-hidden elegant-card">
                        <div class="relative">
                            <div class="bg-family-bungalow bg-cover bg-center h-72"></div>

                        </div>
                        <div class="p-8">
                            <h3 class="font-cormorant text-2xl font-bold text-elegant-burgundy mb-2">{{ $item->name }}
                            </h3>
                            <div class="flex items-center mb-4">

                            </div>
                            <div class="flex items-center mb-6">
                                <i class="fas fa-user-friends text-elegant-gold mr-2"></i>
                                <span class="text-elegant-charcoal">Maximum capacity {{ $item->capacity }}
                                    people</span>
                            </div>
                            <ul class="mb-6 space-y-2 text-elegant-charcoal">
                                <li class="flex items-center">
                                    <i class="fas fa-check text-elegant-gold mr-2"></i>
                                    <span>AC & Flat Screen TV</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check text-elegant-gold mr-2"></i>
                                    <span>Private Balcony</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check text-elegant-gold mr-2"></i>
                                    <span>Private Bathroom</span>
                                </li>
                            </ul>
                            <button
                                class="book-now-btn block text-center bg-elegant-burgundy hover:bg-elegant-burgundy/80 text-elegant-white px-6 py-3 transition-all duration-300 btn-elegant w-full"
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

    <!-- CTA Section -->
    <section
        class="py-24 bg-elegant-burgundy text-elegant-white bg-[url('https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')] bg-cover bg-center relative">
        <div class="absolute inset-0 bg-elegant-navy/80"></div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <div class="w-full mx-auto animate-hidden">
                <h2 class="font-cormorant text-4xl md:text-5xl font-bold mb-6 text-elegant-gold">
                    Ready for an Unforgettable Experience?</h2>
                <div class="w-20 h-px bg-elegant-gold mx-auto mb-6"></div>
                <p class="text-xl mb-10 text-elegant-white/90">Book your stay now and
                    enjoy the tranquility of Bali at Pondok Hari Baik</p>
                <button id="cta-book-btn"
                    class="inline-block bg-elegant-gold hover:bg-elegant-gold/80 text-elegant-navy px-8 py-4 text-lg font-medium transition-all duration-300 btn-elegant border border-elegant-white/20">
                    Book Your Stay
                    <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-elegant-navy text-elegant-white pt-16 pb-6 border-t border-elegant-gold/30">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-10">
                <div>
                    <h3 class="font-cormorant text-2xl font-bold text-elegant-gold mb-6">Pondok Hari Baik</h3>
                    <p class="mb-6 text-elegant-white/70">Luxury villa with
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
                    <h3 class="font-cormorant text-xl font-bold text-elegant-gold mb-6">
                        Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="#home"
                                class="text-elegant-white/70 hover:text-elegant-gold transition-colors duration-300">Home</a>
                        </li>
                        <li><a href="#about"
                                class="text-elegant-white/70 hover:text-elegant-gold transition-colors duration-300">About</a>
                        </li>
                        <li><a href="#rooms"
                                class="text-elegant-white/70 hover:text-elegant-gold transition-colors duration-300">Rooms</a>
                        </li>
                        <li><a href="#amenities"
                                class="text-elegant-white/70 hover:text-elegant-gold transition-colors duration-300">Amenities</a>
                        </li>
                        <li><a href="#location"
                                class="text-elegant-white/70 hover:text-elegant-gold transition-colors duration-300">Location</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-cormorant text-xl font-bold text-elegant-gold mb-6">
                        Contact</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt text-elegant-gold mt-1 mr-3"></i>
                            <span class="text-elegant-white/70">Jalan Raya Denpasar -
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

    <!-- Booking Stepper Modal -->
    <div id="booking-stepper-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <!-- Overlay with blur effect -->
            <div class="fixed inset-0 bg-elegant-black bg-opacity-60 backdrop-blur-sm transition-opacity"
                id="modal-backdrop"></div>

            <!-- Modal Content -->
            <div class="relative bg-elegant-cream max-w-5xl w-full mx-auto rounded-lg shadow-2xl overflow-hidden z-10 transform transition-all duration-500 scale-95 opacity-0"
                id="modal-content">
                <!-- Decorative elements -->
                <div
                    class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-elegant-gold/20 via-elegant-gold to-elegant-gold/20">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-elegant-gold/20 via-elegant-gold to-elegant-gold/20">
                </div>
                <div
                    class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-elegant-gold/20 via-elegant-gold to-elegant-gold/20">
                </div>
                <div
                    class="absolute top-0 right-0 w-1 h-full bg-gradient-to-b from-elegant-gold/20 via-elegant-gold to-elegant-gold/20">
                </div>

                <!-- Close Button -->
                <button id="close-modal"
                    class="absolute top-6 right-6 text-elegant-gold hover:text-elegant-burgundy transition-colors z-20 group">
                    <div class="relative">
                        <div
                            class="w-8 h-8 rounded-full bg-elegant-navy border border-elegant-gold/50 flex items-center justify-center group-hover:bg-elegant-burgundy transition-all duration-300">
                            <i class="fas fa-times"></i>
                        </div>
                        <div
                            class="absolute -inset-1 rounded-full border border-elegant-gold/30 group-hover:border-elegant-gold/50 opacity-0 group-hover:opacity-100 transition-all duration-300">
                        </div>
                    </div>
                </button>

                <!-- Header -->
                <div class="bg-elegant-navy p-8 border-b border-elegant-gold/30 relative overflow-hidden">
                    <!-- Decorative pattern -->
                    <div class="absolute inset-0 opacity-5">
                        <div class="absolute inset-0"
                            style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23C0A062\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                        </div>
                    </div>

                    <div class="relative">
                        <h3 class="font-cormorant text-3xl md:text-4xl font-bold text-elegant-gold mb-2">Book Your
                            Luxury Stay</h3>
                        <p class="text-elegant-white/80 max-w-2xl">Experience the tranquility of Bali in our luxurious
                            villa with stunning views and exceptional service</p>
                    </div>
                </div>

                <!-- Stepper Progress -->
                <div class="px-8 pt-8 pb-4 bg-elegant-cream">
                    <div class="relative">
                        <!-- Progress bar background -->
                        <div class="absolute top-1/2 left-0 w-full h-1 bg-elegant-gold/20 -translate-y-1/2"></div>

                        <!-- Active progress bar -->
                        <div id="progress-bar"
                            class="absolute top-1/2 left-0 h-1 bg-elegant-burgundy -translate-y-1/2 transition-all duration-500"
                            style="width: 0%"></div>

                        <!-- Step circles -->
                        <div class="relative flex justify-between">
                            <div class="stepper-node flex flex-col items-center">
                                <div
                                    class="stepper-circle flex items-center justify-center w-12 h-12 rounded-full bg-elegant-burgundy text-elegant-white font-bold border-4 border-elegant-cream relative z-10 shadow-lg transition-all duration-300">
                                    <span>1</span>
                                </div>
                                <div class="stepper-label mt-2 text-center">
                                    <span class="block text-sm font-medium text-elegant-burgundy">Availability</span>
                                </div>
                            </div>

                            <div class="stepper-node flex flex-col items-center">
                                <div
                                    class="stepper-circle flex items-center justify-center w-12 h-12 rounded-full bg-elegant-gold/30 text-elegant-navy font-bold border-4 border-elegant-cream relative z-10 shadow-lg transition-all duration-300">
                                    <span>2</span>
                                </div>
                                <div class="stepper-label mt-2 text-center">
                                    <span class="block text-sm font-medium text-elegant-charcoal">Room Details</span>
                                </div>
                            </div>

                            <div class="stepper-node flex flex-col items-center">
                                <div
                                    class="stepper-circle flex items-center justify-center w-12 h-12 rounded-full bg-elegant-gold/30 text-elegant-navy font-bold border-4 border-elegant-cream relative z-10 shadow-lg transition-all duration-300">
                                    <span>3</span>
                                </div>
                                <div class="stepper-label mt-2 text-center">
                                    <span class="block text-sm font-medium text-elegant-charcoal">Guest Info</span>
                                </div>
                            </div>

                            <div class="stepper-node flex flex-col items-center">
                                <div
                                    class="stepper-circle flex items-center justify-center w-12 h-12 rounded-full bg-elegant-gold/30 text-elegant-navy font-bold border-4 border-elegant-cream relative z-10 shadow-lg transition-all duration-300">
                                    <span>4</span>
                                </div>
                                <div class="stepper-label mt-2 text-center">
                                    <span class="block text-sm font-medium text-elegant-charcoal">Payment</span>
                                </div>
                            </div>

                            <div class="stepper-node flex flex-col items-center">
                                <div
                                    class="stepper-circle flex items-center justify-center w-12 h-12 rounded-full bg-elegant-gold/30 text-elegant-navy font-bold border-4 border-elegant-cream relative z-10 shadow-lg transition-all duration-300">
                                    <span>5</span>
                                </div>
                                <div class="stepper-label mt-2 text-center">
                                    <span class="block text-sm font-medium text-elegant-charcoal">Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step Content -->
                <div class="p-8 bg-elegant-cream min-h-[400px]">
                    <!-- Step 1: Check Availability -->
                    <div class="step-content" id="step-1">
                        <div class="max-w-4xl mx-auto">
                            <div class="flex items-center mb-6">
                                <div
                                    class="w-10 h-10 rounded-full bg-elegant-burgundy/10 flex items-center justify-center mr-4">
                                    <i class="fas fa-calendar-alt text-elegant-burgundy"></i>
                                </div>
                                <h4 class="font-cormorant text-2xl font-bold text-elegant-burgundy">Select Your Dates
                                </h4>
                            </div>

                            <div class="space-y-6">

                                {{-- Datepickers dalam grid --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                                    {{-- Check-in --}}
                                    <div
                                        class="bg-elegant-white p-6 rounded-lg shadow-md border border-elegant-gold/20 hover:border-elegant-gold/40 transition-all duration-300">
                                        <label for="check-in"
                                            class="block text-sm font-medium text-elegant-charcoal mb-2">Check-in Date
                                            <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <input type="text" id="check-in" name="start_date"
                                                class="w-full px-4 py-3 border border-elegant-gold/30 bg-elegant-cream/50 text-elegant-charcoal focus:outline-none focus:ring-2 focus:ring-elegant-gold rounded-md pl-10"
                                                placeholder="Pilih tanggal">
                                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-elegant-gold">
                                                <i class="fas fa-calendar-day"></i>
                                            </div>
                                        </div>
                                        <div id="check-in-error" class="text-sm text-red-600 mt-1 hidden">
                                            Please select a check-in date
                                        </div>
                                    </div>

                                    {{-- Check-out --}}
                                    <div
                                        class="bg-elegant-white p-6 rounded-lg shadow-md border border-elegant-gold/20 hover:border-elegant-gold/40 transition-all duration-300">
                                        <label for="check-out"
                                            class="block text-sm font-medium text-elegant-charcoal mb-2">Check-out Date
                                            <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <input type="text" id="check-out" name="end_date"
                                                class="w-full px-4 py-3 border border-elegant-gold/30 bg-elegant-cream/50 text-elegant-charcoal focus:outline-none focus:ring-2 focus:ring-elegant-gold rounded-md pl-10"
                                                placeholder="Pilih tanggal">
                                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-elegant-gold">
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




                            <div class="mt-8 bg-elegant-white p-6 rounded-lg shadow-md border border-elegant-gold/20">
                                <div class="flex items-center mb-4">
                                    <div
                                        class="w-8 h-8 rounded-full bg-elegant-burgundy/10 flex items-center justify-center mr-3">
                                        <i class="fas fa-home text-elegant-burgundy"></i>
                                    </div>
                                    <h5 class="font-cormorant text-xl font-bold text-elegant-burgundy">Selected Room
                                    </h5>
                                </div>
                                <div id="selected-room-info" class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-elegant-charcoal" id="selected-room-name">Family
                                            Bungalow</p>
                                        <p class="text-elegant-gold" id="selected-room-price">Rp 450.000 / night</p>
                                    </div>
                                    <button id="change-room-btn"
                                        class="text-elegant-burgundy hover:text-elegant-gold transition-colors">
                                        <i class="fas fa-exchange-alt mr-1"></i> Change
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Room Details -->
                    <div class="step-content hidden" id="step-2">
                        <div class="max-w-4xl mx-auto">
                            <div class="flex items-center mb-6">
                                <div
                                    class="w-10 h-10 rounded-full bg-elegant-burgundy/10 flex items-center justify-center mr-4">
                                    <i class="fas fa-home text-elegant-burgundy"></i>
                                </div>
                                <h4 class="font-cormorant text-2xl font-bold text-elegant-burgundy">Room Details</h4>
                            </div>

                            <div class="bg-elegant-white p-6 rounded-lg shadow-md border border-elegant-gold/20 mb-8">
                                <div class="flex flex-col md:flex-row">
                                    <div class="md:w-2/5 mb-4 md:mb-0 md:mr-6">
                                        <div class="relative rounded-lg overflow-hidden shadow-md group">
                                            <img id="room-image"
                                                src="https://images.unsplash.com/photo-1590490360182-c33d57733427?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                                                alt="Room"
                                                class="w-full h-64 object-cover transition-transform duration-700 group-hover:scale-110">
                                            <div
                                                class="absolute inset-0 bg-gradient-to-t from-elegant-navy/70 to-transparent">
                                            </div>
                                            <div class="absolute bottom-4 left-4 text-elegant-white">
                                                <div class="flex items-center">
                                                    <div class="text-elegant-gold">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star-half-alt"></i>
                                                    </div>
                                                    <span class="ml-2 text-sm">4.8/5</span>
                                                </div>
                                            </div>
                                            <div id="room-tag"
                                                class="absolute top-4 right-4 bg-elegant-gold text-elegant-navy px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                                                Popular
                                            </div>
                                        </div>
                                    </div>
                                    <div class="md:w-3/5">
                                        <h5 id="room-detail-name"
                                            class="font-cormorant text-2xl font-bold text-elegant-burgundy mb-2">Family
                                            Bungalow</h5>
                                        <div class="flex items-center mb-4">
                                            <div id="room-detail-price" class="text-elegant-gold text-xl font-bold">Rp
                                                450.000</div>
                                            <div class="text-elegant-gray ml-2">/night</div>
                                        </div>
                                        <p class="text-elegant-charcoal/80 mb-4" id="room-description">Luxurious
                                            bungalow with private
                                            balcony, perfect for families looking for comfort and privacy. Enjoy
                                            stunning views and premium amenities.</p>
                                        <div class="grid grid-cols-2 gap-2 mb-4">
                                            <div class="flex items-center">
                                                <i class="fas fa-user-friends text-elegant-gold mr-2"></i>
                                                <span id="room-capacity" class="text-elegant-charcoal">Up to 4
                                                    people</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-bed text-elegant-gold mr-2"></i>
                                                <span id="room-beds" class="text-elegant-charcoal">1 King + 2
                                                    Singles</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-bath text-elegant-gold mr-2"></i>
                                                <span class="text-elegant-charcoal">Private Bathroom</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-tv text-elegant-gold mr-2"></i>
                                                <span class="text-elegant-charcoal">Flat Screen TV</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center mb-6">
                                <div
                                    class="w-10 h-10 rounded-full bg-elegant-burgundy/10 flex items-center justify-center mr-4">
                                    <i class="fas fa-receipt text-elegant-burgundy"></i>
                                </div>
                                <h4 class="font-cormorant text-2xl font-bold text-elegant-burgundy">Booking Summary
                                </h4>
                            </div>

                            <div class="bg-elegant-white p-6 rounded-lg shadow-md border border-elegant-gold/20">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h6
                                            class="font-medium text-elegant-burgundy mb-4 pb-2 border-b border-elegant-gold/20">
                                            Stay Details</h6>
                                        <div class="space-y-3 text-elegant-charcoal">
                                            <div class="flex justify-between items-center">
                                                <div class="flex items-center">
                                                    <i class="fas fa-calendar-check text-elegant-gold mr-2"></i>
                                                    <span>Check-in:</span>
                                                </div>
                                                <span id="summary-checkin" class="font-medium">May 10, 2025</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <div class="flex items-center">
                                                    <i class="fas fa-calendar-times text-elegant-gold mr-2"></i>
                                                    <span>Check-out:</span>
                                                </div>
                                                <span id="summary-checkout" class="font-medium">May 15, 2025</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <div class="flex items-center">
                                                    <i class="fas fa-moon text-elegant-gold mr-2"></i>
                                                    <span>Nights:</span>
                                                </div>
                                                <span id="summary-nights" class="font-medium">5</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <div class="flex items-center">
                                                    <i class="fas fa-users text-elegant-gold mr-2"></i>
                                                    <span>Guests:</span>
                                                </div>
                                                <span id="summary-guests" class="font-medium">2 Adults, 0
                                                    Children</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <h6
                                            class="font-medium text-elegant-burgundy mb-4 pb-2 border-b border-elegant-gold/20">
                                            Price Details</h6>
                                        <div class="space-y-3 text-elegant-charcoal">
                                            <div class="flex justify-between items-center">
                                                <span id="room-rate-label">Room Rate (5 nights):</span>
                                                <span id="room-rate-total">Rp 2,250,000</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <span>Tax (10%):</span>
                                                <span id="tax-amount">Rp 225,000</span>
                                            </div>
                                            <div class="pt-3 mt-3 border-t border-elegant-gold/20">
                                                <div
                                                    class="flex justify-between items-center font-bold text-elegant-burgundy">
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
                                    class="w-10 h-10 rounded-full bg-elegant-burgundy/10 flex items-center justify-center mr-4">
                                    <i class="fas fa-user-circle text-elegant-burgundy"></i>
                                </div>
                                <h4 class="font-cormorant text-2xl font-bold text-elegant-burgundy">Guest Information
                                </h4>
                            </div>

                            <div class="bg-elegant-white p-6 rounded-lg shadow-md border border-elegant-gold/20 mb-8">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label for="guest-name"
                                            class="block text-sm font-medium text-elegant-charcoal mb-2">Full
                                            Name <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <input type="text" id="guest-name" placeholder="Enter your full name"
                                                class="w-full px-4 py-3 border border-elegant-gold/30 bg-elegant-cream/50 text-elegant-charcoal focus:outline-none focus:ring-2 focus:ring-elegant-gold rounded-md pl-10">
                                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-elegant-gold">
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
                                                class="w-full px-4 py-3 border border-elegant-gold/30 bg-elegant-cream/50 text-elegant-charcoal focus:outline-none focus:ring-2 focus:ring-elegant-gold rounded-md pl-10">
                                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-elegant-gold">
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
                                                class="w-full px-4 py-3 border border-elegant-gold/30 bg-elegant-cream/50 text-elegant-charcoal focus:outline-none focus:ring-2 focus:ring-elegant-gold rounded-md pl-10">
                                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-elegant-gold">
                                                <i class="fas fa-phone"></i>
                                            </div>
                                        </div>
                                        <div id="guest-phone-error" class="error-message hidden">Please enter your
                                            phone number</div>
                                    </div>
                                    <div>
                                        <label for="guest-country"
                                            class="block text-sm font-medium text-elegant-charcoal mb-2">Country <span
                                                class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <select id="guest-country"
                                                class="w-full px-4 py-3 border border-elegant-gold/30 bg-elegant-cream/50 text-elegant-charcoal focus:outline-none focus:ring-2 focus:ring-elegant-gold rounded-md pl-10 appearance-none">
                                                <option value="">Select your country</option>
                                                <option value="Indonesia">Indonesia</option>
                                                <option value="Singapore">Singapore</option>
                                                <option value="Malaysia">Malaysia</option>
                                                <option value="Australia">Australia</option>
                                                <option value="United States">United States</option>
                                                <option value="Other">Other</option>
                                            </select>
                                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-elegant-gold">
                                                <i class="fas fa-globe"></i>
                                            </div>
                                            <div
                                                class="absolute right-3 top-1/2 -translate-y-1/2 text-elegant-gold pointer-events-none">
                                                <i class="fas fa-chevron-down"></i>
                                            </div>
                                        </div>
                                        <div id="guest-country-error" class="error-message hidden">Please select your
                                            country</div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center mb-6">
                                <div
                                    class="w-10 h-10 rounded-full bg-elegant-burgundy/10 flex items-center justify-center mr-4">
                                    <i class="fas fa-concierge-bell text-elegant-burgundy"></i>
                                </div>
                                <h4 class="font-cormorant text-2xl font-bold text-elegant-burgundy">Special Requests
                                </h4>
                            </div>

                            <div class="bg-elegant-white p-6 rounded-lg shadow-md border border-elegant-gold/20">
                                <label for="special-requests"
                                    class="block text-sm font-medium text-elegant-charcoal mb-2">Do you have any
                                    special requests?</label>
                                <div class="relative">
                                    <textarea id="special-requests" rows="4"
                                        placeholder="Let us know if you have any special requests or requirements..."
                                        class="w-full px-4 py-3 border border-elegant-gold/30 bg-elegant-cream/50 text-elegant-charcoal focus:outline-none focus:ring-2 focus:ring-elegant-gold rounded-md"></textarea>
                                </div>
                                <p class="text-sm text-elegant-charcoal/70 mt-2">We'll do our best to accommodate your
                                    requests, subject to availability.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Payment -->
                    <div class="step-content hidden" id="step-4">
                        <div class="max-w-4xl mx-auto">
                            <div class="flex items-center mb-6">
                                <div
                                    class="w-10 h-10 rounded-full bg-elegant-burgundy/10 flex items-center justify-center mr-4">
                                    <i class="fas fa-credit-card text-elegant-burgundy"></i>
                                </div>
                                <h4 class="font-cormorant text-2xl font-bold text-elegant-burgundy">Payment Information
                                </h4>
                            </div>

                            <div class="bg-elegant-white p-6 rounded-lg shadow-md border border-elegant-gold/20 mb-8">
                                <h5
                                    class="font-medium text-elegant-burgundy mb-4 pb-2 border-b border-elegant-gold/20">
                                    Payment Method</h5>
                                <div class="space-y-4">
                                    <div class="payment-option relative">
                                        <input type="radio" id="payment-credit" name="payment-method"
                                            class="hidden" checked>
                                        <label for="payment-credit"
                                            class="flex items-center p-4 border border-elegant-gold/30 rounded-lg cursor-pointer transition-all duration-300 hover:bg-elegant-cream/50 payment-label">
                                            <div
                                                class="w-6 h-6 rounded-full border-2 border-elegant-gold flex items-center justify-center mr-3 payment-radio">
                                                <div
                                                    class="w-3 h-3 rounded-full bg-elegant-burgundy payment-radio-dot">
                                                </div>
                                            </div>
                                            <span class="mr-4">Credit Card</span>
                                            <div class="flex space-x-2 ml-auto">
                                                <i class="fab fa-cc-visa text-blue-700 text-xl"></i>
                                                <i class="fab fa-cc-mastercard text-red-600 text-xl"></i>
                                                <i class="fab fa-cc-amex text-blue-500 text-xl"></i>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="payment-option relative">
                                        <input type="radio" id="payment-paypal" name="payment-method"
                                            class="hidden">
                                        <label for="payment-paypal"
                                            class="flex items-center p-4 border border-elegant-gold/30 rounded-lg cursor-pointer transition-all duration-300 hover:bg-elegant-cream/50 payment-label">
                                            <div
                                                class="w-6 h-6 rounded-full border-2 border-elegant-gold flex items-center justify-center mr-3 payment-radio">
                                                <div
                                                    class="w-3 h-3 rounded-full bg-elegant-burgundy payment-radio-dot">
                                                </div>
                                            </div>
                                            <span class="mr-4">PayPal</span>
                                            <div class="ml-auto">
                                                <i class="fab fa-paypal text-blue-800 text-xl"></i>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="payment-option relative">
                                        <input type="radio" id="payment-bank" name="payment-method"
                                            class="hidden">
                                        <label for="payment-bank"
                                            class="flex items-center p-4 border border-elegant-gold/30 rounded-lg cursor-pointer transition-all duration-300 hover:bg-elegant-cream/50 payment-label">
                                            <div
                                                class="w-6 h-6 rounded-full border-2 border-elegant-gold flex items-center justify-center mr-3 payment-radio">
                                                <div
                                                    class="w-3 h-3 rounded-full bg-elegant-burgundy payment-radio-dot">
                                                </div>
                                            </div>
                                            <span class="mr-4">Bank Transfer</span>
                                            <div class="ml-auto">
                                                <i class="fas fa-university text-elegant-burgundy text-xl"></i>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div id="credit-card-form"
                                class="bg-elegant-white p-6 rounded-lg shadow-md border border-elegant-gold/20 mb-8">
                                <h5
                                    class="font-medium text-elegant-burgundy mb-4 pb-2 border-b border-elegant-gold/20">
                                    Card Details</h5>

                                <div class="mb-6">
                                    <label for="card-name"
                                        class="block text-sm font-medium text-elegant-charcoal mb-2">Name on
                                        Card <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <input type="text" id="card-name"
                                            placeholder="Enter the name on your card"
                                            class="w-full px-4 py-3 border border-elegant-gold/30 bg-elegant-cream/50 text-elegant-charcoal focus:outline-none focus:ring-2 focus:ring-elegant-gold rounded-md pl-10">
                                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-elegant-gold">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    </div>
                                    <div id="card-name-error" class="error-message hidden">Please enter the name on
                                        your card</div>
                                </div>

                                <div class="mb-6">
                                    <label for="card-number"
                                        class="block text-sm font-medium text-elegant-charcoal mb-2">Card
                                        Number <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <input type="text" id="card-number" placeholder="XXXX XXXX XXXX XXXX"
                                            class="w-full px-4 py-3 border border-elegant-gold/30 bg-elegant-cream/50 text-elegant-charcoal focus:outline-none focus:ring-2 focus:ring-elegant-gold rounded-md pl-10">
                                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-elegant-gold">
                                            <i class="fas fa-credit-card"></i>
                                        </div>
                                    </div>
                                    <div id="card-number-error" class="error-message hidden">Please enter a valid card
                                        number</div>
                                </div>

                                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                                    <div>
                                        <label for="card-expiry-month"
                                            class="block text-sm font-medium text-elegant-charcoal mb-2">Expiry
                                            Month <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <select id="card-expiry-month"
                                                class="w-full px-4 py-3 border border-elegant-gold/30 bg-elegant-cream/50 text-elegant-charcoal focus:outline-none focus:ring-2 focus:ring-elegant-gold rounded-md pl-10 appearance-none">
                                                <option value="">Month</option>
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select>
                                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-elegant-gold">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                            <div
                                                class="absolute right-3 top-1/2 -translate-y-1/2 text-elegant-gold pointer-events-none">
                                                <i class="fas fa-chevron-down"></i>
                                            </div>
                                        </div>
                                        <div id="card-month-error" class="error-message hidden">Please select expiry
                                            month</div>
                                    </div>

                                    <div>
                                        <label for="card-expiry-year"
                                            class="block text-sm font-medium text-elegant-charcoal mb-2">Expiry
                                            Year <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <select id="card-expiry-year"
                                                class="w-full px-4 py-3 border border-elegant-gold/30 bg-elegant-cream/50 text-elegant-charcoal focus:outline-none focus:ring-2 focus:ring-elegant-gold rounded-md pl-10 appearance-none">
                                                <option value="">Year</option>
                                                <option value="2025">2025</option>
                                                <option value="2026">2026</option>
                                                <option value="2027">2027</option>
                                                <option value="2028">2028</option>
                                                <option value="2029">2029</option>
                                                <option value="2030">2030</option>
                                            </select>
                                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-elegant-gold">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                            <div
                                                class="absolute right-3 top-1/2 -translate-y-1/2 text-elegant-gold pointer-events-none">
                                                <i class="fas fa-chevron-down"></i>
                                            </div>
                                        </div>
                                        <div id="card-year-error" class="error-message hidden">Please select expiry
                                            year</div>
                                    </div>

                                    <div>
                                        <label for="card-cvv"
                                            class="block text-sm font-medium text-elegant-charcoal mb-2">CVV <span
                                                class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <input type="text" id="card-cvv" placeholder="XXX"
                                                class="w-full px-4 py-3 border border-elegant-gold/30 bg-elegant-cream/50 text-elegant-charcoal focus:outline-none focus:ring-2 focus:ring-elegant-gold rounded-md pl-10">
                                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-elegant-gold">
                                                <i class="fas fa-lock"></i>
                                            </div>
                                        </div>
                                        <div id="card-cvv-error" class="error-message hidden">Please enter CVV</div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-elegant-white p-6 rounded-lg shadow-md border border-elegant-gold/20">
                                <h5
                                    class="font-medium text-elegant-burgundy mb-4 pb-2 border-b border-elegant-gold/20">
                                    Payment Summary</h5>
                                <div class="space-y-3 text-elegant-charcoal">
                                    <div class="flex justify-between items-center">
                                        <span id="payment-room-rate-label">Room Rate (5 nights):</span>
                                        <span id="payment-room-rate-total">Rp 2,250,000</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span>Tax (10%):</span>
                                        <span id="payment-tax-amount">Rp 225,000</span>
                                    </div>
                                    <div class="pt-3 mt-3 border-t border-elegant-gold/20">
                                        <div class="flex justify-between items-center font-bold text-elegant-burgundy">
                                            <span>Total Amount:</span>
                                            <span id="payment-total">Rp 2,475,000</span>
                                        </div>
                                    </div>
                                </div>
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
                                <h4 class="font-cormorant text-3xl font-bold text-elegant-burgundy mb-4">Booking
                                    Confirmed!</h4>
                                <p class="text-elegant-charcoal mb-2">Thank you for your booking at Pondok Hari Baik.
                                </p>
                                <p class="text-elegant-charcoal mb-6">We've sent a confirmation email to <span
                                        id="confirmation-email" class="font-medium">your email address</span>.</p>
                            </div>

                            <div
                                class="bg-elegant-white p-6 rounded-lg shadow-md border border-elegant-gold/20 mb-8 text-left">
                                <div class="flex items-center mb-4">
                                    <div
                                        class="w-10 h-10 rounded-full bg-elegant-burgundy/10 flex items-center justify-center mr-4">
                                        <i class="fas fa-receipt text-elegant-burgundy"></i>
                                    </div>
                                    <h5 class="font-cormorant text-xl font-bold text-elegant-burgundy">Booking Details
                                    </h5>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <div class="space-y-3 text-elegant-charcoal">
                                            <div class="flex justify-between items-center">
                                                <div class="flex items-center">
                                                    <i class="fas fa-hashtag text-elegant-gold mr-2"></i>
                                                    <span>Booking ID:</span>
                                                </div>
                                                <span id="booking-id" class="font-medium">PHB25052301</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <div class="flex items-center">
                                                    <i class="fas fa-home text-elegant-gold mr-2"></i>
                                                    <span>Room:</span>
                                                </div>
                                                <span id="confirmation-room" class="font-medium">Family
                                                    Bungalow</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <div class="flex items-center">
                                                    <i class="fas fa-calendar-check text-elegant-gold mr-2"></i>
                                                    <span>Check-in:</span>
                                                </div>
                                                <span id="confirmation-checkin" class="font-medium">May 10,
                                                    2025</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <div class="flex items-center">
                                                    <i class="fas fa-calendar-times text-elegant-gold mr-2"></i>
                                                    <span>Check-out:</span>
                                                </div>
                                                <span id="confirmation-checkout" class="font-medium">May 15,
                                                    2025</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="space-y-3 text-elegant-charcoal">
                                            <div class="flex justify-between items-center">
                                                <div class="flex items-center">
                                                    <i class="fas fa-users text-elegant-gold mr-2"></i>
                                                    <span>Guests:</span>
                                                </div>
                                                <span id="confirmation-guests" class="font-medium">2 Adults, 0
                                                    Children</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <div class="flex items-center">
                                                    <i class="fas fa-credit-card text-elegant-gold mr-2"></i>
                                                    <span>Payment Method:</span>
                                                </div>
                                                <span id="confirmation-payment" class="font-medium">Credit Card</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <div class="flex items-center">
                                                    <i class="fas fa-money-bill-wave text-elegant-gold mr-2"></i>
                                                    <span>Total Amount:</span>
                                                </div>
                                                <span id="confirmation-total" class="font-medium">Rp 2,475,000</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <div class="flex items-center">
                                                    <i class="fas fa-check-circle text-elegant-gold mr-2"></i>
                                                    <span>Status:</span>
                                                </div>
                                                <span class="font-medium text-green-600">Confirmed</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col md:flex-row gap-4 justify-center">
                                <button id="download-receipt"
                                    class="bg-elegant-burgundy hover:bg-elegant-burgundy/80 text-elegant-white px-6 py-3 transition-all duration-300 btn-elegant border border-elegant-gold/30 rounded-md flex items-center justify-center">
                                    <i class="fas fa-download mr-2"></i> Download Receipt
                                </button>
                                <button id="view-booking"
                                    class="bg-elegant-navy hover:bg-elegant-navy/80 text-elegant-gold px-6 py-3 transition-all duration-300 btn-elegant border border-elegant-gold/30 rounded-md flex items-center justify-center">
                                    <i class="fas fa-eye mr-2"></i> View Booking
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="bg-elegant-cream p-8 border-t border-elegant-gold/30 flex justify-between">
                    <button id="prev-step"
                        class="bg-elegant-navy hover:bg-elegant-navy/80 text-elegant-gold px-6 py-3 transition-all duration-300 btn-elegant border border-elegant-gold/30 rounded-md hidden group">
                        <div class="flex items-center">
                            <i
                                class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform duration-300"></i>
                            <span>Previous</span>
                        </div>
                    </button>
                    <div class="ml-auto">
                        <button id="next-step"
                            class="bg-elegant-burgundy hover:bg-elegant-burgundy/80 text-elegant-white px-6 py-3 transition-all duration-300 btn-elegant border border-elegant-gold/30 rounded-md group">
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



</body>

</html>
