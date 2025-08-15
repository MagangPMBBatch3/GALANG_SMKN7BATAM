<x-layouts.main title="Data Status">
    <div class="bg-white p-4 rounded shadow w-full">
        <h1 class="text-2xl font-bold mb-4">Data Status</h1>

        {{-- Tombol Tambah & Pencarian --}}
        <div class="flex justify-between mb-4">
            <input type="text" id="searchStatus" placeholder="Cari ID atau Nama..." class="border p-2 rounded w-64" oninput="searchStatus()">
            <button onclick="openAddStatusModal()" class="bg-blue-500 text-white px-4 py-2 rounded">
                Tambah Data
            </button>
        </div>

        {{-- Tabs Aktif / Arsip --}}
        <div class="mb-4">
            <button onclick="showTab('aktif')" id="tabAktif" class="px-4 py-2 bg-blue-500 text-white rounded-t">
                Data Aktif
            </button>
            <button onclick="showTab('arsip')" id="tabArsip" class="px-4 py-2 bg-gray-300 text-black rounded-t">
                Data Arsip
            </button>
        </div>

        {{-- Tabel Data Aktif --}}
        <div id="tableAktif">
            <table class="w-full border">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nama</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody id="dataStatus"></tbody>
            </table>
        </div>

        {{-- Tabel Data Arsip --}}
        <div id="tableArsip" class="hidden">
            <table class="w-full border">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nama</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody id="dataStatusArsip"></tbody>
            </table>
        </div>
    </div>
    {{-- Include Modal Tambah --}}
@include('components.status.modal-add')

{{-- Include Modal Edit --}}
@include('components.status.modal-edit')

{{-- Script --}}
<script src="{{ asset('js/status/status.js') }}"></script>
<script src="{{ asset('js/status/status-create.js') }}"></script>
<script src="{{ asset('js/status/status-edit.js') }}"></script>

<script>
    function showTab(tab) {
        const tabAktif = document.getElementById('tabAktif');
        const tabArsip = document.getElementById('tabArsip');
        const tableAktif = document.getElementById('tableAktif');
        const tableArsip = document.getElementById('tableArsip');

        if (tab === 'aktif') {
            tabAktif.classList.add('bg-blue-500', 'text-white');
            tabAktif.classList.remove('bg-gray-300', 'text-black');
            tabArsip.classList.remove('bg-blue-500', 'text-white');
            tabArsip.classList.add('bg-gray-300', 'text-black');
            tableAktif.classList.remove('hidden');
            tableArsip.classList.add('hidden');
        } else {
            tabArsip.classList.add('bg-blue-500', 'text-white');
            tabArsip.classList.remove('bg-gray-300', 'text-black');
            tabAktif.classList.add('bg-gray-300', 'text-black');
            tabAktif.classList.remove('bg-blue-500', 'text-white');
            tableArsip.classList.remove('hidden');
            tableAktif.classList.add('hidden');
            loadLevel
        }
    }
</script>
</x-layouts.main>