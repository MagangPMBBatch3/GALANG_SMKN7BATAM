<x-layouts.main title="Data Keterangan">
    <div class="bg-white p-4 rounded shadow w-full">
        <h1 class="text-2xl font-bold mb-4">Data Keterangan</h1>

        <div class="flex justify-between mb-4">
            <input type="text" id="searchKeterangan" name="searchKeterangan" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="Cari Bagian atau Proyek..." class="border p-2 rounded w-64" oninput="searchKeterangan()">
            <button onclick="openAddKeteranganModal()" class="bg-blue-500 text-white px-4 py-2 rounded">
                Tambah Data
            </button>
        </div>

        <div class="mb-4">
            <button onclick="showTabKeterangan('aktif')" id="tabAktifKeterangan" class="px-4 py-2 bg-blue-500 text-white rounded-t">
                Data Aktif
            </button>
            <button onclick="showTabKeterangan('arsip')" id="tabArsipKeterangan" class="px-4 py-2 bg-gray-300 text-black rounded-t">
                Data Arsip
            </button>
        </div>

        <div id="tableAktifKeterangan">
            <table class="w-full border">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Bagian</th>
                        <th class="p-2 border">Proyek</th>
                        <th class="p-2 border">Tanggal</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody id="dataKeterangan"></tbody>
            </table>
        </div>

        <div id="tableArsipKeterangan" class="hidden">
            <table class="w-full border">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Bagian</th>
                        <th class="p-2 border">Proyek</th>
                        <th class="p-2 border">Tanggal</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody id="dataKeteranganArsip"></tbody>
            </table>
        </div>
    </div>

    @include('components.keterangan.modal-add')

    @include('components.keterangan.modal-edit')

    <script src="{{ asset('js/keterangan/keterangan.js') }}"></script>
    <script src="{{ asset('js/keterangan/keterangan-create.js') }}"></script>
    <script src="{{ asset('js/keterangan/keterangan-edit.js') }}"></script>
</x-layouts.main>
