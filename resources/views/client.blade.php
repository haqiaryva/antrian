<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client - Antrian Digital</title>
    <link rel="icon" type="image/png" href="{{ asset('unnamed.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">

    <nav class="bg-white shadow-md py-4 px-8">
        <div class="flex justify-between items-center w-full">
            <img src="/unnamed.png" alt="Logo" class="h-20 mx-7">

            <div class="text-2xl font-bold text-blue-600">
                Antrian Digital
            </div>

            <a href="{{ url('/') }}"
                class="bg-red-500 hover:bg-red-600 text-white font-semibold mx-5 py-2 px-4 rounded">
                Log Out
            </a>
        </div>
    </nav>

    <!-- Ini Tombol untuk Menambah Antrian Menggunakan POST dengan Input (R atau W) -->
    <main class="max-w-xl mx-auto mt-12 p-6 bg-white rounded-xl shadow-md text-center">
        <h1 class="text-2xl font-bold mb-4">Client</h1>

        <div class="flex justify-center space-x-6 mb-6">
            <button onclick="submitQueue('R')"
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition">Reservasi</button>
            <button onclick="submitQueue('W')"
                class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg transition">Walk-In</button>
        </div>

        <!-- Teks Kosong Untuk Menampilkan Nomer Antrian -->
        <div class="mt-6 text-xl font-semibold text-gray-800" id="your-number"></div>
    </main>

    <script>
        // Fungsinya Ini Untuk Tombol Menambah Nomer Antrian Tadi, Dan Menambah Teks Untuk Menampilkan Nomer Antrian
        function submitQueue(type) {
            fetch('/api/queue', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ type: type })
            })
                .then(res => res.json())
                .then(data => {
                    if (data?.data?.queue_number) {
                        document.getElementById('your-number').textContent = 'Nomor Antrian Anda: ' + data.data.queue_number;
                    } else {
                        document.getElementById('your-number').textContent = data.message || 'Terjadi kesalahan';
                    }
                })
                .catch(err => {
                    document.getElementById('your-number').textContent = 'Gagal menghubungi server.';
                });
        }
    </script>

</body>

</html>