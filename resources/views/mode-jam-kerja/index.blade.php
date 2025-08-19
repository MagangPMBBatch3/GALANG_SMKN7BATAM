<x-layouts.main title="Data Mode Jam Kerja">
    <div class="bg-white p-4 rounded shadow w-full">
        <h1 class="text-2xl font-bold mb-4">Data Mode Jam Kerja</h1>

        <div class="flex justify-between mb-4">
            <input type="text" id="searchModeJamKerja" name="searchModeJamKerja" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="Cari Mode Jam Kerja..." class="border p-2 rounded w-64" oninput="searchModeJamKerja()">
            <button onclick="openAddModeJamKerjaModal()" class="bg-blue-500 text-white px-4 py-2 rounded">
                Tambah Data
            </button>
        </div>

        <div class="mb-4">
            <button onclick="showTabModeJamKerja('aktif')" id="tabAktifModeJamKerja" class="px-4 py-2 bg-blue-500 text-white rounded-t">
                Data Aktif
            </button>
            <button onclick="showTabModeJamKerja('arsip')" id="tabArsipModeJamKerja" class="px-4 py-2 bg-gray-300 text-black rounded-t">
                Data Arsip
            </button>
        </div>

        <div id="tableAktifModeJamKerja">
            <table class="w-full border">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nama</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody id="dataModeJamKerja"></tbody>
            </table>
        </div>

            <table class="w-full border">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nama</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody id="dataModeJamKerjaArsip"></tbody>
            </table>
        </div>
    </div>

    @include('components.mode-jam-kerja.modal-add')

    @include('components.mode-jam-kerja.modal-edit')

    <script src="{{ asset('js/mode-jam-kerja/mode-jam-kerja.js') }}"></script>
    <script src="{{ asset('js/mode-jam-kerja/mode-jam-kerja-create.js') }}"></script>
    <script src="{{ asset('js/mode-jam-kerja/mode-jam-kerja-edit.js') }}"></script>
</x-layouts.main>