<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Selamat Datang - Antrian Digital</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('unnamed.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="text-center">
        <div class="mb-6 flex justify-center">
            <img src="/unnamed.png" alt="Logo" class="h-40">
        </div>

        <h1 class="text-4xl font-bold text-blue-600 mb-12">Antrian Digital</h1>

        <div class="space-x-6">
            <a href="/dashboard"
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg text-lg font-medium transition">
                Dashboard
            </a>
            <a href="/client"
                class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg text-lg font-medium transition">
                Client
            </a>
        </div>
    </div>

</body>

</html>