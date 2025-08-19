<x-layouts.main title="Data Status Jam Kerja">
    <div class="bg-white p-4 rounded shadow w-full">
        <h1 class="text-2xl font-bold mb-4">Data Status Jam Kerja</h1>

        <div class="flex justify-between mb-4">
            <input type="text" id="searchStatusJamKerja" name="searchStatusJamKerja" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="Cari Status Jam Kerja..." class="border p-2 rounded w-64" oninput="searchStatusJamKerja()">
            <button onclick="openAddStatusJamKerjaModal()" class="bg-blue-500 text-white px-4 py-2 rounded">
                Tambah Data
            </button>
        </div>

        <div class="mb-4">
            <button onclick="showTabStatusJamKerja('aktif')" id="tabAktifStatusJamKerja" class="px-4 py-2 bg-blue-500 text-white rounded-t">
                Data Aktif
            </button>
            <button onclick="showTabStatusJamKerja('arsip')" id="tabArsipStatusJamKerja" class="px-4 py-2 bg-gray-300 text-black rounded-t">
                Data Arsip
            </button>
        </div>

        <div id="tableAktifStatusJamKerja">
            <table class="w-full border">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nama</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody id="dataStatusJamKerja"></tbody>
            </table>
        </div>

        <div id="tableArsipStatusJamKerja" class="hidden">
            <table class="w-full border">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nama</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody id="dataStatusJamKerjaArsip"></tbody>
            </table>
        </div>
    </div>

    @include('components.status-jam-kerja.modal-add')

    @include('components.status-jam-kerja.modal-edit')

    <script src="{{ asset('js/status-jam-kerja/status-jam-kerja.js') }}"></script>
    <script src="{{ asset('js/status-jam-kerja/status-jam-kerja-create.js') }}"></script>
    <script src="{{ asset('js/status-jam-kerja/status-jam-kerja-edit.js') }}"></script>
</x-layouts.main>