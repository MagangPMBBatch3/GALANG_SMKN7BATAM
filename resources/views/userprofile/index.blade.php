
<meta name="csrf-token" content="{{ csrf_token() }}">
<x-layouts.main title="My Profile">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-2xl mx-auto mt-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Profil Saya</h1>

        <!-- Profile Display -->
        <div id="userProfileContainer" class="space-y-6">
            <!-- Placeholder for profile data -->
            <div class="flex items-center space-x-4">
                <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-200">
                    <img id="userProfileFoto" src="" alt="Profile Photo" class="w-full h-full object-cover hidden">
                </div>
                <div>
                    <h2 id="userProfileNamaLengkap" class="text-xl font-semibold text-gray-900"></h2>
                    <p id="userProfileEmail" class="text-gray-600"></p>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">ID</label>
                    <p id="userProfileId" class="mt-1 text-gray-900"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">NRP</label>
                    <p id="userProfileNrp" class="mt-1 text-gray-900"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Alamat</label>
                    <p id="userProfileAlamat" class="mt-1 text-gray-900"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Level</label>
                    <p id="userProfileLevel" class="mt-1 text-gray-900"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <p id="userProfileStatus" class="mt-1 text-gray-900"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Bagian</label>
                    <p id="userProfileBagian" class="mt-1 text-gray-900"></p>
                </div>
            </div>
            <div class="flex justify-end">
                <button onclick="openEditUserProfileModal()" id="editProfileButton" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">Edit Profil</button>
            </div>
        </div>

        <!-- No Data Message -->
        <div id="noDataMessage" class="hidden text-center text-gray-500 p-4">
            Tidak ada data profil
        </div>
    </div>

    <!-- Include Modal Edit -->
    @include('components.userprofile.modal-edit')

    <!-- Scripts -->
    <script>
        window.authUserId = {{ Auth::id() }};
    </script>
    <script src="{{ asset('js/userprofile/userprofile.js') }}"></script>
    <script src="{{ asset('js/userprofile/userprofile-edit.js') }}"></script>
</x-layouts.main>
