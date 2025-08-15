
<div id="modalEditUser" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded p-6 w-full max-w-md">
        <h2 class="text-lg font-bold mb-4">Edit User</h2>
        <input type="hidden" id="editUserId">
        <input type="text" id="editUserNama" class="border p-2 w-full mb-4 rounded" placeholder="Nama User">
        <input type="email" id="editUserEmail" class="border p-2 w-full mb-4 rounded" placeholder="Email User">
        <input type="password" id="editUserPassword" class="border p-2 w-full mb-4 rounded" placeholder="Password (isi jika ingin mengganti)">
        <div class="flex justify-end gap-2">
            <button onclick="closeEditUserModal()" class="px-4 py-2 rounded bg-gray-300">Batal</button>
            <button onclick="updateUser()" class="px-4 py-2 rounded bg-yellow-500 text-white">Update</button>
        </div>
    </div>
</div>