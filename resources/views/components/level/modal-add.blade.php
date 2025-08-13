<!-- filepath: resources/views/components/level/modal-add.blade.php -->
<div id="modalAddLevel" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded p-6 w-full max-w-md">
        <h2 class="text-lg font-bold mb-4">Tambah Level</h2>
        <input type="text" id="addLevelNama" class="border p-2 w-full mb-4 rounded" placeholder="Nama Level">
        <div class="flex justify-end gap-2">
            <button onclick="closeAddLevelModal()" class="px-4 py-2 rounded bg-gray-300">Batal</button>
            <button onclick="createLevel()" class="px-4 py-2 rounded bg-blue-500 text-white">Simpan</button>
        </div>
    </div>
</div>