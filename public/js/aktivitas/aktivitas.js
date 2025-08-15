async function loadAktivitasData() {
    const queryAktif = `
        query {
            allAktivitas {
                id
                bagian_id
                no_wbs
                nama
                bagian { id nama }
            }
        }
    `;
    const resAktif = await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: queryAktif })
    });
    const dataAktif = await resAktif.json();
    renderAktivitasTable(dataAktif?.data?.allAktivitas || [], 'dataAktivitas', true);

    const queryArsip = `
        query {
            allAktivitasArsip {
                id
                bagian_id
                no_wbs
                nama
                deleted_at
                bagian { id nama }
            }
        }
    `;
    const resArsip = await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: queryArsip })
    });
    const dataArsip = await resArsip.json();
    renderAktivitasTable(dataArsip?.data?.allAktivitasArsip || [], 'dataAktivitasArsip', false);
}

async function searchAktivitas() {
    const keyword = document.getElementById('searchAktivitas').value.trim();
    if (!keyword) {
        loadAktivitasData();
        return;
    }

    const query = `
        query {
            allAktivitas {
                id
                bagian_id
                no_wbs
                nama
                bagian { id nama }
            }
        }
    `;
    const res = await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query })
    });
    const data = await res.json();
    const filteredData = data?.data?.allAktivitas?.filter(item =>
        item.bagian?.nama?.toLowerCase().includes(keyword.toLowerCase()) ||
        item.nama?.toLowerCase().includes(keyword.toLowerCase()) ||
        item.no_wbs?.toLowerCase().includes(keyword.toLowerCase())
    ) || [];
    renderAktivitasTable(filteredData, 'dataAktivitas', true);
}

function renderAktivitasTable(aktivitas, tableId, isActive) {
    const tbody = document.getElementById(tableId);
    tbody.innerHTML = '';

    if (!aktivitas.length) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center text-gray-500 p-3">Tidak ada data</td>
            </tr>
        `;
        return;
    }

    aktivitas.forEach(item => {
        let actions = '';
        if (isActive) {
            actions = `
                <button onclick="openEditAktivitasModal(
                    '${item.id}',
                    '${item.bagian_id || ''}',
                    '${item.no_wbs || ''}',
                    '${item.nama || ''}'
                )" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                <button onclick="deleteAktivitas(${item.id})" class="bg-red-500 text-white px-2 py-1 rounded">Arsipkan</button>
            `;
        } else {
            actions = `
                <button onclick="restoreAktivitas(${item.id})" class="bg-green-500 text-white px-2 py-1 rounded">Restore</button>
                <button onclick="forceDeleteAktivitas(${item.id})" class="bg-red-700 text-white px-2 py-1 rounded">Hapus Permanen</button>
            `;
        }

        tbody.innerHTML += `
            <tr>
                <td class="border p-2">${item.id}</td>
                <td class="border p-2">${item.bagian ? item.bagian.nama : '-'}</td>
                <td class="border p-2">${item.no_wbs || '-'}</td>
                <td class="border p-2">${item.nama || '-'}</td>
                <td class="border p-2">${actions}</td>
            </tr>
        `;
    });
}

async function deleteAktivitas(id) {
    const mutation = `
        mutation {
            deleteAktivitas(id: ${id}) {
                id
            }
        }
    `;
    await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation })
    });
    loadAktivitasData();
}

async function restoreAktivitas(id) {
    const mutation = `
        mutation {
            restoreAktivitas(id: ${id}) {
                id
            }
        }
    `;
    await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation })
    });
    loadAktivitasData();
}

async function forceDeleteAktivitas(id) {
    const mutation = `
        mutation {
            forceDeleteAktivitas(id: ${id}) {
                id
            }
        }
    `;
    await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation })
    });
    loadAktivitasData();
}

async function loadSelectOptions() {
    const queryBagian = `
        query {
            allBagian {
                id
                nama
            }
        }
    `;
    const resBagian = await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: queryBagian })
    });
    const dataBagian = await resBagian.json();
    const bagianSelects = [
        document.getElementById('addAktivitasBagianId'),
        document.getElementById('editAktivitasBagianId')
    ];
    bagianSelects.forEach(select => {
        select.innerHTML = '<option value="">Pilih Bagian</option>';
        dataBagian?.data?.allBagian?.forEach(bagian => {
            select.innerHTML += `<option value="${bagian.id}">${bagian.nama}</option>`;
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    loadAktivitasData();
    document.getElementById('searchAktivitas').addEventListener('input', debounce(searchAktivitas, 300));
});

function debounce(func, delay) {
    let timeout;
    return function(...args) {
        const context = this;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), delay);
    };
}

function showTabAktivitas(tab) {
    const tabAktif = document.getElementById('tabAktifAktivitas');
    const tabArsip = document.getElementById('tabArsipAktivitas');
    const tableAktif = document.getElementById('tableAktifAktivitas');
    const tableArsip = document.getElementById('tableArsipAktivitas');

    if (tab === 'aktif') {
        tabAktif.classList.add('bg-blue-500', 'text-white');
        tabAktif.classList.remove('bg-gray-300', 'text-black');
        tabArsip.classList.remove('bg-blue-500', 'text-white');
        tabArsip.classList.add('bg-gray-300', 'text-black');
        tableAktif.classList.remove('hidden');
        tableArsip.classList.add('hidden');
        loadAktivitasData();
    } else {
        tabArsip.classList.add('bg-blue-500', 'text-white');
        tabArsip.classList.remove('bg-gray-300', 'text-black');
        tabAktif.classList.add('bg-gray-300', 'text-black');
        tabAktif.classList.remove('bg-blue-500', 'text-white');
        tableArsip.classList.remove('hidden');
        tableAktif.classList.add('hidden');
        loadAktivitasData();
    }
}