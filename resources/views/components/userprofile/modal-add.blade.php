<meta name="csrf-token" content="{{ csrf_token() }}">
<div id="modalAddUserProfile" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded p-6 w-full max-w-lg">
        <h2 class="text-lg font-bold mb-4">Tambah User Profile</h2>
        <select id="addUserProfileUserId" class="border p-2 w-full mb-4 rounded">
            <option value="">Pilih User</option>
        </select>
        <input type="text" id="addUserProfileNamaLengkap" class="border p-2 w-full mb-4 rounded" placeholder="Nama Lengkap">
        <input type="text" id="addUserProfileNrp" class="border p-2 w-full mb-4 rounded" placeholder="NRP">
        <input type="text" id="addUserProfileAlamat" class="border p-2 w-full mb-4 rounded" placeholder="Alamat">
        <div class="mb-4">
            <label for="addUserProfileFoto" class="block mb-2">Foto (opsional)</label>
            <input type="file" id="addUserProfileFoto" accept="image/*" class="border p-2 w-full rounded">
            <img id="addUserProfileFotoPreview" class="mt-2 h-20 w-20 rounded-full hidden" alt="Preview Foto">
        </div>
        <select id="addUserProfileBagianId" class="border p-2 w-full mb-4 rounded">
            <option value="">Pilih Bagian</option>
        </select>
        <select id="addUserProfileLevelId" class="border p-2 w-full mb-4 rounded">
            <option value="">Pilih Level</option>
        </select>
        <select id="addUserProfileStatusId" class="border p-2 w-full mb-4 rounded">
            <option value="">Pilih Status</option>
        </select>
        <div class="flex justify-end gap-2">
            <button onclick="closeAddUserProfileModal()" class="px-4 py-2 rounded bg-gray-300">Batal</button>
            <button onclick="createUserProfile()" class="px-4 py-2 rounded bg-blue-500 text-white">Simpan</button>
        </div>
    </div>
</div>

<script>
document.getElementById('addUserProfileFoto')?.addEventListener('change', function(e) {
    const preview = document.getElementById('addUserProfileFotoPreview');
    if (e.target.files[0]) {
        preview.src = URL.createObjectURL(e.target.files[0]);
        preview.classList.remove('hidden');
    } else {
        preview.classList.add('hidden');
    }
});
</script>