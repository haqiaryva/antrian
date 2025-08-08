@extends('layouts.app')

@section('content')
<div class="animate-fade-in-up">
    <!-- Header Section - More compact -->
    <div class="text-center mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-1">Queue Management</h1>
        <p class="text-sm md:text-base text-gray-500">Kelola antrian pelanggan dengan efisien</p>
    </div>

    <!-- Main Queue Interface -->
    <div class="max-w-3xl mx-auto">
        <!-- Counter Selection - Simplified -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
            <div class="px-4 py-3 border-b border-gray-200">
                <h2 class="text-base font-medium text-gray-800">Pengaturan Loket</h2>
            </div>
            <div class="p-4">
                <div class="flex flex-col md:flex-row md:items-center gap-3">
                    <label for="loket" class="text-sm font-medium text-gray-700">Pilih Loket:</label>
                    <div class="relative flex-1">
                        <select id="loket" 
                                class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm"
                                aria-label="Pilih loket untuk antrian">
                            <option value="1">Loket 1</option>
                            <option value="2">Loket 2</option>
                            <option value="3">Loket 3</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Queue Display - Cleaner layout -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
            <div class="px-4 py-3 border-b border-gray-200">
                <h2 class="text-base font-medium text-gray-800">Antrian Saat Ini</h2>
            </div>
            <div class="p-4 text-center">
                <div id="queue-number" class="mb-4 min-h-[4rem] flex items-center justify-center text-xl font-semibold text-gray-700" role="status" aria-live="polite">
                    Nomer Antrian (R001/W001)
                </div>

                <!-- Control Buttons - More compact -->
                <div class="flex flex-col sm:flex-row flex-wrap justify-center gap-2">
                    <button id="call-btn" onclick="callQueue()" 
                            class="flex-1 min-w-[150px] bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 shadow hover:shadow-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 flex items-center justify-center"
                            aria-label="Panggil antrian berikutnya">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Panggil
                    </button>
                    
                    <button id="done-btn" onclick="finishQueue()" 
                            class="flex-1 min-w-[150px] bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 shadow hover:shadow-md text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 flex items-center justify-center"
                            disabled
                            aria-label="Selesaikan antrian saat ini">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Selesai
                    </button>
                    
                    <button onclick="fetchNextQueue()" 
                            class="flex-1 min-w-[150px] bg-orange-600 hover:bg-orange-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 shadow hover:shadow-md text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 flex items-center justify-center"
                            aria-label="Lihat antrian berikutnya">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Lihat Berikutnya
                    </button>
                </div>
            </div>
        </div>

        <div class="mt-6 text-center">
            <p class="text-xs text-gray-400">
                © 2025 Antrian Digital. Sistem antrian Indibiz.
            </p>
        </div>
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
                    queueNumberEl.className = 'mb-4 min-h-[4rem] flex items-center justify-center text-xl font-semibold text-blue-600 animate-pulse';

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
                    queueNumberEl.className = 'mb-4 min-h-[4rem] flex items-center justify-center text-xl font-semibold text-red-600';
                    speakText(message);
                }
            })
            .catch(error => {
                console.error('Error calling queue:', error);
                const errorText = 'Terjadi kesalahan';
                const queueNumberEl = document.getElementById('queue-number');
                queueNumberEl.textContent = errorText;
                queueNumberEl.className = 'mb-4 min-h-[4rem] flex items-center justify-center text-xl font-semibold text-red-600';
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
                queueNumberEl.className = 'mb-4 min-h-[4rem] flex items-center justify-center text-xl font-semibold text-green-600';
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
                    queueNumberElement.className = 'mb-4 min-h-[4rem] flex items-center justify-center text-xl font-semibold text-gray-700';
                } else {
                    queueNumberElement.textContent = 'Tidak Ada Antrian';
                    queueNumberElement.className = 'mb-4 min-h-[4rem] flex items-center justify-center text-xl font-semibold text-gray-500';
                }
            })
            .catch(error => {
                console.error('Error fetching next queue:', error);
                const queueNumberElement = document.getElementById('queue-number');
                queueNumberElement.textContent = 'Error!';
                queueNumberElement.className = 'mb-4 min-h-[4rem] flex items-center justify-center text-xl font-semibold text-red-600';
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