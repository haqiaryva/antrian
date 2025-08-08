<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Antrian Digital</title>
    <link rel="icon" type="image/png" href="{{ asset('indibiz.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            padding-top: 80px; /* Sesuaikan dengan tinggi navbar */
        }
        
        /* Navbar solid */
        .navbar-solid {
            background: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border-bottom: 1px solid #e5e7eb;
        }
        
        @media (min-width: 768px) {
            body {
                padding-top: 90px;
            }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 min-h-screen relative">
    <!-- Navigation - Changed to solid navbar -->
    <nav class="navbar-solid fixed top-0 left-0 right-0 w-full z-50">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <!-- Left Section - Staff Controls -->
                <div class="flex items-center space-x-6" style="width: 35%">
                    <!-- Staff Selection -->
                    <div class="relative">
                        <select id="staff-switch" 
                                class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm hover:shadow-md"
                                onchange="activateStaff(this.value)">
                            <option value="">Pilih Staff</option>
                            @foreach ($staffs as $staff)
                                <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Status Toggle -->
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="toggle-active" class="sr-only" onchange="toggleActiveStatus()">
                        <div id="toggle-track" class="w-12 h-6 bg-gray-300 rounded-full relative transition duration-300 shadow-inner">
                            <div id="toggle-dot" class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition duration-300 shadow-md"></div>
                        </div>
                        <span id="toggle-label" class="ml-3 text-sm font-medium text-gray-700">Tidak Aktif</span>
                    </label>
                </div>

                <!-- Center Section - Logo -->
                <div class="flex items-center space-x-4">
                    <img src="/indibiz.png" alt="Logo" class="h-12 w-auto">
                    <div class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        Antrian Digital
                    </div>
                </div>

                <!-- Right Section - Navigation Links -->
                <div class="flex items-center space-x-4" style="width: 35%; justify-content: flex-end;">
                    <a href="{{ route('dashboard') }}"
                        class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 shadow hover:shadow-md text-sm">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('queue') }}"
                        class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 shadow hover:shadow-md text-sm">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Queue
                    </a>
                    <a href="{{ url('/') }}"
                        class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 shadow hover:shadow-md text-sm">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Log Out
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto p-6">
        @yield('content')
    </main>

    <!-- Script tetap sama -->
    <script>
        // Fungsi untuk Menyimpan Staff yang Dipilih dari Dropdown
        document.addEventListener('DOMContentLoaded', function () {
            const storedStaffId = localStorage.getItem('selectedStaffId');
            const staffSelect = document.getElementById('staff-switch');

            if (storedStaffId) {
                staffSelect.value = storedStaffId;
                activateStaff(storedStaffId);
            }
        });

        // Fungsi Untuk Sinkronisasi Status Staff dari Database
        function activateStaff(staffId) {
            const toggle = document.getElementById('toggle-active');
            const label = document.getElementById('toggle-label');
            const dot = document.getElementById('toggle-dot');
            const track = document.getElementById('toggle-track');

            if (!staffId) {
                localStorage.removeItem('selectedStaffId');
                toggle.checked = false;
                label.textContent = "Tidak Aktif";
                track.classList.add('bg-gray-300');
                track.classList.remove('bg-green-500');
                dot.classList.remove('translate-x-6');
                return;
            }

            localStorage.setItem('selectedStaffId', staffId);

            fetch(`/api/staff/${staffId}/status`)
                .then(res => res.json())
                .then(data => {
                    const isActive = data.is_active;

                    toggle.checked = isActive;

                    if (isActive) {
                        label.textContent = "Aktif";
                        track.classList.remove('bg-gray-300');
                        track.classList.add('bg-green-500');
                        dot.classList.add('translate-x-6');
                    } else {
                        label.textContent = "Tidak Aktif";
                        track.classList.add('bg-gray-300');
                        track.classList.remove('bg-green-500');
                        dot.classList.remove('translate-x-6');
                    }
                })
                .catch(err => {
                    console.error("Gagal mengambil status staff:", err);
                    toggle.checked = false;
                    label.textContent = "Tidak Aktif";
                    track.classList.add('bg-gray-300');
                        track.classList.remove('bg-green-500');
                        dot.classList.remove('translate-x-6');
                });
        }

        // Fungsi Untuk Merubah Status Staff Menjadi active atau deactive
        function toggleActiveStatus() {
            const staffId = document.getElementById('staff-switch').value;
            const toggle = document.getElementById('toggle-active');

            if (!staffId) {
                alert("Pilih staff terlebih dahulu.");
                toggle.checked = false;
                return;
            }

            const url = `/api/staff/${staffId}/${toggle.checked ? 'activate' : 'deactivate'}`;

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(res => res.json())
                .then(() => {
                    activateStaff(staffId);
                })
                .catch(err => {
                    console.error("Gagal update status:", err);
                    toggle.checked = !toggle.checked;
                });
        }
    </script>

    @stack('scripts')
</body>

</html>