async function registerUser(event) {
    event.preventDefault();

    const name = document.getElementById('registerName').value.trim();
    const email = document.getElementById('registerEmail').value.trim();
    const password = document.getElementById('registerPassword').value;

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
    alert('Registrasi berhasil! Silakan login.');
    window.location.href = '/login';
}

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('registerForm').addEventListener('submit', registerUser);
});

