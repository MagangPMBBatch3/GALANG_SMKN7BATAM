<x-layouts.main title="Dashboard">
    <div class="bg-gradient-to-r from-blue-400 to-blue-600 rounded-lg shadow-lg p-8 mb-6 flex items-center justify-between">
        <div class="flex items-center">
            @php
                $userProfile = \App\Models\UserProfile\UserProfile::where('user_id', Auth::id())->first();
            @endphp
            @if($userProfile && $userProfile->foto)
                <img src="{{ $userProfile->foto }}" alt="Profile Photo" class="h-24 w-24 rounded-full mr-5">
            @else
                <div class="h-16 w-16 rounded-full bg-gray-300 flex items-center justify-center mr-4">
                    <span class="text-white text-xl">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </div>
            @endif
            <div>
                <h1 class="text-3xl font-bold text-white mb-1">Dashboard</h1>
                <p class="text-blue-100">Selamat datang kembali, <span class="font-semibold">{{ Auth::user()->name }}</span>!</p>
            </div>
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
            @if($userProfile)
                <li><span class="font-medium">Nama Lengkap:</span> {{ $userProfile->nama_lengkap ?? '-' }}</li>
                <li><span class="font-medium">NRP:</span> {{ $userProfile->nrp ?? '-' }}</li>
                <li><span class="font-medium">Alamat:</span> {{ $userProfile->alamat ?? '-' }}</li>
                @if($userProfile->foto)
                    <li><span class="font-medium">Foto:</span> <img src="{{ $userProfile->foto }}" alt="Profile Photo" class="h-10 w-10 rounded-full inline-block"></li>
                @endif
                <li><span class="font-medium">Bagian:</span> {{ $userProfile->bagian ? $userProfile->bagian->nama : '-' }}</li>
                <li><span class="font-medium">Level:</span> {{ $userProfile->level ? $userProfile->level->nama : ($userProfile->level_id ?? '-') }}</li>
                <li><span class="font-medium">Status:</span> {{ $userProfile->status ? $userProfile->status->nama : ($userProfile->status_id ?? '-') }}</li>
                <li><span class="font-medium">Dibuat Pada:</span> {{ $userProfile->created_at ? $userProfile->created_at->format('d-m-Y H:i') : '-' }}</li>
                <li><span class="font-medium">Diperbarui Pada:</span> {{ $userProfile->updated_at ? $userProfile->updated_at->format('d-m-Y H:i') : '-' }}</li>
            @else
                <li><span class="font-medium">Informasi Profil:</span> Tidak ada data profil tersedia</li>
            @endif
        </ul>
    </div>
</x-layouts.main>