<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Tidak Tersedia - {{ config('app.name', 'Poros Aktual') }}</title>
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
                <svg class="w-32 h-32 mx-auto text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                </svg>
            </div>
            <h1 class="text-8xl font-black text-purple-500 mb-4">503</h1>
            <h2 class="text-2xl font-bold text-gray-900 mb-3">Layanan Tidak Tersedia</h2>
            <p class="text-gray-500 mb-8">Saat ini server sedang dalam pemeliharaan. Silakan coba kembali beberapa saat lagi.</p>
            <div class="flex items-center justify-center gap-4">
                <a href="/" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition shadow-md">
                    Kembali ke Beranda
                </a>
                <button onclick="setTimeout(() => location.reload(), 10000)" class="px-6 py-3 bg-white hover:bg-gray-100 text-gray-700 font-medium rounded-lg border border-gray-300 transition">
                    Coba Lagi (10 detik)
                </button>
            </div>
        </div>
    </main>
    <footer class="bg-white border-t py-4 text-center text-sm text-gray-400">
        &copy; {{ date('Y') }} {{ config('app.name', 'Poros Aktual') }}
    </footer>
</body>
</html>
