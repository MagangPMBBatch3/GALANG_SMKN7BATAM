<x-layouts.main title="Data User">
    <div class="bg-white p-4 rounded shadow w-full">
        <h1 class="text-2xl font-bold mb-4">Data User</h1>

        {{-- Tombol Tambah & Pencarian --}}
        <div class="flex justify-between mb-4">
            <input type="text" id="searchUser" name="searchUser" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="Cari ID, Namal..." class="border p-2 rounded w-64" oninput="searchUser()">
            <button onclick="openAddUserModal()" class="bg-blue-500 text-white px-4 py-2 rounded">
                Tambah Data
            </button>
        </div>

        {{-- Tabs Aktif / Arsip --}}
        <div class="mb-4">
            <button onclick="showTabUser('aktif')" id="tabAktifUser" class="px-4 py-2 bg-blue-500 text-white rounded-t">
                Data Aktif
            </button>
            <button onclick="showTabUser('arsip')" id="tabArsipUser" class="px-4 py-2 bg-gray-300 text-black rounded-t">
                Data Arsip
            </button>
        </div>

        {{-- Tabel Data Aktif --}}
        <div id="tableAktifUser">
            <table class="w-full border">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nama</th>
                        <th class="p-2 border">Email</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody id="dataUser"></tbody>
            </table>
        </div>

        {{-- Tabel Data Arsip --}}
        <div id="tableArsipUser" class="hidden">
            <table class="w-full border">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nama</th>
                        <th class="p-2 border">Email</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody id="dataUserArsip"></tbody>
            </table>
        </div>
    </div>
    {{-- Include Modal Tambah --}}
    @include('components.user.modal-add')

    {{-- Include Modal Edit --}}
    @include('components.user.modal-edit')

    {{-- Script --}}
    <script src="{{ asset('js/user/user.js') }}"></script>
    <script src="{{ asset('js/user/user-create.js') }}"></script>
    <script src="{{ asset('js/user/user-edit.js') }}"></script>

    <script>
        function showTabUser(tab) {
            const tabAktif = document.getElementById('tabAktifUser');
            const tabArsip = document.getElementById('tabArsipUser');
            const tableAktif = document.getElementById('tableAktifUser');
            const tableArsip = document.getElementById('tableArsipUser');

            if (tab === 'aktif') {
                tabAktif.classList.add('bg-blue-500', 'text-white');
                tabAktif.classList.remove('bg-gray-300', 'text-black');
                tabArsip.classList.remove('bg-blue-500', 'text-white');
                tabArsip.classList.add('bg-gray-300', 'text-black');
                tableAktif.classList.remove('hidden');
                tableArsip.classList.add('hidden');
                loadUserData();
            } else {
                tabArsip.classList.add('bg-blue-500', 'text-white');
                tabArsip.classList.remove('bg-gray-300', 'text-black');
                tabAktif.classList.add('bg-gray-300', 'text-black');
                tabAktif.classList.remove('bg-blue-500', 'text-white');
                tableArsip.classList.remove('hidden');
                tableAktif.classList.add('hidden');
                loadUserData();
            }
        }
    </script>
</x-layouts.main>