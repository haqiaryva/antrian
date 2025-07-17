@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Dashboard Monitoring</h1>

    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-xl font-semibold">Antrian Aktif</h2>
            <p class="text-3xl text-blue-600 mb-5">{{ $waiting_queues }}</p>

            <h2 class="text-xl font-semibold">Staff Aktif</h2>
            <p class="text-3xl text-blue-600">{{ $active_staff }}</p>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-xl font-semibold">Top 3 Staff</h2>
            <ul>
                Perulangan untuk Menampilkan Top 3 Staff dari Controller
                @foreach ($top_staffs as $staff)
                    <li>{{ $staff['name'] }} - {{ $staff['calls'] }} antrian</li>
                @endforeach
            </ul>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-xl font-semibold mb-4">Rata-rata Waktu Pelayanan per Staff</h2>

            <div id="staffTimes">
                <p>Loading...</p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Untuk Mengambil Waktu Rata-Rata Penanganan Per Staff Menggunakan DashboardController Melalui Rute /api/dashboard
        fetch('/api/dashboard')
            .then(res => res.json())
            .then(data => {
                const staffTimesDiv = document.getElementById('staffTimes');
                staffTimesDiv.innerHTML = '';

                if (data.staff_times && data.staff_times.length > 0) {
                    data.staff_times.forEach(staff => {
                        const row = document.createElement('div');
                        row.className = 'mb-1';
                        row.innerHTML = `<span class="font-medium">${staff.name}</span>: <span class="text-blue-600">${staff.average_time}</span>`;
                        staffTimesDiv.appendChild(row);
                    });
                } else {
                    staffTimesDiv.innerHTML = '<p>Tidak ada data waktu pelayanan.</p>';
                }
            })
            .catch(error => {
                console.error(error);
                document.getElementById('staffTimes').innerHTML = '<p class="text-red-500">Gagal memuat data.</p>';
            });
    </script>
@endpush