<x-layouts.main title="Dashboard">
    <div class="bg-gradient-to-r from-blue-400 to-blue-600 rounded-lg shadow-lg p-8 mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-white mb-1">Dashboard</h1>
            <p class="text-blue-100">Selamat datang kembali, <span class="font-semibold">{{ Auth::user()->name }}</span>!</p>
        </div>
        <div>
            <svg class="w-16 h-16 text-blue-200" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6" />
            </svg>
        </div>
    </div>
    <div class="bg-white p-8 rounded-lg shadow text-gray-700">
        <h2 class="text-2xl font-semibold mb-2">Informasi Akun</h2>
        <ul class="mb-4">
            <li><span class="font-medium">Nama:</span> {{ Auth::user()->name }}</li>
            <li><span class="font-medium">Email:</span> {{ Auth::user()->email }}</li>
        </ul>
        <p class="text-sm text-gray-500">Pastikan data Anda selalu up-to-date.</p>
    </div>
</x-layouts.main>