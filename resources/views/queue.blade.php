@extends('layouts.app')

@section('content')
<div class="animate-fade-in-up">
    <!-- Header Section -->
    <div class="text-center mb-6 md:mb-8">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Queue Management</h1>
        <p class="text-base md:text-lg text-gray-600">Kelola antrian pelanggan dengan efisien</p>
    </div>

    <!-- Main Queue Interface -->
    <div class="max-w-4xl mx-auto">
        <!-- Counter Selection -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:transform hover:scale-105 mb-6 md:mb-8">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 md:px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg md:text-xl font-semibold text-gray-800">Pengaturan Loket</h2>
            </div>
            <div class="p-4 md:p-6">
                <div class="flex flex-col md:flex-row md:items-center space-y-3 md:space-y-0 md:space-x-4">
                    <label for="loket" class="text-base md:text-lg font-medium text-gray-700">Pilih Loket:</label>
                    <div class="relative">
                        <select id="loket" 
                                class="appearance-none bg-white border border-gray-300 rounded-lg px-4 md:px-6 py-2 md:py-3 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm hover:shadow-md text-base md:text-lg font-medium"
                                aria-label="Pilih loket untuk antrian">
                            <option value="1">Loket 1</option>
                            <option value="2">Loket 2</option>
                            <option value="3">Loket 3</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-4 h-4 md:w-5 md:h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Queue Display -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:transform hover:scale-105 mb-6 md:mb-8">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 md:px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg md:text-xl font-semibold text-gray-800">Antrian Saat Ini</h2>
            </div>
            <div class="p-6 md:p-8 text-center">
                <div id="queue-number" class="queue-number mb-6 md:mb-8 min-h-[5rem] md:min-h-[6rem] flex items-center justify-center" role="status" aria-live="polite">
                    Nomer Antrian (R001/W001)
                </div>

                <!-- Control Buttons -->
                <div class="flex flex-col sm:flex-row flex-wrap justify-center gap-3 md:gap-4">
                    <button id="call-btn" onclick="callQueue()" 
                            class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 md:py-4 px-6 md:px-8 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-base md:text-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                            aria-label="Panggil antrian berikutnya">
                        <svg class="w-5 h-5 md:w-6 md:h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Panggil Antrian
                    </button>
                    
                    <button id="done-btn" onclick="finishQueue()" 
                            class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 md:py-4 px-6 md:px-8 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-base md:text-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                            disabled
                            aria-label="Selesaikan antrian saat ini">
                        <svg class="w-5 h-5 md:w-6 md:h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Selesai
                    </button>
                    
                    <button onclick="fetchNextQueue()" 
                            class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold py-3 md:py-4 px-6 md:px-8 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-base md:text-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2"
                            aria-label="Lihat antrian berikutnya">
                        <svg class="w-5 h-5 md:w-6 md:h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Lihat Antrian Berikutnya
                    </button>
                </div>
            </div>
        </div>

        <!-- Status Information -->
        <!-- <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:transform hover:scale-105 p-4 md:p-6 text-center">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Cepat</h3>
                <p class="text-sm text-gray-600">Proses antrian yang cepat</p>
            </div>
            
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:transform hover:scale-105 p-4 md:p-6 text-center">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Efisien</h3>
                <p class="text-sm text-gray-600">Sistem yang efisien</p>
            </div>
            
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:transform hover:scale-105 p-4 md:p-6 text-center">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Terorganisir</h3>
                <p class="text-sm text-gray-600">Antrian yang terorganisir</p>
            </div>
        </div> -->
    </div>
</div>

<script>
    // Menyimpan ID Staff dan Loket ke Storage
    document.addEventListener('DOMContentLoaded', function () {
        const staffSelect = document.getElementById('staff-switch');
        const savedStaff = localStorage.getItem('selectedStaffId');
        const loketSelect = document.getElementById('loket');
        const savedLoket = localStorage.getItem('selectedLoket');

        if (savedStaff) {
            staffSelect.value = savedStaff;
            activateStaff(savedStaff);
        }

        staffSelect.addEventListener('change', function () {
            localStorage.setItem('selectedStaffId', this.value);
        });

        if (savedLoket) {
            loketSelect.value = savedLoket;
        }

        loketSelect.addEventListener('change', function () {
            localStorage.setItem('selectedLoket', this.value);
        });
    });

    let currentQueueId = null; // Untuk Simpan Queue ID yang Dipanggil Sekarang

    function speakText(text) {
        const utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = 'id-ID';
        speechSynthesis.speak(utterance);
    }

    function getSelectedStaffId() {
        // Untuk Ambil ID Staff dari Storage atau Dropdown Staff yang Aktif
        const select = document.getElementById('staff-switch');
        return select.value || localStorage.getItem('selectedStaffId');
    }

    function callQueue() {
        // Inisialisasi ID Staff dan Loket yang dipilih
        const staffId = getSelectedStaffId();
        const loket = document.getElementById('loket').value;

        // Logika Jika Belum ada Staff yang Dipilih dari Dropdown, maka Belum Dapat Memanggil Queue
        if (!staffId) {
            alert('Pilih staff terlebih dahulu.');
            return;
        }

        // Melakukan POST Request ke /api/queue/request dengan Value ID Staff dari body html
        fetch('/api/queue/request', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ staff_id: staffId })
        })
            .then(res => {
                if (!res.ok) {
                    throw new Error(`HTTP error! status: ${res.status}`);
                }
                return res.json();
            })
            .then(data => {
                // Logika Jika Objek Queue Memiliki Properti queue_number
                if (data.queue && data.queue.queue_number) {
                    // Maka Lakukan Inisialisasi ke Variabel nomor dan Mengubah currentQueueId yang Sekarang
                    const nomor = data.queue.queue_number;
                    currentQueueId = data.queue.id;

                    // Output dengan Pemanggilan Variabel nomor dan loket
                    const outputText = `Nomor Antrian ${nomor}, Silakan ke Loket ${loket}`;
                    const queueNumberEl = document.getElementById('queue-number');
                    queueNumberEl.textContent = outputText;
                    queueNumberEl.classList.add('animate-pulse');

                    speakText(outputText);

                    // Mengubah Warna Button Ketika Diklik
                    const callBtn = document.getElementById('call-btn');
                    const doneBtn = document.getElementById('done-btn');
                    
                    callBtn.disabled = true;
                    callBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    doneBtn.disabled = false;
                    doneBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    // Jika Gagal Seperti Objek Queue Tidak Memiliki Properti queue_number
                    const message = data.message || 'Gagal memanggil antrian';
                    const queueNumberEl = document.getElementById('queue-number');
                    queueNumberEl.textContent = message;
                    queueNumberEl.classList.remove('queue-number');
                    queueNumberEl.classList.add('text-red-600', 'text-xl', 'font-semibold');
                    speakText(message);
                }
            })
            .catch(error => {
                console.error('Error calling queue:', error);
                const errorText = 'Terjadi kesalahan';
                const queueNumberEl = document.getElementById('queue-number');
                queueNumberEl.textContent = errorText;
                queueNumberEl.classList.remove('queue-number');
                queueNumberEl.classList.add('text-red-600', 'text-xl', 'font-semibold');
                speakText(errorText);
            });
    }

    // Hampir Sama Metode Fungsinya, Tapi Fungsinya untuk Mengubah Status Queue Menjadi done
    function finishQueue() {
        const staffId = getSelectedStaffId();

        if (!currentQueueId || !staffId) {
            alert('Tidak ada antrian aktif atau staff belum dipilih.');
            return;
        }

        fetch('/api/queue/finish', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                staff_id: staffId,
                queue_id: currentQueueId
            })
        })
            .then(res => {
                if (!res.ok) {
                    throw new Error(`HTTP error! status: ${res.status}`);
                }
                return res.json();
            })
            .then(() => {
                currentQueueId = null;
                const callBtn = document.getElementById('call-btn');
                const doneBtn = document.getElementById('done-btn');
                const queueNumberEl = document.getElementById('queue-number');
                
                callBtn.disabled = false;
                callBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                doneBtn.disabled = true;
                doneBtn.classList.add('opacity-50', 'cursor-not-allowed');

                const finishText = 'Antrian selesai. Terima Kasih Sudah Menggunakan Pelayanan Kami.';
                queueNumberEl.textContent = finishText;
                queueNumberEl.classList.remove('queue-number', 'animate-pulse');
                queueNumberEl.classList.add('text-green-600', 'text-xl', 'font-semibold');
                speakText(finishText);
            })
            .catch(error => {
                console.error('Error finishing queue:', error);
                alert('Gagal menyelesaikan antrian.');
            });
    }

    // Metode Sama Seperti Sebelumnya, Tapi Fungsinya Hanya Untuk Mengambil Nomer Antrian Selanjutnya (Belum Memanggil Antrian)
    function fetchNextQueue() {
        fetch('/api/queue/next')
            .then(res => {
                if (!res.ok) {
                    throw new Error(`HTTP error! status: ${res.status}`);
                }
                return res.json();
            })
            .then(data => {
                const queueNumberElement = document.getElementById('queue-number');

                if (data.queue_number) {
                    queueNumberElement.textContent = data.queue_number;
                    queueNumberElement.className = 'queue-number mb-6 md:mb-8 min-h-[5rem] md:min-h-[6rem] flex items-center justify-center';
                } else {
                    queueNumberElement.textContent = 'Tidak Ada Antrian';
                    queueNumberElement.className = 'text-gray-600 text-xl md:text-2xl font-semibold mb-6 md:mb-8 min-h-[5rem] md:min-h-[6rem] flex items-center justify-center';
                }
            })
            .catch(error => {
                console.error('Error fetching next queue:', error);
                const queueNumberElement = document.getElementById('queue-number');
                queueNumberElement.textContent = 'Error!';
                queueNumberElement.classList.remove('queue-number');
                queueNumberElement.classList.add('text-red-600', 'text-xl', 'font-semibold');
            });
    }

    // Add keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey || e.metaKey) {
            switch(e.key) {
                case 'c':
                    e.preventDefault();
                    callQueue();
                    break;
                case 'd':
                    e.preventDefault();
                    finishQueue();
                    break;
                case 'n':
                    e.preventDefault();
                    fetchNextQueue();
                    break;
            }
        }
    });
</script>
@endsection