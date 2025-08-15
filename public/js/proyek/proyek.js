async function loadProyekData() {
    const queryAktif = `
        query {
            allProyeks {
                id
                kode
                nama
                tanggal
                nama_sekolah
                created_at
                updated_at
            }
        }
    `;
    const resAktif = await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: queryAktif })
    });
    const dataAktif = await resAktif.json();
    renderProyekTable(dataAktif?.data?.allProyeks || [], 'dataProyek', true);

   
    const queryArsip = `
        query {
            allProyekArsip {
                id
                kode
                nama
                tanggal
                nama_sekolah
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
    renderProyekTable(dataArsip?.data?.allProyekArsip || [], 'dataProyekArsip', false);
}

async function searchProyek() {
    const keyword = document.getElementById('searchProyek').value.trim();
    if (!keyword) {
        loadProyekData();
        return;
    }

    const query = `
        query {
            getProyeks(search: "${keyword}") {
                id
                kode
                nama
                tanggal
                nama_sekolah
            }
        }
    `;
    const res = await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query })
    });
    const data = await res.json();
    renderProyekTable(data?.data?.getProyeks || [], 'dataProyek', true);
}

function renderProyekTable(proyeks, tableId, isActive) {
    const tbody = document.getElementById(tableId);
    tbody.innerHTML = '';

    if (!proyeks.length) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-gray-500 p-3">Tidak ada data</td>
            </tr>
        `;
        return;
    }

    proyeks.forEach(item => {
        let actions = '';
        if (isActive) {
            actions = `
                <button onclick="openEditProyekModal(
                    '${item.id}',
                    '${item.kode}',
                    '${item.nama}',
                    '${item.tanggal}',
                    '${item.nama_sekolah}'
                )" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                <button onclick="deleteProyek(${item.id})" class="bg-red-500 text-white px-2 py-1 rounded">Arsipkan</button>
            `;
        } else {
            actions = `
                <button onclick="restoreProyek(${item.id})" class="bg-green-500 text-white px-2 py-1 rounded">Restore</button>
                <button onclick="forceDeleteProyek(${item.id})" class="bg-red-700 text-white px-2 py-1 rounded">Hapus Permanen</button>
            `;
        }

        tbody.innerHTML += `
            <tr>
                <td class="border p-2">${item.id}</td>
                <td class="border p-2">${item.kode || '-'}</td>
                <td class="border p-2">${item.nama || '-'}</td>
                <td class="border p-2">${item.tanggal || '-'}</td>
                <td class="border p-2">${item.nama_sekolah || '-'}</td>
                <td class="border p-2">${actions}</td>
            </tr>
        `;
    });
}

async function deleteProyek(id) {
    const mutation = `
        mutation {
            deleteProyek(id: ${id}) {
                id
            }
        }
    `;
    await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation })
    });
    loadProyekData();
}

async function restoreProyek(id) {
    const mutation = `
        mutation {
            restoreProyek(id: ${id}) {
                id
            }
        }
    `;
    await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation })
    });
    loadProyekData();
}

async function forceDeleteProyek(id) {
    const mutation = `
        mutation {
            forceDeleteProyek(id: ${id}) {
                id
            }
        }
    `;
    await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation })
    });
    loadProyekData();
}

document.addEventListener('DOMContentLoaded', () => {
    loadProyekData();
    document.getElementById('searchProyek').addEventListener('input', debounce(searchProyek, 300));
});

function debounce(func, delay) {
    let timeout;
    return function(...args) {
        const context = this;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), delay);
    };
}

function showTabProyek(tab) {
    const tabAktif = document.getElementById('tabAktifProyek');
    const tabArsip = document.getElementById('tabArsipProyek');
    const tableAktif = document.getElementById('tableAktifProyek');
    const tableArsip = document.getElementById('tableArsipProyek');

    if (tab === 'aktif') {
        tabAktif.classList.add('bg-blue-500', 'text-white');
        tabAktif.classList.remove('bg-gray-300', 'text-black');
        tabArsip.classList.remove('bg-blue-500', 'text-white');
        tabArsip.classList.add('bg-gray-300', 'text-black');
        tableAktif.classList.remove('hidden');
        tableArsip.classList.add('hidden');
        loadProyekData();
    } else {
        tabArsip.classList.add('bg-blue-500', 'text-white');
        tabArsip.classList.remove('bg-gray-300', 'text-black');
        tabAktif.classList.add('bg-gray-300', 'text-black');
        tabAktif.classList.remove('bg-blue-500', 'text-white');
        tableArsip.classList.remove('hidden');
        tableAktif.classList.add('hidden');
        loadProyekData();
    }
}
