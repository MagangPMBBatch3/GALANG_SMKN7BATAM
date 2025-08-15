<div id="modalEditModeJamKerja" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded p-6 w-full max-w-lg">
        <h2 class="text-lg font-bold mb-4">Edit Mode Jam Kerja</h2>
        <input type="hidden" id="editModeJamKerjaId">
        <input type="text" id="editModeJamKerjaNama" class="border p-2 w-full mb-4 rounded" placeholder="Nama Mode Jam Kerja">
        <div class="flex justify-end gap-2">
            <button onclick="closeEditModeJamKerjaModal()" class="px-4 py-2 rounded bg-gray-300">Batal</button>
            <button onclick="updateModeJamKerja()" class="px-4 py-2 rounded bg-yellow-500 text-white">Update</button>
        </div>
    </div>
</div>