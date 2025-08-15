<div id="modalAddProyek" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded p-6 w-full max-w-lg">
        <h2 class="text-lg font-bold mb-4">Tambah Proyek</h2>
        <input type="text" id="addProyekKode" class="border p-2 w-full mb-4 rounded" placeholder="Kode Proyek">
        <input type="text" id="addProyekNama" class="border p-2 w-full mb-4 rounded" placeholder="Nama Proyek">
        <input type="date" id="addProyekTanggal" class="border p-2 w-full mb-4 rounded">
        <input type="text" id="addProyekNamaSekolah" class="border p-2 w-full mb-4 rounded" placeholder="Nama Sekolah">
        <div class="flex justify-end gap-2">
            <button onclick="closeAddProyekModal()" class="px-4 py-2 rounded bg-gray-300">Batal</button>
            <button onclick="createProyek()" class="px-4 py-2 rounded bg-blue-500 text-white">Simpan</button>
        </div>
    </div>
</div>
