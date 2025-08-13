async function loadLevelData() {
    // Ambil data aktif
    const queryAktif = `
        query {
            allLevel {
                id
                nama
            }
        }
    `;
    const resAktif = await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: queryAktif })
    });
    const dataAktif = await resAktif.json();
    renderLevelTable(dataAktif?.data?.allLevel || [], 'dataLevel', true);

    // Ambil data arsip
    const queryArsip = `
        query {
            allLevelArsip {
                id
                nama
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
    renderLevelTable(dataArsip?.data?.allLevelArsip || [], 'dataLevelArsip', false);
}

async function searchLevel() {
    const keyword = document.getElementById('searchLevel').value.trim();
    if (!keyword) {
        loadLevelData();
        return;
    }

    let query = '';
    if (!isNaN(keyword)) {
        query = `
            query {
                level(id: ${keyword}) {
                    id
                    nama
                }
            }
        `;
        const res = await fetch('/graphql', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ query })
        });
        const data = await res.json();
        renderLevelTable(data.data.level ? [data.data.level] : [], 'dataLevel', true);
    } else {
        query = `
            query {
                levelByNama(nama: "%${keyword}%") {
                    id
                    nama
                }
            }
        `;
        const res = await fetch('/graphql', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ query })
        });
        const data = await res.json();
        renderLevelTable(data.data.levelByNama, 'dataLevel', true);
    }
}

async function forceDeleteLevel(id) {
    if (!confirm('Hapus permanen? Data tidak bisa dikembalikan!')) return;
    const mutation = `
        mutation {
            forceDeleteLevel(id: ${id}) { id }
        }
    `;
    await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation })
    });
    loadLevelData();
}

async function archiveLevel(id) {
    if (!confirm('Pindahkan ke arsip?')) return;
    const mutation = `
        mutation {
            deleteLevel(id: ${id}) { id }
        }
    `;
    await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation })
    });
    loadLevelData();
}

async function restoreLevel(id) {
    if (!confirm('Kembalikan dari arsip?')) return;
    const mutation = `
        mutation {
            restoreLevel(id: ${id}) { id }
        }
    `;
    await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation })
    });
    loadLevelData();
}

// filepath: public/js/level/level.js
function openAddLevelModal() {
    document.getElementById('modalAddLevel').classList.remove('hidden');
}
function closeAddLevelModal() {
    document.getElementById('modalAddLevel').classList.add('hidden');
}

function renderLevelTable(levels, tableId, isActive) {
    const tbody = document.getElementById(tableId);
    tbody.innerHTML = '';

    if (!levels.length) {
        tbody.innerHTML = `
            <tr>
                <td colspan="3" class="text-center text-gray-500 p-3">Tidak ada data</td>
            </tr>
        `;
        return;
    }

    levels.forEach(item => {
        let actions = '';
        if (isActive) {
            actions = `
                <button onclick="openEditLevelModal(${item.id}, '${item.nama}')" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                <button onclick="archiveLevel(${item.id})" class="bg-red-500 text-white px-2 py-1 rounded">Arsipkan</button>
            `;
        } else {
            actions = `
                <button onclick="restoreLevel(${item.id})" class="bg-green-500 text-white px-2 py-1 rounded">Restore</button>
                <button onclick="forceDeleteLevel(${item.id})" class="bg-red-700 text-white px-2 py-1 rounded">Hapus Permanen</button>
            `;
        }

        tbody.innerHTML += `
            <tr>
                <td class="border p-2">${item.id}</td>
                <td class="border p-2">${item.nama}</td>
                <td class="border p-2">${actions}</td>
            </tr>
        `;
    });
}

document.addEventListener('DOMContentLoaded', () => {
    loadLevelData();

    document.getElementById('searchLevel').addEventListener('input', debounce(searchLevel, 300));
});

function debounce(func, delay) {
    let timeout;
    return function(...args) {
        const context = this;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), delay);
    };
}

function showTab(tab) {
    const tabAktif = document.getElementById('tabAktif');
    const tabArsip = document.getElementById('tabArsip');
    const tableAktif = document.getElementById('tableAktif');
    const tableArsip = document.getElementById('tableArsip');

    if (tab === 'aktif') {
        tabAktif.classList.add('bg-blue-500', 'text-white');
        tabAktif.classList.remove('bg-gray-300', 'text-black');
        tabArsip.classList.remove('bg-blue-500', 'text-white');
        tabArsip.classList.add('bg-gray-300', 'text-black');
        tableAktif.classList.remove('hidden');
        tableArsip.classList.add('hidden');
        loadLevelData(); // Tambahkan ini
    } else {
        tabArsip.classList.add('bg-blue-500', 'text-white');
        tabArsip.classList.remove('bg-gray-300', 'text-black');
        tabAktif.classList.add('bg-gray-300', 'text-black');
        tabAktif.classList.remove('bg-blue-500', 'text-white');
        tableArsip.classList.remove('hidden');
        tableAktif.classList.add('hidden');
        loadLevelData(); // Tambahkan ini
    }
}

