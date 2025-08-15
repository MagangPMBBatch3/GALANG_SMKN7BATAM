<div id="modalEditProyek" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded p-6 w-full max-w-lg">
        <h2 class="text-lg font-bold mb-4">Edit Proyek</h2>
        <input type="hidden" id="editProyekId">
        <input type="text" id="editProyekKode" class="border p-2 w-full mb-4 rounded" placeholder="Kode Proyek">
        <input type="text" id="editProyekNama" class="border p-2 w-full mb-4 rounded" placeholder="Nama Proyek">
        <input type="date" id="editProyekTanggal" class="border p-2 w-full mb-4 rounded">
        <input type="text" id="editProyekNamaSekolah" class="border p-2 w-full mb-4 rounded" placeholder="Nama Sekolah">
        <div class="flex justify-end gap-2">
            <button onclick="closeEditProyekModal()" class="px-4 py-2 rounded bg-gray-300">Batal</button>
            <button onclick="updateProyek()" class="px-4 py-2 rounded bg-yellow-500 text-white">Update</button>
        </div>
    </div>
</div>
