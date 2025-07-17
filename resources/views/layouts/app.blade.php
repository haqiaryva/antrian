<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Antrian Digital</title>
    <link rel="icon" type="image/png" href="{{ asset('unnamed.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900">
    <nav class="bg-white shadow flex items-center justify-between px-6 py-3">
        <div class="flex items-center space-x-4" style="width: 30%">
            
            <!-- Ini Untuk Memilih Staff dan Menyimpan Staff dari Item Dropdown yang Dipilih -->
            <select id="staff-switch" class="border border-gray-300 px-2 py-1 rounded"
                onchange="activateStaff(this.value)">
                <option value="">Pilih Staff</option>
                @foreach ($staffs as $staff)
                    <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                @endforeach
            </select>

            <!-- Ini Untuk Tombol Toggle, Fungsi Untuk Membuat Status Staff Aktif dan Non-aktif -->
            <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" id="toggle-active" class="sr-only" onchange="toggleActiveStatus()">
                <div id="toggle-track" class="w-11 h-6 bg-gray-300 rounded-full relative transition duration-300">
                    <div id="toggle-dot" class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition">
                    </div>
                </div>
                <span id="toggle-label" class="ml-2 text-sm text-gray-700">Tidak Aktif</span>
            </label>

        </div>

        <div class="flex space-x-6">
            <img src="/unnamed.png" alt="Logo" class="h-8" style="height: 77px">
        </div>

        <div class="flex justify-end items-center space-x-4" style="width: 30%">
            <a href="{{ route('dashboard') }}"
                class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">
                Dashboard
            </a>
            <a href="{{ route('queue') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                Queue
            </a>
            <a href="{{ url('/') }}"
                class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded">
                Log Out
            </a>
        </div>
    </nav>

    <main class="p-6">
        @yield('content')
    </main>

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
                dot.classList.remove('translate-x-5');
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
                        dot.classList.add('translate-x-5');
                    } else {
                        label.textContent = "Tidak Aktif";
                        track.classList.add('bg-gray-300');
                        track.classList.remove('bg-green-500');
                        dot.classList.remove('translate-x-5');
                    }
                })
                .catch(err => {
                    console.error("Gagal mengambil status staff:", err);
                    toggle.checked = false;
                    label.textContent = "Tidak Aktif";
                    track.classList.add('bg-gray-300');
                    track.classList.remove('bg-green-500');
                    dot.classList.remove('translate-x-5');
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