async function loadStatusJamKerjaData() {
    const queryAktif = `
        query {
            allStatusJamKerja {
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
    renderStatusJamKerjaTable(dataAktif?.data?.allStatusJamKerja || [], 'dataStatusJamKerja', true);

    const queryArsip = `
        query {
            allStatusJamKerjaArsip {
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
    renderStatusJamKerjaTable(dataArsip?.data?.allStatusJamKerjaArsip || [], 'dataStatusJamKerjaArsip', false);
}

async function searchStatusJamKerja() {
    const keyword = document.getElementById('searchStatusJamKerja').value.trim();
    if (!keyword) {
        loadStatusJamKerjaData();
        return;
    }

    const query = `
        query {
            allStatusJamKerja {
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
    const filteredData = data?.data?.allStatusJamKerja?.filter(item =>
        item.nama?.toLowerCase().includes(keyword.toLowerCase())
    ) || [];
    renderStatusJamKerjaTable(filteredData, 'dataStatusJamKerja', true);
}

function renderStatusJamKerjaTable(statusJamKerjas, tableId, isActive) {
    const tbody = document.getElementById(tableId);
    tbody.innerHTML = '';

    if (!statusJamKerjas.length) {
        tbody.innerHTML = `
            <tr>
                <td colspan="3" class="text-center text-gray-500 p-3">Tidak ada data</td>
            </tr>
        `;
        return;
    }

    statusJamKerjas.forEach(item => {
        let actions = '';
        if (isActive) {
            actions = `
                <button onclick="openEditStatusJamKerjaModal(
                    '${item.id}',
                    '${item.nama || ''}'
                )" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                <button onclick="deleteStatusJamKerja(${item.id})" class="bg-red-500 text-white px-2 py-1 rounded">Arsipkan</button>
            `;
        } else {
            actions = `
                <button onclick="restoreStatusJamKerja(${item.id})" class="bg-green-500 text-white px-2 py-1 rounded">Restore</button>
                <button onclick="forceDeleteStatusJamKerja(${item.id})" class="bg-red-700 text-white px-2 py-1 rounded">Hapus Permanen</button>
            `;
        }

        tbody.innerHTML += `
            <tr>
                <td class="border p-2">${item.id}</td>
                <td class="border p-2">${item.nama || '-'}</td>
                <td class="border p-2">${actions}</td>
            </tr>
        `;
    });
}

async function deleteStatusJamKerja(id) {
    const mutation = `
        mutation {
            deleteStatusJamKerja(id: ${id}) {
                id
            }
        }
    `;
    await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation })
    });
    loadStatusJamKerjaData();
}

async function restoreStatusJamKerja(id) {
    const mutation = `
        mutation {
            restoreStatusJamKerja(id: ${id}) {
                id
            }
        }
    `;
    await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation })
    });
    loadStatusJamKerjaData();
}

async function forceDeleteStatusJamKerja(id) {
    const mutation = `
        mutation {
            forceDeleteStatusJamKerja(id: ${id}) {
                id
            }
        }
    `;
    await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation })
    });
    loadStatusJamKerjaData();
}

document.addEventListener('DOMContentLoaded', () => {
    loadStatusJamKerjaData();
    document.getElementById('searchStatusJamKerja').addEventListener('input', debounce(searchStatusJamKerja, 300));
});

function debounce(func, delay) {
    let timeout;
    return function(...args) {
        const context = this;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), delay);
    };
}

function showTabStatusJamKerja(tab) {
    const tabAktif = document.getElementById('tabAktifStatusJamKerja');
    const tabArsip = document.getElementById('tabArsipStatusJamKerja');
    const tableAktif = document.getElementById('tableAktifStatusJamKerja');
    const tableArsip = document.getElementById('tableArsipStatusJamKerja');

    if (tab === 'aktif') {
        tabAktif.classList.add('bg-blue-500', 'text-white');
        tabAktif.classList.remove('bg-gray-300', 'text-black');
        tabArsip.classList.remove('bg-blue-500', 'text-white');
        tabArsip.classList.add('bg-gray-300', 'text-black');
        tableAktif.classList.remove('hidden');
        tableArsip.classList.add('hidden');
        loadStatusJamKerjaData();
    } else {
        tabArsip.classList.add('bg-blue-500', 'text-white');
        tabArsip.classList.remove('bg-gray-300', 'text-black');
        tabAktif.classList.add('bg-gray-300', 'text-black');
        tabAktif.classList.remove('bg-blue-500', 'text-white');
        tableArsip.classList.remove('hidden');
        tableAktif.classList.add('hidden');
        loadStatusJamKerjaData();
    }
}