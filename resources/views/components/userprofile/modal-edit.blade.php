
<meta name="csrf-token" content="{{ csrf_token() }}">
<div id="modalEditUserProfile" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded p-6 w-full max-w-lg">
        <h2 class="text-lg font-bold mb-4">Edit User Profile</h2>
        <input type="hidden" id="editUserProfileId">
        <input type="hidden" id="editUserProfileUserId" value="{{ Auth::id() }}">
        <input type="text" id="editUserProfileNamaLengkap" class="border p-2 w-full mb-4 rounded" placeholder="Nama Lengkap">
        <input type="text" id="editUserProfileNrp" class="border p-2 w-full mb-4 rounded" placeholder="NRP">
        <input type="text" id="editUserProfileAlamat" class="border p-2 w-full mb-4 rounded" placeholder="Alamat">
        <div class="mb-4">
            <label for="editUserProfileFoto" class="block mb-2">Foto (opsional, pilih file baru untuk ganti)</label>
            <input type="file" id="editUserProfileFoto" accept="image/*" class="border p-2 w-full rounded">
            <img id="editUserProfileFotoPreview" class="mt-2 h-20 w-20 rounded-full hidden" alt="Preview Foto">
            <input type="hidden" id="editUserProfileFotoExisting" value="">
        </div>
        <select id="editUserProfileBagianId" class="border p-2 w-full mb-4 rounded">
            <option value="">Pilih Bagian</option>
        </select>
        <input type="hidden" id="editUserProfileLevelId" class="border p-2 w-full mb-4 rounded">
           
    </input>
        <select id="editUserProfileStatusId" class="border p-2 w-full mb-4 rounded">
            <option value="">Pilih Status</option>
        </select>
        <div class="flex justify-end gap-2">
            <button onclick="closeEditUserProfileModal()" class="px-4 py-2 rounded bg-gray-300">Batal</button>
            <button onclick="updateUserProfile()" class="px-4 py-2 rounded bg-yellow-500 text-white">Update</button>
        </div>
    </div>
</div>

<script>
document.getElementById('editUserProfileFoto')?.addEventListener('change', function(e) {
    const preview = document.getElementById('editUserProfileFotoPreview');
    if (e.target.files[0]) {
        preview.src = URL.createObjectURL(e.target.files[0]);
        preview.classList.remove('hidden');
    } else {
        preview.src = document.getElementById('editUserProfileFotoExisting').value;
        preview.classList.toggle('hidden', !preview.src);
    }
});
</script>
