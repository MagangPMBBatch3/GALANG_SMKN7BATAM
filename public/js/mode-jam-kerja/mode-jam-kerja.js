async function loadModeJamKerjaData() {
    const queryAktif = `
        query {
            allModeJamKerja {
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
    renderModeJamKerjaTable(dataAktif?.data?.allModeJamKerja || [], 'dataModeJamKerja', true);

    const queryArsip = `
        query {
            allModeJamKerjaArsip {
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
    renderModeJamKerjaTable(dataArsip?.data?.allModeJamKerjaArsip || [], 'dataModeJamKerjaArsip', false);
}

async function searchModeJamKerja() {
    const keyword = document.getElementById('searchModeJamKerja').value.trim();
    if (!keyword) {
        loadModeJamKerjaData();
        return;
    }

    const query = `
        query {
            allModeJamKerja {
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
    const filteredData = data?.data?.allModeJamKerja?.filter(item =>
        item.nama?.toLowerCase().includes(keyword.toLowerCase())
    ) || [];
    renderModeJamKerjaTable(filteredData, 'dataModeJamKerja', true);
}

function renderModeJamKerjaTable(modeJamKerjas, tableId, isActive) {
    const tbody = document.getElementById(tableId);
    tbody.innerHTML = '';

    if (!modeJamKerjas.length) {
        tbody.innerHTML = `
            <tr>
                <td colspan="3" class="text-center text-gray-500 p-3">Tidak ada data</td>
            </tr>
        `;
        return;
    }

    modeJamKerjas.forEach(item => {
        let actions = '';
        if (isActive) {
            actions = `
                <button onclick="openEditModeJamKerjaModal(
                    '${item.id}',
                    '${item.nama || ''}'
                )" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                <button onclick="deleteModeJamKerja(${item.id})" class="bg-red-500 text-white px-2 py-1 rounded">Arsipkan</button>
            `;
        } else {
            actions = `
                <button onclick="restoreModeJamKerja(${item.id})" class="bg-green-500 text-white px-2 py-1 rounded">Restore</button>
                <button onclick="forceDeleteModeJamKerja(${item.id})" class="bg-red-700 text-white px-2 py-1 rounded">Hapus Permanen</button>
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

async function deleteModeJamKerja(id) {
    const mutation = `
        mutation {
            deleteModeJamKerja(id: ${id}) {
                id
            }
        }
    `;
    await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation })
    });
    loadModeJamKerjaData();
}

async function restoreModeJamKerja(id) {
    const mutation = `
        mutation {
            restoreModeJamKerja(id: ${id}) {
                id
            }
        }
    `;
    await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation })
    });
    loadModeJamKerjaData();
}

async function forceDeleteModeJamKerja(id) {
    const mutation = `
        mutation {
            forceDeleteModeJamKerja(id: ${id}) {
                id
            }
        }
    `;
    await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation })
    });
    loadModeJamKerjaData();
}

document.addEventListener('DOMContentLoaded', () => {
    loadModeJamKerjaData();
    document.getElementById('searchModeJamKerja').addEventListener('input', debounce(searchModeJamKerja, 300));
});

function debounce(func, delay) {
    let timeout;
    return function(...args) {
        const context = this;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), delay);
    };
}

function showTabModeJamKerja(tab) {
    const tabAktif = document.getElementById('tabAktifModeJamKerja');
    const tabArsip = document.getElementById('tabArsipModeJamKerja');
    const tableAktif = document.getElementById('tableAktifModeJamKerja');
    const tableArsip = document.getElementById('tableArsipModeJamKerja');

    if (tab === 'aktif') {
        tabAktif.classList.add('bg-blue-500', 'text-white');
        tabAktif.classList.remove('bg-gray-300', 'text-black');
        tabArsip.classList.remove('bg-blue-500', 'text-white');
        tabArsip.classList.add('bg-gray-300', 'text-black');
        tableAktif.classList.remove('hidden');
        tableArsip.classList.add('hidden');
        loadModeJamKerjaData();
    } else {
        tabArsip.classList.add('bg-blue-500', 'text-white');
        tabArsip.classList.remove('bg-gray-300', 'text-black');
        tabAktif.classList.add('bg-gray-300', 'text-black');
        tabAktif.classList.remove('bg-blue-500', 'text-white');
        tableArsip.classList.remove('hidden');
        tableAktif.classList.add('hidden');
        loadModeJamKerjaData();
    }
}