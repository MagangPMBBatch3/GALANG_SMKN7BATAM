async function loadStatusData() {
    
    const queryAktif = `
        query {
            allStatus {
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
    renderStatusTable(dataAktif?.data?.allStatus || [], 'dataStatus', true);

    
    const queryArsip = `
        query {
            allStatusArsip {
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
    renderStatusTable(dataArsip?.data?.allStatusArsip || [], 'dataStatusArsip', false);
}

async function searchStatus() {
    const keyword = document.getElementById('searchStatus').value.trim();
    if (!keyword) {
        loadStatusData();
        return;
    }

    let query = '';
    if (!isNaN(keyword)) {
        query = `
            query {
                status(id: ${keyword}) {
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
        renderStatusTable(data.data.status ? [data.data.status] : [], 'dataStatus', true);
    } else {
        query = `
            query {
                statusByNama(nama: "%${keyword}%") {
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
        renderStatusTable(data.data.statusByNama, 'dataStatus', true);
    }
}

async function forceDeleteStatus(id) {
    if (!confirm('Hapus permanen? Data tidak bisa dikembalikan!')) return;
    const mutation = `
        mutation {
            forceDeleteStatus(id: ${id}) { id }
        }
    `;
    await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation })
    });
    loadStatusData();
}

async function archiveStatus(id) {
    if (!confirm('Pindahkan ke arsip?')) return;
    const mutation = `
        mutation {
            deleteStatus(id: ${id}) { id }
        }
    `;
    await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation })
    });
    loadStatusData();
}

async function restoreStatus(id) {
    if (!confirm('Kembalikan dari arsip?')) return;
    const mutation = `
        mutation {
            restoreStatus(id: ${id}) { id }
        }
    `;
    await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation })
    });
    loadStatusData();
}

function openAddStatusModal() {
    document.getElementById('modalAddStatus').classList.remove('hidden');
}
function closeAddStatusModal() {
    document.getElementById('modalAddStatus').classList.add('hidden');
}

function renderStatusTable(statuses, tableId, isActive) {
    const tbody = document.getElementById(tableId);
    tbody.innerHTML = '';

    if (!statuses.length) {
        tbody.innerHTML = `
            <tr>
                <td colspan="3" class="text-center text-gray-500 p-3">Tidak ada data</td>
            </tr>
        `;
        return;
    }

    statuses.forEach(item => {
        let actions = '';
        if (isActive) {
            actions = `
                <button onclick="openEditStatusModal(${item.id}, '${item.nama}')" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                <button onclick="archiveStatus(${item.id})" class="bg-red-500 text-white px-2 py-1 rounded">Arsipkan</button>
            `;
        } else {
            actions = `
                <button onclick="restoreStatus(${item.id})" class="bg-green-500 text-white px-2 py-1 rounded">Restore</button>
                <button onclick="forceDeleteStatus(${item.id})" class="bg-red-700 text-white px-2 py-1 rounded">Hapus Permanen</button>
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
    loadStatusData();

    document.getElementById('searchStatus').addEventListener('input', debounce(searchStatus, 300));
});

function debounce(func, delay) {
    let timeout;
    return function(...args) {
        const context = this;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), delay);
    };
}

function showTabStatus(tab) {
    const tabAktif = document.getElementById('tabAktifStatus');
    const tabArsip = document.getElementById('tabArsipStatus');
    const tableAktif = document.getElementById('tableAktifStatus');
    const tableArsip = document.getElementById('tableArsipStatus');

    if (tab === 'aktif') {
        tabAktif.classList.add('bg-blue-500', 'text-white');
        tabAktif.classList.remove('bg-gray-300', 'text-black');
        tabArsip.classList.remove('bg-blue-500', 'text-white');
        tabArsip.classList.add('bg-gray-300', 'text-black');
        tableAktif.classList.remove('hidden');
        tableArsip.classList.add('hidden');
        loadStatusData();
    } else {
        tabArsip.classList.add('bg-blue-500', 'text-white');
        tabArsip.classList.remove('bg-gray-300', 'text-black');
        tabAktif.classList.add('bg-gray-300', 'text-black');
        tabAktif.classList.remove('bg-blue-500', 'text-white');
        tableArsip.classList.remove('hidden');
        tableAktif.classList.add('hidden');
        loadStatusData();
    }
}   