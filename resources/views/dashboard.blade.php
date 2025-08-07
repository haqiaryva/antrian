@extends('layouts.app')

@section('content')
<div class="animate-fade-in-up">
    <!-- Header Section -->
    <div class="text-center mb-6 md:mb-8">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Dashboard Monitoring</h1>
        <p class="text-base md:text-lg text-gray-600">Monitor kinerja sistem antrian digital</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
        <!-- Active Queues Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:transform hover:scale-105">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 md:px-6 py-4 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h2 class="text-lg md:text-xl font-semibold text-gray-800">Antrian Aktif</h2>
                </div>
            </div>
            <div class="p-4 md:p-6 text-center">
                <p class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-2">{{ $waiting_queues }}</p>
                <p class="text-sm text-gray-600">antrian menunggu</p>
            </div>
        </div>

        <!-- Active Staff Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:transform hover:scale-105">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 md:px-6 py-4 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-lg md:text-xl font-semibold text-gray-800">Staff Aktif</h2>
                </div>
            </div>
            <div class="p-4 md:p-6 text-center">
                <p class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-green-600 to-teal-600 bg-clip-text text-transparent mb-2">{{ $active_staff }}</p>
                <p class="text-sm text-gray-600">staff sedang bekerja</p>
            </div>
        </div>

        <!-- System Status Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:transform hover:scale-105">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 md:px-6 py-4 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-lg md:text-xl font-semibold text-gray-800">Status Sistem</h2>
                </div>
            </div>
            <div class="p-4 md:p-6 text-center">
                <div class="w-12 h-12 md:w-16 md:h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 md:w-8 md:h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <p class="text-sm font-medium text-green-600">Sistem Berjalan Normal</p>
            </div>
        </div>
    </div>

    <!-- Detailed Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
        <!-- Top Staff Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:transform hover:scale-105">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 md:px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg md:text-xl font-semibold text-gray-800">Top 3 Staff</h2>
            </div>
            <div class="p-4 md:p-6">
                @if(count($top_staffs) > 0)
                    <div class="space-y-3 md:space-y-4">
                        @foreach ($top_staffs as $index => $staff)
                            <div class="flex items-center justify-between p-3 md:p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-6 h-6 md:w-8 md:h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-xs md:text-sm mr-3">
                                        {{ $index + 1 }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm md:text-base">{{ $staff['name'] }}</p>
                                        <p class="text-xs md:text-sm text-gray-600">{{ $staff['calls'] }} antrian ditangani</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6 md:py-8">
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 md:w-8 md:h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-600 text-sm md:text-base">Belum ada data staff</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Average Service Time Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:transform hover:scale-105">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 md:px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg md:text-xl font-semibold text-gray-800">Rata-rata Waktu Pelayanan</h2>
            </div>
            <div class="p-4 md:p-6">
                <div id="staffTimes" class="space-y-3 md:space-y-4" role="status" aria-live="polite">
                    <div class="flex items-center justify-center py-6 md:py-8">
                        <div class="animate-spin rounded-full h-6 w-6 md:h-8 md:w-8 border-b-2 border-blue-600" aria-hidden="true"></div>
                        <span class="ml-3 text-gray-600 text-sm md:text-base">Memuat data...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        // Untuk Mengambil Waktu Rata-Rata Penanganan Per Staff Menggunakan DashboardController Melalui Rute /api/dashboard
        fetch('/api/dashboard')
            .then(res => {
                if (!res.ok) {
                    throw new Error(`HTTP error! status: ${res.status}`);
                }
                return res.json();
            })
            .then(data => {
                const staffTimesDiv = document.getElementById('staffTimes');
                staffTimesDiv.innerHTML = '';

                if (data.staff_times && data.staff_times.length > 0) {
                    data.staff_times.forEach(staff => {
                        const row = document.createElement('div');
                        row.className = 'flex items-center justify-between p-3 md:p-4 bg-gray-50 rounded-lg';
                        row.innerHTML = `
                            <div class="flex items-center">
                                <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-r from-green-500 to-teal-600 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 md:w-5 md:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800 text-sm md:text-base">${staff.name}</p>
                                    <p class="text-xs md:text-sm text-gray-600">Rata-rata waktu pelayanan</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-base md:text-lg font-bold text-green-600">${staff.average_time}</p>
                            </div>
                        `;
                        staffTimesDiv.appendChild(row);
                    });
                } else {
                    staffTimesDiv.innerHTML = `
                        <div class="text-center py-6 md:py-8">
                            <div class="w-12 h-12 md:w-16 md:h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-6 h-6 md:w-8 md:h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-600 text-sm md:text-base">Tidak ada data waktu pelayanan.</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error fetching dashboard data:', error);
                document.getElementById('staffTimes').innerHTML = `
                    <div class="text-center py-6 md:py-8">
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 md:w-8 md:h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-red-600 font-medium text-sm md:text-base">Gagal memuat data</p>
                    </div>
                `;
            });
    </script>
@endpush