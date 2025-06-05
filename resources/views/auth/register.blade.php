<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Pondok Hari Baik Villa</title>
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
                        'hero-pattern': "linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1582610116397-edb318620f90?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')",
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
        /* Subtle shadow */
        .subtle-shadow {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: box-shadow 0.3s ease;
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
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        /* Decorative line */
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
    </style>
</head>

<body class="font-montserrat text-elegant-charcoal bg-pattern-bg min-h-screen py-12 px-4"
    style="background-color: #FFFFFF;">
    <div class="max-w-4xl mx-auto">
        <!-- Logo and Title -->
        <div class="text-center mb-8">
            <a href="/" class="inline-block">
                <h1 class="font-cormorant text-4xl font-bold text-elegant-green">Pondok Hari Baik</h1>
            </a>
            <div class="mt-2">
                <span class="text-elegant-orange text-sm uppercase tracking-widest font-medium">Create an
                    Account</span>
            </div>
            <div class="decorative-line w-32 mx-auto mt-4"></div>
        </div>

        <!-- Signup Form -->
        <div class="bg-elegant-white rounded-lg shadow-lg overflow-hidden subtle-shadow">
            <div class="p-8">
                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-md text-center font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-md">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('guests.store') }}" method="POST">
                    @csrf
                    <!-- Form sections -->
                    <div class="mb-8">
                        <h2 class="font-cormorant text-2xl font-semibold text-elegant-green mb-4">Account Information
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Username Field -->
                            <div>
                                <label for="username"
                                    class="block text-sm font-medium text-elegant-charcoal mb-2">Username <span
                                        class="text-elegant-orange">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-elegant-gray"></i>
                                    </div>
                                    <input type="text" id="username" name="username"
                                        class="w-full pl-10 pr-4 py-3 border border-elegant-gray/20 bg-elegant-white text-elegant-charcoal focus:outline-none focus:ring-2 focus:ring-elegant-green/50 rounded-md"
                                        placeholder="Choose a username" required>
                                </div>
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-elegant-charcoal mb-2">Email
                                    <span class="text-elegant-orange">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-elegant-gray"></i>
                                    </div>
                                    <input type="email" id="email" name="email"
                                        class="w-full pl-10 pr-4 py-3 border border-elegant-gray/20 bg-elegant-white text-elegant-charcoal focus:outline-none focus:ring-2 focus:ring-elegant-green/50 rounded-md"
                                        placeholder="Your email address" required>
                                </div>
                            </div>

                            <!-- Phone Number Field -->
                            <div>
                                <label for="phone_number"
                                    class="block text-sm font-medium text-elegant-charcoal mb-2">Phone Number <span
                                        class="text-elegant-orange">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-phone text-elegant-gray"></i>
                                    </div>
                                    <input type="tel" id="phone_number" name="phone_number"
                                        class="w-full pl-10 pr-4 py-3 border border-elegant-gray/20 bg-elegant-white text-elegant-charcoal focus:outline-none focus:ring-2 focus:ring-elegant-green/50 rounded-md"
                                        placeholder="Your phone number" required>
                                </div>
                            </div>

                            <!-- Password Field -->
                            <div>
                                <label for="password"
                                    class="block text-sm font-medium text-elegant-charcoal mb-2">Password <span
                                        class="text-elegant-orange">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-elegant-gray"></i>
                                    </div>
                                    <input type="password" id="password" name="password"
                                        class="w-full pl-10 pr-4 py-3 border border-elegant-gray/20 bg-elegant-white text-elegant-charcoal focus:outline-none focus:ring-2 focus:ring-elegant-green/50 rounded-md"
                                        placeholder="Create a password" required>
                                </div>
                            </div>

                            <!-- Confirm Password Field -->
                            <div>
                                <label for="password_confirmation"
                                    class="block text-sm font-medium text-elegant-charcoal mb-2">Confirm Password <span
                                        class="text-elegant-orange">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-elegant-gray"></i>
                                    </div>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="w-full pl-10 pr-4 py-3 border border-elegant-gray/20 bg-elegant-white text-elegant-charcoal focus:outline-none focus:ring-2 focus:ring-elegant-green/50 rounded-md"
                                        placeholder="Confirm your password" required>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Terms and Conditions -->
                    <div class="mb-8">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="terms" name="terms" type="checkbox"
                                    class="h-4 w-4 text-elegant-green focus:ring-elegant-green/50 border-elegant-gray/30 rounded"
                                    required>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms" class="text-elegant-charcoal">I agree to the <a href="#"
                                        class="text-elegant-green hover:text-elegant-green/80">Terms and
                                        Conditions</a> and <a href="#"
                                        class="text-elegant-green hover:text-elegant-green/80">Privacy
                                        Policy</a></label>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-elegant-green hover:bg-elegant-green/90 text-elegant-white px-6 py-3 transition-all duration-300 btn-elegant font-medium rounded-md flex items-center justify-center">
                        <span>Create Account</span>
                        <i class="fas fa-user-plus ml-2"></i>
                    </button>
                </form>
            </div>

            <!-- Login Link -->
            <div class="px-8 py-4 bg-elegant-lightgray border-t border-elegant-gray/10 text-center">
                <p class="text-sm text-elegant-charcoal">
                    Already have an account?
                    <a href="{{ route('login') }}"
                        class="font-medium text-elegant-green hover:text-elegant-green/80 transition-colors duration-300">Sign
                        in</a>
                </p>
            </div>
        </div>

        <!-- Back to Home Link -->
        <div class="text-center mt-6">
            <a href="/"
                class="text-sm text-elegant-charcoal hover:text-elegant-green transition-colors duration-300 flex items-center justify-center">
                <i class="fas fa-arrow-left mr-2"></i>
                <span>Back to Home</span>
            </a>
        </div>
    </div>
</body>

</html>
