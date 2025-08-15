function openAddUserModal() {
    document.getElementById('modalAddUser').classList.remove('hidden');
}

function closeAddUserModal() {
    document.getElementById('modalAddUser').classList.add('hidden');
}

async function createUser() {
    const name = document.getElementById('addUserNama').value.trim();
    const email = document.getElementById('addUserEmail').value.trim();
    const password = document.getElementById('addUserPassword').value;

    if (!name || !email || !password) {
        alert('Nama, Email, dan Password harus diisi!');
        return;
    }

    const userMutation = `
        mutation {
            createUser(input: { name: "${name}", email: "${email}", password: "${password}" }) {
                id
                name
                email
            }
        }
    `;
    const userResponse = await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: userMutation })
    });
    const userResult = await userResponse.json();

    if (userResult.errors) {
        alert('Gagal membuat user: ' + userResult.errors[0].message);
        return;
    }

    const newUser = userResult.data.createUser;
    console.log('User created:', newUser);

    
    const profileMutation = `
        mutation {
            createUserProfile(input: {
                user_id: ${newUser.id},
                nama_lengkap: "${newUser.name}",
                nrp: null,
                alamat: null,
                foto: null,
                bagian_id: null,
                level_id: null,
                status_id: null
            }) {
                id
                user_id
                nama_lengkap
            }
        }
    `;
    const profileResponse = await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: profileMutation })
    });
    const profileResult = await profileResponse.json();

    if (profileResult.errors) {
        alert('Gagal membuat user profile: ' + profileResult.errors[0].message);
        return;
    }

    console.log('UserProfile created:', profileResult.data.createUserProfile);

    closeAddUserModal();
    loadUserData();
}