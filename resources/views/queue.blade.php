@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Queue</h1>

    <div class="mb-4">
        <label for="loket" class="block font-semibold mb-1">Pilih Loket:</label>
        <select id="loket" class="border border-gray-300 p-2 rounded">
            <option value="1">Loket 1</option>
            <option value="2">Loket 2</option>
            <option value="3">Loket 3</option>
        </select>
    </div>

    <div class="mb-6 text-center">
        <div id="queue-number" class="text-4xl font-bold text-blue-700 mb-10">Nomer Antrian (R001/W001)</div>

        <div class="flex justify-center space-x-4">
            <button id="call-btn" onclick="callQueue()" class="bg-blue-600 text-white px-4 py-2 rounded">Panggil</button>
            <button id="done-btn" onclick="finishQueue()" class="bg-green-600 text-white px-4 py-2 rounded"
                disabled>Selesai</button>
            <button onclick="fetchNextQueue()" class="bg-orange-400 text-white px-4 py-2 rounded">Lihat Antrian
                Berikutnya</button>
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
                // Akses Isi Data Melalui Pemanggilan JSON
                .then(res => res.json())
                .then(data => {
                    // Logika Jika Objek Queue Memiliki Properti queue_number
                    if (data.queue && data.queue.queue_number) {
                        // Maka Lakukan Inisialisasi ke Variabel nomor dan Mengubah currentQueueId yang Sekarang
                        const nomor = data.queue.queue_number;
                        currentQueueId = data.queue.id;

                        // Output dengan Pemanggilan Variabel nomor dan loket
                        const outputText = `Nomor Antrian ${nomor}, Silakan ke Loket ${loket}`;
                        document.getElementById('queue-number').textContent = outputText;

                        speakText(outputText);

                        // Mengubah Warna Button Ketika Diklik
                        document.getElementById('call-btn').disabled = true;
                        document.getElementById('call-btn').classList.add('bg-gray-400');
                        document.getElementById('done-btn').disabled = false;
                    } else {
                        // Jika Gagal Seperti Objek Queue Tidak Memiliki Properti queue_number
                        const message = data.message || 'Gagal memanggil antrian';
                        document.getElementById('queue-number').textContent = message;
                        speakText(message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    const errorText = 'Terjadi kesalahan';
                    document.getElementById('queue-number').textContent = errorText;
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
                .then(res => res.json())
                .then(() => {
                    currentQueueId = null;
                    document.getElementById('call-btn').disabled = false;
                    document.getElementById('call-btn').classList.remove('bg-gray-400');
                    document.getElementById('done-btn').disabled = true;

                    const finishText = 'Antrian selesai. Terima Kasih Sudah Menggunakan Pelayanan Kami.';
                    document.getElementById('queue-number').textContent = finishText;
                    speakText(finishText);
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal menyelesaikan antrian.');
                });
        }

        // Metode Sama Seperti Sebelumnya, Tapi Fungsinya Hanya Untuk Mengambil Nomer Antrian Selanjutnya (Belum Memanggil Antrian)
        function fetchNextQueue() {
            fetch('/api/queue/next')
                .then(res => res.json())
                .then(data => {
                    const queueNumberElement = document.getElementById('queue-number');

                    if (data.queue_number) {
                        queueNumberElement.textContent = data.queue_number;
                    } else {
                        queueNumberElement.textContent = 'Tidak Ada Antrian';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('queue-number').textContent = 'Error!';
                });
        }
    </script>
@endsection