<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terlalu Banyak Permintaan - {{ config('app.name', 'Poros Aktual') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .animate-float { animation: float 3s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-15px); } }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <a href="/" class="text-2xl font-extrabold tracking-tight">
                <span class="text-blue-700">Poros</span><span class="text-red-600">Aktual</span>
            </a>
        </div>
    </header>
    <main class="flex-1 flex items-center justify-center px-4">
        <div class="text-center max-w-lg">
            <div class="animate-float mb-8">
                <svg class="w-32 h-32 mx-auto text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <h1 class="text-8xl font-black text-orange-500 mb-4">429</h1>
            <h2 class="text-2xl font-bold text-gray-900 mb-3">Terlalu Banyak Permintaan</h2>
            <p class="text-gray-500 mb-8">Anda mengirim terlalu banyak permintaan. Silakan tunggu beberapa saat.</p>
            <div class="flex items-center justify-center gap-4">
                <a href="/" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition shadow-md">
                    Kembali ke Beranda
                </a>
                <button onclick="setTimeout(() => location.reload(), 5000)" class="px-6 py-3 bg-white hover:bg-gray-100 text-gray-700 font-medium rounded-lg border border-gray-300 transition">
                    Coba Lagi (5 detik)
                </button>
            </div>
        </div>
    </main>
    <footer class="bg-white border-t py-4 text-center text-sm text-gray-400">
        &copy; {{ date('Y') }} {{ config('app.name', 'Poros Aktual') }}
    </footer>
</body>
</html>
