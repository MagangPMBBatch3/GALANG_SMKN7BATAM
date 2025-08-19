<x-layouts.main title="My Profile">
    <div class="bg-gradient-to-br from-blue-600 via-blue-500 to-indigo-600 rounded-2xl shadow-xl p-8 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">Profil Saya</h1>
                <p class="text-blue-100 text-lg">Kelola informasi pribadi Anda</p>
            </div>
            <div class="text-right">
                <div class="text-white">
                    <p class="text-sm opacity-75">Terakhir Diperbarui</p>
                    <p class="text-xl font-bold">{{ \Carbon\Carbon::now()->format('d M Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6 max-w-2xl mx-auto hover:shadow-xl transition-shadow">
        <div id="userProfileContainer" class="space-y-6">
            <div class="flex items-center space-x-6">
                <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-200 shadow-md">
                    <img id="userProfileFoto" src="" alt="Profile Photo" class="w-full h-full object-cover hidden">
                </div>
                <div>
                    <h2 id="userProfileNamaLengkap" class="text-2xl font-semibold text-gray-900"></h2>
                    <p id="userProfileEmail" class="text-gray-600 text-sm mt-1"></p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-600">ID</label>
                    <p id="userProfileId" class="mt-1 text-gray-900 font-semibold"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">NRP</label>
                    <p id="userProfileNrp" class="mt-1 text-gray-900 font-semibold"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Alamat</label>
                    <p id="userProfileAlamat" class="mt-1 text-gray-900 font-semibold"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Level</label>
                    <p id="userProfileLevel" class="mt-1 text-gray-900 font-semibold"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Status</label>
                    <p id="userProfileStatus" class="mt-1 text-gray-900 font-semibold"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Bagian</label>
                    <p id="userProfileBagian" class="mt-1 text-gray-900 font-semibold"></p>
                </div>
            </div>
            <div class="flex justify-end">
                <button onclick="openEditUserProfileModal()" id="editProfileButton" class="flex items-center p-3 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>Edit Profil</span>
                </button>
            </div>
        </div>

        <div id="noDataMessage" class="hidden text-center text-gray-500 p-4 bg-gray-50 rounded-lg">
            Tidak ada data profil
        </div>
    </div>

    @include('components.userprofile.modal-edit')

    <script>
        window.authUserId = {{ Auth::id() }};
    </script>
    <script src="{{ asset('js/userprofile/userprofile.js') }}"></script>
    <script src="{{ asset('js/userprofile/userprofile-edit.js') }}"></script>
</x-layouts.main>