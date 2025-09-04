<div id="modalViewUserProfile" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50 transition-opacity duration-300 hidden p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden transform transition-all duration-300">
        <div class="bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 p-6 md:p-8 relative">
            <button onclick="closeUserProfileModal()" class="absolute top-4 right-4 text-white hover:text-gray-200 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="flex flex-col md:flex-row items-center space-x-0 md:space-x-6">
                <div class="w-20 h-20 md:w-24 md:h-24 rounded-full overflow-hidden bg-gray-200 shadow-lg ring-4 ring-white">
                    <img id="modalUserProfileFoto" src="" alt="Profile Photo" class="w-full h-full object-cover hidden">
                </div>
                <div class="mt-4 md:mt-0 text-center md:text-left">
                    <h1 id="modalUserProfileNamaLengkap" class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-white">-</h1>
                    <p class="text-indigo-100 text-base md:text-lg opacity-90">Informasi Profil Rekan Kerja</p>
                </div>
            </div>
        </div>

        <div class="p-6 md:p-8 bg-white overflow-y-auto max-h-[50vh]">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-600">ID</label>
                    <p id="modalUserProfileId" class="mt-1 text-gray-900 font-semibold break-words">-</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">NRP</label>
                    <p id="modalUserProfileNrp" class="mt-1 text-gray-900 font-semibold break-words">-</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Email</label>
                    <p id="modalUserProfileEmail" class="mt-1 text-gray-900 font-semibold break-words">-</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Alamat</label>
                    <p id="modalUserProfileAlamat" class="mt-1 text-gray-900 font-semibold break-words">-</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Level</label>
                    <p id="modalUserProfileLevel" class="mt-1 text-gray-900 font-semibold break-words">-</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Status</label>
                    <p id="modalUserProfileStatus" class="mt-1 text-gray-900 font-semibold break-words">-</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-600">Bagian</label>
                    <p id="modalUserProfileBagian" class="mt-1 text-gray-900 font-semibold break-words">-</p>
                </div>
            </div>
        </div>
    </div>
</div>
