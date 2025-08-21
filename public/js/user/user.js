async function loadUserData() {
    const queryAktif = `
        query {
            allUser {
                id
                name
                email
                level { nama }
            }
        }
    `;
    const resAktif = await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: queryAktif })
    });
    const dataAktif = await resAktif.json();
    renderUserTable(dataAktif?.data?.allUser || [], 'dataUser', true);

    const queryArsip = `
        query {
            allUserArsip {
                id
                name
                email
                level { nama }
                deleted_at
            }
        }
    `;
    const resArsip = await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: queryArsip })
    });
    const dataArsip = await resArsip.json();
    renderUserTable(dataArsip?.data?.allUserArsip || [], 'dataUserArsip', false);
}

async function searchUser() {
    const keyword = document.getElementById('searchUser').value.trim();
    if (!keyword) {
        loadUserData();
        return;
    }

    let query = '';
    if (!isNaN(keyword)) {
        query = `
            query user($id: ID!) {
                user(id: $id) {
                    id
                    name
                    email
                    level { nama }
                }
            }
        `;
        const res = await fetch('/graphql', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ query, variables: { id: parseInt(keyword) } })
        });
        const data = await res.json();
        renderUserTable(data.data.user ? [data.data.user] : [], 'dataUser', true);
    } else {
        query = `
            query userByEmail($email: String!) {
                userByEmail(email: $email) {
                    id
                    name
                    email
                    level { nama }
                }
            }
        `;
        const res = await fetch('/graphql', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ query, variables: { email: `%${keyword}%` } })
        });
        const data = await res.json();
        renderUserTable(data.data.userByEmail || [], 'dataUser', true);
    }
}

async function forceDeleteUser(id) {
    if (!confirm('Hapus permanen? Data tidak bisa dikembalikan!')) return;
    const mutation = `
        mutation forceDeleteUser($id: ID!) {
            forceDeleteUser(id: $id) { id }
        }
    `;
    await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation, variables: { id: parseInt(id) } })
    });
    loadUserData();
}

async function archiveUser(id) {
    if (!confirm('Pindahkan ke arsip?')) return;
    const mutation = `
        mutation deleteUser($id: ID!) {
            deleteUser(id: $id) { id }
        }
    `;
    await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation, variables: { id: parseInt(id) } })
    });
    loadUserData();
}

async function restoreUser(id) {
    if (!confirm('Kembalikan dari arsip?')) return;
    const mutation = `
        mutation restoreUser($id: ID!) {
            restoreUser(id: $id) { id }
        }
    `;
    await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation, variables: { id: parseInt(id) } })
    });
    loadUserData();
}

function openAddUserModal() {
    document.getElementById('modalAddUser').classList.remove('hidden');
}

function closeAddUserModal() {
    document.getElementById('modalAddUser').classList.add('hidden');
}

function renderUserTable(users, tableId, isActive) {
    const tbody = document.getElementById(tableId);
    tbody.innerHTML = '';

    if (!users.length) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center text-gray-500 p-3">Tidak ada data</td>
            </tr>
        `;
        return;
    }

    users.forEach(item => {
        let actions = '';
        if (isActive) {
            actions = `
                <button onclick="openEditUserModal(${item.id}, '${item.name}', '${item.email}', ${item.level?.id || 7})" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                <button onclick="archiveUser(${item.id})" class="bg-red-500 text-white px-2 py-1 rounded">Arsipkan</button>
            `;
        } else {
            actions = `
                <button onclick="restoreUser(${item.id})" class="bg-green-500 text-white px-2 py-1 rounded">Restore</button>
                <button onclick="forceDeleteUser(${item.id})" class="bg-red-700 text-white px-2 py-1 rounded">Hapus Permanen</button>
            `;
        }

        tbody.innerHTML += `
            <tr>
                <td class="border p-2">${item.id}</td>
                <td class="border p-2">${item.name}</td>
                <td class="border p-2">${item.email}</td>
                <td class="border p-2">${item.level?.nama || 'User'}</td>
                <td class="border p-2">${actions}</td>
            </tr>
        `;
    });
}

document.addEventListener('DOMContentLoaded', () => {
    loadUserData();
    document.getElementById('searchUser').addEventListener('input', debounce(searchUser, 300));
});

function debounce(func, delay) {
    let timeout;
    return function(...args) {
        const context = this;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), delay);
    };
}

function showTabUser(tab) {
    const tabAktif = document.getElementById('tabAktifUser');
    const tabArsip = document.getElementById('tabArsipUser');
    const tableAktif = document.getElementById('tableAktifUser');
    const tableArsip = document.getElementById('tableArsipUser');

    if (tab === 'aktif') {
        tabAktif.classList.add('bg-blue-500', 'text-white');
        tabAktif.classList.remove('bg-gray-300', 'text-black');
        tabArsip.classList.remove('bg-blue-500', 'text-white');
        tabArsip.classList.add('bg-gray-300', 'text-black');
        tableAktif.classList.remove('hidden');
        tableArsip.classList.add('hidden');
        loadUserData();
    } else {
        tabArsip.classList.add('bg-blue-500', 'text-white');
        tabArsip.classList.remove('bg-gray-300', 'text-black');
        tabAktif.classList.add('bg-gray-300', 'text-black');
        tabAktif.classList.remove('bg-blue-500', 'text-white');
        tableArsip.classList.remove('hidden');
        tableAktif.classList.add('hidden');
        loadUserData();
    }
}