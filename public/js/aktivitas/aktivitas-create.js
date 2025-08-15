function openAddAktivitasModal() {
    loadSelectOptions();
    document.getElementById('modalAddAktivitas').classList.remove('hidden');
}

function closeAddAktivitasModal() {
    document.getElementById('modalAddAktivitas').classList.add('hidden');
}

async function createAktivitas() {
    const bagian_id = document.getElementById('addAktivitasBagianId').value.trim();
    const no_wbs = document.getElementById('addAktivitasNoWbs').value.trim();
    const nama = document.getElementById('addAktivitasNama').value.trim();

    if (!nama) {
        alert('Nama wajib diisi!');
        return;
    }

    const mutation = `
        mutation {
            createAktivitas(input: {
                bagian_id: ${bagian_id || null},
                no_wbs: "${no_wbs || ''}",
                nama: "${nama}"
            }) {
                id
                nama
            }
        }
    `;
    await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation })
    });
    closeAddAktivitasModal();
    loadAktivitasData();
}