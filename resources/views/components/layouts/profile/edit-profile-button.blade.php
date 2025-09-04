@props(['userProfile'])
<div class="flex justify-end">
    <button onclick="openEditUserProfileModal()" id="editProfileButton" 
            class="flex items-center p-3 bg-gradient-to-r from-yellow-400 to-yellow-500 text-white rounded-lg hover:from-yellow-500 hover:to-yellow-600 transition-all"
            data-profile='{{ json_encode([
                "id" => $userProfile->id ?? "",
                "user_id" => $userProfile->user_id ?? "",
                "nama_lengkap" => $userProfile->nama_lengkap ?? "",
                "nrp" => $userProfile->nrp ?? "",
                "alamat" => $userProfile->alamat ?? "",
                "foto" => $userProfile->foto ?? "",
                "bagian_id" => $userProfile->bagian_id ?? "",
                "level_id" => $userProfile->level_id ?? "",
                "status_id" => $userProfile->status_id ?? ""
            ]) }}'>
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
        <span>Edit Profil</span>
    </button>
</div>