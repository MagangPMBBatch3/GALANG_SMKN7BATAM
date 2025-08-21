<div id="addLemburModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Tambah Lembur</h2>
        
        <form id="addLemburForm">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">User</label>
                <select name="user_profile_id" id="addUserProfileId" class="w-full border p-2 rounded" required>
                    <option value="">Pilih User</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Proyek</label>
                <select name="proyek_id" id="addProyekId" class="w-full border p-2 rounded">
                    <option value="">Pilih Proyek</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Tanggal</label>
                <input type="date" name="tanggal" id="addTanggal" class="w-full border p-2 rounded" required>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeAddLemburModal()" class="px-4 py-2 bg-gray-500 text-white rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>
