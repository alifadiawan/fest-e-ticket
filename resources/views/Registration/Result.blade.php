<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sucess</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 px-4">
        <div class="bg-white shadow-lg rounded-2xl p-8 max-w-md w-full text-center">
            {{-- Icon Success --}}
            <div class="flex items-center justify-center w-20 h-20 rounded-full bg-green-100 mx-auto">
                <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2l4-4m6 2a9 9 0 11-18 0a9 9 0 0118 0z" />
                </svg>
            </div>

            {{-- Title --}}
            <h1 class="text-2xl font-bold text-gray-800 mt-4">Token Berhasil di-Claim!</h1>
            <p class="text-gray-600 mt-2">
                Token <code class="text-blue-600">----</code> sudah berhasil digunakan.<br>
                Anda boleh menutup halaman ini sekarang.
            </p>

            {{-- Event Info (opsional, kalau mau tetap ditampilkan) --}}
            <div class="mt-6 border rounded-xl p-4 bg-gray-50 text-left">
                <p><span class="font-semibold">Event:</span>-------</p>
                <p><span class="font-semibold">Tanggal:</span>
            </div>
        </div>
    </div>
</body>

</html>