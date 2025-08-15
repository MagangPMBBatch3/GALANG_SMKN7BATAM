<x-layouts.main title="Data Aktivitas">
    <div class="bg-white p-4 rounded shadow w-full">
        <h1 class="text-2xl font-bold mb-4">Data Aktivitas</h1>

        {{-- Tombol Tambah & Pencarian --}}
        <div class="flex justify-between mb-4">
            <input type="text" id="searchAktivitas" name="searchAktivitas" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="Cari Bagian atau Nama Aktivitas..." class="border p-2 rounded w-64" oninput="searchAktivitas()">
            <button onclick="openAddAktivitasModal()" class="bg-blue-500 text-white px-4 py-2 rounded">
                Tambah Data
            </button>
        </div>

        {{-- Tabs Aktif / Arsip --}}
        <div class="mb-4">
            <button onclick="showTabAktivitas('aktif')" id="tabAktifAktivitas" class="px-4 py-2 bg-blue-500 text-white rounded-t">
                Data Aktif
            </button>
            <button onclick="showTabAktivitas('arsip')" id="tabArsipAktivitas" class="px-4 py-2 bg-gray-300 text-black rounded-t">
                Data Arsip
            </button>
        </div>

        {{-- Tabel Data Aktif --}}
        <div id="tableAktifAktivitas">
            <table class="w-full border">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Bagian</th>
                        <th class="p-2 border">No WBS</th>
                        <th class="p-2 border">Nama Aktivitas</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody id="dataAktivitas"></tbody>
            </table>
        </div>

        {{-- Tabel Data Arsip --}}
        <div id="tableArsipAktivitas" class="hidden">
            <table class="w-full border">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Bagian</th>
                        <th class="p-2 border">No WBS</th>
                        <th class="p-2 border">Nama Aktivitas</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody id="dataAktivitasArsip"></tbody>
            </table>
        </div>
    </div>

    {{-- Include Modal Tambah --}}
    @include('components.aktivitas.modal-add')

    {{-- Include Modal Edit --}}
    @include('components.aktivitas.modal-edit')

    {{-- Script --}}
    <script src="{{ asset('js/aktivitas/aktivitas.js') }}"></script>
    <script src="{{ asset('js/aktivitas/aktivitas-create.js') }}"></script>
    <script src="{{ asset('js/aktivitas/aktivitas-edit.js') }}"></script>
</x-layouts.main>