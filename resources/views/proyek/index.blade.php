
<x-layouts.main title="Data Proyek">
    <div class="bg-white p-4 rounded shadow w-full">
        <h1 class="text-2xl font-bold mb-4">Data Proyek</h1>

        <div class="flex justify-between mb-4">
            <input type="text" id="searchProyek" name="searchProyek" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="Cari Kode, Nama, atau Nama Sekolah..." class="border p-2 rounded w-64" oninput="searchProyek()">
            <button onclick="openAddProyekModal()" class="bg-blue-500 text-white px-4 py-2 rounded">
                Tambah Data
            </button>
        </div>

        <div class="mb-4">
            <button onclick="showTabProyek('aktif')" id="tabAktifProyek" class="px-4 py-2 bg-blue-500 text-white rounded-t">
                Data Aktif
            </button>
            <button onclick="showTabProyek('arsip')" id="tabArsipProyek" class="px-4 py-2 bg-gray-300 text-black rounded-t">
                Data Arsip
            </button>
        </div>

        <div id="tableAktifProyek">
            <table class="w-full border">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Kode</th>
                        <th class="p-2 border">Nama</th>
                        <th class="p-2 border">Tanggal</th>
                        <th class="p-2 border">Nama Sekolah</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody id="dataProyek"></tbody>
            </table>
        </div>

        <div id="tableArsipProyek" class="hidden">
            <table class="w-full border">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Kode</th>
                        <th class="p-2 border">Nama</th>
                        <th class="p-2 border">Tanggal</th>
                        <th class="p-2 border">Nama Sekolah</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody id="dataProyekArsip"></tbody>
            </table>
        </div>
    </div>

    @include('components.proyek.modal-add')

    @include('components.proyek.modal-edit')

    <script src="{{ asset('js/proyek/proyek.js') }}"></script>
    <script src="{{ asset('js/proyek/proyek-create.js') }}"></script>
    <script src="{{ asset('js/proyek/proyek-edit.js') }}"></script>
</x-layouts.main>
