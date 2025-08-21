const { useInsertionEffect } = require("react");

function openEditKeteranganModal(id, bagian_id, proyek_id, tanggal) {
    loadSelectOptions().then(() => {
        document.getElementById('editKeteranganId').value = id;
        document.getElementById('editKeteranganBagianId').value = bagian_id || '';
        document.getElementById('editKeteranganProyekId').value = proyek_id || '';
        document.getElementById('editKeteranganTanggal').value = tanggal || '';
        document.getElementById('modalEditKeterangan').classList.remove('hidden');
    });
}

function closeEditKeteranganModal() {
    document.getElementById('modalEditKeterangan').classList.add('hidden');
}

async function updateKeterangan() {
    const id = document.getElementById('editKeteranganId').value;
    const bagian_id = document.getElementById('editKeteranganBagianId').value;
    const proyek_id = document.getElementById('editKeteranganProyekId').value;
    const tanggal = document.getElementById('editKeteranganTanggal').value;

    if (!tanggal) {
        alert('Tanggal wajib diisi!');
        return;
    }



    const mutation = `
        mutation {
            updateKeterangan(
                id: ${id},
                input: {
                    bagian_id: ${bagian_id || null},
                    proyek_id: ${proyek_id || null},
                    tanggal: "${tanggal}"
                }
            ) {
                id
                tanggal
            }
        }
    `;
    const response = await fetch('/graphql', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ query: mutation })
    });
    const result = await response.json();
    console.log(result);
    closeEditKeteranganModal();
    loadKeteranganData();
}
