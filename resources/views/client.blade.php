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
        body {
            font-family: 'Inter', sans-serif;
        }

        .nav-glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .queue-number {
            font-size: 1.5rem;
            font-weight: bold;
            color: #3B82F6;
        }

        .animate-slide-in {
            animation: slideIn 0.5s ease-out;
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(-20px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen relative">

    <!-- Navigation -->
    <!-- <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16"> -->
                <!-- Logo and Brand -->
                <!-- <div class="flex items-center">
                    <img src="/indibiz.png" alt="Logo" class="h-10 w-auto">
                    <div class="ml-3 text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        Antrian Digital
                    </div>
                </div>
            </div>
        </div>
    </nav> -->

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto mt-8 p-6 animate-fade-in-up">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Selamat Datang</h1>
            <p class="text-lg text-gray-600">Silakan ambil nomor antrian Anda</p>
        </div>

        <!-- Single Queue Button -->
        <div class="flex justify-center">
            <button onclick="submitQueue()"
                class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 p-8 text-white transition-all duration-300 hover:from-blue-600 hover:to-blue-700 hover:scale-105 hover:shadow-2xl max-w-md w-full">
                <div class="absolute inset-0 bg-white/10 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                <div class="relative z-10 text-center">
                    <div class="mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold mb-2">Ambil Nomor Antrian</h3>
                    <p class="text-blue-100 text-sm">Klik tombol ini untuk mendapatkan nomor antrian Anda</p>
                </div>
            </button>
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
    </main>

    <script>
        function submitQueue() {
            // Show loading state
            document.getElementById('loading').classList.remove('hidden');
            document.getElementById('your-number').textContent = '';

            fetch('/api/queue', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        type: 'A'
                    }) // 'A' for general queue
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