function openEditUserModal(id, name, email, level_id) {
    document.getElementById('editUserId').value = id;
    document.getElementById('editUserNama').value = name;
    document.getElementById('editUserEmail').value = email;
    document.getElementById('editUserPassword').value = '';
    document.getElementById('editUserLevel').value = level_id || 7; 
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
    const level_id = document.getElementById('editUserLevel').value;

    if (!name || !email) {
        alert('Nama dan Email harus diisi!');
        return;
    }


     const mutation = `
        mutation {
            updateUser(
                id: ${id},
                input: {
                    name: "${name}",
                    email: "${email}",       
                    password: "${password}",
                    level_id: ${level_id}
                }
            ) {
                id
                name
                email
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
    closeEditUserModal();
    loadUserData();

   
}