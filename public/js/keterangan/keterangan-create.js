function openAddKeteranganModal() {
    loadSelectOptions();
    document.getElementById('modalAddKeterangan').classList.remove('hidden');
}

function closeAddKeteranganModal() {
    document.getElementById('modalAddKeterangan').classList.add('hidden');
}

async function createKeterangan() {
    const bagian_id = document.getElementById('addKeteranganBagianId').value.trim();
    const proyek_id = document.getElementById('addKeteranganProyekId').value.trim();
    const tanggal = document.getElementById('addKeteranganTanggal').value;

    if (!tanggal) {
        alert('Tanggal wajib diisi!');
        return;
    }

    const mutation = `
        mutation {
            createKeterangan(input: {
                bagian_id: ${bagian_id || null},
                proyek_id: ${proyek_id || null},
                tanggal: "${tanggal}"
            }) {
                id
                tanggal
            }
        }
    `;
    await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation })
    });
    closeAddKeteranganModal();
    loadKeteranganData();
}
