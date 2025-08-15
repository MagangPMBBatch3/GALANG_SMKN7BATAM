function openEditAktivitasModal(id, bagian_id, no_wbs, nama) {
    loadSelectOptions().then(() => {
        document.getElementById('editAktivitasId').value = id;
        document.getElementById('editAktivitasBagianId').value = bagian_id || '';
        document.getElementById('editAktivitasNoWbs').value = no_wbs || '';
        document.getElementById('editAktivitasNama').value = nama || '';
        document.getElementById('modalEditAktivitas').classList.remove('hidden');
    });
}

function closeEditAktivitasModal() {
    document.getElementById('modalEditAktivitas').classList.add('hidden');
}

async function updateAktivitas() {
    const id = document.getElementById('editAktivitasId').value;
    const bagian_id = document.getElementById('editAktivitasBagianId').value;
    const no_wbs = document.getElementById('editAktivitasNoWbs').value.trim();
    const nama = document.getElementById('editAktivitasNama').value.trim();

    if (!nama) {
        alert('Nama wajib diisi!');
        return;
    }

    const mutation = `
        mutation {
            updateAktivitas(
                id: ${id},
                input: {
                    bagian_id: ${bagian_id || null},
                    no_wbs: "${no_wbs || ''}",
                    nama: "${nama}"
                }
            ) {
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
    closeEditAktivitasModal();
    loadAktivitasData();
}