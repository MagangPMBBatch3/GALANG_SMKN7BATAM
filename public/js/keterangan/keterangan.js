async function loadKeteranganData() {
    const queryAktif = `
        query {
            allKeterangans {
                id
                bagian_id
                proyek_id
                tanggal
                bagian { id nama }
                proyek { id nama }
            }
        }
    `;
    const resAktif = await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: queryAktif })
    });
    const dataAktif = await resAktif.json();
    renderKeteranganTable(dataAktif?.data?.allKeterangans || [], 'dataKeterangan', true);

    const queryArsip = `
        query {
            allKeteranganArsip {
                id
                bagian_id
                proyek_id
                tanggal
                deleted_at
                bagian { id nama }
                proyek { id nama }
            }
        }
    `;
    const resArsip = await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: queryArsip })
    });
    const dataArsip = await resArsip.json();
    renderKeteranganTable(dataArsip?.data?.allKeteranganArsip || [], 'dataKeteranganArsip', false);
}

async function searchKeterangan() {
    const keyword = document.getElementById('searchKeterangan').value.trim();
    if (!keyword) {
        loadKeteranganData();
        return;
    }

    const query = `
        query {
            allKeterangans {
                id
                bagian_id
                proyek_id
                tanggal
                bagian { id nama }
                proyek { id nama }
            }
        }
    `;
    const res = await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query })
    });
    const data = await res.json();
    const filteredData = data?.data?.allKeterangans?.filter(item =>
        item.bagian?.nama?.toLowerCase().includes(keyword.toLowerCase()) ||
        item.proyek?.nama?.toLowerCase().includes(keyword.toLowerCase())
    ) || [];
    renderKeteranganTable(filteredData, 'dataKeterangan', true);
}

function renderKeteranganTable(keterangans, tableId, isActive) {
    const tbody = document.getElementById(tableId);
    tbody.innerHTML = '';

    if (!keterangans.length) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center text-gray-500 p-3">Tidak ada data</td>
            </tr>
        `;
        return;
    }

    keterangans.forEach(item => {
        let actions = '';
        if (isActive) {
            actions = `
                <button onclick="openEditKeteranganModal(
                    '${item.id}',
                    '${item.bagian_id || ''}',
                    '${item.proyek_id || ''}',
                    '${item.tanggal || ''}'
                )" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                <button onclick="deleteKeterangan(${item.id})" class="bg-red-500 text-white px-2 py-1 rounded">Arsipkan</button>
            `;
        } else {
            actions = `
                <button onclick="restoreKeterangan(${item.id})" class="bg-green-500 text-white px-2 py-1 rounded">Restore</button>
                <button onclick="forceDeleteKeterangan(${item.id})" class="bg-red-700 text-white px-2 py-1 rounded">Hapus Permanen</button>
            `;
        }

        tbody.innerHTML += `
            <tr>
                <td class="border p-2">${item.id}</td>
                <td class="border p-2">${item.bagian ? item.bagian.nama : '-'}</td>
                <td class="border p-2">${item.proyek ? item.proyek.nama : '-'}</td>
                <td class="border p-2">${item.tanggal || '-'}</td>
                <td class="border p-2">${actions}</td>
            </tr>
        `;
    });
}

async function deleteKeterangan(id) {
    const mutation = `
        mutation {
            deleteKeterangan(id: ${id}) {
                id
            }
        }
    `;
    await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation })
    });
    loadKeteranganData();
}

async function restoreKeterangan(id) {
    const mutation = `
        mutation {
            restoreKeterangan(id: ${id}) {
                id
            }
        }
    `;
    await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation })
    });
    loadKeteranganData();
}

async function forceDeleteKeterangan(id) {
    const mutation = `
        mutation {
            forceDeleteKeterangan(id: ${id}) {
                id
            }
        }
    `;
    await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation })
    });
    loadKeteranganData();
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
        document.getElementById('addKeteranganBagianId'),
        document.getElementById('editKeteranganBagianId')
    ];
    bagianSelects.forEach(select => {
        select.innerHTML = '<option value="">Pilih Bagian</option>';
        dataBagian?.data?.allBagian?.forEach(bagian => {
            select.innerHTML += `<option value="${bagian.id}">${bagian.nama}</option>`;
        });
    });

    // Fetch Proyek
    const queryProyek = `
        query {
            allProyeks {
                id
                nama
            }
        }
    `;
    const resProyek = await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: queryProyek })
    });
    const dataProyek = await resProyek.json();
    const proyekSelects = [
        document.getElementById('addKeteranganProyekId'),
        document.getElementById('editKeteranganProyekId')
    ];
    proyekSelects.forEach(select => {
        select.innerHTML = '<option value="">Pilih Proyek</option>';
        dataProyek?.data?.allProyeks?.forEach(proyek => {
            select.innerHTML += `<option value="${proyek.id}">${proyek.nama}</option>`;
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    loadKeteranganData();
    document.getElementById('searchKeterangan').addEventListener('input', debounce(searchKeterangan, 300));
});

function debounce(func, delay) {
    let timeout;
    return function(...args) {
        const context = this;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), delay);
    };
}

function showTabKeterangan(tab) {
    const tabAktif = document.getElementById('tabAktifKeterangan');
    const tabArsip = document.getElementById('tabArsipKeterangan');
    const tableAktif = document.getElementById('tableAktifKeterangan');
    const tableArsip = document.getElementById('tableArsipKeterangan');

    if (tab === 'aktif') {
        tabAktif.classList.add('bg-blue-500', 'text-white');
        tabAktif.classList.remove('bg-gray-300', 'text-black');
        tabArsip.classList.remove('bg-blue-500', 'text-white');
        tabArsip.classList.add('bg-gray-300', 'text-black');
        tableAktif.classList.remove('hidden');
        tableArsip.classList.add('hidden');
        loadKeteranganData();
    } else {
        tabArsip.classList.add('bg-blue-500', 'text-white');
        tabArsip.classList.remove('bg-gray-300', 'text-black');
        tabAktif.classList.add('bg-gray-300', 'text-black');
        tabAktif.classList.remove('bg-blue-500', 'text-white');
        tableArsip.classList.remove('hidden');
        tableAktif.classList.add('hidden');
        loadKeteranganData();
    }
}
