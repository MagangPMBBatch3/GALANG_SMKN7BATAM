function openAddUserProfileModal() {
    loadSelectOptions();
    document.getElementById('modalAddUserProfile').classList.remove('hidden');
}

function closeAddUserProfileModal() {
    document.getElementById('modalAddUserProfile').classList.add('hidden');
}


async function createUserProfile() {
    const user_id = document.getElementById('addUserProfileUserId').value.trim();
    const nama_lengkap = document.getElementById('addUserProfileNamaLengkap').value.trim();
    const nrp = document.getElementById('addUserProfileNrp').value.trim();
    const alamat = document.getElementById('addUserProfileAlamat').value.trim();
    const fileInput = document.getElementById('addUserProfileFoto');
    const bagian_id = document.getElementById('addUserProfileBagianId').value.trim();
    const level_id = document.getElementById('addUserProfileLevelId').value.trim();
    const status_id = document.getElementById('addUserProfileStatusId').value.trim();

    if (!user_id || !nama_lengkap) {
        alert('User dan Nama Lengkap harus diisi!');
        return;
    }

    let foto = '';
    if (fileInput.files[0]) {
        const formData = new FormData();
        formData.append('foto', fileInput.files[0]);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content); 
        const uploadRes = await fetch('/upload-foto', {
            method: 'POST',
            body: formData
        });
        const uploadData = await uploadRes.json();
        if (uploadData.error) {
            alert(uploadData.error);
            return;
        }
        foto = uploadData.url;
    }

    const mutation = `
        mutation {
            createUserProfile(input: {
                user_id: ${user_id},
                nama_lengkap: "${nama_lengkap}",
                nrp: "${nrp}",
                alamat: "${alamat}",
                foto: "${foto}",
                bagian_id: ${bagian_id || null},
                level_id: ${level_id || null},
                status_id: ${status_id || null}
            }) {
                id
                nama_lengkap
            }
        }
    `;
    await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation })
    });
    closeAddUserProfileModal();
    loadUserProfileData();
}