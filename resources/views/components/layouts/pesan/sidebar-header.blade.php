@props(['userProfile', 'userLevel'])
<div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-4 text-white sticky top-0 z-10">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Pesan</h1>
        <button onclick="closeSidebar()" class="md:hidden text-white hover:bg-blue-700 p-2 rounded-full transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    <div class="flex items-center space-x-3 mb-4 p-3 bg-white bg-opacity-10 rounded-lg">
        @if($userProfile->foto)
            <img src="{{ asset($userProfile->foto) }}" alt="{{ $userProfile->nama_lengkap }}" class="w-16 h-16 rounded-full object-cover border-2 border-white">
        @else
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center border-2 border-white">
                <span class="text-white font-semibold text-lg">{{ substr($userProfile->nama_lengkap, 0, 1) }}</span>
            </div>
        @endif
        <div class="flex-1 min-w-0">
            <p class="text-white font-medium text-sm truncate">{{ $userProfile->nama_lengkap }}</p>
            <p class="text-blue-100 text-xs">{{ $userLevel->nama }}</p>
        </div>
    </div>
    <button onclick="openModal('addPesanModal')" class="bg-white text-blue-600 px-4 py-2 rounded-full text-sm font-medium hover:bg-gray-100 transition-colors w-full md:w-auto">
        Pesan Baru
    </button>
</div>