<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Client - Antrian Digital</title>
    <link rel="icon" type="image/png" href="{{ asset('indibiz.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen relative">

    <!-- Navigation -->
    <nav class="nav-glass shadow-lg py-4 px-8 sticky top-0 z-50">
        <div class="flex justify-between items-center w-full max-w-7xl mx-auto">
            <div class="flex items-center space-x-4">
                <img src="/indibiz.png" alt="Logo" class="h-16 w-auto animate-slide-in">
                <div class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    Antrian Digital
                </div>
            </div>

            <a href="{{ url('/') }}"
                class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Log Out
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto mt-8 p-6 animate-fade-in-up">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Selamat Datang</h1>
            <p class="text-lg text-gray-600">Silakan pilih jenis antrian yang Anda inginkan</p>
        </div>

        <!-- Queue Type Selection -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:transform hover:scale-105 max-w-2xl mx-auto">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Pilih Jenis Antrian</h2>
            </div>
            <div class="p-8">
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Reservasi Button -->
                    <button onclick="submitQueue('R')" 
                            class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 p-8 text-white transition-all duration-300 hover:from-blue-600 hover:to-blue-700 hover:scale-105 hover:shadow-2xl">
                        <div class="absolute inset-0 bg-white/10 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                        <div class="relative z-10">
                            <div class="mb-4">
                                <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-2">Reservasi</h3>
                            <p class="text-blue-100 text-sm">Antrian untuk pelanggan yang mau melakukan reservasi</p>
                        </div>
                    </button>

                    <!-- Walk-In Button -->
                    <button onclick="submitQueue('W')" 
                            class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-green-500 to-green-600 p-8 text-white transition-all duration-300 hover:from-green-600 hover:to-green-700 hover:scale-105 hover:shadow-2xl">
                        <div class="absolute inset-0 bg-white/10 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                        <div class="relative z-10">
                            <div class="mb-4">
                                <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-2">Walk-In</h3>
                            <p class="text-green-100 text-sm">Antrian untuk pelanggan yang datang langsung</p>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Queue Number Display -->
        <div class="mt-8 text-center">
            <div id="your-number" class="queue-number min-h-[4rem] flex items-center justify-center"></div>
            
            <!-- Loading State -->
            <div id="loading" class="hidden mt-4">
                <div class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-full">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Memproses antrian<span class="loading-dots"></span>
                </div>
            </div>
        </div>

        <!-- Info Section -->
        <!-- <div class="mt-12 grid md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:transform hover:scale-105 p-6 text-center">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Cepat</h3>
                <p class="text-sm text-gray-600">Proses antrian yang cepat dan efisien</p>
            </div>
            
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:transform hover:scale-105 p-6 text-center">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Terjamin</h3>
                <p class="text-sm text-gray-600">Sistem antrian yang terjamin keamanannya</p>
            </div>
            
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:transform hover:scale-105 p-6 text-center">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Mudah</h3>
                <p class="text-sm text-gray-600">Interface yang mudah digunakan</p>
            </div>
        </div> -->
    </main>

    <script>
        // Fungsinya Ini Untuk Tombol Menambah Nomer Antrian Tadi, Dan Menambah Teks Untuk Menampilkan Nomer Antrian
        function submitQueue(type) {
            // Show loading state
            document.getElementById('loading').classList.remove('hidden');
            document.getElementById('your-number').textContent = '';
            
            fetch('/api/queue', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ type: type })
            })
                .then(res => res.json())
                .then(data => {
                    // Hide loading state
                    document.getElementById('loading').classList.add('hidden');
                    
                    if (data?.data?.queue_number) {
                        document.getElementById('your-number').textContent = 'Nomor Antrian Anda: ' + data.data.queue_number;
                        // Add success animation
                        document.getElementById('your-number').classList.add('animate-pulse');
                        setTimeout(() => {
                            document.getElementById('your-number').classList.remove('animate-pulse');
                        }, 3000);
                    } else {
                        document.getElementById('your-number').textContent = data.message || 'Terjadi kesalahan';
                        document.getElementById('your-number').classList.remove('queue-number');
                        document.getElementById('your-number').classList.add('text-red-600', 'text-xl', 'font-semibold');
                    }
                })
                .catch(err => {
                    // Hide loading state
                    document.getElementById('loading').classList.add('hidden');
                    
                    console.error('Error:', err);
                    document.getElementById('your-number').textContent = 'Gagal menghubungi server.';
                    document.getElementById('your-number').classList.remove('queue-number');
                    document.getElementById('your-number').classList.add('text-red-600', 'text-xl', 'font-semibold');
                });
        }
    </script>

</body>

</html>