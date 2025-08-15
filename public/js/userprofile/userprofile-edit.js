
async function loadSelectOptions() {
    try {
        // Fetch levels
        const levelRes = await fetch('/graphql', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ query: `query { allLevel { id nama } }` })
        });
        const levelData = await levelRes.json();
        if (levelData.errors) {
            console.error('Error fetching levels:', levelData.errors);
        }
        const levels = levelData.data?.allLevel || [];
        const editLevelSelect = document.getElementById('editUserProfileLevelId');
        if (editLevelSelect) {
            editLevelSelect.innerHTML = '<option value="">Pilih Level</option>' +
                levels.map(l => `<option value="${l.id}">${l.nama}</option>`).join('');
        }

        // Fetch statuses
        const statusRes = await fetch('/graphql', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ query: `query { allStatus { id nama } }` })
        });
        const statusData = await statusRes.json();
        if (statusData.errors) {
            console.error('Error fetching statuses:', statusData.errors);
        }
        const statuses = statusData.data?.allStatus || [];
        const editStatusSelect = document.getElementById('editUserProfileStatusId');
        if (editStatusSelect) {
            editStatusSelect.innerHTML = '<option value="">Pilih Status</option>' +
                statuses.map(s => `<option value="${s.id}">${s.nama}</option>`).join('');
        }

        // Fetch bagians
        const bagianRes = await fetch('/graphql', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ query: `query { allBagian { id nama } }` })
        });
        const bagianData = await bagianRes.json();
        if (bagianData.errors) {
            console.error('Error fetching bagians:', bagianData.errors);
        }
        const bagians = bagianData.data?.allBagian || [];
        const editBagianSelect = document.getElementById('editUserProfileBagianId');
        if (editBagianSelect) {
            editBagianSelect.innerHTML = '<option value="">Pilih Bagian</option>' +
                bagians.map(b => `<option value="${b.id}">${b.nama}</option>`).join('');
        }

        return true;
    } catch (error) {
        console.error('Error loading select options:', error);
        return false;
    }
}

function openEditUserProfileModal() {
    const editButton = document.getElementById('editProfileButton');
    if (!editButton.dataset.profile) {
        console.error('No profile data found in edit button dataset');
        alert('Gagal membuka modal edit: Data profil tidak ditemukan.');
        return;
    }

    let profile;
    try {
        profile = JSON.parse(editButton.dataset.profile);
        console.log('Profile data for modal:', profile);
    } catch (error) {
        console.error('Error parsing profile data:', error);
        alert('Gagal membuka modal edit: Data profil tidak valid.');
        return;
    }

    if (!profile.id) {
        console.error('No valid profile ID found');
        alert('Gagal membuka modal edit: ID profil tidak valid.');
        return;
    }

    // Open modal and populate fields after loading select options
    loadSelectOptions().then(() => {
        console.log('Populating modal fields...');

        // Set hidden ID field
        const idInput = document.getElementById('editUserProfileId');
        if (idInput) {
            idInput.value = profile.id || '';
            console.log('Set editUserProfileId:', idInput.value);
        }

        // Set hidden user_id field
        const userIdInput = document.getElementById('editUserProfileUserId');
        if (userIdInput) {
            userIdInput.value = profile.user_id || window.authUserId || '';
            console.log('Set editUserProfileUserId:', userIdInput.value);
        }

        // Set text inputs
        const namaLengkapInput = document.getElementById('editUserProfileNamaLengkap');
        if (namaLengkapInput) {
            namaLengkapInput.value = profile.nama_lengkap || '';
            console.log('Set editUserProfileNamaLengkap:', namaLengkapInput.value);
        }

        const nrpInput = document.getElementById('editUserProfileNrp');
        if (nrpInput) {
            nrpInput.value = profile.nrp || '';
            console.log('Set editUserProfileNrp:', nrpInput.value);
        }

        const alamatInput = document.getElementById('editUserProfileAlamat');
        if (alamatInput) {
            alamatInput.value = profile.alamat || '';
            console.log('Set editUserProfileAlamat:', alamatInput.value);
        }

        // Set dropdowns
        const bagianSelect = document.getElementById('editUserProfileBagianId');
        if (bagianSelect) {
            bagianSelect.value = profile.bagian_id || '';
            console.log('Set editUserProfileBagianId:', bagianSelect.value);
        }

        const levelSelect = document.getElementById('editUserProfileLevelId');
        if (levelSelect) {
            levelSelect.value = profile.level_id || '';
            console.log('Set editUserProfileLevelId:', levelSelect.value);
        }

        const statusSelect = document.getElementById('editUserProfileStatusId');
        if (statusSelect) {
            statusSelect.value = profile.status_id || '';
            console.log('Set editUserProfileStatusId:', statusSelect.value);
        }

        // Set photo preview
        const existingFotoInput = document.getElementById('editUserProfileFotoExisting');
        const preview = document.getElementById('editUserProfileFotoPreview');
        if (existingFotoInput && preview) {
            existingFotoInput.value = profile.foto || '';
            console.log('Set editUserProfileFotoExisting:', existingFotoInput.value);
            if (profile.foto) {
                preview.src = profile.foto;
                preview.classList.remove('hidden');
                console.log('Set photo preview:', preview.src);
            } else {
                preview.src = '';
                preview.classList.add('hidden');
                console.log('Hid photo preview');
            }
        }

        // Show the modal
        const modal = document.getElementById('modalEditUserProfile');
        if (modal) {
            modal.classList.remove('hidden');
            console.log('Modal opened');
        } else {
            console.error('Modal element not found');
            alert('Gagal membuka modal edit: Elemen modal tidak ditemukan.');
        }
    }).catch(error => {
        console.error('Failed to load select options:', error);
        alert('Gagal memuat opsi untuk edit profil. Silakan coba lagi.');
    });
}

function closeEditUserProfileModal() {
    document.getElementById('modalEditUserProfile').classList.add('hidden');
}

async function updateUserProfile() {
    const id = document.getElementById('editUserProfileId').value;
    const user_id = document.getElementById('editUserProfileUserId').value;
    const nama_lengkap = document.getElementById('editUserProfileNamaLengkap').value.trim();
    const nrp = document.getElementById('editUserProfileNrp').value.trim();
    const alamat = document.getElementById('editUserProfileAlamat').value.trim();
    const fileInput = document.getElementById('editUserProfileFoto');
    let foto = document.getElementById('editUserProfileFotoExisting').value;
    const bagian_id = document.getElementById('editUserProfileBagianId').value;
    const level_id = document.getElementById('editUserProfileLevelId').value;
    const status_id = document.getElementById('editUserProfileStatusId').value;

    if (!user_id || !nama_lengkap) {
        alert('User dan Nama Lengkap harus diisi!');
        return;
    }

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

    const bagianIdVal = bagian_id ? bagian_id : null;
    const levelIdVal = level_id ? level_id : null;
    const statusIdVal = status_id ? status_id : null;

    const mutation = `
        mutation {
            updateUserProfile(
                id: ${id},
                input: {
                    user_id: ${user_id},
                    nama_lengkap: "${nama_lengkap}",
                    nrp: "${nrp}",
                    alamat: "${alamat}",
                    foto: "${foto}",
                    bagian_id: ${bagianIdVal},
                    level_id: ${levelIdVal},
                    status_id: ${statusIdVal}
                }
            ) {
                id
                nama_lengkap
            }
        }
    `;
    const response = await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation })
    });
    const result = await response.json();
    console.log(result);
    closeEditUserProfileModal();
    loadUserProfileData();
}
