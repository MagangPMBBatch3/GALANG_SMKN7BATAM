@props(['userProfile'])
<div class="bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-3xl shadow-2xl p-8 mb-8">
    <div class="flex flex-col md:flex-row items-center justify-between">
        <div class="flex items-center space-x-6">
            <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-200 shadow-lg ring-4 ring-white">
                <img id="userProfileFoto" src="{{ $userProfile->foto ?? '' }}" alt="Profile Photo" class="{{ $userProfile->foto ? '' : 'hidden' }}">
            </div>
            <div>
                <h1 class="text-4xl font-extrabold text-white mb-2" id="userProfileNamaLengkap">{{ $userProfile->nama_lengkap ?? '-' }}</h1>
                <p class="text-indigo-100 text-lg opacity-90">Kelola informasi pribadi Anda</p>
            </div>
        </div>
        <div class="text-right mt-4 md:mt-0">
            <div class="text-white">
                <p class="text-sm opacity-75">Terakhir Diperbarui</p>
                <p class="text-xl font-bold">{{ \Carbon\Carbon::now()->format('d M Y') }}</p>
            </div>
        </div>
    </div>
</div>