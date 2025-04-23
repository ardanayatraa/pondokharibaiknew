<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TK Sari Kumara Denpasar- Login</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1ABC9C',
                        secondary: '#36A2EB',
                    }
                }
            }
        }
    </script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4 bg-gradient-to-b from-blue-50 to-purple-50">
    <div class="w-full max-w-md overflow-hidden bg-white border-2 border-[#1ABC9C] rounded-xl shadow-xl">
        <!-- Colorful top bar -->
        <div class="bg-[#1ABC9C] h-3 w-full"></div>

        <!-- Header -->
        <div class="pt-8 pb-4 flex flex-col items-center space-y-2">
            <div class="h-20 w-20 rounded-full bg-[#1ABC9C]/10 flex items-center justify-center mb-2">
                <!-- School Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="text-[#1ABC9C]">
                    <path d="m4 6 8-4 8 4"></path>
                    <path d="m18 10 4 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-8l4-2"></path>
                    <path d="M14 22v-4a2 2 0 0 0-4 0v4"></path>
                    <path d="M18 5v17"></path>
                    <path d="M6 5v17"></path>
                    <circle cx="12" cy="9" r="2"></circle>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-center text-[#1ABC9C]">TK Sari Kumara</h1>
            <p class="text-gray-500 text-center">Please sign in to your account</p>
        </div>

        <!-- Content -->
        <div class="space-y-6 p-6">
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div class="space-y-2">
                    <label for="username" class="flex items-center gap-2 font-semibold">
                        <!-- Pencil Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="text-[#1ABC9C]">
                            <path d="M17 3a2.85 2.85 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path>
                        </svg>
                        Username
                    </label>
                    \
                    <x-input id="username"
                        class="w-full px-3 py-2 border-2 border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1ABC9C] focus:border-transparent"
                        type="text" name="username" :value="old('username')" required placeholder="Enter your username"
                        autofocus autocomplete="username" />
                </div>

                <div class="space-y-2">
                    <label for="password" class="flex items-center gap-2 font-semibold">
                        <!-- Book Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="text-[#1ABC9C]">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                        </svg>
                        Password
                    </label>
                    <input id="password" type="password" required autocomplete="current-password"
                        placeholder="Enter your password"
                        class="w-full px-3 py-2 border-2 border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1ABC9C] focus:border-transparent" />


                </div>


                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-2">

                    <button type="submit"
                        class="w-full sm:w-auto px-8 py-2 bg-[#1ABC9C] text-white font-semibold rounded-full hover:bg-[#1ABC9C]/90 transition-colors">
                        Log in
                    </button>
                </div>
            </form>

            <div class="pt-4 border-t border-gray-200">
                <div class="flex justify-center space-x-4">
                    <div class="w-4 h-4 rounded-full bg-[#FF6B6B]"></div>
                    <div class="w-4 h-4 rounded-full bg-[#4ECDC4]"></div>
                    <div class="w-4 h-4 rounded-full bg-[#FFD166]"></div>
                    <div class="w-4 h-4 rounded-full bg-[#6A0572]"></div>
                    <div class="w-4 h-4 rounded-full bg-[#1A936F]"></div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
