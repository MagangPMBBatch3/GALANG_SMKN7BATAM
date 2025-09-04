<div id="modalViewUserProfile" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-2xl">
        <h2 class="text-2xl font-bold mb-6 text-center">Detail Profil</h2>
        
        <div class="flex flex-col md:flex-row items-center mb-6">
            <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-200 mr-6">
                <img id="modalUserProfileFoto" src="" alt="Profile Photo" class="w-full h-full object-cover">
            </div>
            <div>
                <h3 class="text-3xl font-bold" id="modalUserProfileNamaLengkap"></h3>
                <p class="text-gray-600" id="modalUserProfileNrp"></p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-600">ID</label>
                <p id="modalUserProfileId" class="text-gray-900 font-semibold"></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600">Email</label>
                <p id="modalUserProfileEmail" class="text-gray-900 font-semibold"></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600">Alamat</label>
                <p id="modalUserProfileAlamat" class="text-gray-900 font-semibold"></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600">Level</label>
                <p id="modalUserProfileLevel" class="text-gray-900 font-semibold"></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600">Status</label>
                <p id="modalUserProfileStatus" class="text-gray-900 font-semibold"></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600">Bagian</label>
                <p id="modalUserProfileBagian" class="text-gray-900 font-semibold"></p>
            </div>
        </div>

        <div class="flex justify-end">
            <button onclick="closeUserProfileModal()" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
function closeUserProfileModal() {
    document.getElementById('modalViewUserProfile').classList.add('hidden');
}

document.getElementById('modalViewUserProfile').addEventListener('click', function(e) {
    if (e.target === this) {
        closeUserProfileModal();
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeUserProfileModal();
    }
});
</script>
