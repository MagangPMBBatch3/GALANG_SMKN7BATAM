<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Progress Project</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-profile-id" content="{{ auth()->user()->userprofile->id ?? 1 }}">
    <meta name="user-level-name" content="{{ auth()->user()->level->nama ?? 'User' }}">
    <meta name="user-profile-photo" content="{{ auth()->user()->userprofile->foto ?? '' }}">
    <meta name="user-profile-name" content="{{ auth()->user()->userprofile->nama_lengkap ?? 'User' }}">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link rel="stylesheet" href="{{ asset('css/scrollable-data.css') }}">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100 flex" x-data="sidebarState()" x-init="init()">
    <div x-show="isOpen" @click="isOpen = false" class="fixed inset-0 z-20 bg-black bg-opacity-50 lg:hidden" x-cloak></div>

    <aside class="fixed inset-y-0 left-0 z-30 w-64 min-h-screen p-5 bg-gradient-to-b from-blue-500 to-blue-700 shadow-lg transform -translate-x-full lg:translate-x-0 lg:static lg:inset-0 transition-transform duration-300 ease-in-out"
        :class="{ 'translate-x-0': isOpen }">

        <div class="flex items-center gap-2 mb-8">
            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow">
                <i class="fas fa-bars text-blue-600 text-lg"></i>
            </div>
            <h2 class="text-2xl font-bold text-white">Progres Project</h2>
        </div>

        <nav class="space-y-3 text-sm">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-2 rounded-lg text-white hover:bg-blue-600 transition">
                <i class="fas fa-home"></i>
                Dashboard
            </a>

            <a href="{{ route('userprofile') }}" class="flex items-center gap-3 p-2 rounded-lg text-white hover:bg-blue-600 transition">
                <i class="fas fa-user-circle"></i>
                Profil
            </a>

            <a href="{{ route('rekan')}}" class="flex items-center gap-3 p-2 rounded-lg text-white hover:bg-blue-600 transition">
                <i class="fas fa-person"></i>
                Rekan Kerja
            </a>
            
            <a href="{{ route('progres.kerja') }}" class="flex items-center gap-3 p-2 rounded-lg text-white hover:bg-blue-600 transition">
                <i class="fas fa-briefcase"></i>
                Progres Proyek
            </a>    

            @if(auth()->user()->level->nama === 'Admin')
            <div>
                <button @click="toggle('masterData')" class="flex items-center justify-between w-full p-2 rounded-lg text-white hover:bg-blue-600 transition">
                    <span class="flex items-center gap-3">
                        <i class="fas fa-database"></i>
                        Master Data
                    </span>
                    <i :class="openSection === 'masterData' ? 'fas fa-chevron-down rotate-180 transition-transform' : 'fas fa-chevron-down transition-transform'"></i>
                </button>
                <ul x-show="openSection === 'masterData'" x-collapse class="mt-2 pl-8 space-y-1" x-cloak>
                    <li><a href="{{ route('bagian') }}" class="block p-2 rounded-lg text-white hover:bg-blue-500 flex items-center gap-3"><i class="fas fa-sitemap"></i> Bagian</a></li>
                    <li><a href="{{ route('proyek') }}" class="block p-2 rounded-lg text-white hover:bg-blue-500 flex items-center gap-3"><i class="fas fa-project-diagram"></i> Proyek</a></li>
                    <li><a href="{{ route('aktivitas') }}" class="block p-2 rounded-lg text-white hover:bg-blue-500 flex items-center gap-3"><i class="fas fa-tasks"></i> Aktivitas</a></li>
                    <li><a href="{{ route('level') }}" class="block p-2 rounded-lg text-white hover:bg-blue-500 flex items-center gap-3"><i class="fas fa-layer-group"></i> Level</a></li>
                    <li><a href="{{ route('keterangan') }}" class="block p-2 rounded-lg text-white hover:bg-blue-500 flex items-center gap-3"><i class="fas fa-info-circle"></i> Keterangan</a></li>
                    <li><a href="{{ route('user') }}" class="block p-2 rounded-lg text-white hover:bg-blue-500 flex items-center gap-3"><i class="fas fa-users"></i> User</a></li>
                    <li><a href="{{ route('status') }}" class="block p-2 rounded-lg text-white hover:bg-blue-500 flex items-center gap-3"><i class="fas fa-info"></i> Status</a></li>
                    <li><a href="{{ route('jenis.pesan') }}" class="block p-2 rounded-lg text-white hover:bg-blue-500 flex items-center gap-3"><i class="fas fa-envelope-open-text"></i> Jenis Pesan</a></li>
                    <li><a href="{{ route('mode.jam.kerja') }}" class="block p-2 rounded-lg text-white hover:bg-blue-500 flex items-center gap-3"><i class="fas fa-clock"></i> Mode Jam Kerja</a></li>
                    <li><a href="{{ route('status.jam.kerja') }}" class="block p-2 rounded-lg text-white hover:bg-blue-500 flex items-center gap-3"><i class="fas fa-check-circle"></i> Status Jam Kerja</a></li>
                </ul>
            </div>
            @endif

            <a href="{{ route('lembur') }}" class="flex items-center gap-3 p-2 rounded-lg text-white hover:bg-blue-600 transition">
                <i class="fas fa-clock"></i>
                Lembur
            </a>

            <a href="{{ route('pesan') }}" class="flex items-center gap-3 p-2 rounded-lg text-white hover:bg-blue-600 transition">
                <i class="fas fa-envelope"></i>
                Pesan
            </a>

            <form action="/logout" method="POST" class="mt-6">
                @csrf
                <button type="submit" class="flex items-center gap-2 py-2 px-4 rounded-lg text-white bg-red-500 hover:bg-red-600 shadow transition">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </button>
            </form>
        </nav>
    </aside>

    <div class="flex-1 p-6 lg:ml-0">
        <button @click="isOpen = !isOpen" class="lg:hidden fixed top-4 left-4 z-40 p-2 bg-blue-600 text-white rounded-lg shadow-lg">
            <i class="fas fa-bars"></i>
        </button>
        <div class="pt-12 lg:pt-0">
            {{ $slot }}
        </div>
    </div>

    <script>
        function sidebarState() {
            return {
                isOpen: false,
                openSection: localStorage.getItem('sidebarOpen') || '',
                toggle(section) {
                    this.openSection = (this.openSection === section) ? '' : section;
                    localStorage.setItem('sidebarOpen', this.openSection);
                },
                init() {}
            }
        }
    </script>
</body>
</html>