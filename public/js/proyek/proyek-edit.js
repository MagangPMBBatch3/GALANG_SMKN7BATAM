function openEditProyekModal(id, kode, nama, tanggal, nama_sekolah) {
    document.getElementById('editProyekId').value = id;
    document.getElementById('editProyekKode').value = kode || '';
    document.getElementById('editProyekNama').value = nama || '';
    document.getElementById('editProyekTanggal').value = tanggal || '';
    document.getElementById('editProyekNamaSekolah').value = nama_sekolah || '';
    document.getElementById('modalEditProyek').classList.remove('hidden');
}

function closeEditProyekModal() {
    document.getElementById('modalEditProyek').classList.add('hidden');
}

async function updateProyek() {
    const id = document.getElementById('editProyekId').value;
    const kode = document.getElementById('editProyekKode').value.trim();
    const nama = document.getElementById('editProyekNama').value.trim();
    const tanggal = document.getElementById('editProyekTanggal').value;
    const nama_sekolah = document.getElementById('editProyekNamaSekolah').value.trim();

    if (!kode || !nama || !tanggal || !nama_sekolah) {
        alert('Semua kolom wajib diisi!');
        return;
    }

    const mutation = `
        mutation {
            updateProyek(
                id: ${id},
                input: {
                    kode: "${kode}",
                    nama: "${nama}",
                    tanggal: "${tanggal}",
                    nama_sekolah: "${nama_sekolah}"
                }
            ) {
                id
                nama
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
    closeEditProyekModal();
    loadProyekData();
}
