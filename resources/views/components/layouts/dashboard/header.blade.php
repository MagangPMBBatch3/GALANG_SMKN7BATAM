<div class="bg-gradient-to-br from-blue-600 via-blue-500 to-indigo-600 rounded-2xl shadow-xl p-8 mb-8">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-6">
            <div class="w-16 h-16 rounded-full overflow-hidden bg-gray-200 shadow-md">
                <img id="userProfileFoto" src="{{ auth()->user()->userprofile->foto ?? '' }}" alt="Profile Photo" class="w-full h-full object-cover {{ auth()->user()->userprofile->foto ? '' : 'hidden' }}">
            </div>
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">Selamat datang, <span id="userProfileNamaLengkap">{{ auth()->user()->userprofile->nama_lengkap ?? 'User' }}</span></h1>
                <p class="text-blue-100 text-lg">Sistem manajemen proyek</p>
            </div>
        </div>
        <div class="text-right">
            <div class="text-white">
                <p class="text-sm opacity-75">Hari ini</p>
                <p class="text-2xl font-bold">{{ \Carbon\Carbon::now()->format('d M Y') }}</p>
            </div>
        </div>
    </div>
</div>