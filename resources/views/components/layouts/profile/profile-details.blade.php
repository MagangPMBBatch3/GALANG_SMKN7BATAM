@props(['user', 'userProfile'])
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-medium text-gray-600">ID</label>
        <p id="userProfileId" class="mt-1 text-gray-900 font-semibold">{{ $userProfile->id ?? '-' }}</p>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-600">NRP</label>
        <p id="userProfileNrp" class="mt-1 text-gray-900 font-semibold">{{ $userProfile->nrp ?? '-' }}</p>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-600">Email</label>
        <p id="userProfileEmail" class="mt-1 text-gray-900 font-semibold">{{ $user->email ?? '-' }}</p>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-600">Alamat</label>
        <p id="userProfileAlamat" class="mt-1 text-gray-900 font-semibold">{{ $userProfile->alamat ?? '-' }}</p>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-600">Level</label>
        <p id="userProfileLevel" class="mt-1 text-gray-900 font-semibold">{{ $userProfile->level->nama ?? '-' }}</p>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-600">Status</label>
        <p id="userProfileStatus" class="mt-1 text-gray-900 font-semibold">{{ $userProfile->status->nama ?? '-' }}</p>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-600">Bagian</label>
        <p id="userProfileBagian" class="mt-1 text-gray-900 font-semibold">{{ $userProfile->bagian->nama ?? '-' }}</p>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-600">Total Jam Kerja</label>
        <p class="mt-1 text-gray-900 font-semibold">
            {{ \App\Models\JamKerja\JamKerja::where('user_profile_id', $userProfile->id)->sum('jumlah_jam') }} jam
        </p>
    </div>
</div>