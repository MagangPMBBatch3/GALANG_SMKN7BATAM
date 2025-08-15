<div id="modalAddKeterangan" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded p-6 w-full max-w-lg">
        <h2 class="text-lg font-bold mb-4">Tambah Keterangan</h2>
        <select id="addKeteranganBagianId" class="border p-2 w-full mb-4 rounded">
            <option value="">Pilih Bagian</option>
        </select>
        <select id="addKeteranganProyekId" class="border p-2 w-full mb-4 rounded">
            <option value="">Pilih Proyek</option>
        </select>
        <input type="date" id="addKeteranganTanggal" class="border p-2 w-full mb-4 rounded">
        <div class="flex justify-end gap-2">
            <button onclick="closeAddKeteranganModal()" class="px-4 py-2 rounded bg-gray-300">Batal</button>
            <button onclick="createKeterangan()" class="px-4 py-2 rounded bg-blue-500 text-white">Simpan</button>
        </div>
    </div>
</div>
