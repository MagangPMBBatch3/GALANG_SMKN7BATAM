
<div id="modalEditLevel" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded p-6 w-full max-w-md">
        <h2 class="text-lg font-bold mb-4">Edit Level</h2>
        <input type="hidden" id="editLevelId">
        <input type="text" id="editLevelNama" class="border p-2 w-full mb-4 rounded" placeholder="Nama Level">
        <div class="flex justify-end gap-2">
            <button onclick="closeEditLevelModal()" class="px-4 py-2 rounded bg-gray-300">Batal</button>
            <button onclick="updateLevel()" class="px-4 py-2 rounded bg-yellow-500 text-white">Update</button>
        </div>