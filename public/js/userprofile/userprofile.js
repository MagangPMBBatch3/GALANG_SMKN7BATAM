async function loadUserProfileData() {
    const query = `
        query {
            userProfileByUserId(user_id: ${window.authUserId}) {
                id
                user_id
                nama_lengkap
                nrp
                alamat
                foto
                level_id
                status_id
                bagian_id
                created_at
                updated_at
                user { id name email }
                bagian { id nama }
                level { id nama }
                status { id nama }
            }
        }
    `;
    try {
        const res = await fetch('/graphql', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ query })
        });
        const data = await res.json();
        if (data.errors) {
            console.error('GraphQL errors:', data.errors);
            renderUserProfile(null);
            return;
        }
        const profile = data?.data?.userProfileByUserId;
        renderUserProfile(profile);
    } catch (error) {
        console.error('Error loading user profile:', error);
        renderUserProfile(null);
    }
}

function renderUserProfile(profile) {
    const container = document.getElementById('userProfileContainer');
    const noDataMessage = document.getElementById('noDataMessage');
    const editButton = document.getElementById('editProfileButton');

    const dashboardFoto = document.getElementById('userProfileFoto');
    const dashboardNama = document.getElementById('userProfileNamaLengkap');

    if (!profile) {
        if (container && noDataMessage && editButton) {
            container.classList.add('hidden');
            noDataMessage.classList.remove('hidden');
            editButton.classList.add('hidden');
        }
        if (dashboardFoto && dashboardNama) {
            dashboardFoto.classList.add('hidden');
            dashboardNama.textContent = 'User';
        }
        return;
    }

    if (container && noDataMessage && editButton) {
        container.classList.remove('hidden');
        noDataMessage.classList.add('hidden');
        editButton.classList.remove('hidden');

        document.getElementById('userProfileId').textContent = profile.id || '-';
        document.getElementById('userProfileNamaLengkap').textContent = profile.nama_lengkap || '-';
        document.getElementById('userProfileEmail').textContent = profile.user?.email || '-';
        document.getElementById('userProfileNrp').textContent = profile.nrp || '-';
        document.getElementById('userProfileAlamat').textContent = profile.alamat || '-';
        document.getElementById('userProfileLevel').textContent = profile.level?.nama || '-';
        document.getElementById('userProfileStatus').textContent = profile.status?.nama || '-';
        document.getElementById('userProfileBagian').textContent = profile.bagian?.nama || '-';

        const fotoElement = document.getElementById('userProfileFoto');
        if (fotoElement) {
            if (profile.foto) {
                fotoElement.src = profile.foto;
                fotoElement.classList.remove('hidden');
            } else {
                fotoElement.classList.add('hidden');
            }
        }

        editButton.dataset.profile = JSON.stringify({
            id: profile.id || '',
            user_id: profile.user_id || '',
            nama_lengkap: profile.nama_lengkap || '',
            nrp: profile.nrp || '',
            alamat: profile.alamat || '',
            foto: profile.foto || '',
            bagian_id: profile.bagian_id || '',
            level_id: profile.level_id || '',
            status_id: profile.status_id || ''
        }, (key, value) => (value === null ? '' : value));
    }

    if (dashboardFoto && dashboardNama) {
        if (profile.foto) {
            dashboardFoto.src = profile.foto;
            dashboardFoto.classList.remove('hidden');
        } else {
            dashboardFoto.classList.add('hidden');
        }
        dashboardNama.textContent = profile.nama_lengkap || 'User';
    }
}

async function loadSelectOptions() {
    try {
        const userRes = await fetch('/graphql', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ query: `query { allUser { id name email } }` })
        });
        const userData = await userRes.json();
        if (userData.errors) {
            console.error('Error fetching users:', userData.errors);
        }
        const users = userData.data?.allUser || [];
        const editUserSelect = document.getElementById('editUserProfileUserId');
        if (editUserSelect) {
            editUserSelect.innerHTML = '<option value="">Pilih User</option>' +
                users.map(u => `<option value="${u.id}">${u.name} (${u.email})</option>`).join('');
        }

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

    loadSelectOptions().then(() => {
        console.log('Populating modal fields...');

        const idInput = document.getElementById('editUserProfileId');
        if (idInput) {
            idInput.value = profile.id || '';
            console.log('Set editUserProfileId:', idInput.value);
        }

        const userSelect = document.getElementById('editUserProfileUserId');
        if (userSelect) {
            userSelect.value = profile.user_id || '';
            console.log('Set editUserProfileUserId:', userSelect.value);
        }

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

document.addEventListener('DOMContentLoaded', () => {
    loadUserProfileData();
}); 