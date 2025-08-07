<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Selamat Datang - Antrian Digital</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem antrian digital untuk pelayanan pelanggan yang efisien dan modern">
    <link rel="icon" type="image/png" href="{{ asset('indibiz.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body { 
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
        }
        /* Optimize animations for better performance */
        @media (prefers-reduced-motion: reduce) {
            .animate-fade-in-up, .animate-slide-in {
                animation: none;
            }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen flex items-center justify-center p-4 md:p-6 relative antialiased">

    <div class="text-center animate-fade-in-up max-w-4xl mx-auto">
        <!-- Logo Section -->
        <div class="mb-6 md:mb-8 flex justify-center">
            <div class="relative">
                <img src="/indibiz.png" alt="Logo Antrian Digital" class="h-24 md:h-32 w-auto animate-slide-in">
                <div class="absolute -inset-3 md:-inset-4 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full opacity-20 blur-xl"></div>
            </div>
        </div>

        <!-- Title Section -->
        <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-3 md:mb-4">
            Antrian Digital
        </h1>
        <p class="text-lg md:text-xl text-gray-600 mb-8 md:mb-12 max-w-md mx-auto">
            Sistem antrian digital yang modern dan efisien untuk mengelola pelayanan pelanggan
        </p>

        <!-- Navigation Buttons -->
        <div class="space-y-4 md:space-y-0 md:space-x-4 md:flex md:justify-center mb-12 md:mb-16">
            <a href="/dashboard"
                class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 md:py-4 px-6 md:px-8 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-base md:text-lg inline-block focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                role="button"
                aria-label="Masuk ke dashboard monitoring">
                <svg class="w-5 h-5 md:w-6 md:h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Dashboard
            </a>
            <a href="/client"
                class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 md:py-4 px-6 md:px-8 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-base md:text-lg inline-block focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                role="button"
                aria-label="Masuk ke halaman client">
                <svg class="w-5 h-5 md:w-6 md:h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Client
            </a>
        </div>

        <!-- Features Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:transform hover:scale-105 p-4 md:p-6 text-center">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2 text-sm md:text-base">Cepat</h3>
                <p class="text-xs md:text-sm text-gray-600">Proses antrian yang cepat dan efisien</p>
            </div>
            
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:transform hover:scale-105 p-4 md:p-6 text-center">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2 text-sm md:text-base">Terjamin</h3>
                <p class="text-xs md:text-sm text-gray-600">Sistem yang terjamin keamanannya</p>
            </div>
            
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:transform hover:scale-105 p-4 md:p-6 text-center">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2 text-sm md:text-base">Mudah</h3>
                <p class="text-xs md:text-sm text-gray-600">Interface yang mudah digunakan</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 md:mt-12 text-center">
            <p class="text-xs md:text-sm text-gray-500">
                © 2024 Antrian Digital. Sistem antrian modern untuk pelayanan yang lebih baik.
            </p>
        </div>
    </div>

</body>

</html>