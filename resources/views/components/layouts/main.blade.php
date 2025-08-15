<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: 'Inter', sans-serif; }
        details[open] summary svg {
            transform: rotate(90deg);
        }
    </style>
</head>
<body class="bg-gray-100 flex">
    <aside class="w-64 h-screen p-5 bg-gradient-to-b from-blue-500 to-blue-700 shadow-lg">
        <div class="flex items-center gap-2 mb-8">
            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-white">Menu</h2>
        </div>

        <nav class="space-y-3 text-sm">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-2 rounded-lg text-white hover:bg-blue-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-9 2v8" />
                </svg>
                Dashboard
            </a>

            <a href="{{ route('userprofile') }}" class="flex items-center gap-3 p-2 rounded-lg text-white hover:bg-blue-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zm-4 7c-3 0-5.5 1.5-7 4h14c-1.5-2.5-4-4-7-4z" />
                </svg>
                Profil
            </a>

            <details class="group">
                <summary class="flex items-center justify-between p-2 rounded-lg text-white hover:bg-blue-600 cursor-pointer">
                    <span class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m4 0H5" />
                        </svg>
                        Master Data
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </summary>
                <ul class="mt-2 pl-8 space-y-1">
                    <li><a href="{{ route('bagian') }}" class="block p-2 rounded-lg text-white hover:bg-blue-500">Bagian</a></li>
                    <li><a href="{{ route('proyek') }}" class="block p-2 rounded-lg text-white hover:bg-blue-500">Proyek</a></li>
                    <li><a href="{{ route('aktivitas') }}" class="block p-2 rounded-lg text-white hover:bg-blue-500">Aktivitas</a></li>
                    <li><a href="{{ route('level') }}" class="block p-2 rounded-lg text-white hover:bg-blue-500">Level</a></li>
                    <li><a href="{{ route('keterangan') }}" class="block p-2 rounded-lg text-white hover:bg-blue-500">Keterangan</a></li>
                    <li><a href="{{ route('user') }}" class="block p-2 rounded-lg text-white hover:bg-blue-500">User</a></li>
        
                    <li><a href="{{ route('status') }}" class="block p-2 rounded-lg text-white hover:bg-blue-500">Status</a></li>

                    <li><a href="{{ route('mode.jam.kerja') }}" class="block p-2 rounded-lg text-white hover:bg-blue-500">Mode Jam Kerja</a></li>
                    <li><a href="{{ route('status.jam.kerja') }}" class="block p-2 rounded-lg text-white hover:bg-blue-500">Status Jam Kerja</a></li>
                </ul>
            </details>

            <details class="group">
                <summary class="flex items-center justify-between p-2 rounded-lg text-white hover:bg-blue-600 cursor-pointer">
                    <span class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" />
                        </svg>
                        Progres Kerja
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </summary>
                <ul class="mt-2 pl-8 space-y-1">
                    <li><a href="#" class="block p-2 rounded-lg text-white hover:bg-blue-500">Jam Kerja</a></li>
                </ul>
            </details>

            <details class="group">
                <summary class="flex items-center justify-between p-2 rounded-lg text-white hover:bg-blue-600 cursor-pointer">
                    <span class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" />
                        </svg>
                        Lembur
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </summary>
                <ul class="mt-2 pl-8 space-y-1">
                    <li><a href="#" class="block p-2 rounded-lg text-white hover:bg-blue-500">Lembur</a></li>
                </ul>
            </details>

            <details class="group">
                <summary class="flex items-center justify-between p-2 rounded-lg text-white hover:bg-blue-600 cursor-pointer">
                    <span class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 14h.01M16 10h.01M21 16a2 2 0 01-2 2H5a2 2 0 01-2-2V8" />
                        </svg>
                        Pesan
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </summary>
                <ul class="mt-2 pl-8 space-y-1">
                    <li><a href="#" class="block p-2 rounded-lg text-white hover:bg-blue-500">Pesan</a></li>
                </ul>
            </details>
        </nav>
    </aside>

    <div class="flex-1 p-6">
        <form action="/logout" method="POST" class="mb-4">
            @csrf
            <button type="submit" class="flex items-center gap-2 py-2 px-4 rounded-lg text-white bg-red-500 hover:bg-red-600 shadow transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" />
                </svg>
                Logout
            </button>
        </form>
        <div>
            {{ $slot }}
        </div>
    </div>
</body>
</html>