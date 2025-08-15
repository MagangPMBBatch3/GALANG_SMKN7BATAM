function openEditUserModal(id, name, email) {
    document.getElementById('editUserId').value = id;
    document.getElementById('editUserNama').value = name;
    document.getElementById('editUserEmail').value = email;
    document.getElementById('editUserPassword').value = '';
    document.getElementById('modalEditUser').classList.remove('hidden');
}

function closeEditUserModal() {
    document.getElementById('modalEditUser').classList.add('hidden');
}

async function updateUser() {
    const id = document.getElementById('editUserId').value;
    const name = document.getElementById('editUserNama').value.trim();
    const email = document.getElementById('editUserEmail').value.trim();
    const password = document.getElementById('editUserPassword').value;

    if (!name || !email) {
        alert('Nama dan Email harus diisi!');
        return;
    }

    
    let inputFields = `id: ${id}, name: "${name}", email: "${email}"`;
    if (password) {
        inputFields += `, password: "${password}"`;
    }

    const mutation = `
        mutation {
            updateUser(input: { ${inputFields} }) {
                id
                name
                email
            }
        }
    `;
    await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation })
    });
    closeEditUserModal();
}