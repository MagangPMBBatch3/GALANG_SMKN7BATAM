<div id="modalAddAktivitas" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded p-6 w-full max-w-lg">
        <h2 class="text-lg font-bold mb-4">Tambah Aktivitas</h2>
        <select id="addAktivitasBagianId" class="border p-2 w-full mb-4 rounded">
            <option value="">Pilih Bagian</option>
        </select>
        <input type="text" id="addAktivitasNoWbs" class="border p-2 w-full mb-4 rounded" placeholder="No WBS">
        <input type="text" id="addAktivitasNama" class="border p-2 w-full mb-4 rounded" placeholder="Nama Aktivitas">
        <div class="flex justify-end gap-2">
            <button onclick="closeAddAktivitasModal()" class="px-4 py-2 rounded bg-gray-300">Batal</button>
            <button onclick="createAktivitas()" class="px-4 py-2 rounded bg-blue-500 text-white">Simpan</button>
        </div>
    </div>
</div>